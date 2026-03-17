<?php
$is_logged_in = isset($_SESSION['user_id']);
$user_name = $_SESSION['full_name'] ?? '';
?>
<header>
  <h1>Find It 🧭</h1>
  <nav>
    <a href="index.php">Home</a>
    <a href="items.php">Reported Items</a>
    <?php if ($is_logged_in): ?>
      <a href="report_lost.php">Report Lost</a>
      <a href="report_found.php">Report Found</a>
      <span>Welcome, <?php echo htmlspecialchars($user_name); ?></span>
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="login.php">Login</a>
      <a href="register.php">Register</a>
    <?php endif; ?>
  </nav>
</header>