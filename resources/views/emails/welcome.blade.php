@extends('emails.layout')

@section('content')
<h2>🎉 Welcome to {{ $appName }}!</h2>

<p>Hi <strong>{{ $user->name }}</strong>,</p>

<p>Congratulations! You have successfully claimed your QR code and joined our smart QR code management system. We're excited to have you on board!</p>

<div class="success-box">
    <h3>🔗 Your QR Code Details</h3>
    <p><strong>QR Code:</strong> {{ $qrCode->code }}</p>
    <p><strong>Status:</strong> <span class="highlight">Active & Claimed</span></p>
    <p><strong>Claimed on:</strong> {{ $qrCode->claimed_at->format('F j, Y \a\t g:i A') }}</p>
</div>

<div class="info-box">
    <h3>🔐 Your Login Credentials</h3>
    <p>You can now access your dashboard using the following credentials:</p>
    
    <div class="credentials">
        <strong>Login URL:</strong> <a href="{{ $loginUrl }}">{{ $loginUrl }}</a><br>
        <strong>Email/Username:</strong> {{ $user->email }}<br>
        @if($password)
        <strong>Password:</strong> {{ $password }}
        @else
        <strong>Password:</strong> The password you set during registration
        @endif
    </div>
    
    <p><strong>⚠️ Important:</strong> Please save these credentials in a secure location. For security reasons, we recommend changing your password after your first login.</p>
</div>

<div style="text-align: center; margin: 30px 0;">
    <a href="{{ $loginUrl }}" class="btn btn-success">🚀 Access Your Dashboard</a>
</div>

<h3>🌟 What's Next?</h3>
<ul>
    <li><strong>Complete Your Profile:</strong> Add your personal information, social links, and gallery images</li>
    <li><strong>Customize Your QR Code:</strong> Make it uniquely yours with custom themes and colors</li>
    <li><strong>Share Your Profile:</strong> Your QR code is ready to be shared with the world</li>
    <li><strong>Track Analytics:</strong> Monitor who scans your QR code and when</li>
</ul>

<div class="info-box">
    <h3>🎁 Free Trial Information</h3>
    <p>You're currently on our <strong>free trial</strong> which includes:</p>
    <ul>
        <li>✅ Full access to all features</li>
        <li>✅ Unlimited QR code scans</li>
        <li>✅ Profile customization</li>
        <li>✅ Basic analytics</li>
    </ul>
    <p>Your trial will expire in <strong>{{ $user->trial_ends_at ? $user->trial_ends_at->diffInDays(now()) : 'N/A' }} days</strong>. Don't worry, we'll send you reminders before it expires!</p>
</div>

<h3>💡 Need Help?</h3>
<p>If you have any questions or need assistance getting started, our support team is here to help:</p>
<ul>
    <li>📧 Email us at: <a href="mailto:support@smart-keyholder.click">support@smart-keyholder.click</a></li>
    <li>🌐 Visit our help center: <a href="https://smart-keyholder.click/help">Help Center</a></li>
    <li>💬 Live chat available in your dashboard</li>
</ul>

<p>Thank you for choosing {{ $appName }}. We're committed to helping you create amazing digital experiences with your QR code!</p>

<p>Best regards,<br>
<strong>The {{ $appName }} Team</strong></p>
@endsection