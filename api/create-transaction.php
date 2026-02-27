<?php
session_start();
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$product_id = $_POST['product_id'] ?? '';
$nickname = $_POST['nickname'] ?? '';
$id_game = $_POST['id_game'] ?? '';
$wa = $_POST['wa'] ?? '';

if (!$product_id || !$nickname || !$id_game || !$wa) {
    echo json_encode(['error' => 'Semua field harus diisi']);
    exit;
}

$product = getProductById($conn, $product_id);
if (!$product) {
    echo json_encode(['error' => 'Produk tidak ditemukan']);
    exit;
}

$amount = $product['price'];
$order_id = generateOrderId();

if (!createTransaction($conn, $product_id, $nickname, $id_game, $wa, $amount, $order_id)) {
    echo json_encode(['error' => 'Gagal menyimpan transaksi']);
    exit;
}

$customer_details = [
    'first_name' => $nickname,
    'phone' => $wa
];

$snap_token = getMidtransSnapToken($order_id, $amount, $customer_details);
if (!$snap_token) {
    echo json_encode(['error' => 'Gagal mendapatkan token pembayaran']);
    exit;
}

updateTransactionToken($conn, $order_id, $snap_token);

echo json_encode(['snap_token' => $snap_token, 'order_id' => $order_id]);
?>