<?php
require_once 'config.php';

$token = DELHIVERY_API_TOKEN;
$url = DELHIVERY_IS_PRODUCTION
    ? 'https://track.delhivery.com/api/backend/client/warehouse/location'
    : 'https://staging-express.delhivery.com/api/backend/client/warehouse/location'; // Endpoint to list warehouses might differ, checking common one or just testing creation

// Let's try to just create a dummy order to repro the error with more verbose output
// But first, let's check if we can list warehouses to verify the name.
// "https://track.delhivery.com/api/backend/client/warehouse/location" is often used to get warehouses.

echo "Testing Token: " . substr($token, 0, 5) . "...\n";
echo "Environment: " . (DELHIVERY_IS_PRODUCTION ? "Production" : "Staging") . "\n";
echo "Target Warehouse Name: " . DELHIVERY_WAREHOUSE_NAME . "\n";

$ch = curl_init();
// Try alternative endpoint
// Try specific client warehouse endpoint if available
curl_setopt($ch, CURLOPT_URL, "https://track.delhivery.com/api/backend/client/warehouse/location?offset=0");
// Also try with trailing slash or without?
// Let's print the token as well to be sure? No security risk if truncated.
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Token " . $token,
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For debugging local SSL issues

$response = curl_exec($ch);
$err = curl_error($ch);
curl_close($ch);

if ($err) {
    echo "cURL Error: " . $err . "\n";
} else {
    echo "Warehouse List Response:\n" . $response . "\n";
}

echo "\n--------------------------------------------------\n";

// Test Order Creation Integration
require_once 'includes/Delhivery.php';
$delhivery = new Delhivery();

$testOrder = [
    'name' => 'Test User',
    'email' => 'test@example.com',
    'phone' => '9999999999',
    'address' => 'Test Address',
    'city' => 'Mumbai',
    'state' => 'Maharashtra',
    'pincode' => '400101',
    'payment_id' => 'pay_' . time(),
    'amount' => 1
];

echo "Attempting to create test order...\n";
$res = $delhivery->createOrder($testOrder);
print_r($res);
