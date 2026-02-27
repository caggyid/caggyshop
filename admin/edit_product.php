<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit;
}
require_once '../includes/functions.php';

$id = $_GET['id'] ?? 0;
$product = getProductById($conn, $id);
if (!$product) {
    header('Location: products.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    if ($_FILES['image']['name']) {
        $target_dir = "../uploads/";
        $image = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, image=? WHERE id=?");
        $stmt->bind_param("ssdsi", $name, $description, $price, $image, $id);
    } else {
        $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=? WHERE id=?");
        $stmt->bind_param("ssdi", $name, $description, $price, $id);
    }
    $stmt->execute();
    header('Location: products.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="admin-container">
        <h1>Edit Produk</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="name" value="<?php echo $product['name']; ?>" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" required><?php echo $product['description']; ?></textarea>
            </div>
            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="price" value="<?php echo $product['price']; ?>" required>
            </div>
            <div class="form-group">
                <label>Gambar Saat Ini</label><br>
                <img src="../uploads/<?php echo $product['image']; ?>" width="200"><br>
                <label>Ganti Gambar (kosongkan jika tidak diganti)</label>
                <input type="file" name="image" accept="image/*">
            </div>
            <button type="submit">Update</button>
            <a href="products.php">Batal</a>
        </form>
    </div>
</body>
</html>