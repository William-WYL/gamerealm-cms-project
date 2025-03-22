<?php

/*******w******** 
    
    Name: Wei Wang
    Date: February 6, 2025
    Description: Display a single game post with comments.

 ****************/

require('../tools/connect.php');

// Validate the game ID
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
  header("refresh:1; URL=../index.php");
  die("Invalid game post ID."); // Stop execution if the ID is missing or invalid
}

$id = $_GET['id'];

// Fetch the game post by ID with its category name
$gameQuery = "
    SELECT g.*, c.category_name 
    FROM games g
    LEFT JOIN categories c ON g.category_id = c.category_id
    WHERE g.id = :id
";
$gameStatement = $db->prepare($gameQuery);
$gameStatement->bindValue(':id', $id, PDO::PARAM_INT);
$gameStatement->execute();
$game = $gameStatement->fetch(PDO::FETCH_ASSOC);

// If no game post is found, display an error message
if (!$game) {
  header("refresh:1; URL=../index.php");
  die("Game post not found.");
}

// Fetch comments for the current game
$commentQuery = "SELECT * FROM comments WHERE game_id = :game_id ORDER BY created_at DESC";
$commentStatement = $db->prepare($commentQuery);
$commentStatement->bindValue(':game_id', $id, PDO::PARAM_INT);
$commentStatement->execute();
$comments = $commentStatement->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Full Game Post -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>GameRealm - <?= htmlspecialchars($game['title']) ?></title>
  <link rel="stylesheet" href="../main.css" type="text/css">
</head>

<body>
  <div id="wrapper">
    <div id="header">
      <h1><a href="../index.php">GameRealm - <?= htmlspecialchars($game['title']) ?></a></h1>
    </div> <!-- END div id="header" -->
    <ul id="menu">
      <li><a href="../index.php">Home</a></li>
    </ul> <!-- END div id="menu" -->
    <div id="all_games">
      <div class="game_post">
        <h2><?= htmlspecialchars($game['title']) ?></h2>
        <p>
          <small>
            Release Date:
            <?= date("F j, Y, g:i a", strtotime($game['release_date'])) ?>
          </small>
        </p>
        <p>
          <small>
            ID: <?= htmlspecialchars($game['id']) ?>
            <a href="../games/edit.php?id=<?= htmlspecialchars($game['id']) ?>">Edit/Delete</a>
          </small>
        </p>
        <div class='game_category'>
          <small>
            Category:
            <?= !empty($game['category_name']) ? htmlspecialchars($game['category_name']) : 'Uncategorized' ?>
          </small>
        </div>
        <div class='game_description'>
          <small>
            Description: <?= htmlspecialchars($game['description']) ?>
          </small>
        </div>

        <!-- Display Comments -->
        <div id="comments">
          <h3>Comments</h3>
          <?php if (!empty($comments)): ?>
            <ul>
              <?php foreach ($comments as $comment): ?>
                <li>
                  <strong><?= htmlspecialchars($comment['username']) ?></strong>
                  <span><?= date("F j, Y, g:i a", strtotime($comment['created_at'])) ?></span>
                  <p><?= htmlspecialchars($comment['content']) ?></p>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <p>No comments yet. Be the first to comment!</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div id="footer">
      Copywrong 2025 - No Rights Reserved
    </div> <!-- END div id="footer" -->
  </div> <!-- END div id="wrapper" -->
</body>

</html>