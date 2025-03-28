<?php

/*******w******** 
    
    Name: Wei Wang
    Date: February 6, 2025
    Description: Process comment management actions.

 ****************/

require('../tools/connect.php');
require('../tools/authenticate.php');


$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $command = $_POST['command'] ?? '';
  $comment_id = $_POST['id'] ?? 0;

  try {
    switch ($command) {
      case 'Update':
        $content = trim($_POST['content']);
        $status = $_POST['status'];

        if (empty($content)) {
          $errors[] = "Comment content cannot be empty";
          break;
        }

        $stmt = $db->prepare("UPDATE comments 
                             SET content = :content, status = :status 
                             WHERE id = :id");
        $stmt->execute([
          ':content' => $content,
          ':status' => $status,
          ':id' => $comment_id
        ]);

        $success = "Comment updated successfully";
        break;

      case 'Delete':
        // Soft delete example (set status to deleted)
        $stmt = $db->prepare("DELETE FROM comments WHERE id = :id");
        $stmt->execute([':id' => $comment_id]);
        $success = "Comment marked as deleted";

        // Or hard delete:
        // $stmt = $db->prepare("DELETE FROM comments WHERE id = :id");
        // $stmt->execute([':id' => $comment_id]);
        // $success = "Comment permanently deleted";
        break;

      default:
        $errors[] = "Invalid action";
    }
  } catch (PDOException $e) {
    $errors[] = "Database error: " . $e->getMessage();
  }

  // Handle redirect
  $params = [];
  if (!empty($errors)) {
    $params['error'] = urlencode(implode("\n", $errors));
  } elseif (!empty($success)) {
    $params['success'] = urlencode($success);
  }

  header('Location: manage_comments.php?' . http_build_query($params));
  exit;
}

header('Location: manage_comments.php');
exit;
?>
<!-- End -->