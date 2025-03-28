<?php
session_start();
require_once '../tools/connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: login.php');
  exit();
}

// Task finished:  Validation and Sanitazation
// Sanitize inputs
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = $_POST['password'];

// Validate inputs
if (empty($email) || empty($password)) {
  die("Please fill in all fields");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo "Invalid email format";
  exit;
}

try {
  // Get user from database
  $stmt = $db->prepare("
        SELECT id, username, password, role 
        FROM users 
        WHERE email = :email
        LIMIT 1
    ");
  $stmt->execute([':email' => $email]);
  $user = $stmt->fetch();

  if (!$user || !password_verify($password, $user['password'])) {
    error_log("Failed login attempt for email: $email");
    echo "Invalid email or password";
    exit;
  }

  // Regenerate session ID to prevent fixation
  session_regenerate_id(true);

  // Set session variables
  $_SESSION['user_id'] = $user['id'];
  $_SESSION['username'] = $user['username'];
  $_SESSION['role'] = $user['role'];
  $_SESSION['last_login'] = time();

  // Redirect to index.php on which you can see you user name
  header('Location: ../index.php');
  exit();
} catch (PDOException $e) {
  error_log("Login error: " . $e->getMessage());
  die("System error. Please try again later.");
} ?>
<!-- End -->