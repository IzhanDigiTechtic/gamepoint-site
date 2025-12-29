# Setup Instructions

## Prerequisites
- PHP 8.2+
- MySQL
- Composer
- Node.js & NPM

## Installation Steps

1. **Install PHP Dependencies**
   ```bash
   composer install
   ```

2. **Install NPM Dependencies**
   ```bash
   npm install
   ```

3. **Configure Environment**
   - Copy `.env.example` to `.env` if not exists
   - Update database configuration in `.env`:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=your_database_name
     DB_USERNAME=your_username
     DB_PASSWORD=your_password
     ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Run Migrations**
   ```bash
   php artisan migrate
   ```

6. **Create Storage Link**
   ```bash
   php artisan storage:link
   ```

7. **Create Admin User**
   You can create an admin user via tinker:
   ```bash
   php artisan tinker
   ```
   Then run:
   ```php
   $user = \App\Models\User::create([
       'name' => 'Admin',
       'email' => 'admin@example.com',
       'password' => bcrypt('password'),
       'is_admin' => true,
   ]);
   ```

8. **Build Assets**
   ```bash
   npm run build
   ```

9. **Start Development Server**
   ```bash
   php artisan serve
   ```

## Features Implemented

✅ Bootstrap-based responsive frontend
✅ Home page with banner carousel
✅ Product listing with filters (category, brand, search)
✅ Product detail page with reviews
✅ Review system (requires admin approval)
✅ Login/Signup functionality
✅ Admin panel for:
   - Banner/Carousel management
   - Product management
   - Category management
   - Brand management
✅ WhatsApp floating button
✅ Mobile-friendly responsive design
✅ MySQL database support

## Admin Access

To access admin panel, user must have `is_admin = true` in the users table.

## WhatsApp Button

Update the WhatsApp number in `resources/views/layouts/app.blade.php`:
```php
href="https://wa.me/YOUR_PHONE_NUMBER?text=..."
```

## Notes

- Reviews require admin approval before being displayed
- Product images are stored in `storage/app/public/products`
- Banner images are stored in `storage/app/public/banners`
- Make sure to run `php artisan storage:link` to make images accessible

