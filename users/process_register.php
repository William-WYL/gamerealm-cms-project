<?php
require_once '../tools/connect.php';

// For security concern, this process does not allow admin user register. Assigning admin has been done by backend mysql.
// Admin username: adminwilliam
// Admin email: adminwilliam@rrc.ca
// Password: adminwilliampass

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Sanitize and validate input
  $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
  $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
  $password = $_POST['password'];

  // Validate required fields
  if (empty($username) || empty($email) || empty($password)) {
    die("All fields are required");
  }

  // Validate email format
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format");
  }

  // Validate password strength
  if (strlen($password) < 8) {
    die("Password must be at least 8 characters");
  }

  try {
    // Check for existing username or email
    $checkStmt = $db->prepare("
            SELECT COUNT(*) 
            FROM users 
            WHERE username = :username OR email = :email
        ");
    $checkStmt->execute([
      ':username' => $username,
      ':email' => $email
    ]);

    if ($checkStmt->fetchColumn() > 0) {
      die("Username or email already exists");
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    if ($hashedPassword === false) {
      throw new Exception("Password hashing failed");
    }

    // Insert new user
    $insertStmt = $db->prepare("
            INSERT INTO users (username, email, password, role)
            VALUES (:username, :email, :password, 'user')
        ");

    $insertStmt->execute([
      ':username' => $username,
      ':email' => $email,
      ':password' => $hashedPassword
    ]);

    // Success response
    echo "Registration successful! Welcome " . htmlspecialchars($username);
    header('Location: login.php'); // Redirect to login page
    exit();
  } catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    die("Registration failed. Please try again later.");
  } catch (Exception $e) {
    error_log("General error: " . $e->getMessage());
    die("An error occurred during registration.");
  }
} else {
  // Redirect if accessed directly
  header('Location: register.html');
  exit();
}
