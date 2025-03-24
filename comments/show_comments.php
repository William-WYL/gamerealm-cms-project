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
  <link rel="stylesheet" href="../main.css">
</head>

<body>
  <div id="wrapper">
    <div id="header">
      <h1><a href="../index.php"><?= htmlspecialchars($game['title']) ?></a></h1>
    </div>
    <ul id="menu">
      <li><a href="../index.php">Home</a></li>
      <?php if (isset($_SESSION['username'])): ?>
        <!-- Login user display -->
        <li class="user-info">
          Welcome, <?= htmlspecialchars($_SESSION['username']) ?>
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <span class="admin-badge">(Admin)</span>
          <?php endif; ?>
        </li>
        <li class="user-function"><a href="../users/logout.php">Logout</a></li>
      <?php else: ?>
        <!-- Unlogin user display -->
        <li class="user-function"><a href="../users/register.php">Register</a></li>
        <li class="user-function"><a href="../users/login.php">Login</a></li>
      <?php endif; ?>
    </ul> <!-- END div id="menu" -->

    <!-- Game Details Section -->
    <div class="game-post">
      <img src="../asset/images/<?= htmlspecialchars($game['cover_image']) ?>"
        alt="<?= htmlspecialchars($game['title']) ?> Cover">

      <div class="game-meta">
        <p>Released: <?= date("F j, Y", strtotime($game['release_date'])) ?></p>
        <p>Category: <?= htmlspecialchars($game['category_name'] ?? 'Uncategorized') ?></p>
      </div>

      <div class="game-description">
        <?= htmlspecialchars($game['description']) ?>
      </div>
    </div>

    <!-- Comments Section -->
    <div class="comments-section">
      <h2>Player Discussions</h2>

      <?php if (!empty($comments)): ?>
        <div class="comments-list">
          <?php foreach ($comments as $comment): ?>
            <div class="comment">
              <div class="comment-header">
                <span class="user-name">
                  <?= htmlspecialchars($comment['username']) ?>
                  <?php if ($comment['role'] === 'admin'): ?>
                    <span class="admin-badge">(Admin)</span>
                  <?php endif; ?>
                </span>
                <span class="comment-date">
                  <?= date("M j, Y g:i a", strtotime($comment['created_at'])) ?>
                </span>
              </div>
              <div class="comment-content">
                <?= htmlspecialchars($comment['content']) ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p class="no-comments">Be the first to discuss this game!</p>
      <?php endif; ?>
    </div>

    <div id="footer">
      © GameRealm 2025 - All virtual rights reserved
    </div>
  </div>
</body>

</html>