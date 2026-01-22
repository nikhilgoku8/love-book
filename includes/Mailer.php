<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);

        // Server settings
        // $this->mail->SMTPDebug = 2;                      // Enable verbose debug output
        $this->mail->isSMTP();                                            // Send using SMTP
        $this->mail->Host = SMTP_HOST;                    // Set the SMTP server to send through
        $this->mail->SMTPAuth = true;                                   // Enable SMTP authentication
        $this->mail->Username = SMTP_USER;                     // SMTP username
        $this->mail->Password = SMTP_PASS;                               // SMTP password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $this->mail->Port = SMTP_PORT;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        $this->mail->setFrom(SMTP_USER, 'Love & Her Sisters');
    }

    public function sendOrderConfirmation($toEmail, $orderData, $delhiveryData = [])
    {
        try {
            // Recipients
            $this->mail->addAddress($toEmail);     // Add a recipient

            // Content
            $this->mail->isHTML(true);                                  // Set email format to HTML
            $this->mail->Subject = 'Order Confirmation - Love & Her Sisters';

            $body = "<h1>Thank you for your order!</h1>";
            $body .= "<p>Your payment of ₹{$orderData['amount']} was successful.</p>";
            $body .= "<h3>Order Details:</h3>";
            $body .= "<ul>";
            $body .= "<li>Order ID: {$orderData['payment_id']}</li>";
            $body .= "<li>Name: {$orderData['name']}</li>";
            $body .= "<li>Address: {$orderData['address']}, {$orderData['city']}, {$orderData['state']} - {$orderData['pincode']}</li>";
            $body .= "</ul>";

            if (!empty($delhiveryData)) {
                $body .= "<p><strong>Delivery Information:</strong></p>";
                if (isset($delhiveryData['packages'][0]['waybill'])) {
                    $body .= "<p>Waybill Number: " . $delhiveryData['packages'][0]['waybill'] . "</p>";
                }
                // Check if there are errors or warnings in Delhivery response
                if (isset($delhiveryData['remarks'])) {
                    $body .= "<p>Note: " . print_r($delhiveryData['remarks'], true) . "</p>";
                }
            }

            $this->mail->Body = $body;
            $this->mail->AltBody = strip_tags($body);

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            // Log error
            error_log("Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}");
            return false;
        }
    }

    public function sendAdminNotification($orderData, $delhiveryData = [])
    {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress(ADMIN_EMAIL);

            $this->mail->isHTML(true);
            $this->mail->Subject = 'New Order Received - ' . $orderData['payment_id'];

            $body = "<h1>New Order Notification</h1>";
            $body .= "<p>A new order has been placed.</p>";
            $body .= "<h3>Customer Details:</h3>";
            $body .= "<ul>";
            $body .= "<li>Name: {$orderData['name']}</li>";
            $body .= "<li>Email: {$orderData['email']}</li>";
            $body .= "<li>Phone: {$orderData['phone']}</li>";
            $body .= "<li>Address: {$orderData['address']}, {$orderData['city']}, {$orderData['state']} - {$orderData['pincode']}</li>";
            $body .= "</ul>";

            if (!empty($delhiveryData)) {
                $body .= "<h3>Courier Details (Delhivery):</h3>";
                $body .= "<pre>" . print_r($delhiveryData, true) . "</pre>";
            }

            $this->mail->Body = $body;
            $this->mail->AltBody = strip_tags($body);

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Admin notification could not be sent. Mailer Error: {$this->mail->ErrorInfo}");
            return false;
        }
    }

    public function sendMobileNumber($mobileNumber)
    {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress(ADMIN_EMAIL);

            $this->mail->isHTML(true);
            $this->mail->Subject = 'Check Out Popup - ' . $mobileNumber;

            $body = "<h1>New Check Out Popup</h1>";
            $body .= "<h3>Customer Details:</h3>";
            $body .= "<ul>";
            $body .= "<li>Phone: {$mobileNumber}</li>";
            $body .= "</ul>";

            $this->mail->Body = $body;
            $this->mail->AltBody = strip_tags($body);

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Admin notification could not be sent. Mailer Error: {$this->mail->ErrorInfo}");
            return false;
        }
    }


}
