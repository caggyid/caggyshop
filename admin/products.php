<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}
require_once '../includes/functions.php';

// Handle tambah produk
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $target_dir = "../uploads/";
        $image = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        $stmt = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $name, $description, $price, $image);
        $stmt->execute();
    }
}

// Handle hapus
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header('Location: products.php');
    exit;
}

$products = getProducts($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Produk - CaggyShop</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="admin-container">
        <h1>Manajemen Produk</h1>
        <a href="index.php">Kembali ke Dashboard</a>
        <h2>Tambah Produk</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" required></textarea>
            </div>
            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="price" required>
            </div>
            <div class="form-group">
                <label>Gambar</label>
                <input type="file" name="image" accept="image/*" required>
            </div>
            <button type="submit">Tambah</button>
        </form>

        <h2>Daftar Produk</h2>
        <table border="1" cellpadding="10">
            <tr>
                <th>ID</th>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($products as $p): ?>
            <tr>
                <td><?php echo $p['id']; ?></td>
                <td><img src="../uploads/<?php echo $p['image']; ?>" width="100"></td>
                <td><?php echo $p['name']; ?></td>
                <td><?php echo $p['description']; ?></td>
                <td>Rp <?php echo number_format($p['price'], 0, ',', '.'); ?></td>
                <td>
                    <a href="edit_product.php?id=<?php echo $p['id']; ?>">Edit</a> | 
                    <a href="products.php?delete=<?php echo $p['id']; ?>" onclick="return confirm('Yakin?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>