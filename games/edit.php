<?php

/*******w******** 
    
    Name: Wei Wang
    Date: February 6, 2025
    Description: Edit a game post.

 ****************/

session_start();
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
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../general.css">

    <!-- Include external JavaScript file -->
    <script src="./js/imageController.js"></script>
    <title>Edit Game - GameRealm</title>
</head>

<body>
    <div id="wrapper">
        <div class="container">


            <?php
            $basePath = "../";
            $currentPage = "edit_game_details";
            include '../components/navigation.php';
            ?>

            <!-- Message Section -->
            <?php if (isset($_SESSION['success'])): ?>
                <div id="success-message" class="alert alert-success alert-dismissible fade show">
                    <?= htmlspecialchars($_SESSION['success']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['success']); // Remove message after displaying 
                ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div id="error-message" class="alert alert-danger alert-dismissible fade show">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['error']); // Remove message after displaying 
                ?>
            <?php endif; ?>
            </ul> <!-- END div id="menu" -->
            <div class="card">
                <div class="card-header">
                    <legend class="fs-5">Edit Game Details</legend>
                </div>
                <div class="card-body">
                    <form action="process_post.php" method="post" enctype='multipart/form-data'>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title:</label>
                            <input type="text" name="title" id="title" class="form-control w-50" value="<?= htmlspecialchars($game['title']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price (with 2 decimal places):</label>
                            <input
                                type="number"
                                name="price"
                                id="price"
                                class="form-control w-50"
                                step="0.01"
                                min="0"
                                max="9999.99"
                                placeholder="With 2 decimal places"
                                value="<?= htmlspecialchars($game['price']) ?>"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category:</label>
                            <select name="category_id" id="category_id" class="form-select w-50" required>
                                <option value="">Select a category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['category_id'] ?>"
                                        <?= ($category['category_id'] == $game['category_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category['category_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="release_date" class="form-label">Release Date:</label>
                            <input type="date" name="release_date" id="release_date" class="form-control w-50" value="<?= htmlspecialchars($game['release_date']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea name="description" id="description" rows="5" class="form-control w-75" required><?= htmlspecialchars(html_entity_decode($game['description'])) ?></textarea>
                        </div>

                        <div id="image_container" class="mb-3">
                            <label for="preview_image" class="form-label">Cover Image:</label>
                            <div>
                                <img id="preview_image" style="width: 300px;" src="../asset/images/<?= htmlspecialchars($game['cover_image']) ?>" alt="<?= htmlspecialchars($game['cover_image']) ?>">
                            </div>
                            <div><?= htmlspecialchars($game['cover_image']) ?></div>
                        </div>

                        <div class="mb-3">
                            <label for="cover_image" class="form-label">Upload a new image:</label>
                            <input type="file" name="cover_image" id="cover_image" class="form-control w-50">
                        </div>

                        <div class="mb-3">
                            <input type="checkbox" name="delete_image" id="delete_image" value="1">
                            <label for="delete_image" class="form-label">I don't need any image for this game.</label>
                        </div>

                        <input type="hidden" name="id" value="<?= $game['id'] ?>" />

                        <div class="d-flex justify-content-start ">
                            <input type="submit" class="btn btn-primary m-2" name="command" value="Update">
                            <input type="submit" class="btn btn-danger m-2" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')">
                        </div>
                    </form>
                </div>
            </div>

            <footer class="text-center py-3 mt-4">
                <p class="small text-muted">Copywrong 2025 - No Rights Reserved</p>
            </footer>
        </div> <!-- End Container -->

</body>

</html>