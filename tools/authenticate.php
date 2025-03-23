<?php
// authenticate.php

/**
 * Admin Access Control
 * - Verifies admin status via session
 * - Redirects non-admin users to login
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Verify admin session
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  // Clear any existing session data
  $_SESSION = array();

  // Send forbidden status and redirect
  header('HTTP/1.1 403 Forbidden');
  header('Location: login.php');
  exit('Access Denied: Administrator privileges required');
}

?>
<!-- End -->