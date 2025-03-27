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
    <title>Add New Game - GameRealm</title>
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
                            <li class="nav-item active"><a class="nav-link active" href="post.php">Add Game</a></li>
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

        <div class="card">
            <div class="card-header">
                <legend class="fs-5">Add a New Game</legend>
            </div>
            <div class="card-body">
                <form action="process_post.php" method="post">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title:</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category:</label>
                        <select name="category_id" id="category_id" class="form-select" required>
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
                        <input type="date" name="release_date" id="release_date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description:</label>
                        <textarea name="description" id="description" rows="5" class="form-control" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="cover_image" class="form-label">Cover Image:</label>
                        <input type="file" name="cover_image" id="cover_image" class="form-control" accept="image/*">
                        <small class="text-muted">Max size: 2MB (JPEG, PNG, GIF)</small>
                    </div>

                    <p>
                        <input class="btn btn-primary" type="submit" name="command" value="Create" />
                    </p>
                </form>
            </div>
        </div>

        <footer class="text-center py-3 mt-4">
            <p class="small text-muted">Copywrong 2025 - No Rights Reserved</p>
        </footer>
    </div> <!-- End Container -->
</body>

</html>