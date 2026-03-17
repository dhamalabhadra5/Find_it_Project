<?php
include_once '../includes/session.php';
include_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $item_name = trim($_POST['item_name']);
    $description = trim($_POST['description']);
    $location = trim($_POST['location']);
    $date_reported = $_POST['date_reported'] ?? date('Y-m-d');
    $image_name = null;

    if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] === UPLOAD_ERR_OK) {
        $allowed_ext = ['jpg','jpeg','png','gif'];
        $file_ext = strtolower(pathinfo($_FILES['item_image']['name'], PATHINFO_EXTENSION));
        if (in_array($file_ext, $allowed_ext) && $_FILES['item_image']['size'] <= 2*1024*1024) {
            $image_name = uniqid().'.'.$file_ext;
            move_uploaded_file($_FILES['item_image']['tmp_name'], "../assets/uploads/".$image_name);
        }
    }

    $sql = "INSERT INTO items (user_id, item_name, description, status, location, date_reported, image) VALUES (?, ?, ?, 'found', ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isssss", $user_id, $item_name, $description, $location, $date_reported, $image_name);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: items.php?msg=reported");
        exit();
    } else {
        $error = "Error reporting item.";
    }
}
?>
<?php include '../includes/header.php'; ?>
<form method="POST" enctype="multipart/form-data" class="report-form">
  <h2>Report Found Item</h2>
  <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
  <input type="text" name="item_name" placeholder="Item Name" required>
  <input type="text" name="location" placeholder="Location" required>
  <textarea name="description" placeholder="Description" required></textarea>
  <input type="date" name="date_reported" required>
  <input type="file" name="item_image" accept="image/*">
  <button type="submit">Submit</button>
</form>