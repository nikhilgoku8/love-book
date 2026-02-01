<?php
// error_reporting(E_ALL);
error_reporting(0);
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

        $postFields = "entry.2076477803=" .$user_mobile;


        $ch1 = curl_init();
        curl_setopt($ch1, CURLOPT_URL, "https://docs.google.com/forms/d/e/1FAIpQLSeOEBHz0w_elUNeBPLdjtNzDt19sG4LSFDASR7mcfyEPDw5vA/formResponse");
        curl_setopt($ch1, CURLOPT_POST, 1);
        curl_setopt($ch1, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch1, CURLOPT_HEADER, 0);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        //print_r($hash);
        $result1 = curl_exec($ch1);  

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