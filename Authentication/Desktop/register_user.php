<?php
// Enable errors for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// DB config
$host = 'localhost';
$db = 'projectdb';
$user = 'root';
$pass = '';

// Connect to DB
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Helper to escape inputs
function sanitize($conn, $field) {
    return htmlspecialchars(trim($conn->real_escape_string($field)));
}

// Default feedback message
$feedback = "";

/// Process form if submitted via AJAX
// Process form if submitted via AJAX
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = sanitize($conn, $_POST['name']);
    $username = sanitize($conn, $_POST['username']);
    $phone    = sanitize($conn, $_POST['phone']);
    $whatsapp = sanitize($conn, $_POST['whatsapp']);
    $email    = sanitize($conn, $_POST['email']);
    $password = sanitize($conn, $_POST['password']); // you can hash this
    $image    = sanitize($conn, $_POST['image']);
    $address  = sanitize($conn, $_POST['address']);

    // Check if username is taken
    $check = $conn->query("SELECT * FROM users WHERE username = '$username'");
    if ($check->num_rows > 0) {
        echo "<span style='color:red;'>Username already taken</span>";
    } else {
        // Insert user
        $stmt = $conn->prepare("INSERT INTO users (name, username, phone, whatsapp, email, password, image, address)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $name, $username, $phone, $whatsapp, $email, $password, $image, $address);

        if ($stmt->execute()) {
            echo "<span style='color:green;'>User registered successfully!</span>";
        } else {
            echo "<span style='color:red;'>Error: " . $stmt->error . "</span>";
        }

        $stmt->close();
    }
}

?>

<!-- HTML inside PHP file -->
<!DOCTYPE html>
<html>
<head>
    <title>PHP Registration</title>
</head>
<body>

    <h2>Register</h2>
    <?php echo $feedback; ?>
    <form method="POST" action="">
        <input type="text" name="name" placeholder="Name" required><br><br>
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="text" name="phone" placeholder="Phone" required><br><br>
        <input type="text" name="whatsapp" placeholder="WhatsApp"><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <input type="text" name="image" placeholder="Image filename (e.g. avatar.jpg)" required><br><br>
        <input type="text" name="address" placeholder="Address"><br><br>
        <input type="submit" value="Register">
    </form>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $("#registrationForm").on("submit", function(event) {
        event.preventDefault(); // Prevent the form from submitting the traditional way
        
        // Collect form data
        var formData = $(this).serialize();
        
        // Make AJAX request
        $.ajax({
            type: "POST",
            url: "", // Current PHP file to process the data
            data: formData,
            success: function(response) {
                $('#formFeedback').html(response);
            },
            error: function() {
                $('#formFeedback').html("Something went wrong while registering.");
            }
        });
    });
});
</script>
</html>
