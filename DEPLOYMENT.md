# Girna Global - Deployment Guide (Hostinger & Shared Hosting)

This guide walks you through deploying the **Girna Global** website and CMS onto standard Linux shared hosting such as **Hostinger**, **cPanel**, **cPanel/WHM**, or **Bluehost**.

---

## Step 1: Create MySQL Database

1. Log into your hosting control panel (Hostinger hPanel or cPanel).
2. Go to **Databases** -> **MySQL Databases**.
3. Create a new database named `girna_global_db`.
4. Create a database user (e.g. `girna_user`) and assign a secure password.
5. Grant all privileges to the user for the `girna_global_db` database.

---

## Step 2: Import Database Schema (`database.sql`)

1. Open **phpMyAdmin** from your hosting dashboard.
2. Select your newly created database (`girna_global_db`).
3. Click on the **Import** tab at the top.
4. Choose the `database.sql` file located in the root directory of this project.
5. Click **Go** / **Import**. All 9 tables and default seed data will be created automatically.

---

## Step 3: Configure Database Credentials

Open `config/database.php` and update the constants with your live credentials:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'your_live_db_user');
define('DB_PASS', 'your_live_db_password');
define('DB_NAME', 'your_live_db_name');
```

---

## Step 4: Upload Project Files

1. Compress all files from the `GIRNA GLOBAL WEBSITE` directory into a `.zip` file (excluding local git or IDE folders if any).
2. Go to **File Manager** in your hosting panel and navigate to `public_html/`.
3. Upload the `.zip` file and extract it directly inside `public_html/`.
4. Ensure the `/uploads/` directory and all its subfolders (`/uploads/services/`, `/uploads/products/`, `/uploads/site/`, etc.) have write permissions (`755` or `777`).

---

## Step 5: Admin Login & Initial Test

1. Visit your domain's admin URL: `http://your-domain.com/admin/login.php`
2. Enter default login credentials:
   - **Username**: `admin`
   - **Password**: `admin123`
3. Go to **Global Site Settings** to upload your actual logo, phone number, WhatsApp number, and office address.

---

## Step 6: Gmail SMTP Email Configuration (Optional)

If you wish to use Gmail SMTP for sending contact emails via PHPMailer:
1. Go to your Google Account -> Security -> Enable 2-Step Verification.
2. Search for **App Passwords** and generate a 16-character App Password for "Mail".
3. Enter your SMTP credentials inside `config/database.php` or `admin/settings.php`.
