<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body>
    @include('partials.header')

    <div class="container">
        <div class="title">Registration</div>
        <div class="content">
            {{-- Laravel error summary --}}
            @if ($errors->any())
                <div class="error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="registerForm" method="POST" action="{{ route('register.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="user-details">

                    <div class="input-box">
                        <span class="details">Full Name</span>
                        <input type="text" id="full_name" name="name" placeholder="Enter your name" value="{{ old('name') }}" required>
                        <span class="error" id="fullNameFeedback">@error('name'){{ $message }}@enderror</span>
                    </div>

                    <div class="input-box">
                        <span class="details">Username</span>
                        <input type="text" id="username" name="username" placeholder="Enter your username" value="{{ old('username') }}" required>
                        <span class="error" id="usernameFeedback">@error('username'){{ $message }}@enderror</span>
                    </div>

                    <div class="input-box">
                        <span class="details">Address</span>
                        <input type="text" name="address" placeholder="Enter your address" value="{{ old('address') }}" required>
                        <span class="error">@error('address'){{ $message }}@enderror</span>
                    </div>

                    <div class="input-box">
                        <span class="details">Phone</span>
                        <input type="text" name="phone" placeholder="Enter your number" value="{{ old('phone') }}" required>
                        <span class="error">@error('phone'){{ $message }}@enderror</span>
                    </div>

                    <div class="input-box">
                        <span class="details">Whatsapp Number</span>
                        <input type="text" name="whatsapp" id="whatsapp" placeholder="Enter your number" value="{{ old('whatsapp') }}" required>
                        <span class="error">@error('whatsapp'){{ $message }}@enderror</span>
                    </div>

                    <div class="input-box">
                        <span class="details">Email</span>
                        <input type="text" name="email" placeholder="Enter your email" value="{{ old('email') }}" required>
                        <span class="error">@error('email'){{ $message }}@enderror</span>
                    </div>

                    <div class="input-box">
                        <span class="details">Password</span>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <span class="error" id="passwordFeedback">@error('password'){{ $message }}@enderror</span>
                    </div>

                    <div class="input-box">
                        <span class="details">Confirm Password</span>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                        <span class="error" id="confirmPasswordFeedback">@error('confirm_password'){{ $message }}@enderror</span>
                    </div>
                </div>

                <div class="buttonU">
                    <input type="file" id="fileToUpload" name="fileToUpload" required>
                    <span class="error">@error('fileToUpload'){{ $message }}@enderror</span>
                </div>

                <div class="button">
                    <input type="submit" name="submit" value="Register">
                </div>
            </form>
        </div>
    </div>

    @include('partials.footer')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
    let isUsernameValid = false;

    $('#username').on('keyup', function () {
        var username = $(this).val();

        if (username.length < 3) {
            $('#usernameFeedback').text('');
            isUsernameValid = false;
            return; // don't check too short usernames
        }

        $.post('{{ url("check_username") }}', { username: username, _token: '{{ csrf_token() }}' })
        .done(function(response) {
      console.log('Username check response:', response);
      if (response.trim() === 'taken') {
          $('#usernameFeedback').text('Username already taken').css('color', 'red');
          isUsernameValid = false;
      } else {
          $('#usernameFeedback').text('Username available').css('color', 'green');
          isUsernameValid = true;
      }
  })
  .fail(function(jqXHR, textStatus, errorThrown) {
      console.error('AJAX error:', textStatus, errorThrown);
      $('#usernameFeedback').text('Error checking username').css('color', 'red');
  });
    });

    $('#registerForm').on('submit', function(e) {
        // Validate full name
        const fullName = $('#full_name').val();
        if (!/^[a-zA-Z\s]+$/.test(fullName)) {
            $('#fullNameFeedback').text('Only letters and spaces allowed.');
            e.preventDefault();
            return;
        } else {
            $('#fullNameFeedback').text('');
        }

        // Check username availability before submit
        if (!isUsernameValid) {
            $('#usernameFeedback').text('Please choose a valid username.').css('color', 'red');
            e.preventDefault();
            return;
        }

        // Validate password and confirmation
        const password = $('#password').val();
        const confirmPassword = $('#confirm_password').val();

        if (password !== confirmPassword) {
            $('#confirmPasswordFeedback').text('Passwords do not match.');
            e.preventDefault();
            return;
        } else {
            $('#confirmPasswordFeedback').text('');
        }

        if (password.length < 8 || !/\d/.test(password) || !/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
            $('#passwordFeedback').text('Password must be 8+ characters with number and symbol.');
            e.preventDefault();
            return;
        } else {
            $('#passwordFeedback').text('');
        }
    });
});
    </script>
</body>

</html>
