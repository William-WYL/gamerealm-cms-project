<?php

/*******w******** 
    
    Name: Wei Wang
    Date: February 6, 2025
    Description: Comment management page for administrators.

 ****************/

require('../tools/connect.php');
require('../tools/authenticate.php');

// Pagination settings
$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Build search query
$searchConditions = [];
$params = [];

if (!empty($_GET['id'])) {
  $searchConditions[] = "c.id = :id";
  $params[':id'] = $_GET['id'];
}

if (!empty($_GET['content'])) {
  $searchConditions[] = "c.content LIKE :content";
  $params[':content'] = '%' . $_GET['content'] . '%';
}

if (!empty($_GET['user_id'])) {
  $searchConditions[] = "c.user_id = :user_id";
  $params[':user_id'] = $_GET['user_id'];
}

if (!empty($_GET['game_id'])) {
  $searchConditions[] = "c.game_id = :game_id";
  $params[':game_id'] = $_GET['game_id'];
}

if (!empty($_GET['status'])) {
  $searchConditions[] = "c.status = :status";
  $params[':status'] = $_GET['status'];
}

// Base query with JOINs
$query = "SELECT c.*, u.username, g.title 
          FROM comments c
          LEFT JOIN users u ON c.user_id = u.id
          LEFT JOIN games g ON c.game_id = g.id";

if (!empty($searchConditions)) {
  $query .= " WHERE " . implode(" AND ", $searchConditions);
}
$query .= " ORDER BY c.created_at DESC LIMIT :limit OFFSET :offset";

$statement = $db->prepare($query);
foreach ($params as $key => $value) {
  $statement->bindValue($key, $value);
}

$statement->bindValue(':limit', $limit, PDO::PARAM_INT);
$statement->bindValue(':offset', $offset, PDO::PARAM_INT);
$statement->execute();
$comments = $statement->fetchAll();

// Get total count for pagination
$countQuery = "SELECT COUNT(*) FROM comments" . (!empty($searchConditions) ? " WHERE " . implode(" AND ", $searchConditions) : "");
$countStatement = $db->prepare($countQuery);
foreach ($params as $key => $value) {
  $countStatement->bindValue($key, $value);
}
$countStatement->execute();
$totalComments = $countStatement->fetchColumn();
$totalPages = ceil($totalComments / $limit);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../general.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Manage Comments - GameRealm</title>
</head>

<body>
  <div class="container">

    <?php
    $basePath = "../";
    $currentPage = "comments";
    include '../components/navigation.php';
    ?>

    <div class="container my-4">
      <!-- Search Form -->
      <form method="get" class="mb-5 border p-3">
        <fieldset>
          <legend class="fs-5">Search Comments</legend>
          <div class="row g-3">
            <div class="col-md-2">
              <input type="number" name="id" placeholder="Comment ID" class="form-control">
            </div>
            <div class="col-md-3">
              <input type="text" name="content" placeholder="Content" class="form-control">
            </div>
            <div class="col-md-2">
              <input type="number" name="user_id" placeholder="User ID" class="form-control">
            </div>
            <div class="col-md-2">
              <input type="number" name="game_id" placeholder="Game ID" class="form-control">
            </div>
            <div class="col-md-2">
              <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="approved">Approved</option>
                <option value="pending">Pending</option>
                <option value="trash">Trash</option>
              </select>
            </div>
            <div class="col-md-1">
              <button type="submit" class="btn btn-primary">Search</button>
            </div>
          </div>
        </fieldset>
      </form>

      <!-- Messages -->
      <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
          <?= htmlspecialchars(str_replace('+', ' ', $_GET['success'])) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" />
        </div>
      <?php endif; ?>

      <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
          <?= htmlspecialchars(str_replace('+', ' ', $_GET['error'])) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" />
        </div>
      <?php endif; ?>

      <!-- Comments Table -->
      <div class="border p-3">
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Content</th>
              <th>User</th>
              <th>Game</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($comments as $comment): ?>
              <tr>
                <form action="process_manage_comments.php" method="post">
                  <input type="hidden" name="id" value="<?= $comment['id'] ?>">
                  <td><?= $comment['id'] ?></td>
                  <td class="col-4">
                    <textarea name="content" class="form-control" rows="2"><?= htmlspecialchars($comment['content']) ?></textarea>
                  </td>
                  <td><?= $comment['username'] ?? 'Unknown User' ?></td>
                  <td><?= $comment['title'] ?? 'Unknown Game' ?></td>
                  <td>
                    <select name="status" class="form-select">
                      <option value="approved" <?= $comment['status'] == 'approved' ? 'selected' : '' ?>>Approved</option>
                      <option value="pending" <?= $comment['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                      <option value="trash" <?= $comment['status'] == 'trash' ? 'selected' : '' ?>>Trash</option>
                    </select>
                  </td>
                  <td>
                    <button type="submit" name="command" value="Update" class="btn btn-warning" style="width: 81px;">Update</button>
                    <button type="submit" name="command" value="Delete"
                      onclick="return confirm('Permanently delete this comment?')"
                      class="btn btn-danger"
                      style="width: 81px;">Delete</button>
                  </td>
                </form>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <div class="mb-2">Total Comments: <span class="text-info"><?= $totalComments ?></span></div>

        <!-- Pagination Navigation -->
        <?php include '../components/pagination.php'; ?>

      </div>
    </div>
  </div>
  <!-- Footer -->
  <?php include '../components/footer.php'; ?>

  </div> <!-- END div container -->



  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>