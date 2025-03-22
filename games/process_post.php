<?php

/*******w******** 
    
    Name: Wei Wang
    Date: February 6, 2025
    Description: Blogging Application (CRUD tasks), handle update, create, delete

 ****************/

require('../tools/connect.php');

// Function to sanitize user input
function sanitizeInput($input)
{
    return filter_input(INPUT_POST, $input, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

// Function to validate date format
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

// Function to execute queries
function executeQuery($query, $params)
{
    global $db;
    $statement = $db->prepare($query);
    foreach ($params as $key => $value) {
        $statement->bindValue($key, $value);
    }
    return $statement->execute();
}

// Get the command from POST request (Create, Update, Delete)
$command = $_POST['command'] ?? '';

// Common input sanitization
$id = isset($_POST['id']) ? $_POST['id'] : null;
$title = sanitizeInput('title');
$release_date = sanitizeInput('release_date');
$description = sanitizeInput('description');
$cover_image = sanitizeInput('cover_image');
$category_id = sanitizeInput('category_id');

// ID validation
$isInvalidId = !$id || !filter_var($id, FILTER_VALIDATE_INT);

// Validate required fields
$requiredFields = [
    'title' => $title,
    'release_date' => $release_date,
    'description' => $description,
    'category_id' => $category_id
];

foreach ($requiredFields as $field => $value) {
    if (empty($value)) {
        die("Error: " . ucfirst($field) . " cannot be empty.");
    }
}

// Validate data formats
if (!validateDate($release_date)) {
    die("Error: Invalid date format. Use YYYY-MM-DD.");
}

if (!filter_var($category_id, FILTER_VALIDATE_INT)) {
    die("Error: Invalid category selection.");
}

// Handle different actions
try {
    $db->beginTransaction();

    switch ($command) {
        case 'Create':
            $query = "INSERT INTO games 
                     (title, release_date, description, cover_image, category_id) 
                     VALUES 
                     (:title, :release_date, :description, :cover_image, :category_id)";

            $params = [
                ':title' => $title,
                ':release_date' => $release_date,
                ':description' => $description,
                ':cover_image' => $cover_image,
                ':category_id' => $category_id
            ];

            $statement = $db->prepare($query);
            $statement->execute($params);
            $newId = $db->lastInsertId();
            $db->commit();
            header("Location: ../comments/show_comments.php?id=$newId");
            exit;

        case 'Update':
            if ($isInvalidId) {
                throw new Exception("Invalid game ID");
            }

            $query = "UPDATE games SET 
                     title = :title,
                     release_date = :release_date,
                     description = :description,
                     cover_image = :cover_image,
                     category_id = :category_id
                     WHERE id = :id";

            $params = [
                ':title' => $title,
                ':release_date' => $release_date,
                ':description' => $description,
                ':cover_image' => $cover_image,
                ':category_id' => $category_id,
                ':id' => $id
            ];

            $statement = $db->prepare($query);
            $statement->execute($params);
            $db->commit();
            header("Location: ../comments/show_comments.php?id=$id");
            exit;

        case 'Delete':
            if ($isInvalidId) {
                throw new Exception("Invalid game ID");
            }

            $query = "DELETE FROM games WHERE id = :id";
            $statement = $db->prepare($query);
            $statement->execute([':id' => $id]);
            $db->commit();
            header("Location: ../index.php");
            exit;

        default:
            throw new Exception("Invalid action");
    }
} catch (PDOException $e) {
    $db->rollBack();
    die("Database error: " . $e->getMessage());
} catch (Exception $e) {
    $db->rollBack();
    die("Error: " . $e->getMessage());
}
?>
<!-- end -->