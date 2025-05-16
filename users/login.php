<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - GameRealm</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../general.css">
</head>

<body>
  <div class="container">
    <!-- Navigation Bar -->
    <?php
    $basePath = "../";
    $currentPage = "login";
    include '../components/navigation.php';
    ?>

    <!-- Login Form Section -->
    <div id="login_form" class="container mt-5 mb-5">
      <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6">
          <h4 class="text-center mb-4">Log in to Your Account</h4>
          <form action="process_login.php" method="POST">
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control shadow-sm" id="email" name="email" required placeholder="Please enter a valid email">
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control shadow-sm" id="password" name="password" required placeholder="Enter your password">
            </div>

            <div class="d-flex justify-content-center gap-3">
              <button type="submit" class="btn btn-primary btn-lg px-4">Login</button>
            </div>
          </form>
        </div> <!-- End of form column -->
      </div> <!-- End of row -->
    </div> <!-- End of login_form container -->

    <!-- Footer Section -->
    <div id="footer" class="text-center py-4 mt-5">
      <p>&copy; 2025 GameRealm - All Rights Reserved</p>
    </div> <!-- END div id="footer" -->
  </div> <!-- END div container -->

  <!-- Bootstrap JS (Optional for any form validation or interactive components) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>