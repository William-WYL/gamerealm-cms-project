<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - GameRealm</title>
  <link rel="stylesheet" href="../main.css">

</head>

<body>
  <div id="wrapper">
    <div id="header">
      <h1><a href="../index.php">GameRealm - Log in</a></h1>
    </div>

    <ul id="menu">
      <li><a href="../index.php">Home</a></li>
      <li class="user-function"><a href="register.php">Sign up</a></li>
    </ul>

    <div id="login_form">
      <form action="process_login.php" method="POST">
        <label>Email:</label>
        <input type="email" name="email" required placeholder="Please enter a valid email"><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Login</button>
      </form>
    </div>

    <div id="footer">
      Copywrong 2025 - No Rights Reserved
    </div>
  </div>
</body>

</html>