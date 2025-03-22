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
      <form action="process_register.php" method="POST">
        <label>User Name: </label>
        <input type="text" name="username" required><br>

        <label>Email：</label>
        <input type="email" name="email" required><br>

        <label>Password：</label>
        <input type="password" name="password" minlength="8" placeholder="Password must be at least 8 characters."><br>

        <button type="submit">Submit</button>
        <button type="reset">Reset</button>
      </form>
    </div>
    <div id="footer">
      Copywrong 2025 - No Rights Reserved
    </div> <!-- END div id="footer" -->
  </div> <!-- END div id="wrapper" -->
</body>

</html>