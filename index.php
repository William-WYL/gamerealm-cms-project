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

// Fetch games with their category names
$query = "
    SELECT g.*, c.category_name 
    FROM games g
    LEFT JOIN categories c ON g.category_id = c.category_id
    ORDER BY $orderBy 
";

$statement = $db->prepare($query);
$statement->execute();

?>

<!-- Home Page -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css" type="text/css">
    <link rel="stylesheet" href="index.css" type="text/css">
    <title>Welcome to GameRealm!</title>
</head>

<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">GameRealm</a></h1>
        </div> <!-- END div id="header" -->
        <ul id="menu">
            <li><a href="index.php" class='active'>Home</a></li>
            <li><a href="./games/post.php">Add New Game</a></li>
            <li><a href="./categories/manage_categories.php">Manage Categories</a></li>
            <?php if (isset($_SESSION['username'])): ?>
                <!-- Login user display -->
                <li class="user-info">
                    Welcome, <?= htmlspecialchars($_SESSION['username']) ?>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <span class="admin-badge">(Admin)</span>
                    <?php endif; ?>
                </li>
                <li><a href="./users/logout.php">Logout</a></li>
            <?php else: ?>
                <!-- Unlogin user display -->
                <li><a href="./users/register.php">Register</a></li>
                <li><a href="./users/login.php">Login</a></li>
            <?php endif; ?>
        </ul>
        </ul> <!-- END div id="menu" -->

        <div class="sort-options">
            <ul id="menu">
                <span>Sort by:</span>
                <small>
                    <li><a href="index.php?sort=title" class="<?= $sort == 'title' ? 'active' : '' ?>">Title</a></li>
                </small>
                <small>
                    <li><a href="index.php?sort=category" class="<?= $sort == 'category' ? 'active' : '' ?>">Category</a></li>
                </small>
                <small>
                    <li><a href="index.php?sort=date" class="<?= $sort == 'date' ? 'active' : '' ?>">Release Date</a></li>
                </small>
            </ul>
        </div>

        <div id="all_games">
            <?php while ($game = $statement->fetch()): ?>
                <div class="game_post">
                    <h2>
                        <a href="comments/show_comments.php?id=<?= $game['id'] ?>">
                            <?= htmlspecialchars($game['title']) ?>
                        </a>
                    </h2>
                    <div class="game_image">
                        <img
                            src="./asset/images/<?= htmlspecialchars($game['cover_image']) ?>"
                            alt="<?= htmlspecialchars($game['title']) ?>" />
                    </div>
                    <p>
                        <small>
                            Release Date:
                            <?= date("F j, Y", strtotime($game['release_date'])) ?>
                        </small>
                    </p>
                    <p>
                        <small>
                            ID: <?= htmlspecialchars($game['id']) ?>
                            <a href="games/edit.php?id=<?= htmlspecialchars($game['id']) ?>">edit/delete</a>
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
                    <div>
                        <small>
                            <a href="comments/show_comments.php?id=<?= htmlspecialchars($game['id']) ?>">See Comments</a>
                        </small>
                    </div>
                </div>
            <?php endwhile ?>
        </div><!-- END div id="all_games" -->
        <div id="footer">
            Copywrong 2025 - No Rights Reserved
        </div> <!-- END div id="footer" -->
    </div><!-- END div id="wrapper" -->
</body>

</html>