<?php

/*******w******** 
    
    Name: Wei Wang
    Date: February 6, 2025
    Description: Display a single game post with user comments.

 ****************/
session_start();
require('../tools/connect.php');

// Validate game ID from query parameters
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
  header("Location: ../index.php");
  exit("Invalid game ID.");
}

$game_id = $_GET['id'];

// Retrieve game details with category information
$gameQuery = "
    SELECT 
        g.id, 
        g.title, 
        g.description, 
        g.release_date, 
        g.cover_image,
        c.category_name
    FROM games g
    LEFT JOIN categories c ON g.category_id = c.category_id
    WHERE g.id = :game_id
";

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

// Retrieve comments with user information
$commentQuery = "
    SELECT 
        cm.content,
        cm.created_at,
        u.username,
        u.role
    FROM comments cm
    JOIN users u ON cm.user_id = u.id
    WHERE cm.game_id = :game_id
    ORDER BY cm.created_at DESC
";

try {
  $commentStatement = $db->prepare($commentQuery);
  $commentStatement->bindValue(':game_id', $game_id, PDO::PARAM_INT);
  $commentStatement->execute();
  $comments = $commentStatement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Database error: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>GameRealm - <?= htmlspecialchars($game['title']) ?></title>
  <link rel="stylesheet" href="../general.css">
  <!-- Bootstrap CSS -->
  <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <div class="container">
    <div class="py-4 text-center">
      <h1><a href="../index.php" class="text-decoration-none text-dark">GameRealm - Add New Game</a></h1>
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
              <li class="nav-item"><a class="nav-link" href="./users/logout.php">Logout</a></li>
            <?php else: ?>
              <li class="nav-item"><a class="nav-link" href="./users/register.php">Sign up</a></li>
              <li class="nav-item"><a class="nav-link" href="./users/login.php">Log in</a></li>
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


    <!-- Comments Section -->
    <div class="comments-section">
      <h5 class="mb-4">Player Discussions</h5>

      <?php if (!empty($comments)): ?>
        <div class="list-group">
          <?php foreach ($comments as $comment): ?>
            <div class="list-group-item">
              <div class="d-flex justify-content-between">
                <span class="fw-bold"><?= htmlspecialchars($comment['username']) ?>
                  <?php if ($comment['role'] === 'admin'): ?>
                    <span class="badge bg-warning">(Admin)</span>
                  <?php endif; ?>
                </span>
                <span class="text-muted"><?= date("M j, Y g:i a", strtotime($comment['created_at'])) ?></span>
              </div>
              <p class="mt-2"><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p class="text-start text-muted">Be the first to discuss this game!</p>
      <?php endif; ?>
    </div>

    <footer class="text-center mt-5">
      <p class="small text-muted">© GameRealm 2025 - All virtual rights reserved</p>
    </footer>
  </div> <!-- End Container -->
</body>

</html>