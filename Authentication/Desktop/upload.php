<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("../DB_ops.php");
require_once("./validator.php");

$target_dir = __DIR__ . "/uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Validate image
$imageInfo = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
if ($imageInfo === false) {
    echo "File is not an image.<br>";
    $uploadOk = 0;
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.<br>";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.<br>";
    $uploadOk = 0;
}

// File type check
if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
    $uploadOk = 0;
}

// Validate WhatsApp number
$whatsapp = $_POST['whatsapp'];
$response = validate_whatsapp_numbers([$whatsapp]);
echo "<pre>" . print_r($response, true) . "</pre>";

// Check if WhatsApp number is valid
$whatsappValid = false;
foreach ($response as $item) {
    if ($item['phone_number'] == $whatsapp && $item['status'] == 'valid') {
        $whatsappValid = true;
        break;
    }
}

echo "<pre>" . print_r($whatsappValid) . "</pre>";

// Proceed with upload and DB insert
if ($uploadOk == 1 && $whatsappValid===true) {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.<br>";

        $name = $_POST['name'];
        $username = $_POST['username'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $image = basename($_FILES["fileToUpload"]["name"]);

        $db = new DB_ops();
        $success = $db->create($name, $username, $phone, $whatsapp, $email, $password, $image, $address);

        if ($success) {
            echo "User registered successfully.";
        } else {
            
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
} else {
    echo "Upload failed. Data not saved.";
}
?>