<?php
session_start();
require('../tools/connect.php');
require('../tools/authenticate.php');

require "../tools/ImageResize.php";
require "../tools/ImageResizeException.php";

use \Gumlet\ImageResize;

// Handle image upload
// Function to validate if the file is an image
function file_is_an_image($temporary_path, $new_path)
{
    $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
    $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];

    $actual_file_extension   = strtolower(pathinfo($new_path, PATHINFO_EXTENSION));
    $actual_mime_type = mime_content_type($temporary_path);

    $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
    $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);

    return $file_extension_is_valid && $mime_type_is_valid;
}

$cover_image = null;
if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
    // Get the temporary file path and the new file path
    $temporary_path = $_FILES['cover_image']['tmp_name'];
    $new_path = $_FILES['cover_image']['name'];

    // Validate the uploaded file using the file_is_an_image function
    if (!file_is_an_image($temporary_path, $new_path)) {
        die("Error: Only JPG, PNG, GIF files are allowed.");
    }

    // Generate a unique filename
    $file_extension = strtolower(pathinfo($new_path, PATHINFO_EXTENSION));
    $filename = uniqid() . '.' . $file_extension;
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/WebDev2/Project/gamerealm-cms/asset/images/';
    $target_path = $target_dir . $filename;

    // Ensure the directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Move the uploaded file
    if (!move_uploaded_file($temporary_path, $target_path)) {
        die("Error: Failed to upload image.");
    }

    // Create resized versions
    try {
        // Process image resizing
        $resized_image = new ImageResize($target_path);
        $resized_image->resizeToWidth(600);

        // Save resized version and overwrite original
        $resized_image->save($target_path);
    } catch (Exception $e) {
        // Cleanup on failure
        if (file_exists($target_path)) {
            unlink($target_path);
        }
        die("Image processing failed: " . $e->getMessage());
    }

    $cover_image = $filename;
}

// General input filtering and validation
function sanitizeInput($input)
{
    return filter_input(INPUT_POST, $input, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

// 4.2 ID sanitation and validation
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$title = sanitizeInput('title');
$price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$release_date = sanitizeInput('release_date');
$description = sanitizeInput('description');
$category_id = sanitizeInput('category_id');

// ID validation
if ($id && !filter_var($id, FILTER_VALIDATE_INT)) {
    die("Invalid ID: must be a number.");
}

// Price validation
if (!filter_var($price, FILTER_VALIDATE_FLOAT) || $price < 0) {
    die("Invalid price: must be a positive number.");
}

if (strpos($price, '.') !== false && strlen(explode('.', $price)[1]) > 2) {
    die("Invalid price: max 2 decimal places.");
}


// Validate required fields
$requiredFields = [
    'title' => $title,
    'price' => $price,
    'release_date' => $release_date,
    'description' => $description,
    'category_id' => $category_id
];

foreach ($requiredFields as $field => $value) {
    if (empty($value)) {
        die("Error: " . ucfirst($field) . " cannot be empty.");
    }
}

// 4.1 Explaination, title and description


// Validate date format
if (!DateTime::createFromFormat('Y-m-d', $release_date)) {
    die("Error: Invalid date format. Use YYYY-MM-DD.");
}

// Validate category ID
if (!filter_var($category_id, FILTER_VALIDATE_INT)) {
    die("Error: Invalid category selection.");
}

try {
    $db->beginTransaction();

    switch ($_POST['command']) {
        case 'Create':
            $query = "INSERT INTO games 
                     (title, price, release_date, description, cover_image, category_id) 
                     VALUES 
                     (:title, :price, :release_date, :description, :cover_image, :category_id)";

            $params = [
                ':title' => $title,
                ':price' => $price,
                ':release_date' => $release_date,
                ':description' => $description,
                ':cover_image' => $cover_image,
                ':category_id' => $category_id
            ];

            $statement = $db->prepare($query);
            $statement->execute($params);
            $newId = $db->lastInsertId();
            $db->commit();

            // Set flash message for creation
            $_SESSION['success'] = "Game created successfully.";
            header("Location: dashboard.php");
            // header("Location: ../comments/show_comments.php?id=$newId");
            exit;

        case 'Update':
            if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
                throw new Exception("Invalid game ID");
            }

            // Get the old image filename
            $stmt = $db->prepare("SELECT cover_image FROM games WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $old_image = $stmt->fetchColumn();



            // Check if the "delete image" checkbox is checked
            $deleteImageChecked = isset($_POST['delete_image']) && $_POST['delete_image'] == '1';


            if ($old_image) {
                $old_image_path = $_SERVER['DOCUMENT_ROOT'] . '/WebDev2/Project/gamerealm-cms/asset/images/' . $old_image;

                // If the checkbox is checked and there is an old image, delete it
                if ($deleteImageChecked) {
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                    $cover_image = null;
                }

                // If a new image is uploaded, handle the old image
                if ($cover_image) {
                    $old_image_path = $_SERVER['DOCUMENT_ROOT'] . '/WebDev2/Project/gamerealm-cms/asset/images/' . $old_image;
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
            }

            // If no new image is provided and delete checkbox is not checked, keep the old image.
            if (!$cover_image && !$deleteImageChecked) {
                $cover_image = $old_image;
            }

            $query = "UPDATE games SET 
                     title = :title,
                     price = :price,
                     release_date = :release_date,
                     description = :description,
                     cover_image = :cover_image,
                     category_id = :category_id
                     WHERE id = :id";

            $params = [
                ':title' => $title,
                ':price' => $price,
                ':release_date' => $release_date,
                ':description' => $description,
                ':cover_image' => $cover_image,
                ':category_id' => $category_id,
                ':id' => $id
            ];



            $statement = $db->prepare($query);
            $statement->execute($params);
            $db->commit();

            // Set flash message for update
            $_SESSION['success'] = "Game updated successfully.";
            header("Location: ../games/edit.php?id=$id");

            exit;

        case 'Delete':
            if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
                throw new Exception("Invalid game ID");
            }

            // Delete the associated image file
            $stmt = $db->prepare("SELECT cover_image FROM games WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $image = $stmt->fetchColumn();

            if ($image) {
                $image_path = $_SERVER['DOCUMENT_ROOT'] . '/WebDev2/Project/gamerealm-cms/asset/images/' . $image;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }

            $query = "DELETE FROM games WHERE id = :id";
            $statement = $db->prepare($query);
            $statement->execute([':id' => $id]);
            $db->commit();

            // A flash message for deletion.
            $_SESSION['success'] = "Game deleted successfully.";
            header("Location: dashboard.php");
            // header("Location: ../index.php")
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
<!-- End -->