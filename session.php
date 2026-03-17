<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']);

// Allow these pages without login
$allowed_pages = ['index.php', 'login.php', 'register.php'];

if (!isset($_SESSION['user_id']) && !in_array($current_page, $allowed_pages)) {
    header("Location: login.php");
    exit();
}
?>