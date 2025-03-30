<?php
session_start();
require('./tools/connect.php');

// Get all categories for navigation dropdown
$categoryQuery = "SELECT * FROM categories ORDER BY category_name";
$categoryStatement = $db->prepare($categoryQuery);
$categoryStatement->execute();
$categories = $categoryStatement->fetchAll();

// Get selected category ID from URL
$currentCategoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;

// Validate sorting parameter
$validSorts = ['title', 'category', 'date'];
$sort = isset($_GET['sort']) && in_array($_GET['sort'], $validSorts) ? $_GET['sort'] : 'date';

// Set ORDER BY clause based on sort
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

// Build WHERE clause if category is selected
$whereClause = '';
$queryParams = [];
if ($currentCategoryId > 0) {
    $whereClause = 'WHERE g.category_id = :category_id';
    $queryParams[':category_id'] = $currentCategoryId;
}

// Pagination calculations
$gamesPerPage = 9;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $gamesPerPage;

// Modify main query to include pagination
$query = "
    SELECT g.*, c.category_name 
    FROM games g
    LEFT JOIN categories c ON g.category_id = c.category_id
    {$whereClause}
    ORDER BY {$orderBy}
    LIMIT :limit OFFSET :offset
";

$statement = $db->prepare($query);
foreach ($queryParams as $param => $value) {
    $statement->bindValue($param, $value);
}
$statement->bindValue(':limit', $gamesPerPage, PDO::PARAM_INT);
$statement->bindValue(':offset', $offset, PDO::PARAM_INT);
$statement->execute();

// Get total games count for pagination
$totalQuery = "SELECT COUNT(*) FROM games g {$whereClause}";
$totalStatement = $db->prepare($totalQuery);
foreach ($queryParams as $param => $value) {
    $totalStatement->bindValue($param, $value);
}
$totalStatement->execute();
$totalGames = $totalStatement->fetchColumn();
$totalPages = ceil($totalGames / $gamesPerPage);
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

        <?php
        $basePath = "./";
        $currentPage = "home";
        include './components/navigation.php';
        ?>


        <!-- Sorting options (Admin only) -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <div id="sorting" class="py-3 ">
                <span>Sort by:</span>
                <a href="index.php?sort=title" class="btn btn-outline-dark btn-sm <?= $sort == 'title' ? 'active' : '' ?>">Title</a>
                <a href="index.php?sort=category" class="btn btn-outline-dark btn-sm <?= $sort == 'category' ? 'active' : '' ?>">Category</a>
                <a href="index.php?sort=date" class="btn btn-outline-dark btn-sm <?= $sort == 'date' ? 'active' : '' ?>">Release Date</a>
            </div>
        <?php endif; ?>


        <?php
        // Get the current category name
        $currentCategoryName = 'All Categories';
        if ($currentCategoryId > 0) {
            foreach ($categories as $category) {
                if ($category['category_id'] == $currentCategoryId) {
                    $currentCategoryName = htmlspecialchars($category['category_name']);
                    break;
                }
            }
        }
        ?>
        <nav class="navbar navbar-expand-lg dropdown">
            <a class="nav-link dropdown-toggle"
                href="#" role="button" data-bs-toggle="dropdown">
                <?= $currentCategoryName ?>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item"
                        href="index.php">
                        All Categories
                    </a>
                </li>
                <?php foreach ($categories as $category): ?>
                    <li>
                        <a class="dropdown-item <?= $currentCategoryId == $category['category_id'] ? 'active' : '' ?>"
                            href="index.php?category_id=<?= $category['category_id'] ?>">
                            <?= htmlspecialchars($category['category_name']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <!-- Game List -->
        <div id="game-list" class="row mt-3">
            <!-- If no games, give  -->
            <?php if ($statement->rowCount() === 0): ?>
                <div class="col-12 text-center py-5">
                    <div class="alert alert-warning w-50 mx-auto">
                        <h4 class="alert-heading">No Games Found</h4>
                        <p class="mb-0">
                            <?php if ($currentCategoryId > 0): ?>
                                No games available in this category.
                            <?php else: ?>
                                No games available in the database.
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            <?php else: ?>
                <!-- Existing game card content -->
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
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php include './components/pagination.php'; ?>

        <!-- Footer -->
        <?php include './components/footer.php'; ?>
    </div> <!-- End Container -->
</body>

</html>