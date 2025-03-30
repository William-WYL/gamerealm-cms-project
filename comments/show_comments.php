<?php

/*******w******** 
    
    Name: Wei Wang
    Date: February 6, 2025
    Description: Display a single game post with user comments.

 ****************/
session_start();
require('../tools/connect.php');

if (isset($_SESSION['error'])) {
  $error = $_SESSION['error'];
  unset($_SESSION['error']);
}
if (isset($_SESSION['success'])) {
  $success = $_SESSION['success'];
  unset($_SESSION['success']);
}

// General input filtering and validation
function sanitizeInput($input)
{
  return filter_input(INPUT_POST, $input, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

// Validate game ID
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
  header("Location: ../index.php");
  exit("Invalid game ID.");
}

$game_id = $_GET['id'];

// Fetch game details
$gameQuery = "SELECT g.*, c.category_name 
             FROM games g
             LEFT JOIN categories c ON g.category_id = c.category_id
             WHERE g.id = :game_id";

try {
  $gameStatement = $db->prepare($gameQuery);
  $gameStatement->bindValue(':game_id', $game_id, PDO::PARAM_INT);
  $gameStatement->execute();
  $game = $gameStatement->fetch(PDO::FETCH_ASSOC);

  if (!$game) {
    header("Location: ../index.php");
    exit("Game not found.");
  }
} catch (PDOException $e) {
  die("Database error: " . $e->getMessage());
}

// Fetch approved comments
$commentQuery = "SELECT cm.*, u.username, u.role 
                FROM comments cm
                JOIN users u ON cm.user_id = u.id
                WHERE cm.game_id = :game_id 
                AND cm.status = 'approved'
                -- reverse chronological order
                ORDER BY cm.created_at DESC";

try {
  $commentStatement = $db->prepare($commentQuery);
  $commentStatement->bindValue(':game_id', $game_id, PDO::PARAM_INT);
  $commentStatement->execute();
  $comments = $commentStatement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Database error: " . $e->getMessage());
}

// Handle comment submission
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment'])) {
  if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "You must be logged in to post comments.";
    header("Location: show_comments.php?id=" . $game_id);
    exit();
  } else {
    $content = trim(sanitizeInput('content'));

    if (empty($content)) {
      $_SESSION['error'] = "Comment content cannot be empty.";
      header("Location: show_comments.php?id=" . $game_id);
      exit();
    } else {
      try {
        $insertQuery = "INSERT INTO comments 
                             (content, user_id, game_id, status)
                             VALUES (:content, :user_id, :game_id, 'approved')";

        $stmt = $db->prepare($insertQuery);
        $stmt->bindValue(':content', $content);
        $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':game_id', $game_id, PDO::PARAM_INT);
        $stmt->execute();

        $_SESSION['success'] = "Comment submitted!";
        header("Location: show_comments.php?id=" . $game_id);
        exit();
      } catch (PDOException $e) {
        $_SESSION['error'] = "Error submitting comment: " . $e->getMessage();
        header("Location: show_comments.php?id=" . $game_id);
        exit();
      }
    }
  }
}

// Handle comment deletion or update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
  if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "You must be logged in to perform this action.";
    header("Location: show_comments.php?id=" . $game_id);
    exit();
  }

  $comment_id = filter_input(INPUT_POST, 'comment_id', FILTER_SANITIZE_NUMBER_INT);

  try {
    // Validate comment ownership
    $ownershipQuery = "SELECT user_id FROM comments WHERE id = :comment_id";
    $stmt = $db->prepare($ownershipQuery);
    $stmt->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);
    $stmt->execute();
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$comment) {
      $_SESSION['error'] = "Comment not found.";
      header("Location: show_comments.php?id=" . $game_id);
      exit();
    }

    // Permission check: User must be either the comment author or an admin
    if ($_SESSION['user_id'] != $comment['user_id'] && $_SESSION['role'] !== 'admin') {
      $_SESSION['error'] = "Unauthorized action.";
      header("Location: show_comments.php?id=" . $game_id);
      exit();
    }

    // Process delete operation
    if ($_POST['action'] === 'delete') {
      $deleteQuery = "DELETE FROM comments WHERE id = :comment_id";
      $stmt = $db->prepare($deleteQuery);
      $stmt->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);
      $stmt->execute();

      $_SESSION['success'] = "Comment deleted successfully.";
    }

    // Process update operation
    if ($_POST['action'] === 'update') {
      $newContent = trim(sanitizeInput('content'));
      if (empty($newContent)) {
        $_SESSION['error'] = "Comment content cannot be empty.";
        header("Location: show_comments.php?id=" . $game_id);
        exit();
      }

      $updateQuery = "UPDATE comments SET content = :content WHERE id = :comment_id";
      $stmt = $db->prepare($updateQuery);
      $stmt->bindValue(':content', $newContent);
      $stmt->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);
      $stmt->execute();

      $_SESSION['success'] = "Comment updated successfully.";
    }

    header("Location: show_comments.php?id=" . $game_id);
    exit();
  } catch (PDOException $e) {
    $_SESSION['error'] = "Database error: " . $e->getMessage();
    header("Location: show_comments.php?id=" . $game_id);
    exit();
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($game['title']) ?> - GameRealm</title>
  <link rel="stylesheet" href="../general.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>

  </style>
</head>

<body>
  <div class="container">
    <div class="py-4 text-start">
      <h1><a href="../index.php" class="text-decoration-none text-dark">GameRealm</a></h1>
    </div>

    <nav id="menu" class="navbar navbar-expand-lg navbar-light bg-light border-bottom mb-2">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
              <li class="nav-item active"><a class="nav-link active" href="../games/post.php">Add Game</a></li>
              <li class="nav-item"><a class="nav-link" href="../categories/manage_categories.php">Categories</a></li>
              <li class="nav-item"><a class="nav-link" href="../users/manage_users.php">Users</a></li>
              <li class="nav-item"><a class="nav-link" href="../comments/manage_comments.php">Comments</a></li>
            <?php endif; ?>
          </ul>
          <ul class="navbar-nav ms-auto">
            <?php if (isset($_SESSION['username'])): ?>
              <li class="nav-item">
                <span class="nav-link text-primary">Welcome, <?= htmlspecialchars($_SESSION['username']) ?>
                  <?php if ($_SESSION['role'] === 'admin'): ?>
                    <span class="admin-badge text-warning">(Admin)</span>
                  <?php endif; ?>
                </span>
              </li>
              <li class="nav-item"><a class="nav-link" href="../users/logout.php">Logout</a></li>
            <?php else: ?>
              <li class="nav-item"><a class="nav-link" href="../users/register.php">Sign up</a></li>
              <li class="nav-item"><a class="nav-link" href="../users/login.php">Log in</a></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>


    <!-- Game Details Section -->
    <div class="row justify-content-start border-bottom mb-2">
      <div class="col-md-6 text-start">
        <?php if (isset($game['cover_image'])) : ?>
          <img src="../asset/images/<?= htmlspecialchars($game['cover_image']) ?>" class="img-fluid mb-4" alt="<?= htmlspecialchars($game['title']) ?> Cover">
        <?php else : ?>
          <div class="no-image text-center fs-3 fw-light text-body-secondary">No Image</div>
        <?php endif ?>
        <h5 class="mb-3"><?= htmlspecialchars($game['title']) ?></h5>
        <p><strong>Released:</strong> <?= date("F j, Y", strtotime($game['release_date'])) ?></p>
        <p><strong>Category:</strong> <?= htmlspecialchars($game['category_name'] ?? 'Uncategorized') ?></p>
        <p><?= nl2br(htmlspecialchars($game['description'])) ?></p>
      </div>
    </div>

    <!-- Comments section -->
    <div class="comments-section mt-5">
      <h4 class="mb-4 border-bottom pb-2">Community Discussions</h4>

      <!-- Comment form -->
      <?php if (isset($_SESSION['user_id'])): ?>
        <div class="card mb-4">
          <div class="card-body">
            <form method="post">
              <?php if ($success): ?>
                <div id="success-message" class="alert alert-success alert-dismissible fade show">
                  <?= $success ?>
                  <button type="button" class="btn-close text-end" data-bs-dismiss="alert"></button>
                </div>

              <?php elseif ($error): ?>
                <div id="error-message" class="alert alert-error alert-dismissible fade show">
                  <?= $error ?>
                  <button type="button" class="btn-close text-end" data-bs-dismiss="alert"></button>
                </div>

              <?php endif; ?>

              <div class="mb-3">
                <textarea name="content" class="form-control" rows="4"
                  placeholder="Share your thoughts about this game..."
                  maxlength="500"></textarea>
                <small class="text-muted">Max 500 characters</small>
              </div>
              <button type="submit" name="submit_comment"
                class="btn btn-primary">Post Comment</button>
            </form>
          </div>
        </div>
      <?php else: ?>
        <div class="alert alert-info">
          Please <a href="../users/login.php">login</a> to participate in discussions
        </div>
      <?php endif; ?>

      <!-- Comment display section -->
      <?php foreach ($comments as $comment): ?>
        <div class="col-12">
          <div class="comment-card card shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between mb-2">
                <div>
                  <strong><?= htmlspecialchars($comment['username']) ?></strong>
                  <?php if ($comment['role'] === 'admin'): ?>
                    <span class="admin-badge badge bg-warning">Admin</span>
                  <?php endif; ?>
                </div>
                <div>
                  <!-- Action buttons -->
                  <?php if (
                    isset($_SESSION['user_id']) &&
                    ($_SESSION['user_id'] == $comment['user_id'] || $_SESSION['role'] === 'admin')
                  ): ?>
                    <div class="btn-group">
                      <!-- Edit button triggers modal -->
                      <button type="button" class="btn btn-sm btn-outline-primary"
                        style="width: 70px;"
                        data-bs-toggle="modal"
                        data-bs-target="#editModal"
                        data-comment-id="<?= $comment['id'] ?>"
                        data-comment-content="<?= htmlspecialchars($comment['content']) ?>">
                        Edit
                      </button>

                      <!-- Delete form -->
                      <form method="post" class="d-inline">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger ms-2"
                          style="width: 70px;"
                          onclick="return confirm('Are you sure you want to delete this comment?')">
                          Delete
                        </button>
                      </form>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
              <p class="mb-0"><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

      <!-- Edit Comment Modal -->
      <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <form method="post">
              <div class="modal-header">
                <h5 class="modal-title">Edit Comment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="comment_id" id="editCommentId">
                <div class="mb-3">
                  <textarea name="content" id="editCommentContent"
                    class="form-control" rows="4" required></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>


      <!-- Footer -->
      <?php include '../components/footer.php'; ?>

      <!-- JavaScript to handle the edit modal -->
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          var editModal = document.getElementById('editModal');

          editModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var commentId = button.getAttribute('data-comment-id');
            var commentContent = button.getAttribute('data-comment-content');

            document.getElementById('editCommentId').value = commentId;
            document.getElementById('editCommentContent').value = commentContent;
          });

          // Listen for the scroll event and store the scroll position
          window.addEventListener('scroll', function() {
            localStorage.setItem('scrollPosition', window.scrollY);
          });

          // Restore the scroll position when the page reloads
          if (localStorage.getItem('scrollPosition')) {
            window.scrollTo(0, localStorage.getItem('scrollPosition'));
          }
        });
      </script>


      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>