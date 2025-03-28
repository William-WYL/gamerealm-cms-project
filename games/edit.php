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
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../general.css">

    <!-- Include external JavaScript file -->
    <script src="./validateImageGracefully.js"></script>
    <title>Edit Game - GameRealm</title>
</head>

<body>
    <div id="wrapper">
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
                                <li class="nav-item"><a class="nav-link" href="post.php">Add Game</a></li>
                                <li class="nav-item active"><a class="nav-link active" href="#">Edit Game Details</a></li>
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
            </ul> <!-- END div id="menu" -->
            <div class="card">
                <div class="card-header">
                    <legend class="fs-5">Edit Game Details</legend>
                </div>
                <div class="card-body">
                    <form action="process_post.php" method="post" enctype='multipart/form-data'>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title:</label>
                            <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($game['title']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category:</label>
                            <select name="category_id" id="category_id" class="form-select" required>
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
                            <input type="date" name="release_date" id="release_date" class="form-control" value="<?= htmlspecialchars($game['release_date']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea name="description" id="description" rows="5" class="form-control" required><?= htmlspecialchars($game['description']) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="cover_image" class="form-label">Cover Image URL:</label>
                            <div>
                                <img style="width: 300px;" src="../asset/images/<?= htmlspecialchars($game['cover_image']) ?>" alt="No Cover Image">
                            </div>
                            <div><?= htmlspecialchars($game['cover_image']) ?></div>
                        </div>

                        <div class="mb-3">
                            <label for="cover_image" class="form-label">Upload a new image:</label>
                            <input type="file" name="cover_image" id="cover_image" class="form-control">
                            <small class="text-muted">Optional. (JPG, PNG)</small>
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