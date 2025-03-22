<?php

/*******w******** 
    
    Name: Wei Wang
    Date: February 6, 2025
    Description: Add a new game post.

 ****************/

require('../tools/connect.php');
require('../tools/authenticate.php');

// Fetch all categories for the dropdown
$categoryQuery = "SELECT * FROM categories ORDER BY category_name ASC";
$categoryStatement = $db->prepare($categoryQuery);
$categoryStatement->execute();
$categories = $categoryStatement->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- New Post Page (Authenticated Users Only): -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Add New Game - GameRealm</title>
</head>

<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">GameRealm - Add New Game</a></h1>
        </div> <!-- END div id="header" -->
        <ul id="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="post.php" class='active'>Add New Game</a></li>
            <li><a href="./category/manage_categories.php">Manage Categories</a></li>
        </ul> <!-- END div id="menu" -->
        <div id="all_games">
            <form action="process_post.php" method="post">
                <fieldset>
                    <legend>Add New Game</legend>
                    <label for="title">Title:</label>
                    <input type="text" name="title" id="title" required>

                    <label for="category_id">Category:</label>
                    <select name="category_id" id="category_id" required>
                        <option value="">Select a category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['category_id'] ?>">
                                <?= htmlspecialchars($category['category_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label for="release_date">Release Date:</label>
                    <input type="date" name="release_date" id="release_date" required>

                    <label for="description">Description:</label>
                    <textarea name="description" id="description" rows="5" required></textarea>

                    <label for="cover_image">Cover Image URL:</label>
                    <input type="text" name="cover_image" id="cover_image">

                    <p>
                        <input type="submit" name="command" value="Create" />
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