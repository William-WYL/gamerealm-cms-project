<?php
define('DB_DSN', 'mysql:host=localhost;dbname=gamerealm;charset=utf8');
define('DB_USER', 'gamerealmadmin');
define('DB_PASS', 'admin123');

try {
  // Try creating new PDO connection to MySQL.
  $db = new PDO(DB_DSN, DB_USER, DB_PASS);

  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
} catch (PDOException $e) {

  print "Error: " . $e->getMessage();
  die();
}
?>
<!-- End -->