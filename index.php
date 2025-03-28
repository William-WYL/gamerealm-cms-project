<?php

/*******w******** 
    
    Name: Wei Wang
    Date: 

 ****************/

session_start();
require('./tools/connect.php');

// Define valid sorting options
$validSorts = ['title', 'category', 'date'];
$sort = isset($_GET['sort']) && in_array($_GET['sort'], $validSorts) ? $_GET['sort'] : 'date';


// Set the ORDER BY clause based on the selected sort option
switch ($sort) {
    case 'title':
        $orderBy = 'g.title ASC';
        break;
    case 'category':
        $orderBy = 'c.category_name ASC';
        break;
    case 'date':
    default:
        $orderBy = 'g.release_date DESC';
        break;
}

// Page settings
$gamesPerPage = 9;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $gamesPerPage;

// Fetch total number of games
$totalQuery = "SELECT COUNT(*) FROM games";
$totalStatement = $db->prepare($totalQuery);
$totalStatement->execute();
$totalGames = $totalStatement->fetchColumn();
$totalPages = ceil($totalGames / $gamesPerPage);

// Fetch games with their category names
$query = "
    SELECT g.*, c.category_name 
    FROM games g
    LEFT JOIN categories c ON g.category_id = c.category_id
    ORDER BY $orderBy 
    LIMIT :limit OFFSET :offset
";

$statement = $db->prepare($query);
$statement->bindValue(':limit', $gamesPerPage, PDO::PARAM_INT);
$statement->bindValue(':offset', $offset, PDO::PARAM_INT);
$statement->execute();
?>

<!-- Home Page -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="general.css" type="text/css">
    <title>Welcome to GameRealm!</title>
</head>

<body class="bg-body">
    <div class="container">
        <div class="py-4 text-start">
            <h1><a href="index.php" class="fs-1 fw-bolder text-decoration-none text-dark">GameRealm</a></h1>
        </div> <!-- END div id="header" -->

        <!-- Navigation -->
        <nav id="menu" class="navbar navbar-expand-lg navbar-light bg-light border-bottom ">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item active"><a class="nav-link active" href="index.php">Home</a></li>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <li class="nav-item"><a class="nav-link" href="./games/post.php">Add Game</a></li>
                            <li class="nav-item"><a class="nav-link" href="./categories/manage_categories.php">Categories</a></li>
                            <li class="nav-item"><a class="nav-link" href="./users/manage_users.php">Users</a></li>
                            <li class="nav-item"><a class="nav-link" href="./comments/manage_comments.php">Comments</a></li>
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

        <!-- Sorting options (Admin only) -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <div id="sorting" class="py-3 ">
                <span>Sort by:</span>
                <a href="index.php?sort=title" class="btn btn-outline-dark btn-sm <?= $sort == 'title' ? 'active' : '' ?>">Title</a>
                <a href="index.php?sort=category" class="btn btn-outline-dark btn-sm <?= $sort == 'category' ? 'active' : '' ?>">Category</a>
                <a href="index.php?sort=date" class="btn btn-outline-dark btn-sm <?= $sort == 'date' ? 'active' : '' ?>">Release Date</a>
            </div>
        <?php endif; ?>

        <!-- Game List -->
        <div id="game-list" class="row mt-3">
            <?php while ($game = $statement->fetch()): ?>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="game_post p-3">
                        <h2 class="h5">
                            <a href="comments/show_comments.php?id=<?= $game['id'] ?>" class="text-dark text-decoration-none">
                                <?= htmlspecialchars($game['title']) ?>
                            </a>
                        </h2>
                        <div class="game_image mb-2">
                            <?php if (isset($game['cover_image'])) : ?>
                                <a href="comments/show_comments.php?id=<?= $game['id'] ?>">
                                    <img src="./asset/images/<?= htmlspecialchars($game['cover_image']) ?>"
                                        alt="<?= htmlspecialchars($game['title']) ?>" class="img-fluid">
                                </a>
                            <?php else : ?>
                                <a href="comments/show_comments.php?id=<?= $game['id'] ?>" class="text-decoration-none">
                                    <div class="no-image text-center fs-3 fw-light text-body-secondary" style="margin:auto;">No Image</div>
                                </a>
                            <?php endif ?>

                        </div>

                        <p class="small text-muted">
                            <strong>Category:</strong> <?= !empty($game['category_name']) ? htmlspecialchars($game['category_name']) : 'Uncategorized' ?>
                        </p>

                        <!-- Hide the description if it is longer than 50 letters. -->
                        <div class='blog_content'>
                            <?php if (strlen($game['description']) > 50): ?>
                                <!-- Ensure special characters(spaces and line breaks) are displayed correctly in HTML -->
                                <p class="small"> <?= nl2br(htmlspecialchars(html_entity_decode(substr(html_entity_decode($game['description']), 0, 200)))) ?>...</p>
                            <?php else: ?>
                                <p class="small"> <?= nl2br(htmlspecialchars(html_entity_decode($game['description']))) ?> </p>
                            <?php endif; ?>
                        </div>
                        <p class="small text-muted"><strong>Release Date:</strong> <?= date("F j, Y", strtotime($game['release_date'])) ?></p>
                        <a href="comments/show_comments.php?id=<?= htmlspecialchars($game['id']) ?>" class="btn btn-sm btn-outline-secondary">Comments</a>

                        <!-- Admin controls -->
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <p class="mt-2 text-muted small">
                                ID: <?= htmlspecialchars($game['id']) ?>
                                <a href="games/edit.php?id=<?= htmlspecialchars($game['id']) ?>" class="text-danger">edit/delete</a>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link text-dark border-dark bg-white" href="?page=<?= $page - 1 ?>">Prev</a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link border-dark <?= ($i == $page) ? 'bg-dark text-white' : 'bg-white text-dark' ?>"
                            href="index.php?sort=<?= $sort ?>&page=<?= $i ?>"> <?= $i ?> </a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                    <a class="page-link text-dark border-dark bg-white" href="?page=<?= $page + 1 ?>">Next</a>
                </li>
            </ul>
        </nav>

        <!-- Footer -->
        <footer class="text-center py-3">
            <p class="small text-muted">Copywrong 2025 - No Rights Reserved</p>
        </footer>
    </div> <!-- End Container -->
</body>

</html>