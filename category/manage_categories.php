<?php

/*******w******** 
    
    Name: Wei Wang
    Date: February 6, 2025
    Description: Add a new game post.

 ****************/

require('./tools/connect.php');
require('./tools/authenticate.php');
?>

<!-- New Post Page (Authenticated Users Only): -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../main.css">
  <title>Add New Game - GameRealm</title>
</head>

<body>
  <div id="wrapper">
    <div id="header">
      <h1><a href="index.php">GameRealm - Add New Game</a></h1>
    </div> <!-- END div id="header" -->
    <ul id="menu">
      <li><a href="index.php">Home</a></li>
      <li><a href="post.php">Add New Game</a></li>
      <li><a href="manage_categories.php" class='active'>Manage Categories</a></li>
    </ul> <!-- END div id="menu" -->
    <div id="create_categories">
      <form action="process_post.php" method="post">
        <fieldset>
          <legend>Add a new category</legend>
          <label for="new_category">New category name: </label>
          <input type="text" name="new_category" id="new_category" required>
          <input type="submit" name="command" value="Create Category" />
        </fieldset>
      </form>
    </div>
    <div id="footer">
      Copywrong 2025 - No Rights Reserved
    </div> <!-- END div id="footer" -->
  </div> <!-- END div id="wrapper" -->
</body>

</html>
<!-- End -->