<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../general.css">
  <title>Register - GameRealm</title>
</head>

<body>
  <div class="container">
    <div class="py-4 text-start">
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
          </ul>
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link active" href="register.php">Sign up</a></li>
            <li class="nav-item"><a class="nav-link" href="login.php">Log in</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Registration Form Section -->
    <div id="user_register" class="container mt-5 mb-5">
      <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6">
          <h4 class="text-center mb-4">Create Your Account</h4>
          <form action="process_register.php" method="POST" onsubmit="return validatePasswords()">
            <div class="mb-3">
              <label for="username" class="form-label">User Name</label>
              <input type="text" class="form-control shadow-sm" id="username" name="username" required>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control shadow-sm" id="email" name="email" placeholder="Please provide a valid email" required>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control shadow-sm" id="password" name="password" minlength="8" placeholder="More than 8 characters" required>
            </div>

            <div class="mb-3">
              <label for="password_confirm" class="form-label">Confirm Password</label>
              <input type="password" class="form-control shadow-sm" id="password_confirm" name="password_confirm" minlength="8" placeholder="Two passwords must match" required>
            </div>

            <div id="passwordError" class="text-danger mb-3" style="display:none;"></div>

            <div class="d-flex justify-content-center gap-3">
              <button type="submit" class="btn btn-primary btn-lg px-4">Submit</button>
              <button type="reset" class="btn btn-secondary btn-lg px-4">Reset</button>
            </div>
          </form>
        </div> <!-- End of form column -->
      </div> <!-- End of row -->
    </div> <!-- End of user_register container -->

    <!-- Footer Section -->
    <div id="footer" class="text-center py-4 mt-5">
      <p>&copy; 2025 GameRealm - All Rights Reserved</p>
    </div> <!-- END div id="footer" -->
  </div> <!-- END div id="wrapper" -->

  <!-- Bootstrap JS (Optional for any form validation or interactive components) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Password Validation JS -->
  <script>
    function validatePasswords() {
      const password = document.getElementById('password').value;
      const confirmPassword = document.getElementById('password_confirm').value;
      const errorDiv = document.getElementById('passwordError');

      if (password !== confirmPassword) {
        errorDiv.textContent = "Passwords do not match!";
        errorDiv.style.display = 'block';
        return false; // Prevent form submission
      }

      errorDiv.style.display = 'none';
      return true; // Allow form submission
    }
  </script>
</body>

</html>