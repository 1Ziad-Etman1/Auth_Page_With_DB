<?php
require_once __DIR__ . '/validator.php';

echo "<script>console.log( 'Hello2' );</script>";
$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phoneNumber[0] = isset($_POST['whatsapp']) ? trim($_POST['whatsapp']) : '';
    echo "Hello3" . $phoneNumber[0];
    echo "<script>console.log( 'Hello3' " . $phoneNumber[0] . ");</script>";

    if (isset($_POST['submit'])) {
        // This block runs when the "Validate" button is clicked
        echo "HHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHH";
        $result = validate_whatsapp_numbers($phoneNumber);
        echo '<div style="color:' . ($result['success'] ? 'green' : 'red') . ';">' . $result['message'] . '</div>';
        echo "<h3>Result:</h3><pre>" . htmlspecialchars(json_encode($result, JSON_PRETTY_PRINT));
    }
}
?>


<!-- HTML inside PHP file -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- <link rel="stylesheet" href="./H&F.css">  -->
    <link rel="stylesheet" href="./style.css">
    <style>
        <?php include './style.php'; ?>
    </style>
</head>

<body>
    <?php include './header.php'; ?>
    <div class="container">
        <!-- Title section -->
        <div class="title">Registration</div>
        <div class="content">
            <form id="registerForm" action="upload.php" method="post" enctype="multipart/form-data">


                <div class="user-details">
                    <!-- Input for Full Name -->
                    <div class="input-box">
                        <span class="details">Full Name</span>
                        <input type="text" id="full_name" name="name" placeholder="Enter your name" required>
                        <span id="fullNameFeedback"></span>
                    </div>
                    <!-- Input for Username -->
                    <div class="input-box">
                        <span class="details">Username</span>
                        <input type="text" id="username" name="username" placeholder="Enter your username" required>
                        <span id="usernameFeedback"></span>
                    </div>
                    <!-- Input for Address -->
                    <div class="input-box">
                        <span class="details">Address</span>
                        <input type="text" name="address" placeholder="Enter your address" required>
                    </div>
                    <!-- Input for Phone Number -->
                    <div class="input-box">
                        <span class="details">Phone</span>
                        <input type="text" name="phone" placeholder="Enter your number" required>
                    </div>
                    <!-- Input for Whatsapp Number -->
                    <div class="input-boxW">
                        <span class="details">Whatsapp Number</span>
                        <input type="text" name="whatsapp" id="whatsapp" placeholder="Enter your number" required>
                        <span class="buttonW">
                            <button type="button" name="validate" id="validateBtn">Validate</button>
                        </span>
                        <!-- <?php if ($result !== null): ?>
                            <h3>Result:</h3>
                            <pre><?php echo htmlspecialchars(json_encode($result, JSON_PRETTY_PRINT)); ?></pre>
                        <?php endif; ?> -->
                        <div id="validationResult"></div>
                    </div>
                    <!-- Input for Email -->
                    <div class="input-box">
                        <span class="details">Email</span>
                        <input type="text" name="email" placeholder="Enter your email" required>
                    </div>
                    <!-- Input for Password -->
                    <div class="input-box">
                        <span class="details">Password</span>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <span id="passwordFeedback"></span>
                    </div>
                    <!-- Input for Confirm Password -->
                    <div class="input-box">
                        <span class="details">Confirm Password</span>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                        <span id="confirmPasswordFeedback"></span>
                    </div>
                </div>
                <div class="buttonU">
                    <input type="file" id="fileToUpload" name="fileToUpload" placeholder="image" required>
                </div>

                <!-- Submit button -->
                <div class="button">
                    <input type="submit" name="submit" value="Register">
                </div>
            </form>
            <h3>Result</h3>
            <?php if ($result !== null): ?>
                <pre><?php echo htmlspecialchars(json_encode($result, JSON_PRETTY_PRINT)); ?></pre>
            <?php endif; ?>
        </div>
    </div>


    <?php include './footer.php'; ?>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#username').on('keyup', function() {
                var username = $(this).val();

                $.ajax({
                    url: 'check_username.php',
                    method: 'POST',
                    data: {
                        username: username
                    },
                    success: function(response) {
                        if (response == 'taken') {
                            $('#usernameFeedback').text('Username already taken').css('color', 'red');
                        } else {
                            $('#usernameFeedback').text('').css('color', 'green');
                        }
                    }
                });

            });
        });
    </script>
    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let isValid = true;

            // Full Name validation (letters and spaces only)
            const fullName = document.getElementById('full_name').value;
            if (!/^[a-zA-Z\s]+$/.test(fullName)) {
                document.getElementById('fullNameFeedback').textContent = 'Full name should contain only letters and spaces';
                isValid = false;
            } else {
                document.getElementById('fullNameFeedback').textContent = '';
            }


        });

        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const feedback = document.getElementById('passwordFeedback');

            if (password.length < 8) {
                feedback.textContent = 'Password must be at least 8 characters';
            } else if (!/\d/.test(password)) {
                feedback.textContent = 'Password must contain at least one number';
            } else if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                feedback.textContent = 'Password must contain at least one special character';
            } else {
                feedback.textContent = '';
            }
        });
        document.getElementById('confirm_password').addEventListener('input', function() {
            const confirmPassword = this.value;
            const password = document.getElementById('password').value;
            const feedback = document.getElementById('confirmPasswordFeedback');

            if (password !== confirmPassword) {
                feedback.textContent = 'Passwords do not match';
            } else {
                feedback.textContent = '';
            }
        });
    </script>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = document.getElementById('registerForm');
            const formData = new FormData(form);

            $.ajax({
                url: 'upload.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    alert(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        });
    </script>
</body>

</html>


<!-- <input type="text" id="username" name="username" placeholder="Enter username" required>
                    <span id="usernameFeedback"></span>
                    <br>
                    <input type="text" id= "full_name" name="name" placeholder="Full Name" required><br><br>
                    <span id="fullNameFeedback"></span>
                
                    <input type="text" name="phone" placeholder="Phone" required><br><br>
                    <input type="text" name="whatsapp" placeholder="WhatsApp" required><br><br>
                    <input type="email" name="email" placeholder="Email" required><br><br>
                    <input type="password" id="password" name="password" placeholder="Password" required><br><br>
                    <span id="passwordFeedback"></span><br><br>
                
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                    <span id="confirmPasswordFeedback"></span><br><br>
                    <input type="text" name="address" placeholder="Address" required><br><br>
                    <input type="file" id="fileToUpload" name="fileToUpload" placeholder="image" required> <br><br>
                    -->
<!-- Submit button -->
<!-- <div class="button">
                        <input type="submit" value="Register">
                    </div> -->