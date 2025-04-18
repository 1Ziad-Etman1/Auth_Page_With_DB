<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./style.css">
    <style>
        <?php include './style.php'; ?>
    </style>
</head>

<body>
    <?php include './header.php'; ?>
    <div class="container">
        
        <div class="title">Registration</div>
        <div class="content">
            <form id="registerForm" method="POST"  enctype="multipart/form-data">


                <div class="user-details">
                    
                    <div class="input-box">
                        <span class="details">Full Name</span>
                        <input type="text" id="full_name" name="name" placeholder="Enter your name" required>
                        <span id="fullNameFeedback"></span>
                    </div>
                    
                    <div class="input-box">
                        <span class="details">Username</span>
                        <input type="text" id="username" name="username" placeholder="Enter your username" required>
                        <span id="usernameFeedback"></span>
                    </div>
                    
                    <div class="input-box">
                        <span class="details">Address</span>
                        <input type="text" name="address" placeholder="Enter your address" required>
                    </div>
                    
                    <div class="input-box">
                        <span class="details">Phone</span>
                        <input type="text" name="phone" placeholder="Enter your number" required>
                    </div>
                    
                    <div class="input-box">
                        <span class="details">Whatsapp Number</span>
                        <input type="text" name="whatsapp" id="whatsapp" placeholder="Enter your number" required>
                        
                    </div>
                    
                    <div class="input-box">
                        <span class="details">Email</span>
                        <input type="text" name="email" placeholder="Enter your email" required>
                    </div>
                    
                    <div class="input-box">
                        <span class="details">Password</span>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <span id="passwordFeedback"></span>
                    </div>
                    
                    <div class="input-box">
                        <span class="details">Confirm Password</span>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                        <span id="confirmPasswordFeedback"></span>
                    </div>
                </div>
                <div class="buttonU">
                    <input type="file" id="fileToUpload" name="fileToUpload" placeholder="image" required>
                </div>

                
                <div class="button">
                    <input type="submit" name="submit" value="Register">
                </div>
            </form>     
        </div>
    </div>


    <?php include './footer.php'; ?>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let isUsernameValid = false;

$('#username').on('keyup', function() {
    var username = $(this).val();
    $.post('check_username.php', { username: username }, function(response) {
        if (response.trim() === 'taken') {
            $('#usernameFeedback').text('Username already taken').css('color', 'red');
            isUsernameValid = false;
        } else {
            $('#usernameFeedback').text('').css('color', 'green');
            isUsernameValid = true;
        }
    });
});

$('#registerForm').on('submit', function(e) {
    e.preventDefault();

    // Validate username
    if (!isUsernameValid) {
        alert('Username is taken. Please choose another.');
        return;
    }

    // Validate full name
    const fullName = $('#full_name').val();
    if (!/^[a-zA-Z\s]+$/.test(fullName)) {
        $('#fullNameFeedback').text('Only letters and spaces allowed.');
        return;
    } else {
        $('#fullNameFeedback').text('');
    }

    // Validate password
    const password = $('#password').val();
    const confirmPassword = $('#confirm_password').val();
    if (password !== confirmPassword) {
        $('#confirmPasswordFeedback').text('Passwords do not match.');
        return;
    }

    if (password.length < 8 || !/\d/.test(password) || !/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
        $('#passwordFeedback').text('Password must be 8+ characters with number and symbol.');
        return;
    } else {
        $('#passwordFeedback').text('');
    }

    const formData = new FormData(this);

    $.ajax({
        url: 'upload.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            alert(response);
        },
        error: function() {
            alert('Something went wrong.');
        }
    });
});
</script>
</body>

</html>



