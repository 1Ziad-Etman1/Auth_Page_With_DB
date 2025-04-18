<?php
$host = 'localhost';
$db = 'projectdb';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['username'])) {
    $username = $conn->real_escape_string($_POST['username']);

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo 'taken';
    } else {
        echo 'available';
    }
}
$conn->close();

?>