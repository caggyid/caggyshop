<?php
require_once 'includes/header.php';

$order_id = $_GET['order_id'] ?? '';
if (!$order_id) {
    header('Location: index.php');
    exit;
}

$transaction = getTransactionByOrderId($conn, $order_id);
if (!$transaction) {
    header('Location: index.php');
    exit;
}

$status = $transaction['status'];
$product = getProductById($conn, $transaction['product_id']);

if ($status === 'paid') {
    $wa_number = '6281357630688';
    $message = "Nomor pesanan: " . $transaction['order_id'] . "\n";
    $message .= "Nama produk: " . $product['name'] . "\n";
    $message .= "ID Game: " . $transaction['customer_id_game'] . "\n";
    $message .= "Nickname: " . $transaction['customer_name'] . "\n";
    $message .= "Total pembayaran: Rp " . number_format($transaction['amount'], 0, ',', '.') . "\n";
    $message .= "Status: LUNAS";
    $url = "https://wa.me/" . $wa_number . "?text=" . urlencode($message);
    header('Location: ' . $url);
    exit;
} else {
    ?>
    <div class="container" style="text-align: center; margin-top: 100px;">
        <h2>Menunggu konfirmasi pembayaran...</h2>
        <p>Status: <?php echo $status; ?></p>
        <p>Halaman ini akan otomatis refresh. Setelah pembayaran dikonfirmasi, Anda akan diarahkan ke WhatsApp.</p>
        <p>Order ID: <?php echo $order_id; ?></p>
        <meta http-equiv="refresh" content="5">
    </div>
    <?php
}

require_once 'includes/footer.php';
?>