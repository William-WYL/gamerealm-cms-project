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
  <link rel="stylesheet" href="../general.css">
  <link rel="stylesheet" href="category.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Manage Categories - GameRealm</title>
</head>

<body>
  <div class="container">
    <div class="py-4 text-start ">
      <h1><a href="../index.php" class="text-decoration-none text-dark">GameRealm - Manage Categories</a></h1>
    </div>

    <?php
    $basePath = "../";
    $currentPage = "categories";
    include '../components/navigation.php';
    ?>

    <div id="create_categories" class="container my-4">
      <form action="process_manage_categories.php" method="post">
        <fieldset>
          <legend class="fs-5">Add a new category</legend>
          <div class="row mb-3">
            <div class="col-md-3">
              <input type="text" name="category_name" id="category_name" class="form-control" required>
            </div>
            <div class="col-md-3">
              <button type="submit" name="command" value="Create" class="btn btn-primary">Create</button>
            </div>
          </div>
          <div>

          </div>
        </fieldset>
      </form>
    </div>

    <?php if (isset($_GET['success'])): ?>
      <div id="success-message" class="alert alert-success alert-dismissible fade show">
        <?= htmlspecialchars($_GET['success']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
      <div id="error-message" class="alert alert-danger alert-dismissible fade show">
        <?= htmlspecialchars($_GET['error']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <!-- category list -->
    <div id="category_list" class="container my-4">

      <?php
      // Fetch all categories
      $query = "SELECT * FROM categories ORDER BY category_name";
      $statement = $db->query($query);
      $categories = $statement->fetchAll();
      ?>
      <fieldset>
        <legend class="fs-5">Existing Categories</legend>
        <?php foreach ($categories as $category): ?>
          <form action="process_manage_categories.php" method="post" class="mb-3">
            <input type="hidden" name="category_id" value="<?= $category['category_id'] ?>">
            <div class="row mb-3">
              <!-- Category Name Input -->
              <div class="col-md-3">
                <input type="text" name="category_name" value="<?= htmlspecialchars($category['category_name']) ?>" class="form-control" required>
              </div>

              <!-- Update and Delete Buttons -->
              <div class="col-md-6 d-flex justify-content-start">
                <button type="submit" name="command" value="Update" class="btn btn-warning me-2">Update</button>
                <button type="submit" name="command" value="Delete" onclick="return confirm('Delete?')" class="btn btn-danger">Delete</button>
              </div>
            </div>
          </form>
        <?php endforeach; ?>
      </fieldset>
    </div>

    <!-- Footer -->
    <?php include '../components/footer.php'; ?>
  </div> <!-- END div id="wrapper" -->

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Hide messages -->
  <script>
    // Automatically hide success or error messages after 5 seconds
    window.onload = function() {
      const successMessage = document.getElementById('success-message');
      const errorMessage = document.getElementById('error-message');

      if (successMessage) {
        setTimeout(function() {
          successMessage.classList.remove('show'); // Hides the success message
        }, 5000); // 5000 milliseconds = 5 seconds
      }

      if (errorMessage) {
        setTimeout(function() {
          errorMessage.classList.remove('show'); // Hides the error message
        }, 5000); // 5000 milliseconds = 5 seconds
      }
    }
  </script>
</body>

</html>
<!-- End -->