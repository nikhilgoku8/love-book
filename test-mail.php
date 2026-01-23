<?php

require_once 'includes/Mailer.php';
    $mailer = new Mailer();

    // Send to Customer
    $mailer->sendOrderConfirmation($orderDetails['email'], $orderDetails, $delhiveryResponse);