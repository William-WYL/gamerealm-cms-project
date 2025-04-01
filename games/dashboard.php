<?php
session_start(); // Start the session to access session variables

// Check if there's a success message to display
if (isset($_SESSION['success'])) {
  $successMessage = $_SESSION['success'];
  unset($_SESSION['success']); // Unset the session variable after displaying the message
}
?>

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
  <title>Dashbord</title>
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

    <!-- Main content -->
    <div class="row mt-5">
      <div class="col-12">
        <?php if (isset($successMessage)): ?>
          <!-- Alert message for success -->
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $successMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <script>
            // After 2 seconds, automatically redirect to the dashboard
            setTimeout(function() {
              window.location.href = "../index.php"; // Redirect after 2 seconds
            }, 5000);
          </script>
        <?php endif; ?>
      </div>

      <!-- Footer -->
      <?php include '../components/footer.php'; ?>
    </div>
    <!-- End of Container -->

    <!-- End -->