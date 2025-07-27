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

## License
See LICENSE file for details.
