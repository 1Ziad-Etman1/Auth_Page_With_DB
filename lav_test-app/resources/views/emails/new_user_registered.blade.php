<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New User Registration Notification</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #3498db; color: white; padding: 15px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { padding: 25px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-top: none; border-radius: 0 0 5px 5px; }
        .user-details { margin-top: 20px; }
        .detail-row { display: flex; margin-bottom: 10px; }
        .detail-label { font-weight: bold; width: 120px; }
        .footer { text-align: center; margin-top: 30px; font-size: 12px; color: #6c757d; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>New User Registration</h2>
    </div>

    <div class="content">
        <p>Hello Admin,</p>
        <p>A new user has registered on your platform. Here are the details:</p>

        <div class="user-details">
            <div class="detail-row">
                <span class="detail-label">Full Name:</span>
                <span>{{ $user->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Username:</span>
                <span>{{ $user->username }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Email:</span>
                <span>{{ $user->email }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Phone:</span>
                <span>{{ $user->phone }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">WhatsApp:</span>
                <span>{{ $user->whatsapp }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Registration Date:</span>
                <span>{{ $user->created_at->format('F j, Y, g:i a') }}</span>
            </div>
        </div>

        <p>You can view the full user details in the admin panel.</p>
    </div>

    <div class="footer">
        <p>This is an automated notification. Please do not reply to this email.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</div>
</body>
</html>
