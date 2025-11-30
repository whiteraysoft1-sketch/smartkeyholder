# Smart Keyolder

This is the Smart Keyolder project.

## Overview
Smart Keyolder is a Laravel-based application. It provides features for digital business cards, QR code management, PWA support, and more.

## Features
- Digital vCard templates
- QR code generation and management
- Progressive Web App (PWA) support
- Admin dashboard
- Payment integration

## Requirements
- PHP >= 8.0
- Composer
- Node.js & npm
- MySQL or compatible database

## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/SteveWhiteraysoft/Smart-Keyolder.git
   ```
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Install JavaScript dependencies:
   ```bash
   npm install
   ```
4. Copy the example environment file and set your configuration:
   ```bash
   cp .env.example .env
   ```
5. Generate application key:
   ```bash
   php artisan key:generate
   ```
6. Run migrations:
   ```bash
   php artisan migrate
   ```
7. Build assets:
   ```bash
   npm run build
   ```
8. Start the development server:
   ```bash
   php artisan serve
   ```

## Local Deployment
To deploy and test the project on your local machine:

1. Ensure you have completed all steps in the Installation section above.
2. Start the Laravel development server:
   ```bash
   php artisan serve
   ```
   By default, the application will be available at http://localhost:8000
3. (Optional) If you are using a different local web server (e.g., XAMPP, WAMP), configure your web server's document root to point to the `public` directory of this project.
4. Access the application in your browser at http://localhost:8000 or your configured local domain.

## How the Project Works

Smart Keyolder is designed to help users create, manage, and share digital business cards (vCards) with ease. Here’s how the main features work:

- **User Registration & Login:** Users can register for an account and log in to access their dashboard.
- **vCard Creation:** After logging in, users can create and customize digital vCards using a variety of templates. Each vCard can include contact information, social links, and more.
- **QR Code Generation:** For each vCard, a unique QR code is generated. This QR code can be downloaded or printed, allowing others to scan and view the digital card instantly.
- **Admin Dashboard:** Admin users can manage all users, view analytics, and configure system settings.
- **PWA Support:** The application can be installed as a Progressive Web App (PWA) on mobile devices for quick access and offline functionality.
- **Payments:** Integrated payment options allow users to upgrade their plans or purchase additional features.

The project is built with Laravel for the backend, Blade for templating, and includes modern web features for a seamless user experience.

## License
See LICENSE file for details.
# smartkeyholder
#
## Deployment Trigger
Triggered redeployment on November 30, 2025.
# smartkeyholder
