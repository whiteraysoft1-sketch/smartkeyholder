# Whiteray Smart Tag - Project Overview

## Project Type
**Laravel 10 SaaS Application** - A digital identity system with QR codes, user profiles, payment integration, and e-commerce store functionality.

---

## Core Workflow

### 1. **QR Code Generation & Management**
- **Admin** generates QR codes in batches (stored in database with UUID, code, and URL)
- Each QR code is **permanent and non-editable**
- QR codes are physically printed on items (key holders, tags, etc.)
- Each code contains a URL pointing to: `yourdomain.com/qr/{uuid}`

### 2. **User Claiming Flow**
- User scans the QR code → directed to `/qr/{uuid}` endpoint
- If **not claimed**: Shows **claim page** for user registration/login
- User creates account or logs in → fills profile details → **claims QR code**
- QR code becomes permanently tied to that user's account

### 3. **Profile Display (vCard)**
- After claiming, scanning the QR code shows user's **public digital profile**
- Profile includes:
  - User photo, name, bio, contact info
  - Social media links
  - Service gallery (images)
  - E-commerce store (if enabled)
- Profiles are **customizable with multiple templates** (professional, retail, health, etc.)

### 4. **Subscription/Payment System**
- **Free 1-month trial** automatically granted on signup
- **Flutterwave payment gateway** integration for subscriptions
- After trial expires → user must pay to maintain dashboard access
- Admin can manage pricing plans and user subscriptions
- `EnsureSubscribed` middleware guards dashboard routes

### 5. **E-Commerce Store**
- Users can enable a store on their profile
- Features: Product catalog, categories, WhatsApp orders, delivery options
- Customers can browse and order directly from the QR code profile page

---

## Technology Stack

| Component | Technology |
|-----------|------------|
| Backend Framework | Laravel 12 |
| Database | MySQL/PostgreSQL |
| Frontend | Blade Templates + TailwindCSS |
| QR Code Generation | `simplesoftwareio/simple-qrcode` package |
| Authentication | Laravel Breeze |
| Payment Gateway | Flutterwave (`flutterwavedev/flutterwave-v3`) |
| PWA Support | Custom PWA implementation (manifest.json, service workers) |
| UI/Mobile | TailwindCSS (mobile-first responsive design) |

---

## Database Schema

### Key Models & Tables

1. **Users**
   - `id`, `name`, `email`, `password`
   - `is_admin`, `trial_ends_at`, `is_subscribed`, `subscription_ends_at`
   - Relationships: profile, qrCode, socialLinks, galleryItems, subscriptions

2. **QrCodes**
   - `uuid` (unique identifier), `code` (unique code), `url`
   - `user_id` (owner after claimed), `is_claimed`, `is_active`
   - `scan_count`, `claimed_at`, `last_scanned_at`

3. **UserProfiles**
   - `display_name`, `bio`, `profile_image`, `background_image`
   - `is_public`, `selected_template` (vCard template choice)
   - Store-related: `store_enabled`, `store_name`, `store_description`, `store_whatsapp`, `store_address`
   - Currency: `currency`, `currency_symbol`
   - PWA config: `pwa_enabled`, `pwa_app_name`, `pwa_theme_color`, `pwa_icon`, etc.

4. **SocialLinks**
   - `user_id`, `platform` (Facebook, Twitter, etc.), `url`, `sort_order`, `is_active`

5. **GalleryItems**
   - `user_id`, `image_url`, `title`, `description`, `sort_order`, `is_active`

6. **Subscriptions**
   - `user_id`, `plan_name`, `plan_id`, `transaction_reference`
   - `status` (active/expired), `starts_at`, `expires_at`
   - `metadata` (JSON for additional plan info)

7. **StoreProducts, StoreCategories, StoreOrders**
   - Full e-commerce system with categories, products, inventory, orders

8. **PricingPlans**
   - Admin-managed subscription plans

9. **Settings**
   - System-wide settings (app name, logo, Flutterwave config, email settings)

---

## Key Controllers

| Controller | Purpose |
|-----------|---------|
| **QrCodeController** | Handle QR code viewing, claiming, generation, downloads |
| **DashboardController** | User dashboard - profile editing, social links, gallery, store management |
| **PaymentController** | Billing page, payment initialization, webhook handling, subscription management |
| **AdminController** | Admin panel - QR code batches, user management, settings, pricing plans |
| **AuthController** | User registration, login, email verification |
| **PwaController** | PWA manifest and service worker generation |
| **StoreController** | Public store display, product browsing, order placement |

---

## Important Routes

### Public Routes
- `GET /` - Welcome page
- `GET /qr/{uuid}` - View QR code profile (auto-redirects to claim if unclaimed)
- `GET /qr/{uuid}/claim` - Show claim form
- `POST /qr/{uuid}/claim` - Process claim (creates subscription)
- `GET /qr/{uuid}/store` - View user's store

### Protected Routes (Auth + Subscription)
- `GET /dashboard` - Main user dashboard
- `POST /dashboard/profile` - Update profile
- `POST/DELETE /dashboard/social-links/*` - Manage social media links
- `POST/DELETE /dashboard/gallery/*` - Manage gallery
- `GET/POST /dashboard/store*` - Store management
- `GET /dashboard/vcard-templates` - Template selection

### Payment Routes (Auth)
- `GET /billing` - Billing/subscription page
- `POST /payment/initialize` - Start payment process
- `GET /payment/callback` - Flutterwave callback handler
- `POST /payment/webhook` - Webhook from Flutterwave (public)

### Admin Routes (Auth + Admin)
- `GET /admin` - Admin dashboard
- `GET /admin/qr-codes` - QR code management
- `POST /admin/qr-codes/generate` - Generate QR batches
- `GET /admin/users` - User management
- `GET /admin/settings` - System settings
- `GET /admin/pricing-plans` - Pricing plan management

---

## Middleware

| Middleware | Function |
|-----------|----------|
| `auth` | Verify user is authenticated |
| `admin` | Verify user is admin |
| `subscribed` | Verify user has active subscription or trial (`EnsureSubscribed`) |

---

## Subscription Logic

### User Subscription Status
Users can be in one of these states:
- **Trial** (free for 1 month)
- **Subscribed** (active payment)
- **Expired** (trial/subscription ended)

Helper methods in `User` model:
- `hasActiveSubscription()` - Check if subscribed and not expired
- `isOnTrial()` - Check if in trial period
- `canAccessDashboard()` - Can access dashboard (trial OR subscribed)
- `canAccessWhatsAppStore()` - Store access based on plan

### Trial Period
- Automatically granted on user registration
- Set in `RegisteredUserController` to `now()->addMonth()`
- Middleware blocks dashboard access when expired

---

## Admin Panel Features

1. **QR Code Management**
   - Generate batches of QR codes
   - Activate/deactivate codes
   - Export codes (CSV, PDF)
   - Reassign codes to different users

2. **User Management**
   - View all users and their details
   - Upgrade/extend subscriptions
   - Cancel subscriptions

3. **Settings**
   - Configure Flutterwave API keys
   - Set app name, logo, email settings
   - Manage system-wide currency

4. **Pricing Plans**
   - Create/edit/delete subscription plans
   - Set plan features and pricing
   - Toggle plans active/inactive

---

## File Organization

```
app/
├── Models/                    # Database models
│   ├── User.php
│   ├── QrCode.php
│   ├── UserProfile.php
│   ├── SocialLink.php
│   ├── GalleryItem.php
│   ├── Subscription.php
│   ├── StoreProduct.php
│   └── ...
├── Http/Controllers/
│   ├── QrCodeController.php   # QR code operations
│   ├── DashboardController.php # User dashboard
│   ├── PaymentController.php   # Billing & payments
│   ├── Admin/AdminController.php # Admin operations
│   └── ...
├── Http/Middleware/
│   ├── EnsureSubscribed.php    # Subscription middleware
│   └── AdminMiddleware.php
├── Services/
│   └── EmailService.php        # Email handling
└── Mail/                       # Email templates

routes/
├── web.php                     # All application routes

database/
├── migrations/                 # Database schema
└── seeders/                    # Database seed data

resources/
├── views/
│   ├── qr/                    # QR code views (claim, profile)
│   ├── dashboard/             # User dashboard components
│   ├── admin/                 # Admin panel views
│   ├── vcardTemplates/        # Multiple vCard templates
│   ├── payment/               # Payment/billing views
│   └── ...
├── css/
│   └── liquid-glass.css       # Apple-style UI
└── js/                        # Frontend JavaScript
```

---

## Key Flows

### Flow 1: User Registration & Onboarding
1. User visits home or scans unclaimed QR → `/qr/{uuid}`
2. Redirects to `/qr/{uuid}/claim` if unclaimed
3. User registers (email, password) or logs in
4. Fills profile info (name, bio, image)
5. **Claim QR code** endpoint creates:
   - UserProfile record
   - Sets QrCode.user_id and is_claimed
   - Grants 1-month trial
   - Creates first Subscription record
6. Redirected to `/dashboard`

### Flow 2: Subscription Management
1. User on dashboard with trial → sees countdown
2. Day before expiry → reminder email sent
3. Trial expires → middleware redirects to `/billing`
4. User selects plan → `/payment/initialize`
5. Redirected to Flutterwave checkout
6. After payment → Flutterwave webhooks `/payment/webhook`
7. App verifies payment → creates active Subscription record
8. User can access dashboard again

### Flow 3: Public Profile View
1. User scans QR code (anytime, even if they don't own it)
2. App tracks scan count
3. If claimed → displays public profile (vCard template)
4. Shows social links, gallery, store (if enabled)
5. Non-logged-in users can browse, but orders require login

### Flow 4: Admin QR Generation
1. Admin: `/admin/qr-codes/generate`
2. Inputs quantity (e.g., 1000)
3. System generates QR codes with unique UUIDs and codes
4. Admin can export as CSV/PDF for printing
5. Each printed code contains URL with UUID

---

## Important Features

### PWA (Progressive Web App)
- Users can install profile as native app on mobile
- Custom app name, icon, theme colors
- Service worker for offline support
- Automatic manifest generation per user

### E-Commerce Integration
- Users can set up a store on their profile
- Add products with categories
- WhatsApp order integration
- Delivery fee and minimum order settings
- Order management in dashboard

### Email Notifications
- Welcome email on signup
- Trial expiry warnings (before expiration)
- Payment receipt emails
- Subscription renewal reminders

### Mobile Optimization
- TailwindCSS mobile-first design
- Responsive across all screen sizes
- PWA for native app experience
- Touch-friendly UI

---

## Security Considerations

1. **QR Code Protection**
   - Each QR code has unique UUID (not sequential)
   - Once claimed, cannot be transferred without admin intervention

2. **Subscription Gating**
   - `EnsureSubscribed` middleware prevents access to premium features
   - Dashboard only accessible if user has trial OR active subscription

3. **Admin Authentication**
   - Separate admin login from user login
   - `admin` middleware on admin routes

4. **Payment Security**
   - Flutterwave handles PCI compliance
   - Webhook verification with secret hash
   - Transaction reference stored for audit trail

---

## Configuration Files

- `.env` - Database, Flutterwave keys, email settings, app configuration
- `.env.production` - Production-specific settings
- `config/services.php` - Third-party service configs (Flutterwave)
- `config/mail.php` - Email driver configuration

---

## Installation & Setup Quick Guide

```bash
# 1. Install dependencies
composer install
npm install

# 2. Configure environment
cp .env.example .env
php artisan key:generate

# 3. Database setup
php artisan migrate
php artisan db:seed

# 4. Build assets
npm run dev  # development
npm run build  # production

# 5. Storage symlink
php artisan storage:link

# 6. Run in development
php artisan serve
```

---

## Common Tasks

### Generate QR Codes (Admin)
Navigate to `/admin/qr-codes/generate`, enter quantity, generate, export

### Give User Trial
CLI: `php artisan tinker` then `User::find(1)->update(['trial_ends_at' => now()->addMonth()])`

### Test Email Config
`php artisan test:email-config`

### Check Expired Trials
Console command: `php artisan check:expired-trials`

---

## System Status

- **Database**: ✅ Fully migrated (25+ migrations)
- **Authentication**: ✅ Laravel Breeze (user + admin)
- **Payment**: ✅ Flutterwave integrated with webhooks
- **QR Codes**: ✅ Working with permanent UUIDs
- **Templates**: ✅ 20+ vCard templates available
- **E-Commerce**: ✅ Full store system implemented
- **PWA**: ✅ Manifest and service worker generation
- **Email**: ✅ Welcome, notifications, payment receipts configured

---

## Notes for Developers

1. **QR Code Model**: Uses UUID as route key (not ID)
2. **Trial Auto-Generated**: Set during registration in `RegisteredUserController`
3. **Flutterwave Webhook**: Public route, no CSRF protection needed
4. **Storage**: Profile images and backgrounds stored in `storage/app/public/`
5. **Blade Templates**: PWA templates dynamically generated per user
6. **Admin Settings**: Stored in `settings` table, cached with `SettingsHelper`
