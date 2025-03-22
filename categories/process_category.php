<?php

/*******w******** 
    
    Name: Wei Wang
    Date: February 6, 2025
    Description: Handles category CRUD operations

 ****************/

require('../tools/connect.php');
require('../tools/authenticate.php');

// Function to sanitize user input
function sanitizeInput($input)
{
  return filter_input(INPUT_POST, $input, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

// Function to validate category ID
function validateId($id)
{
  return filter_var($id, FILTER_VALIDATE_INT) && $id > 0;
}

// Function to execute database queries
function executeQuery($query, $params)
{
  global $db;
  $statement = $db->prepare($query);
  foreach ($params as $key => $value) {
    $statement->bindValue($key, $value);
  }
  $statement->execute();
  return $statement;
}

try {
  $command = $_POST['command'] ?? '';
  $category_id = $_POST['category_id'] ?? null;
  $category_name = trim(sanitizeInput('category_name'));

  // Validation
  $errors = [];
  $valid_commands = ['Create', 'Update', 'Delete'];
  if (!in_array($command, $valid_commands)) {
    $errors[] = "Invalid operation command";
  }

  if (in_array($command, ['Update', 'Delete']) && !validateId($category_id)) {
    $errors[] = "Invalid category ID";
  }

  if (in_array($command, ['Create', 'Update'])) {
    if (empty($category_name)) {
      $errors[] = "Category name cannot be empty";
    } elseif (strlen($category_name) > 255) {
      $errors[] = "Category name is too long (max 255 characters)";
    }

    // Check for duplicate names
    if (empty($errors)) {
      $query = "SELECT COUNT(*) FROM categories WHERE category_name = :category_name";
      $params = [':category_name' => $category_name];
      if ($command === 'Update') {
        $query .= " AND category_id != :category_id";
        $params[':category_id'] = $category_id;
      }
      $stmt = executeQuery($query, $params);
      if ($stmt->fetchColumn() > 0) {
        $errors[] = "Category name already exists";
      }
    }
  }

  if (!empty($errors)) {
    throw new Exception(implode(" | ", $errors));
  }

  $db->beginTransaction();

  switch ($command) {
    case 'Create':
      $stmt = executeQuery(
        "INSERT INTO categories (category_name) VALUES (:category_name)",
        [':category_name' => $category_name]
      );
      if ($stmt->rowCount() === 0) {
        throw new Exception("Failed to create category");
      }
      $db->commit();
      header("Location: manage_categories.php?success=Category created successfully");
      exit;

    case 'Update':
      $stmt = executeQuery(
        "UPDATE categories SET category_name = :category_name WHERE category_id = :category_id",
        [':category_name' => $category_name, ':category_id' => $category_id]
      );
      if ($stmt->rowCount() === 0) {
        throw new Exception("No changes made or update failed");
      }
      $db->commit();
      header("Location: manage_categories.php?success=Category updated successfully");
      exit;

    case 'Delete':
      $stmt = executeQuery(
        "SELECT COUNT(*) FROM games WHERE category_id = :category_id",
        [':category_id' => $category_id]
      );
      if ($stmt->fetchColumn() > 0) {
        throw new Exception("Cannot delete: Category is associated with games");
      }
      $stmt = executeQuery(
        "DELETE FROM categories WHERE category_id = :category_id",
        [':category_id' => $category_id]
      );
      if ($stmt->rowCount() === 0) {
        throw new Exception("Failed to delete category");
      }
      $db->commit();
      header("Location: manage_categories.php?success=Category deleted successfully");
      exit;
  }
} catch (PDOException $e) {
  $db->rollBack();
  error_log("Database error: " . $e->getMessage());
  header("Location: manage_categories.php?error=Database operation failed");
  exit;
} catch (Exception $e) {
  $db->rollBack();
  header("Location: manage_categories.php?error=" . urlencode($e->getMessage()));
  exit;
}
?>
<!-- End -->