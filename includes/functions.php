<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/midtrans.php';

function getProducts($conn) {
    $sql = "SELECT * FROM products ORDER BY id DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getProductById($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function createTransaction($conn, $product_id, $nickname, $id_game, $wa, $amount, $order_id) {
    $stmt = $conn->prepare("INSERT INTO transactions (order_id, product_id, customer_name, customer_id_game, customer_wa, amount, status, snap_token, created_at) VALUES (?, ?, ?, ?, ?, ?, 'pending', NULL, NOW())");
    $stmt->bind_param("sissds", $order_id, $product_id, $nickname, $id_game, $wa, $amount);
    return $stmt->execute();
}

function updateTransactionToken($conn, $order_id, $token) {
    $stmt = $conn->prepare("UPDATE transactions SET snap_token = ? WHERE order_id = ?");
    $stmt->bind_param("ss", $token, $order_id);
    return $stmt->execute();
}

function getTransactionByOrderId($conn, $order_id) {
    $stmt = $conn->prepare("SELECT * FROM transactions WHERE order_id = ?");
    $stmt->bind_param("s", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function generateOrderId() {
    return "INV-" . time() . rand(100, 999);
}

function getMidtransSnapToken($order_id, $amount, $customer_details) {
    $params = array(
        'transaction_details' => array(
            'order_id' => $order_id,
            'gross_amount' => $amount,
        ),
        'customer_details' => $customer_details,
        'credit_card' => array(
            'secure' => true
        )
    );

    $auth = base64_encode(MIDTRANS_SERVER_KEY . ':');
    $url = MIDTRANS_IS_PRODUCTION ? 'https://app.midtrans.com/snap/v1/transactions' : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Basic ' . $auth
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code == 201) {
        $result = json_decode($response, true);
        return $result['token'];
    } else {
        return false;
    }
}
?>