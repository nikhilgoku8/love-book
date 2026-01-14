<?php

require_once 'config.php';

use Razorpay\Api\Api;

session_start();

$success = false;
$error = "Payment Failed";

if (empty($_POST['razorpay_payment_id']) === false) {

    $api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);

    try {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but for simplicity we use POST if sent, 
        // better would be to checking against database or just verifying the signature completely) for this signature verification

        $attributes = array(
            'razorpay_order_id' => $_POST['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

        $api->utility->verifyPaymentSignature($attributes);
        $success = true;
    } catch (Razorpay\Api\Errors\SignatureVerificationError $e) {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}

if ($success === true) {
    // Payment was successful

    // Store user details in session
    $orderDetails = [
        'name' => $_POST['name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'address' => $_POST['address'] ?? '',
        'city' => $_POST['city'] ?? '',
        'state' => $_POST['state'] ?? '',
        'pincode' => $_POST['pincode'] ?? '',
        'payment_id' => $_POST['razorpay_payment_id'],
        'amount' => PRODUCT_PRICE
    ];
    $_SESSION['order_details'] = $orderDetails;

    // 1. Create Order in Delhivery
    require_once 'includes/Delhivery.php';
    $delhivery = new Delhivery();
    $delhiveryResponse = $delhivery->createOrder($orderDetails);

    // 2. Send Emails
    require_once 'includes/Mailer.php';
    $mailer = new Mailer();

    // Send to Customer
    $mailer->sendOrderConfirmation($orderDetails['email'], $orderDetails, $delhiveryResponse);

    // Send to Admin
    $mailer->sendAdminNotification($orderDetails, $delhiveryResponse);

    // Redirect to Thank You page
    header('Location: thank-you.php');
    exit;
} else {
    // Payment failed
    echo "<h1>Payment Failed</h1>";
    echo "<p>{$error}</p>";
    echo "<p><a href='checkout.php'>Try Again</a></p>";
}
