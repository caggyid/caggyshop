<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}
require_once '../includes/functions.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin - CaggyShop</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="admin-container">
        <h1>Dashboard Admin</h1>
        <nav>
            <ul>
                <li><a href="products.php">Manajemen Produk</a></li>
                <li><a href="transactions.php">Daftar Transaksi</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</body>
</html>