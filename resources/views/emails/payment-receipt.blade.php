@extends('emails.layout')

@section('content')
@if($isRenewal)
    <h2>🎉 Payment Successful - Subscription Renewed!</h2>
@else
    <h2>🎉 Welcome to Premium - Payment Successful!</h2>
@endif

<p>Hi <strong>{{ $user->name }}</strong>,</p>

@if($isRenewal)
    <p>Thank you for renewing your subscription! Your payment has been processed successfully, and your premium features have been extended.</p>
@else
    <p>Welcome to the premium experience! Your payment has been processed successfully, and you now have full access to all our premium features.</p>
@endif

<div class="success-box">
    <h3>💳 Payment Receipt</h3>
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;"><strong>Transaction ID:</strong></td>
            <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;">{{ $subscription->flutterwave_reference }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;"><strong>Plan:</strong></td>
            <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;">{{ $subscription->plan_name }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;"><strong>Amount:</strong></td>
            <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;">{{ $subscription->currency }} {{ number_format($subscription->amount, 2) }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;"><strong>Payment Date:</strong></td>
            <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;">{{ $subscription->created_at->format('F j, Y \a\t g:i A') }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;"><strong>Subscription Period:</strong></td>
            <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;">{{ $subscription->starts_at->format('M j, Y') }} - {{ $subscription->ends_at->format('M j, Y') }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0;"><strong>Status:</strong></td>
            <td style="padding: 8px 0;"><span class="highlight">{{ ucfirst($subscription->status) }}</span></td>
        </tr>
    </table>
</div>

@if(!$isRenewal)
    <h3>🌟 You Now Have Access To:</h3>
    <div class="info-box">
        <ul>
            <li>🎨 <strong>Advanced Customization:</strong> Custom themes, colors, and branding options</li>
            <li>📊 <strong>Detailed Analytics:</strong> Track QR code scans, user locations, and engagement metrics</li>
            <li>🔗 <strong>Unlimited Social Links:</strong> Add all your social media profiles and websites</li>
            <li>🖼️ <strong>Gallery Management:</strong> Upload and showcase unlimited images in your profile</li>
            <li>📱 <strong>PWA Features:</strong> Offline access and mobile app-like experience</li>
            <li>🛡️ <strong>Priority Support:</strong> Get faster response times and dedicated assistance</li>
            <li>🔄 <strong>Regular Backups:</strong> Automatic data backups to keep your information safe</li>
            <li>📈 <strong>Advanced QR Features:</strong> Custom QR code designs and bulk generation tools</li>
            <li>🎯 <strong>Custom Domains:</strong> Use your own domain for your profile (coming soon)</li>
            <li>📧 <strong>Email Marketing:</strong> Send newsletters to your QR code visitors (coming soon)</li>
        </ul>
    </div>
@endif

<div style="text-align: center; margin: 30px 0;">
    <a href="{{ $dashboardUrl }}" class="btn btn-success">🚀 Access Your Premium Dashboard</a>
</div>

@if($isRenewal)
    <h3>🙏 Thank You for Your Continued Trust</h3>
    <p>We appreciate your loyalty and continued support. Your subscription has been renewed and you can continue enjoying all premium features without interruption.</p>
@else
    <h3>🚀 Getting Started with Premium</h3>
    <p>Here are some things you can do right now to make the most of your premium subscription:</p>
    <ol>
        <li><strong>Customize Your Theme:</strong> Visit the customization section to personalize your profile appearance</li>
        <li><strong>Add Social Links:</strong> Connect all your social media accounts and websites</li>
        <li><strong>Upload Gallery Images:</strong> Showcase your work, products, or personal photos</li>
        <li><strong>Check Your Analytics:</strong> See who's been scanning your QR code and when</li>
        <li><strong>Download Your QR Code:</strong> Get high-resolution versions for printing and sharing</li>
    </ol>
@endif

<div class="info-box">
    <h3>📋 Subscription Management</h3>
    <p>You can manage your subscription at any time from your dashboard:</p>
    <ul>
        <li>View billing history and download invoices</li>
        <li>Update payment methods</li>
        <li>Change subscription plans</li>
        <li>Set up automatic renewals</li>
        <li>Cancel subscription (we hope you won't need this!)</li>
    </ul>
</div>

<h3>💡 Need Help?</h3>
<p>As a premium subscriber, you have access to priority support:</p>
<ul>
    <li>📧 <strong>Priority Email:</strong> <a href="mailto:premium@smart-keyholder.click">premium@smart-keyholder.click</a></li>
    <li>💬 <strong>Live Chat:</strong> Available 24/7 in your dashboard</li>
    <li>📞 <strong>Phone Support:</strong> Call us during business hours</li>
    <li>📚 <strong>Premium Tutorials:</strong> Access exclusive how-to guides and video tutorials</li>
</ul>

<div class="success-box">
    <h3>🎁 Exclusive Premium Benefits</h3>
    <p>As a premium member, you also get:</p>
    <ul>
        <li>🆕 <strong>Early Access:</strong> Be the first to try new features</li>
        <li>💬 <strong>Community Access:</strong> Join our exclusive premium user community</li>
        <li>📈 <strong>Monthly Reports:</strong> Detailed analytics reports delivered to your inbox</li>
        <li>🎯 <strong>Feature Requests:</strong> Priority consideration for feature suggestions</li>
    </ul>
</div>

<h3>📄 Important Information</h3>
<ul>
    <li><strong>Billing:</strong> Your subscription will automatically renew unless cancelled</li>
    <li><strong>Refunds:</strong> 30-day money-back guarantee if you're not satisfied</li>
    <li><strong>Support:</strong> Premium support is available 24/7</li>
    <li><strong>Data:</strong> Your data is backed up daily and secured with enterprise-grade encryption</li>
</ul>

<p>Thank you for choosing {{ $appName }} Premium. We're committed to providing you with the best QR code management experience possible!</p>

<p>Best regards,<br>
<strong>The {{ $appName }} Team</strong></p>

<hr style="margin: 30px 0; border: none; border-top: 1px solid #e9ecef;">

<p style="font-size: 12px; color: #6c757d;">
    <strong>Keep this email for your records.</strong> You can also download a PDF copy of this receipt from your dashboard at any time.
</p>
@endsection