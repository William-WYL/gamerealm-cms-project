<?php

/*******w******** 
    
    Name: Wei Wang
    Date: February 6, 2025
    Description: Add a new game post.

 ****************/

require('../tools/connect.php');
require('../tools/authenticate.php');
?>

<!-- New Post Page (Authenticated Users Only): -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../main.css">
  <link rel="stylesheet" href="category.css">
  <title>Add New Game - GameRealm</title>
</head>

<body>
  <div id="wrapper">
    <div id="header">
      <h1><a href="../index.php">GameRealm - Add New Game</a></h1>
    </div> <!-- END div id="header" -->
    <ul id="menu">
      <li><a href="../index.php">Home</a></li>
      <li><a href="../games/post.php">Add New Game</a></li>
      <li><a href="manage_categories.php" class='active'>Manage Categories</a></li>
      <li><a href="../users/manage_users.php">Manage Users</a></li>
      <li><a href="../comments/manage_comments.php">Manage Comments</a></li>
      <?php if (isset($_SESSION['username'])): ?>
        <!-- Login user display -->
        <li class="user-info">
          Welcome, <?= htmlspecialchars($_SESSION['username']) ?>
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <span class="admin-badge">(Admin)</span>
          <?php endif; ?>
        </li>
        <li class="user-function"><a href="../users/logout.php">Logout</a></li>
      <?php else: ?>
        <!-- Unlogin user display -->
        <li class="user-function"><a href="../users/register.php">Sign up</a></li>
        <li class="user-function"><a href="../users/login.php">Log in</a></li>
      <?php endif; ?>
    </ul> <!-- END div id="menu" -->

    <div id="create_categories">
      <form action="process_category.php" method="post">
        <fieldset>
          <legend>Add a new category</legend>
          <label for="category_name">New category name: </label>
          <input type="text" name="category_name" id="category_name" required>
          <input type="submit" name="command" value="Create">
        </fieldset>
      </form>
    </div>
    <?php if (isset($_GET['success'])): ?>
      <div class="success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
      <div class="error"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>
    <!-- category list -->
    <div id="category_list">

      <?php
      // Fetch all categories
      $query = "SELECT * FROM categories ORDER BY category_name";
      $statement = $db->query($query);
      $categories = $statement->fetchAll();
      ?>
      <fieldset>
        <legend>Existing Categories</legend>
        <?php foreach ($categories as $category): ?>
          <form action="process_category.php" method="post">
            <input type="hidden" name="category_id" value="<?= $category['category_id'] ?>">
            <input type="text" name="category_name" value="<?= htmlspecialchars($category['category_name']) ?>">
            <button type="submit" name="command" value="Update">Update</button>
            <button type="submit" name="command" value="Delete" onclick="return confirm('Delete?')">Delete</button>
          </form>
        <?php endforeach; ?>
      </fieldset>
    </div>
    <div id="footer">
      Copywrong 2025 - No Rights Reserved
    </div> <!-- END div id="footer" -->
  </div> <!-- END div id="wrapper" -->

</body>

</html>
<!-- End -->