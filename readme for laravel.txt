# Whiteray Smart Tag - Project Documentation

## Overview

**Whiteray Smart Tag** is a smart digital identity system powered by permanent QR codes printed on physical items (e.g., key holders). Users can scan these QR codes to claim their profile, which can be shared publicly as a vCard-style page containing social media links, service galleries, and user details. Once claimed, the QR code becomes permanently tied to that user.

---

## Core Features

* Permanent, pre-generated QR codes (non-editable and unique)
* Claim and activate via onboarding flow
* Public digital profile (vCard style) with:

  * User photo, name, bio
  * Social media links
  * Service gallery images
* Admin panel for managing QR codes and users
* User dashboard for editing profile and managing content
* **SaaS model with payment integration (Flutterwave) and 1-month free trial**
* **Mobile-responsive UI using TailwindCSS (optimized for Android and iOS devices)**

---

## Tech Stack

* **Backend**: Laravel 10
* **Frontend**: Laravel Blade + TailwindCSS
* **Database**: MySQL or PostgreSQL
* **QR Code Library**: `simple-qrcode` Laravel package
* **Authentication**: Laravel Breeze (or Jetstream if teams needed)
* **Payment Gateway**: Flutterwave
* **Mobile Responsiveness**: TailwindCSS utility classes and mobile-first design principles

---

## Step-by-Step Laravel Implementation

### Step 1: Project Setup

```bash
laravel new whiteray_smart_tag
cd whiteray_smart_tag
composer require laravel/breeze --dev
php artisan breeze:install
npm install && npm run dev
php artisan migrate
```

### Step 2: TailwindCSS Mobile Optimization

Ensure Tailwind config supports responsive design:

```js
// tailwind.config.js
module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
```

Use Tailwind mobile-first classes like:

```html
<div class="w-full md:w-1/2 p-4">
  <img src="..." class="rounded-xl shadow-md" />
</div>
```

### Step 3: QR Code Management

Install QR package:

```bash
composer require simplesoftwareio/simple-qrcode
```

Generate QR codes in controller:

```php
use SimpleSoftwareIO\QrCode\Facades\QrCode;
QrCode::size(200)->generate(route('qr.view', $qr->code));
```

### Step 4: Profile and Gallery Setup

Use Blade components with Tailwind grid/flex utilities:

```blade
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
  @foreach($user->gallery as $item)
    <div class="p-2">
      <img src="{{ $item->image_url }}" class="rounded-xl" />
    </div>
  @endforeach
</div>
```

### Step 5: Flutterwave Payment Integration

Install SDK:

```bash
composer require flutterwavedev/flutterwave-v3
```

Add .env keys and create controller to manage subscriptions:

* Redirect to Flutterwave
* Listen to webhook
* Grant 1-month trial on registration
* Use middleware to block access post-trial without payment

### Step 6: Middleware for Subscription Check

Create middleware `EnsureSubscribed` to guard dashboard routes:

```php
if (subscription is expired or trial expired) redirect('/billing');
```

### Step 7: Admin Features

Admin panel to:

* View & manage QR codes
* Generate batches
* Manage users & subscriptions

---

## Database Schema

(unchanged from previous)

---

## Route Structure

(unchanged from previous)

---

## QR Code Claim Flow

(unchanged from previous)

---

## User Dashboard Features

* Upload/change profile image (mobile optimized)
* Update bio, name, and contact options
* Add/edit/remove social media links
* Add/edit/delete gallery images
* View billing/subscription status
* Fully responsive design with Tailwind grid/flex classes

---

## Admin Panel Features

* View list of QR codes and their status
* Regenerate QR or export them
* View all registered users
* Deactivate or reassign codes if needed

---

## Payment Integration with Flutterwave

* Use Flutterwave’s inline modal or hosted payment links
* Laravel service to manage webhook callbacks
* Grant 1-month free trial on account creation (set `trial_ends_at`)
* On trial expiry, block dashboard access until payment is made
* Support for different plans (Basic, Premium, etc.)

---

## Future Enhancements

* Add analytics (number of scans, devices)
* NFC support for smart cards
* More payment gateways (e.g., Stripe, Paystack)
* Premium themes for profile pages

---

## Conclusion

Whiteray Smart Tag combines physical QR tags with a rich digital profile experience. It's ideal for freelancers, creators, and service providers who want a smart, scannable digital identity tied to a physical item.

---

For implementation walkthrough, Laravel seeders, migrations, and starter UI — continue with component-based development using this blueprint.
 Note THiS: This Management System for KeyTag with a Re-generated QR CODES for New User where a new user scans it and filling the details and active it for others people to see the detail like a vCard












All custom CSS for your Apple-style Liquid Glass UI has been saved to resources/css/liquid-glass.css. You can now include this file in your layouts or views for consistent, maintainable styling across your app. This makes it easy to manage and update your glassmorphism and mobile-friendly UI styles in one place.
