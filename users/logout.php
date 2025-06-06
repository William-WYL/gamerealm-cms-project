<?php
// users/logout.php
session_start();

// Resect session
$_SESSION = array();

// Delete session cookies
if (ini_get("session.use_cookies")) {
  $params = session_get_cookie_params();
  setcookie(
    session_name(),
    '',
    time() - 3600,
    $params["path"],
    $params["domain"],
    $params["secure"],
    $params["httponly"]
  );
}

// Destroy session
session_destroy();

header("Location: ../index.php");
exit;
?>
<!-- End -->