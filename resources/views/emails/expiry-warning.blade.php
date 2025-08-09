@extends('emails.layout')

@section('content')
@if($daysLeft > 0)
    <h2>⏰ Your Trial Expires in {{ $daysLeft }} Day{{ $daysLeft > 1 ? 's' : '' }}!</h2>
@else
    <h2>⚠️ Your Trial Has Expired</h2>
@endif

<p>Hi <strong>{{ $user->name }}</strong>,</p>

@if($daysLeft > 0)
    <p>We hope you've been enjoying {{ $appName }}! This is a friendly reminder that your free trial will expire in <strong>{{ $daysLeft }} day{{ $daysLeft > 1 ? 's' : '' }}</strong>.</p>
    
    <div class="warning-box">
        <h3>⏳ Trial Expiration Details</h3>
        <p><strong>Trial ends on:</strong> {{ $user->trial_ends_at->format('F j, Y \a\t g:i A') }}</p>
        <p><strong>Days remaining:</strong> <span class="highlight">{{ $daysLeft }} day{{ $daysLeft > 1 ? 's' : '' }}</span></p>
    </div>
@else
    <p>Your free trial for {{ $appName }} has expired. Don't worry - your QR code and profile are still safe, but some features are now limited.</p>
    
    <div class="warning-box">
        <h3>⚠️ Trial Expired</h3>
        <p><strong>Trial expired on:</strong> {{ $user->trial_ends_at->format('F j, Y \a\t g:i A') }}</p>
        <p><strong>Status:</strong> <span class="highlight">Limited Access</span></p>
    </div>
@endif

<h3>🚀 Upgrade to Continue Enjoying Full Access</h3>
<p>Don't let your digital presence pause! Upgrade now to continue enjoying:</p>

<div class="info-box">
    <h3>✨ Premium Features Include:</h3>
    <ul>
        <li>🎨 <strong>Advanced Customization:</strong> Custom themes, colors, and branding</li>
        <li>📊 <strong>Detailed Analytics:</strong> Track scans, locations, and user engagement</li>
        <li>🔗 <strong>Unlimited Social Links:</strong> Add all your social media profiles</li>
        <li>🖼️ <strong>Gallery Management:</strong> Showcase your work with unlimited images</li>
        <li>📱 <strong>PWA Features:</strong> Offline access and mobile app experience</li>
        <li>🛡️ <strong>Priority Support:</strong> Get help when you need it most</li>
        <li>🔄 <strong>Regular Backups:</strong> Your data is always safe</li>
        <li>📈 <strong>Advanced QR Features:</strong> Custom QR designs and bulk generation</li>
    </ul>
</div>

<div style="text-align: center; margin: 30px 0;">
    <a href="{{ $upgradeUrl }}" class="btn btn-success">🎯 Upgrade Now - Starting from $9.99/month</a>
</div>

<h3>💰 Special Offer</h3>
<div class="success-box">
    <p><strong>🎉 Limited Time:</strong> Use code <span class="highlight">SAVE20</span> to get <strong>20% off</strong> your first 3 months!</p>
    <p>This offer expires in 48 hours, so don't miss out!</p>
</div>

@if($daysLeft > 0)
    <h3>🤔 Not Ready to Upgrade Yet?</h3>
    <p>No problem! You still have {{ $daysLeft }} day{{ $daysLeft > 1 ? 's' : '' }} to:</p>
    <ul>
        <li>✅ Complete your profile setup</li>
        <li>✅ Add your social media links</li>
        <li>✅ Upload gallery images</li>
        <li>✅ Test all premium features</li>
        <li>✅ Share your QR code with friends</li>
    </ul>
@else
    <h3>🔄 Reactivate Your Account</h3>
    <p>Your account is currently in limited mode, but you can reactivate full access instantly by upgrading to a premium plan.</p>
@endif

<div style="text-align: center; margin: 30px 0;">
    <a href="{{ $loginUrl }}" class="btn">📱 Access Your Dashboard</a>
</div>

<h3>❓ Questions?</h3>
<p>Our team is here to help you make the most of {{ $appName }}:</p>
<ul>
    <li>📧 Email: <a href="mailto:support@smart-keyholder.click">support@smart-keyholder.click</a></li>
    <li>💬 Live chat in your dashboard</li>
    <li>📞 Phone support for premium users</li>
</ul>

<p>Thank you for being part of the {{ $appName }} community. We're excited to continue this journey with you!</p>

<p>Best regards,<br>
<strong>The {{ $appName }} Team</strong></p>

<hr style="margin: 30px 0; border: none; border-top: 1px solid #e9ecef;">

<p style="font-size: 12px; color: #6c757d;">
    <strong>P.S.</strong> Don't want to receive these reminders? You can update your email preferences in your dashboard settings.
</p>
@endsection