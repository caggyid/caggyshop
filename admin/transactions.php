<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE transactions SET status = ? WHERE order_id = ?");
    $stmt->bind_param("ss", $status, $order_id);
    $stmt->execute();
}

$result = $conn->query("SELECT t.*, p.name as product_name FROM transactions t LEFT JOIN products p ON t.product_id = p.id ORDER BY t.created_at DESC");
$transactions = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Transaksi</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="admin-container">
        <h1>Daftar Transaksi</h1>
        <a href="index.php">Kembali</a>
        <table border="1" cellpadding="10">
            <tr>
                <th>Order ID</th>
                <th>Produk</th>
                <th>Nickname</th>
                <th>ID Game</th>
                <th>WA</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($transactions as $t): ?>
            <tr>
                <td><?php echo $t['order_id']; ?></td>
                <td><?php echo $t['product_name']; ?></td>
                <td><?php echo $t['customer_name']; ?></td>
                <td><?php echo $t['customer_id_game']; ?></td>
                <td><?php echo $t['customer_wa']; ?></td>
                <td>Rp <?php echo number_format($t['amount'], 0, ',', '.'); ?></td>
                <td><?php echo $t['status']; ?></td>
                <td><?php echo $t['created_at']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="order_id" value="<?php echo $t['order_id']; ?>">
                        <select name="status">
                            <option value="pending" <?php echo $t['status']=='pending'?'selected':''; ?>>Pending</option>
                            <option value="paid" <?php echo $t['status']=='paid'?'selected':''; ?>>Paid</option>
                            <option value="failed" <?php echo $t['status']=='failed'?'selected':''; ?>>Failed</option>
                        </select>
                        <button type="submit" name="update_status">Update</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>