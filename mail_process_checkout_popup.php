<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
date_default_timezone_set('Asia/Calcutta');

require_once 'config.php';
require_once 'includes/Mailer.php';
$mailer = new Mailer();

$error_flag = 0;
$statusCode = 200;
$form_errors_array = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["user_mobile"])) {
        $form_errors_array['user_mobile'] = "Phone is required";
        $error_flag = 1;
    } else {
        $user_mobile = test_input($_POST["user_mobile"]);

        if (!preg_match("/^[0-9]{10}$/", $user_mobile)) {
            $form_errors_array['user_mobile'] = "Phone number must be exactly 10 digits";
            $error_flag = 1;
        }
    }

    if ($error_flag == 0) {

        if ($mailer->sendMobileNumber($user_mobile)) {
            $response = [
                'success' => ['message' => 'success'],
                'user_mobile' => $user_mobile,
            ];
        } else {
            $response = ['error' => ['message' => 'Mail not working']];
            $statusCode = 422;
        }

    } else {
        $response = ['error' => ['error_type' => 'form', 'errors' => $form_errors_array]];
        $statusCode = 422;
    }

} else {
    $response = ['error' => ['message' => 'Invalid request']];
    $statusCode = 422;
}

header('Content-Type: application/json; charset=UTF-8');
http_response_code($statusCode);
echo json_encode($response);

function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}



?>