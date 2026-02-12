# 🚀 InsuranceSell — Hostinger Deployment Guide

## Pre-requisites
- Hostinger shared hosting plan (Business or Premium) 
- PHP 8.2+ enabled in hPanel
- MySQL database created in hPanel
- SSH access enabled (for running deploy script)

---

## Step 1: Create ZIP File

On your local PC, create a ZIP of the project **without** these folders:
- `vendor/` (will be installed on server)
- `node_modules/` (not needed)
- `.git/` (not needed on server)
- `storage/logs/*.log` (not needed)

### Quick ZIP Command (PowerShell):
```powershell
# Run this in the project folder
Compress-Archive -Path .env.example, app, bootstrap, config, database, deploy.sh, DEPLOY.md, public, resources, routes, storage, artisan, composer.json, composer.lock, .htaccess, .user.ini -DestinationPath C:\Users\$env:USERNAME\Desktop\insurancesell.zip -Force
```

Or manually: Select all files/folders **except** `vendor/`, `node_modules/`, `.git/` → Right click → "Send to Compressed (zipped) folder"

---

## Step 2: Upload ZIP to Hostinger

1. Login to **Hostinger hPanel**
2. Go to **Files → File Manager**
3. Navigate to `public_html/`
4. Click **Upload** → Select `insurancesell.zip`
5. Wait for upload to finish
6. Right-click the ZIP → **Extract** → Extract to `public_html/`
7. Make sure all files are directly inside `public_html/` (NOT inside a subfolder)

> [!IMPORTANT]
> Files should be at `public_html/app/`, `public_html/public/`, etc.
> NOT at `public_html/insurancesell/app/` — if they're in a subfolder, move them up!

---

## Step 3: Configure Domain Root

> [!IMPORTANT]
> Hostinger serves from `public_html/`. Laravel's entry point is `public/index.php`.
> You need to redirect all requests to the `public/` folder.

### Create Root .htaccess
Create a NEW file `public_html/.htaccess` (NOT inside `public/`):

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

You can create this via **File Manager → New File** in `public_html/`

---

## Step 4: Create Database

1. Go to **hPanel → Databases → MySQL Databases**
2. Create a new database (e.g., `u123456789_insurance`)
3. Note down: **Database Name**, **Username**, **Password**

---

## Step 5: Configure .env

### Via SSH:
```bash
ssh u123456789@your-server.hostinger.com
cd public_html
cp .env.example .env
nano .env
```

### Or via File Manager:
1. Copy `.env.example` → Rename copy to `.env`
2. Click `.env` → **Edit**

### Update these values:
```env
APP_NAME=InsuranceSell
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_HOST=localhost
DB_DATABASE=u123456789_insurance
DB_USERNAME=u123456789_insurance
DB_PASSWORD=your_password_here

ADMIN_EMAIL=admin@yourdomain.com
ADMIN_PASSWORD=YourSecurePassword123!
```

---

## Step 6: Run Deploy Script via SSH

```bash
# SSH into server
ssh u123456789@your-server.hostinger.com

# Go to project
cd public_html

# Make script executable & run
chmod +x deploy.sh
bash deploy.sh
```

This will automatically:
- ✅ Install Composer dependencies (`vendor/` folder)
- ✅ Generate APP_KEY
- ✅ Run all database migrations
- ✅ Seed database (admin user, 50 posts, 5 pages, settings)
- ✅ Create storage symlink
- ✅ Create upload directories (videos, images)
- ✅ Build production cache
- ✅ Set file permissions

---

## Step 7: Verify

1. **Website:** Visit `https://yourdomain.com`
2. **Admin Panel:** Visit `https://yourdomain.com/admin`
3. **Login:** Use the email/password from your `.env`
4. **SEO:** Visit `https://yourdomain.com/robots.txt` and `https://yourdomain.com/sitemap.xml`

---

## Step 8: Configure AdSense

1. Login to admin panel → **AdSense Manager**
2. Set your AdSense Publisher ID
3. Update `ads.txt` content
4. Go to **Site Settings** → Configure ad slot codes (1-4), content ads, sticky ad

---

## Post-Deployment Checklist

- [ ] Change admin password after first login
- [ ] Update `APP_URL` in `.env` to your real domain
- [ ] Add real AdSense code in admin panel
- [ ] Update `ads.txt` with your real publisher ID
- [ ] Submit sitemap to Google Search Console
- [ ] Enable Hostinger SSL (free Let's Encrypt)
- [ ] Test all pages load correctly
- [ ] Test video upload (250MB max) from admin panel
- [ ] Verify admin panel is accessible

---

## Common Issues

### 500 Internal Server Error
```bash
chmod -R 775 storage bootstrap/cache
tail -50 storage/logs/laravel.log
```

### Storage Images/Videos Not Loading
```bash
php artisan storage:link
```

### Admin Panel Not Loading (404)
```bash
php artisan route:clear
php artisan route:cache
```

### Video Upload Fails (Size Limit)
The `.user.ini` file in `public/` sets PHP limits to 256MB. If it still fails:
```bash
# Check current PHP limits
php -i | grep upload_max
# If too low, edit .user.ini in public/ folder
```

### Database Connection Error
- Verify DB credentials in `.env`
- Hostinger uses `localhost` for DB_HOST (not 127.0.0.1)

### Files in Wrong Folder
All project files must be directly in `public_html/`:
```
public_html/
├── app/
├── public/
├── routes/
├── .env
├── deploy.sh
└── ...
```
NOT inside a subfolder like `public_html/insurancesell/`
