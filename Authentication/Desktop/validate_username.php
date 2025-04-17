<?php


ini_set('display_errors', 1);
error_reporting(E_ALL);


$host = 'localhost';
$db = 'projectdb';
$user = 'root';
$pass = '';


$conn = new mysqli($host, $user, $pass, $db);

if ($aconn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['username'])) {
    $username = $conn->real_escape_string($_POST['username']);

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result) {
        echo ($result->num_rows > 0) ? 'taken' : 'available';
    } else {
        echo 'Query failed: ' . $conn->error;
    }
} else {
    echo 'No username received';
}

$conn->close();
?>