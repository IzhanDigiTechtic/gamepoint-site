# Admin Panel Access Guide

## Step 1: Create an Admin User

You need to create a user account and mark it as admin. Here are two ways:

### Method 1: Using Laravel Tinker (Recommended)

1. Open terminal/command prompt in your project directory
2. Run:
   ```bash
   php artisan tinker
   ```
3. In the tinker console, run:
   ```php
   $user = \App\Models\User::create([
       'name' => 'Admin',
       'email' => 'admin@example.com',
       'password' => bcrypt('your_password_here'),
       'is_admin' => true,
   ]);
   ```
4. Type `exit` to leave tinker

### Method 2: Using Database Directly

1. Register a normal user account through the website (Register page)
2. Then update that user in the database:
   ```sql
   UPDATE users SET is_admin = 1 WHERE email = 'your_email@example.com';
   ```

## Step 2: Access Admin Panel

1. **Login** to your website using the admin account you created
2. Go to: `http://your-domain.com/admin/dashboard`
   - Or click on "Admin Panel" in the user dropdown menu (top right)

## Step 3: Add Banners

### Option A: From Admin Dashboard
1. Go to Admin Dashboard (`/admin/dashboard`)
2. Click on the **"Banners"** card
3. Click **"Add New Banner"** button (or "Manage" → "Add New Banner")

### Option B: Direct URL
1. Go to: `http://your-domain.com/admin/banners/create`

### Banner Form Fields:
- **Title** (Optional): Banner title
- **Description** (Optional): Banner description
- **Image** (Required): Upload banner image
  - Recommended size: 1920x500px or similar wide format
  - Max size: 2MB
  - Formats: JPEG, PNG, JPG, GIF
- **Link** (Optional): URL to redirect when banner is clicked
  - Example: `https://example.com` or `/products?category=1`
- **Order**: Display order (lower numbers appear first)
  - Example: 0, 1, 2, 3...
- **Active**: Checkbox to enable/disable the banner

### Tips:
- Upload high-quality images for best display
- Set order numbers to control which banner appears first
- Only active banners will show on the homepage
- Banners appear in a carousel on the homepage

## Managing Banners

- **View All Banners**: `/admin/banners`
- **Edit Banner**: Click "Edit" button next to any banner
- **Delete Banner**: Click "Delete" button (with confirmation)
- **Change Order**: Edit banner and change the "Order" number

## Other Admin Features

From the Admin Dashboard, you can also manage:
- **Products**: Add, edit, delete products
- **Categories**: Manage product categories (with icons for icon bar)
- **Brands**: Manage product brands

## Important Notes

- Only users with `is_admin = true` can access admin panel
- Make sure to run `php artisan storage:link` if you haven't already (for image uploads)
- Banner images are stored in `storage/app/public/banners/`

