<?php

require_once 'vendor/autoload.php';

use Razorpay\Api\Api;

// KEY_ID and KEY_SECRET
// PLEASE REPLACE THESE WITH YOUR ACTUAL KEYS
define('RAZORPAY_KEY_ID', 'rzp_live_S32aNavEKCnUz4');
define('RAZORPAY_KEY_SECRET', 'T2bCGkWDZA0Q96Fq6yfD0CtG');

// Product Details
define('PRODUCT_NAME', 'Love & Her Sisters');
define('PRODUCT_PRICE', 1); // Price in Rupees
define('CURRENCY', 'INR');

// Initialize Razorpay API
$api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);

// Display Errors (For Debugging - Disable in Production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
