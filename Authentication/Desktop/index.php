<!-- HTML inside PHP file -->
<!DOCTYPE html>
<html>
<form id="registerForm" action="upload.php" method="post" enctype="multipart/form-data">
    <input type="text" id="username" name="username" placeholder="Enter username" required>
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
    <input type="submit" value="Register">
</form>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#username').on('keyup', function() {
        var username = $(this).val();

            $.ajax({
                url: 'check_username.php',
                method: 'POST',
                data: { username: username },
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
