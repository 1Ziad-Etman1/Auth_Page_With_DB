<?php
require_once("../DB_ops.php"); 

$target_dir = __DIR__ . "/uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Validate image
$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
if ($check === false) {
    echo "File is not an image.";
    $uploadOk = 0;
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// File type check
if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.<br>";

        // to DB
        $name = $_POST['name'];
        $username = $_POST['username'];
        $phone = $_POST['phone'];
        $whatsapp = $_POST['whatsapp'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $image = basename($_FILES["fileToUpload"]["name"]);

        $db = new DB_ops();
        $db->create($name, $username, $phone, $whatsapp, $email, $password, $image, $address);
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
} else {
    echo "File upload failed. Data not saved.";
}
?>