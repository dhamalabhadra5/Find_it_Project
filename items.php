<?php
include_once '../includes/session.php';
include_once '../includes/db.php';
include '../includes/header.php';

$status = $_GET['status'] ?? '';
$where = '';
if (in_array($status, ['lost','found','claimed'])) {
    $where = "WHERE status='$status'";
}

$sql = "SELECT items.*, users.full_name FROM items LEFT JOIN users ON items.user_id = users.user_id $where ORDER BY reported_at DESC";
$result = mysqli_query($conn, $sql);
?>
<h2>Reported Items</h2>
<form method="GET">
  <select name="status" onchange="this.form.submit()">
    <option value="">All</option>
    <option value="lost" <?php if($status=='lost') echo "selected"; ?>>Lost</option>
    <option value="found" <?php if($status=='found') echo "selected"; ?>>Found</option>
    <option value="claimed" <?php if($status=='claimed') echo "selected"; ?>>Claimed</option>
  </select>
</form>
<div class="items-list">
<?php
while ($row = mysqli_fetch_assoc($result)) :
?>
  <div class="item-card">
    <?php if($row['image']): ?>
      <img src="../assets/uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Item Image" class="item-img">
    <?php endif; ?>
    <h3><?php echo htmlspecialchars($row['item_name']); ?> (<?php echo htmlspecialchars($row['status']); ?>)</h3>
    <p><?php echo htmlspecialchars($row['description']); ?></p>
    <p><b>Location:</b> <?php echo htmlspecialchars($row['location']); ?></p>
    <p><small>Reported by: <?php echo htmlspecialchars($row['full_name']); ?></small></p>
    <?php if($row['status'] !== 'claimed'): ?>
      <form method="POST" action="claim_item.php">
        <input type="hidden" name="item_id" value="<?php echo $row['item_id']; ?>">
        <button type="submit" class="btn">Claim</button>
      </form>
    <?php else: ?>
      <p><b>Claimed</b></p>
    <?php endif; ?>
  </div>
<?php endwhile; ?>
</div>