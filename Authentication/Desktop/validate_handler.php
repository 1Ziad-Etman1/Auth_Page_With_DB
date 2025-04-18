<?php
    require_once __DIR__ . '/validator.php';

    header('Content-Type: application/json');

    $data = json_decode(file_get_contents('php://input'), true);
    print("Hello1");
    if (isset($data['phoneNumbers'])) {
        $phoneNumbers = trim($data['phoneNumbers']);
        $phoneArray = array_map('trim', explode(',', $phoneNumbers));
        print("Hello2");

        $result = validate_whatsapp_numbers($phoneArray);
        echo json_encode($result);
    } else {
        echo json_encode(['success' => false, 'message' => 'No numbers provided.']);
    }
