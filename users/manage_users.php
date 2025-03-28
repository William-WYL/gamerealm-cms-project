<?php

/*******w******** 
    
    Name: Wei Wang
    Date: February 6, 2025
    Description: User management page for administrators.

 ****************/

require('../tools/connect.php');
require('../tools/authenticate.php');


// Handle search parameters
$searchConditions = [];
$params = [];

if (!empty($_GET['id'])) {
  $searchConditions[] = "id = :id";
  $params[':id'] = $_GET['id'];
}

if (!empty($_GET['username'])) {
  $searchConditions[] = "username LIKE :username";
  $params[':username'] = '%' . $_GET['username'] . '%';
}

if (!empty($_GET['email'])) {
  $searchConditions[] = "email LIKE :email";
  $params[':email'] = '%' . $_GET['email'] . '%';
}

if (!empty($_GET['role'])) {
  $searchConditions[] = "role = :role";
  $params[':role'] = $_GET['role'];
}

$query = "SELECT * FROM users";
if (!empty($searchConditions)) {
  $query .= " WHERE " . implode(" AND ", $searchConditions);
}
$query .= " ORDER BY id"; // Order the results by id

// Prepare and execute the query with bound parameters
$statement = $db->prepare($query);
foreach ($params as $key => $value) {
  $statement->bindValue($key, $value); // Bind each parameter to the prepared statement
}
$statement->execute(); // Execute the query
$users = $statement->fetchAll(); // Fetch all results

// Pagination logic
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 3; // temp
$offset = ($page - 1) * $limit;

$totalQuery = "SELECT COUNT(*) FROM users";
$totalStatement = $db->prepare($totalQuery);
$totalStatement->execute();
$totalUsers = $totalStatement->fetchColumn();
$totalPages = ceil($totalUsers / $limit);

$query .= " LIMIT :limit OFFSET :offset";
$statement = $db->prepare($query);
foreach ($params as $key => $value) {
  $statement->bindValue($key, $value);
}
$statement->bindValue(':limit', $limit, PDO::PARAM_INT);
$statement->bindValue(':offset', $offset, PDO::PARAM_INT);
$statement->execute();
$users = $statement->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../general.css"> <!-- Link to general styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Link to Bootstrap CSS -->
  <title>Manage Users - GameRealm</title>
</head>

<body>
  <div class="container">
    <div class="py-4 text-start ">
      <h1><a href="../index.php" class="text-decoration-none text-dark">GameRealm - Manage Users</a></h1>
    </div>

    <!-- Navigation bar section -->
    <nav id="menu" class="navbar navbar-expand-lg navbar-light bg-light border-bottom mb-2">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
              <li class="nav-item"><a class="nav-link " href="../games/post.php">Add Game</a></li>
              <li class="nav-item "><a class="nav-link " href="../categories/manage_categories.php">Categories</a></li>
              <li class="nav-item active"><a class="nav-link active" href="manage_users.php">Users</a></li>
              <li class="nav-item"><a class="nav-link" href="../comments/manage_comments.php">Comments</a></li>
            <?php endif; ?>
          </ul>
          <ul class="navbar-nav ms-auto">
            <?php if (isset($_SESSION['username'])): ?>
              <li class="nav-item">
                <span class="nav-link text-primary">Welcome, <?= htmlspecialchars($_SESSION['username']) ?>
                  <?php if ($_SESSION['role'] === 'admin'): ?>
                    <span class="admin-badge text-warning">(Admin)</span>
                  <?php endif; ?>
                </span>
              </li>
              <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            <?php else: ?>
              <li class="nav-item"><a class="nav-link" href="register.php">Sign up</a></li>
              <li class="nav-item"><a class="nav-link" href="login.php">Log in</a></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container my-4">
      <!-- Add new user form -->
      <form action="process_manage_users.php" method="post" class="mb-5 border p-3">
        <fieldset>
          <legend class="fs-5">Add New User</legend>
          <div class="row g-3">
            <div class="col-md-3">
              <input type="text" name="username" placeholder="Username" class="form-control" required>
            </div>
            <div class="col-md-3">
              <input type="email" name="email" placeholder="Email" class="form-control" required>
            </div>
            <div class="col-md-3">
              <input type="password" name="password" placeholder="Password" class="form-control" required>
            </div>
            <div class="col-md-3">
              <select name="role" class="form-select" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
              </select>
            </div>
            <div class="col-md-2">
              <button type="submit" name="command" value="Create" class="btn btn-success" style="width: 100px">Add User</button>
            </div>
          </div>
        </fieldset>
      </form>

      <!-- Search form for users -->
      <form method="get" class="mb-5 border p-3">
        <fieldset>
          <legend class="fs-5">Search Users</legend>
          <div class="row g-3">
            <div class="col-md-3">
              <input type="number" name="id" placeholder="User ID" class="form-control">
            </div>
            <div class="col-md-3">
              <input type="text" name="username" placeholder="Username" class="form-control">
            </div>
            <div class="col-md-3">
              <input type="email" name="email" placeholder="Email" class="form-control">
            </div>
            <div class="col-md-3">
              <select name="role" class="form-select">
                <option value="">All Roles</option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
              </select>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary" style="width: 100px">Search</button>
            </div>
          </div>
        </fieldset>
      </form>

      <!-- Message section -->
      <?php if (isset($_GET['success'])): ?>
        <div id="success-message" class="alert alert-success alert-dismissible fade show">
          <?= htmlspecialchars(str_replace('+', ' ', $_GET['success'])) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <?php if (isset($_GET['error'])): ?>
        <div id="error-message" class="alert alert-danger alert-dismissible fade show">
          <?= htmlspecialchars(str_replace('+', ' ', $_GET['error'])) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <!-- User list table -->
      <div class="border p-3">
        <fieldset>
          <legend class="fs-5">User List</legend>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $user): ?>
                <tr>
                  <form action="process_manage_users.php" method="post">
                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                    <td><?= $user['id'] ?></td>
                    <td>
                      <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" class="form-control" required>
                    </td>
                    <td>
                      <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="form-control" required>
                    </td>
                    <td>
                      <select name="role" class="form-select">
                        <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                      </select>
                    </td>
                    <td class="d-flex gap-2">
                      <button type="submit" name="command" value="Update" class="btn btn-warning">Update</button>
                      <button type="submit" name="command" value="Delete" onclick="return confirm('Delete this user?')" class="btn btn-danger">Delete</button>
                    </td>
                  </form>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </fieldset>
      </div>
    </div>

    <!-- Pagination Navigation -->
    <?php if ($totalUsers > $limit): ?>
      <nav class="pagination justify-content-center mt-3">
        <ul class="pagination">
          <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page - 1 ?>">Prev</a>
          </li>
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
              <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
          <?php endfor; ?>
          <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
          </li>
        </ul>
      </nav>
    <?php endif; ?>

    <!-- Footer Section -->
    <div id="footer" class="text-center py-4 mt-5">
      <p>&copy; 2025 GameRealm - All Rights Reserved</p>
    </div> <!-- END div id="footer" -->

  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>