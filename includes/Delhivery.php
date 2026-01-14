<?php

class Delhivery
{
    private $apiToken;
    private $isProduction;
    private $warehouseName;

    public function __construct()
    {
        $this->apiToken = DELHIVERY_API_TOKEN;
        $this->isProduction = DELHIVERY_IS_PRODUCTION;
        $this->warehouseName = DELHIVERY_WAREHOUSE_NAME;
    }

    public function createOrder($orderData)
    {
        $url = $this->isProduction
            ? 'https://track.delhivery.com/api/cmu/create.json'
            : 'https://staging-express.delhivery.com/api/cmu/create.json';

        $payload = str_replace(
            ['%WAREHOUSE_NAME%'],
            [$this->warehouseName],
            json_encode(['format' => 'json', 'data' => json_encode([$this->formatOrderPayload($orderData)])])
        );

        // Delhivery expects 'format=json&data={JSON_STRING}' in body for form-data or raw json depending on endpoint.
        // Documentation says "Post the following data to ..."
        // Actually, for /api/cmu/create.json, it usually expects 'format=json' and 'data=JSON_OBJECT_ARRAY' as POST fields.

        // Standard Express API Payload Structure
        $postData = [
            'format' => 'json',
            'data' => json_encode([
                'shipments' => [
                    $this->formatOrderPayload($orderData)
                ],
                'pickup_location' => [
                    'name' => $this->warehouseName
                ]
            ])
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Token " . $this->apiToken
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Added to bypass local WAMP SSL error

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return ['status' => false, 'error' => $err];
        }

        return json_decode($response, true);
    }

    private function formatOrderPayload($data)
    {
        // Map local data to Delhivery payload structure
        $payload = [
            "name" => $data['name'],
            "add" => $data['address'],
            "pin" => (string)$data['pincode'],
            "city" => $data['city'],
            "state" => $data['state'],
            "country" => "India",
            "phone" => (string)$data['phone'],

            "order" => (string)$data['payment_id'],
            "payment_mode" => "Prepaid",

            "return_pin" => "",
            "return_city" => "",
            "return_phone" => "",
            "return_add" => "",
            "return_state" => "",
            "return_country" => "",

            "products_desc" => "Love Book",
            "hsn_code" => "4901",
            "cod_amount" => "",
            "order_date" => null,
            "total_amount" => (string)$data['amount'],

            "seller_add" => "",
            "seller_name" => "",
            "seller_inv" => "",

            "quantity" => "1",
            "waybill" => "",

            "shipment_width" => "10",
            "shipment_height" => "10",
            "weight" => "0.5",

            "shipping_mode" => "Surface",
            "address_type" => ""
        ];

        return $payload;
    }
}
