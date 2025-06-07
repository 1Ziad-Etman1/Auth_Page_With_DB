<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.title') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
@include('partials.header')

<div class="container">
    <div class="title">{{ __('messages.title') }}</div>
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
                    <span class="details">{{ __('messages.full_name') }}</span>
                    <input type="text" id="full_name" name="name" placeholder="{{ __('messages.full_name') }}" value="{{ old('name') }}" required>
                    <span class="error" id="fullNameFeedback">@error('name'){{ $message }}@enderror</span>
                </div>

                <div class="input-box">
                    <span class="details">{{ __('messages.username') }}</span>
                    <input type="text" id="username" name="username" placeholder="{{ __('messages.username') }}" value="{{ old('username') }}" required>
                    <span class="error" id="usernameFeedback">@error('username'){{ $message }}@enderror</span>
                </div>

                <div class="input-box">
                    <span class="details">{{ __('messages.address') }}</span>
                    <input type="text" name="address" placeholder="{{ __('messages.address') }}" value="{{ old('address') }}" required>
                    <span class="error">@error('address'){{ $message }}@enderror</span>
                </div>

                <div class="input-box">
                    <span class="details">{{ __('messages.phone') }}</span>
                    <input type="text" name="phone" placeholder="{{ __('messages.phone') }}" value="{{ old('phone') }}" required>
                    <span class="error">@error('phone'){{ $message }}@enderror</span>
                </div>

                <div class="input-box">
                    <span class="details">{{ __('messages.whatsapp') }}</span>
                    <input type="text" name="whatsapp" id="whatsapp" placeholder="{{ __('messages.whatsapp') }}" value="{{ old('whatsapp') }}" required>
                    <span class="error">@error('whatsapp'){{ $message }}@enderror</span>
                </div>

                <div class="input-box">
                    <span class="details">{{ __('messages.email') }}</span>
                    <input type="text" name="email" placeholder="{{ __('messages.email') }}" value="{{ old('email') }}" required>
                    <span class="error">@error('email'){{ $message }}@enderror</span>
                </div>

                <div class="input-box">
                    <span class="details">{{ __('messages.password') }}</span>
                    <input type="password" id="password" name="password" placeholder="{{ __('messages.password') }}" required>
                    <span class="error" id="passwordFeedback">@error('password'){{ $message }}@enderror</span>
                </div>

                <div class="input-box">
                    <span class="details">{{ __('messages.confirm_password') }}</span>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="{{ __('messages.confirm_password') }}" required>
                    <span class="error" id="confirmPasswordFeedback">@error('confirm_password'){{ $message }}@enderror</span>
                </div>
            </div>

            <div class="buttonU">
                <input type="file" id="fileToUpload" name="fileToUpload" required>
                <span class="error">@error('fileToUpload'){{ $message }}@enderror</span>
            </div>

            <div class="button">
                <input type="submit" name="submit" value="{{ __('messages.register') }}">
            </div>
        </form>
    </div>
</div>

@include('partials.footer')

{{-- Optional: Language Switcher --}}
<div style="text-align:center; margin-top: 20px;">
    <a href="{{ url('lang/en') }}">English</a>  |
    <a href="{{ url('lang/ar') }}">العربية</a>
</div>
<div>
    <p>Current Locale: {{ app()->getLocale() }}</p>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        let isUsernameValid = false;

        $('#username').on('keyup', function () {
            var username = $(this).val();

            if (username.length < 3) {
                $('#usernameFeedback').text('');
                isUsernameValid = false;
                return;
            }

            $.post('{{ url("check_username") }}', {
                username: username,
                _token: '{{ csrf_token() }}'
            }).done(function (response) {
                if (response.trim() === 'taken') {
                    $('#usernameFeedback').text(@json(__('messages.username_taken'))).css('color', 'red');
                    isUsernameValid = false;
                } else {
                    $('#usernameFeedback').text(@json(__('messages.username_available'))).css('color', 'green');
                    isUsernameValid = true;
                }
            }).fail(function () {
                $('#usernameFeedback').text(@json(__('messages.error_checking_username'))).css('color', 'red');
            });
        });

        $('#registerForm').on('submit', function (e) {
            const fullName = $('#full_name').val();
            if (!/^[a-zA-Z\s\u0600-\u06FF]+$/.test(fullName)) {
                $('#fullNameFeedback').text(@json(__('messages.name_error')));
                e.preventDefault();
                return;
            } else {
                $('#fullNameFeedback').text('');
            }

            if (!isUsernameValid) {
                $('#usernameFeedback').text(@json(__('messages.username_invalid'))).css('color', 'red');
                e.preventDefault();
                return;
            }

            const password = $('#password').val();
            const confirmPassword = $('#confirm_password').val();

            if (password !== confirmPassword) {
                $('#confirmPasswordFeedback').text(@json(__('messages.password_mismatch')));
                e.preventDefault();
                return;
            } else {
                $('#confirmPasswordFeedback').text('');
            }

            if (password.length < 8 || !/\d/.test(password) || !/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
                $('#passwordFeedback').text(@json(__('messages.password_weak')));
                e.preventDefault();
                return;
            } else {
                $('#passwordFeedback').text('');
            }
        });
    });

    function changeLang(locale) {
        fetch(`/lang/${locale}`)
            .then(() => location.reload());
    }
</script>
</body>

</html>
