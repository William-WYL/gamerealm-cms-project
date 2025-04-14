<?php
session_start();
require('./tools/connect.php');

// Get all categories for dropdowns
$categoryQuery = "SELECT * FROM categories ORDER BY category_name";
$categoryStatement = $db->prepare($categoryQuery);
$categoryStatement->execute();
$categories = $categoryStatement->fetchAll();

// Handle search parameters
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$currentCategoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
$validSorts = ['title', 'category', 'date', 'price'];
$sort = isset($_GET['sort']) && in_array($_GET['sort'], $validSorts) ? $_GET['sort'] : 'date';

// Pagination configuration
$gamesPerPage = 12;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $gamesPerPage;

// Build base query conditions
$queryConditions = [];
$queryParams = [];

// Add category filter
if ($currentCategoryId > 0) {
    $queryConditions[] = 'g.category_id = :category_id';
    $queryParams[':category_id'] = $currentCategoryId;
}

// Add search term filter
if (!empty($searchTerm)) {
    $queryConditions[] = '(g.title LIKE :search)';
    // OR g.description LIKE :search
    $queryParams[':search'] = "%{$searchTerm}%";
}

// Construct WHERE clause
$whereClause = $queryConditions ? 'WHERE ' . implode(' AND ', $queryConditions) : '';

// Configure sorting
switch ($sort) {

    case 'title':
        $orderBy = 'g.title ASC';
        break;
    case 'price':
        $orderBy = 'g.price DESC';
        break;
    case 'date':
    default:
        $orderBy = 'g.release_date DESC';
        break;
}

// Main data query
$query = "
    SELECT SQL_CALC_FOUND_ROWS g.*, c.category_name 
    FROM games g
    LEFT JOIN categories c ON g.category_id = c.category_id
    {$whereClause}
    ORDER BY {$orderBy}
    LIMIT :limit OFFSET :offset
";

// Execute main query
$statement = $db->prepare($query);
foreach ($queryParams as $param => $value) {
    $statement->bindValue($param, $value);
}
$statement->bindValue(':limit', $gamesPerPage, PDO::PARAM_INT);
$statement->bindValue(':offset', $offset, PDO::PARAM_INT);
$statement->execute();
$games = $statement->fetchAll();

// Get total matching games
$totalGames = $db->query('SELECT FOUND_ROWS()')->fetchColumn();
$totalPages = ceil($totalGames / $gamesPerPage);

// Get current category name
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameRealm</title>
    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="general.css" type="text/css">
    <script src="./tools/decodeHtmlEntity.js"></script>
</head>

<body class="bg-body">
    <div class="container">
        <!-- Header -->
        <div class="py-4 text-start">
            <h1><a href="index.php" class="fs-1 fw-bolder text-decoration-none text-dark">GameRealm</a></h1>
        </div> <!-- END div id="header" -->

        <?php
        $basePath = "./";
        $currentPage = "home";
        include './components/navigation.php';
        ?>

        <!-- Main Search Form -->
        <div id="Search" class="d-flex w-100">
            <!-- Search Trigger Button -->
            <div class="text-center mb-4">
                <button class="btn btn-dark btn-md"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#searchForm"
                    aria-expanded="false"
                    aria-controls="searchForm">
                    Search Games
                </button>
            </div>

            <!-- Collapsible Search Form -->
            <div class="collapse w-75" id="searchForm">
                <div class="container-sm">
                    <form method="get" action="index.php">
                        <div class="input-group">
                            <input type="text"
                                name="search"
                                class="form-control form-control-md"
                                placeholder="Search games by title..."
                                value="<?= htmlspecialchars($searchTerm) ?>">

                            <select name="category_id" class="form-select form-select-md">
                                <option value="0">All Categories</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['category_id'] ?>"
                                        <?= $currentCategoryId == $category['category_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category['category_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <button type="submit" class="btn btn-dark btn-md">
                                Confirm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Results Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>
                <?php if ($searchTerm): ?>
                    Results for "<?= htmlspecialchars($searchTerm) ?>"
                <?php else: ?>
                    All Games
                <?php endif; ?>
                <small class="text-muted">(<?= $totalGames ?> found)</small>
            </h4>

            <!-- Sorting Controls -->
            <div class="btn-group shadow-lg">
                <a href="?<?= http_build_query([
                                'search' => $searchTerm,
                                'category_id' => $currentCategoryId,
                                'sort' => 'title'
                            ]) ?>" class="btn btn-outline-dark <?= $sort === 'title' ? 'active' : '' ?>">
                    Sort by Title
                </a>
                <a href="?<?= http_build_query([
                                'search' => $searchTerm,
                                'category_id' => $currentCategoryId,
                                'sort' => 'price'
                            ]) ?>" class="btn btn-outline-dark <?= $sort === 'price' ? 'active' : '' ?>">
                    Sort by Price
                </a>
                <a href="?<?= http_build_query([
                                'search' => $searchTerm,
                                'category_id' => $currentCategoryId,
                                'sort' => 'date'
                            ]) ?>" class="btn btn-outline-dark <?= $sort === 'date' ? 'active' : '' ?>">
                    Sort by Date
                </a>
            </div>
        </div>

        <!-- Game Grid -->
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
            <?php if (empty($games)): ?>
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        No games found matching your criteria
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($games as $game): ?>
                    <div class="col">
                        <div class="card game-card h-100 shadow">
                            <?php if ($game['cover_image']): ?>
                                <a href="comments/show_comments.php?id=<?= $game['id'] ?>"
                                    class="text-decoration-none text-dark">
                                    <img src="asset/images/<?= htmlspecialchars($game['cover_image']) ?>"
                                        class="card-img-top"
                                        alt="<?= htmlspecialchars($game['title']) ?>">
                                </a>
                            <?php else: ?>
                                <a href="comments/show_comments.php?id=<?= $game['id'] ?>"
                                    class="text-decoration-none text-dark">
                                    <div id="no_image" style=" background-color: gainsboro; width: 100%; height:200px; text-align: center; ">No Image</div>
                                </a>
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="comments/show_comments.php?id=<?= $game['id'] ?>"
                                        class="text-decoration-none text-dark">
                                        <?= htmlspecialchars($game['title']) ?>
                                    </a>
                                </h5>
                                <p class="small text-muted">
                                    <strong>Category:</strong> <?= !empty($game['category_name']) ? htmlspecialchars($game['category_name']) : 'Uncategorized' ?>
                                </p>
                                <p class="small text-muted">
                                    <strong>Price:</strong> $<?= !empty($game['price']) ? htmlspecialchars($game['price']) : 'Uncategorized' ?>
                                </p>
                                <p class="card-text text-muted">
                                    <?= htmlspecialchars(truncateDescription(html_entity_decode($game['description']))) ?>
                                </p>
                                <!-- Admin controls -->
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                    <p class="mt-2 text-muted small">
                                        ID: <?= htmlspecialchars($game['id']) ?>
                                        <a href="games/edit.php?id=<?= htmlspecialchars($game['id']) ?>" class="text-danger">edit/delete</a>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <div class="card-footer bg-white">
                                <small class="text-muted">
                                    <?= date('M j, Y', strtotime($game['release_date'])) ?>
                                </small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Pagination: particular for index -->
        <?php if ($totalPages > 1): ?>
            <nav class="mt-5">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link text-dark border-dark bg-white"
                            href="?<?= http_build_query([
                                        'search' => $searchTerm,
                                        'category_id' => $currentCategoryId,
                                        'sort' => $sort,
                                        'page' => $page - 1
                                    ]) ?>">
                            Prev
                        </a>
                    </li>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                            <a class="page-link <?= $i === $page ? 'bg-dark text-white' : 'text-dark border-dark bg-white' ?>"
                                href="?<?= http_build_query([
                                            'search' => $searchTerm,
                                            'category_id' => $currentCategoryId,
                                            'sort' => $sort,
                                            'page' => $i
                                        ]) ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link text-dark border-dark bg-white"
                            href="?<?= http_build_query([
                                        'search' => $searchTerm,
                                        'category_id' => $currentCategoryId,
                                        'sort' => $sort,
                                        'page' => $page + 1
                                    ]) ?>">
                            Next
                        </a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>


        <!-- Footer -->
        <?php include './components/footer.php'; ?>
    </div>

    <?php
    // Helper function to truncate long descriptions
    function truncateDescription($text, $maxLength = 50)
    {
        if (strlen($text) <= $maxLength) return $text;
        $truncated = substr($text, 0, strpos($text, ' ', $maxLength));
        return $truncated ? $truncated . '...' : substr($text, 0, $maxLength) . '...';
    }
    ?>


    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>