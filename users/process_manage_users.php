<?php

/*******w******** 
    
    Name: Wei Wang
    Date: February 6, 2025
    Description: Process user management actions.

 ****************/

require('../tools/connect.php'); // Include database connection file
require('../tools/authenticate.php'); // Include authentication file to verify user session

// Check if the user is an admin
if ($_SESSION['role'] !== 'admin') {
  header('Location: ../index.php'); // Redirect to homepage if the user is not an admin
  exit;
}




$errors = []; // Initialize an empty array to store errors
$success = ''; // Initialize a variable to store success message

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $command = $_POST['command'] ?? ''; // Get the command (Create, Update, or Delete)
  $id = $_POST['id'] ?? 0; // Get the user ID if provided


  try {
    // Switch based on the command
    switch ($command) {
      case 'Create':
        // Validate input data
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $role = $_POST['role'];


        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $errors[] = "Invalid email format";
          break;
        }

        // Check if all fields are provided
        if (empty($username) || empty($email) || empty($password)) {
          $errors[] = "All fields are required."; // Add an error message if fields are missing
          break;
        }

        // Check if the username already exists
        $checkQuery = "SELECT COUNT(*) FROM users WHERE username = :username";
        $stmt = $db->prepare($checkQuery);
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
          $errors[] = "Username already exists."; // Add an error if the username exists
          break;
        }

        // Hash the password and insert the new user into the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insertQuery = "INSERT INTO users (username, email, password, role) 
                               VALUES (:username, :email, :password, :role)";
        $stmt = $db->prepare($insertQuery);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $hashedPassword);
        $stmt->bindValue(':role', $role);
        $stmt->execute();
        $success = "User created successfully."; // Set success message
        break;

      case 'Update':
        // Get the updated user data
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $role = $_POST['role'];

        // Retrieve original user data from the database
        $getUserQuery = "SELECT * FROM users WHERE id = :id";
        $stmt = $db->prepare($getUserQuery);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $originalUser = $stmt->fetch();

        // Check if the username has changed and if it already exists
        if ($originalUser['username'] !== $username) {
          $checkQuery = "SELECT COUNT(*) FROM users WHERE username = :username";
          $stmt = $db->prepare($checkQuery);
          $stmt->bindValue(':username', $username);
          $stmt->execute();
          if ($stmt->fetchColumn() > 0) {
            $errors[] = "Username already exists."; // Add error if the new username already exists
            break;
          }
        }

        // Update user data in the database
        $updateQuery = "UPDATE users SET username = :username, email = :email, role = :role WHERE id = :id";
        $stmt = $db->prepare($updateQuery);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':role', $role);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $success = "User updated successfully."; // Set success message
        break;

      case 'Delete':
        // Delete user from the database
        $deleteQuery = "DELETE FROM users WHERE id = :id";
        $stmt = $db->prepare($deleteQuery);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $success = "User deleted successfully."; // Set success message
        break;

      default:
        $errors[] = "Invalid command."; // Handle invalid command
    }
  } catch (PDOException $e) {
    $errors[] = "Database error: " . $e->getMessage(); // Catch and handle any database errors
  }

  // Redirect with error or success message
  $queryParams = [];
  if (!empty($errors)) {
    $queryParams['error'] = urlencode(implode("\n", $errors)); // Pass error message to the URL
  } elseif (!empty($success)) {
    $queryParams['success'] = urlencode($success); // Pass success message to the URL
  }
  header('Location: manage_users.php?' . http_build_query($queryParams)); // Redirect back to the user management page with message
  exit;
}

// Default redirection if no POST data is provided
header('Location: manage_users.php');
exit;
