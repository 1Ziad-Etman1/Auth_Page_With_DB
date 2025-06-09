New User Registration Notification

Hello Admin,

A new user has registered on your platform. Here are the details:

Full Name: {{ $user->name }}
Username: {{ $user->username }}
Email: {{ $user->email }}
Phone: {{ $user->phone }}
WhatsApp: {{ $user->whatsapp }}
Registration Date: {{ $user->created_at->format('F j, Y, g:i a') }}

You can view the full user details in the admin panel.

---
This is an automated notification. Please do not reply to this email.
© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
