<?php

require_once 'config.php';

header('Content-Type: application/json');

try {
    // Generate a unique receipt ID
    $receiptId = 'receipt_' . time() . '_' . rand(1000, 9999);

    $orderData = [
        'receipt' => $receiptId,
        'amount' => PRODUCT_PRICE * 100, // Amount in paise
        'currency' => CURRENCY,
        'payment_capture' => 1, // Auto capture
        'notes' => [
            'source' => 'website'
        ]
    ];

    $razorpayOrder = $api->order->create($orderData);

    $response = [
        'id' => $razorpayOrder['id'],
        'amount' => $orderData['amount'],
        'currency' => $orderData['currency'],
        'key' => RAZORPAY_KEY_ID,
        'name' => PRODUCT_NAME,
        'description' => 'Purchase of ' . PRODUCT_NAME,
        // You can add customer info if collected, e.g., pre-fill
    ];

    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
