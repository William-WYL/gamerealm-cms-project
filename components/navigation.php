<!-- navigation.php -->
<nav id="menu" class="navbar navbar-expand-lg navbar-light bg-light border-bottom mb-2">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link fs-5 <?= ($currentPage === 'home') ? 'active' : '' ?>" href="<?= $basePath ?>index.php">Home</a>
        </li>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
          <li class="nav-item">
            <?php if ($currentPage === 'edit_game_details'): ?>
              <a class="nav-link fs-5 active" href="#">Edit Game Details</a>
            <?php else: ?>
              <a class="nav-link fs-5 <?= ($currentPage === 'add_game') ? 'active' : '' ?>" href="<?= $basePath ?>games/post.php">Add Game</a>
            <?php endif; ?>
          </li>
          <li class="nav-item">
            <a class="nav-link  fs-5 <?= ($currentPage === 'categories') ? 'active' : '' ?>" href="<?= $basePath ?>categories/manage_categories.php">Categories</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fs-5 <?= ($currentPage === 'users') ? 'active' : '' ?>" href="<?= $basePath ?>users/manage_users.php">Users</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fs-5 <?= ($currentPage === 'comments') ? 'active' : '' ?>" href="<?= $basePath ?>comments/manage_comments.php">Comments</a>
          </li>
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
          <li class="nav-item">
            <a class="nav-link <?= ($currentPage === 'logout') ? 'active' : '' ?>" href="<?= $basePath ?>users/logout.php">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link <?= ($currentPage === 'signup') ? 'active' : '' ?>" href="<?= $basePath ?>users/register.php">Sign up</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($currentPage === 'login') ? 'active' : '' ?>" href="<?= $basePath ?>users/login.php">Log in</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<!-- End -->