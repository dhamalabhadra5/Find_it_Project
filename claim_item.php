<?php
include_once '../includes/session.php';
include_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['item_id'])) {
    $item_id = intval($_POST['item_id']);
    $user_id = $_SESSION['user_id'];

    // Update item status and claimed_by
    $sql = "UPDATE items SET status='claimed', claimed_by=? WHERE item_id=? AND status!='claimed'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $item_id);
    mysqli_stmt_execute($stmt);

    // Record the claim
    $sql_claim = "INSERT INTO claims (item_id, user_id) VALUES (?, ?)";
    $stmt_claim = mysqli_prepare($conn, $sql_claim);
    mysqli_stmt_bind_param($stmt_claim, "ii", $item_id, $user_id);
    mysqli_stmt_execute($stmt_claim);

    header("Location: items.php?msg=claimed");
    exit();
}
?>