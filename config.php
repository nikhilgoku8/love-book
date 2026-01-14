<?php

require_once 'vendor/autoload.php';

use Razorpay\Api\Api;

// KEY_ID and KEY_SECRET
// PLEASE REPLACE THESE WITH YOUR ACTUAL KEYS
define('RAZORPAY_KEY_ID', 'rzp_live_S32aNavEKCnUz4');
define('RAZORPAY_KEY_SECRET', 'T2bCGkWDZA0Q96Fq6yfD0CtG');

// Product Details
define('PRODUCT_NAME', 'Love & Her Sisters');
define('PRODUCT_PRICE', 1999); // Price in Rupees
define('CURRENCY', 'INR');

// Delhivery Configuration
define('DELHIVERY_API_TOKEN', 'ab2b7d96c329c20451bdef39dece0ec3396b0ea4'); // Replace with actual token
define('DELHIVERY_WAREHOUSE_NAME', 'Youngistan Creative And Digital Services Pvt Ltd'); // Replace with registered warehouse name
define('DELHIVERY_IS_PRODUCTION', true); // Set to true for production

// Email Configuration
// define('ADMIN_EMAIL', 'positionwithpoems@gmail.com'); // Replace with admin email
define('ADMIN_EMAIL', 'nikhilgoku8@gmail.com'); // Replace with admin email
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USER', 'nikhilgoku8@gmail.com');
define('SMTP_PASS', 'zlcxdklatmtzvqmo');
define('SMTP_PORT', 587);


// Initialize Razorpay API
$api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);

// Display Errors (For Debugging - Disable in Production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
