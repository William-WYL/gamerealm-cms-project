<!-- register.php -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../main.css">
  <link rel="stylesheet" href="register.css">
  <title>Register - GameRealm</title>
</head>

<body>
  <div id="wrapper">
    <div id="header">
      <h1><a href="../index.php">GameRealm - Register</a></h1>
    </div> <!-- END div id="header" -->
    <ul id="menu">
      <li><a href="../index.php">Home</a></li>
      <li><a href="login.php">Login</a></li>
    </ul> <!-- END div id="menu" -->
    <div id="user_register">
      <form action="process_register.php" method="POST" onsubmit="return validatePasswords()">
        <label>User Name: </label>
        <input type="text" name="username" required><br>

        <label>Email：</label>
        <input type="email" name="email" required><br>

        <label>Password：</label>
        <input type="password" name="password" id="password" minlength="8" placeholder="More than 8 characters" required><br>

        <label>Confirm Password：</label>
        <input type="password" name="password_confirm" id="password_confirm" minlength="8" placeholder="Two passwords must match" required><br>

        <div id="passwordError" style="color:red; display:none;"></div>

        <button type="submit">Submit</button>
        <button type="reset">Reset</button>
      </form>
    </div>
    <div id="footer">
      Copywrong 2025 - No Rights Reserved
    </div> <!-- END div id="footer" -->
  </div> <!-- END div id="wrapper" -->

  <!-- Using JS to handle password confimation, avoid backend handling -->
  <script>
    function validatePasswords() {
      const password = document.getElementById('password').value;
      const confirmPassword = document.getElementById('password_confirm').value;
      const errorDiv = document.getElementById('passwordError');

      if (password !== confirmPassword) {
        errorDiv.textContent = "Passwords do not match!";
        errorDiv.style.display = 'block';
        return false; // Prevent form submition
      }

      errorDiv.style.display = 'none';
      return true; // Allow form submition
    }
  </script>
</body>

</html>