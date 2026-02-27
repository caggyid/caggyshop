<?php
require_once '../includes/functions.php';

$notification = json_decode(file_get_contents('php://input'), true);
if (!$notification) {
    http_response_code(400);
    exit;
}

$order_id = $notification['order_id'];
$transaction_status = $notification['transaction_status'];
$fraud_status = $notification['fraud_status'];

$transaction = getTransactionByOrderId($conn, $order_id);
if (!$transaction) {
    http_response_code(404);
    exit;
}

if ($transaction_status == 'capture' || $transaction_status == 'settlement') {
    $status = 'paid';
} elseif ($transaction_status == 'pending') {
    $status = 'pending';
} elseif ($transaction_status == 'deny' || $transaction_status == 'expire' || $transaction_status == 'cancel') {
    $status = 'failed';
} else {
    $status = $transaction['status'];
}

$stmt = $conn->prepare("UPDATE transactions SET status = ?, updated_at = NOW() WHERE order_id = ?");
$stmt->bind_param("ss", $status, $order_id);
$stmt->execute();

http_response_code(200);
?>