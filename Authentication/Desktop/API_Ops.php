<?php
    require_once __DIR__ . '/../config.php';

    function validate_whatsapp_numbers($phoneNumbers) {
        echo "Hello1";
        $url = API_URL;

       
        $headers = [
            "Content-Type: application/json",
            "X-RapidAPI-Key: " . RAPIDAPI_KEY,
            "X-RapidAPI-Host: " . RAPIDAPI_HOST
        ];

        
        $postData = json_encode(["phone_numbers" => $phoneNumbers]);

        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

       
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        
        if ($httpCode !== 200 || !$response) {
            return ['success' => false, 'message' => 'API request failed'];
        }

        $data = json_decode($response, true);
        return $data ?: ['success' => false, 'message' => 'Invalid JSON response'];
    }
?>