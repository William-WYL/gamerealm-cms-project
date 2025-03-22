<?php

/*******w******** 
    
    Name: Wei Wang
    Date: February 6, 2025
    Description: Edit a game post.

 ****************/

require('../tools/connect.php');
require('../tools/authenticate.php');

// Validate the game ID
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    header("refresh:1; URL=../index.php"); // Redirect to index.php after 1 seconds  
    die("Invalid game post ID."); // Stop execution if the ID is missing or invalid
}

$id = $_GET['id'];

// Fetch the game post by ID with its category
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

// If no game post is found, show an error
if (!$game) {
    header("refresh:1; URL=../index.php"); // Redirect to index.php after 1 seconds  
    die("Game post with ID $id not found."); // Stop execution if the post does not exist
}

// Fetch all categories for the dropdown
$categoryQuery = "SELECT * FROM categories ORDER BY category_name ASC";
$categoryStatement = $db->prepare($categoryQuery);
$categoryStatement->execute();
$categories = $categoryStatement->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Edit Post Page (Authenticated Users Only): -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../main.css">
    <title>Edit Game - GameRealm</title>
</head>

<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="../index.php">GameRealm - Edit Game</a></h1>
        </div> <!-- END div id="header" -->
        <ul id="menu">
            <li><a href="../index.php">Home</a></li>
            <li><a href="post.php">Add New Game</a></li>
            <li><a href="../categories/manage_categories.php">Manage Categories</a></li>
        </ul> <!-- END div id="menu" -->
        <div id="all_games">
            <form action="process_post.php" method="post">
                <fieldset>
                    <legend>Edit Game Details</legend>
                    <p>
                        <label for="title">Title:</label>
                        <input type="text" name="title" id="title" value="<?= htmlspecialchars($game['title']) ?>" required>
                    </p>
                    <p>
                        <label for="category_id">Category:</label>
                        <select name="category_id" id="category_id" required>
                            <option value="">Select a category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['category_id'] ?>"
                                    <?= ($category['category_id'] == $game['category_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category['category_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </p>
                    <p>
                        <label for="release_date">Release Date:</label>
                        <input type="date" name="release_date" id="release_date"
                            value="<?= htmlspecialchars($game['release_date']) ?>" required>
                    </p>
                    <p>
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" rows="5" required><?= htmlspecialchars($game['description']) ?></textarea>
                    </p>
                    <p>
                        <label for="cover_image">Cover Image URL:</label>
                        <input type="text" name="cover_image" id="cover_image" value="<?= htmlspecialchars($game['cover_image']) ?>">
                    </p>
                    <p>
                        <input type="hidden" name="id" value="<?= $game['id'] ?>" />
                        <input type="submit" name="command" value="Update" />
                        <input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />
                    </p>
                </fieldset>
            </form>
        </div>
        <div id="footer">
            Copywrong 2025 - No Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>

</html>