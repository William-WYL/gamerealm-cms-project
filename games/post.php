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
    <!-- Bootstrap CSS -->
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../general.css">

    <!-- Include external JavaScript file -->
    <script src="./js/imageController.js"></script>
    <title>Add New Game - GameRealm</title>
</head>

<body>
    <div class="container">
        <div class="py-4 text-start">
            <h1><a href="../index.php" class="text-decoration-none text-dark">GameRealm - Add New Game</a></h1>
        </div>

        <?php
        $basePath = "../";
        $currentPage = "add_game";
        include '../components/navigation.php';
        ?>

        <div class="card">
            <div class="card-header">
                <legend class="fs-5">Add a New Game</legend>
            </div>
            <div class="card-body">
                <form action="process_post.php" method="post" enctype='multipart/form-data'>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title:</label>
                        <input type="text" name="title" id="title" class="form-control w-50" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price:</label>
                        <input
                            type="number"
                            name="price"
                            id="price"
                            class="form-control w-50"
                            step="0.01"
                            min="0"
                            max="9999.99"
                            placeholder="With 2 decimal places"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category:</label>
                        <select name="category_id" id="category_id" class="form-select w-25" required>
                            <option value="">Select a category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['category_id'] ?>">
                                    <?= htmlspecialchars($category['category_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="release_date" class="form-label">Release Date:</label>
                        <input type="date" name="release_date" id="release_date" class="form-control w-25" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description:</label>
                        <textarea name="description" id="description" rows="5" class="form-control w-75" required></textarea>
                    </div>

                    <!-- Image upload section -->
                    <!-- File upload section -->
                    <div id="image_container" class="mb-3">

                        <div class="mb-3">
                            <label for="preview_image" class="form-label">Cover Image:</label>
                            <img id="preview_image" src="" alt="Image Preview" style="width: 300px; display: none;">
                        </div>

                        <div class="mb-3">
                            <label for="cover_image" class="form-label">Upload a new image:</label>
                            <input type="file" name="cover_image" id="cover_image" class="form-control">
                            <small class="text-muted">Optional. (JPG, PNG)</small>
                        </div>
                    </div>


                    <div class="mb-3">
                        <input type="checkbox" name="delete_image" id="delete_image" value="1">
                        <label for="delete_image" class="form-label">I don't need any image for this game.</label>
                    </div>

                    <!-- Submit section -->
                    <p>
                        <input class="btn btn-primary" type="submit" name="command" value="Create" />
                    </p>
                </form>
            </div>
        </div>
        <!-- Footer -->
        <?php include '../components/footer.php'; ?>
    </div> <!-- End Container -->

    <script>

    </script>
</body>

</html>