<?php
include_once '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $full_name, $email, $password);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: login.php?msg=registered");
        exit();
    } else {
        $error = "Email already registered or error occurred";
    }
    mysqli_stmt_close($stmt);
}
?>
<!-- HTML Form: Use assets/css/style.css -->
<?php include '../includes/header.php'; ?>
<form method="POST" class="auth-form">
  <h2>Register</h2>
  <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
  <input type="text" name="full_name" placeholder="Full Name" required>
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">Register</button>
</form>