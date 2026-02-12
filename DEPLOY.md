# 🚀 InsuranceSell — Hostinger Deployment Guide

## Pre-requisites
- Hostinger shared hosting plan (Business or Premium) 
- PHP 8.2+ enabled in hPanel
- MySQL database created in hPanel
- SSH access enabled

---

## Step 1: Upload Files

### Option A: Git (Recommended)
```bash
# SSH into Hostinger
ssh u123456789@your-server.hostinger.com

# Navigate to web root
cd public_html

# Clone your repo
git clone https://github.com/Rohit8737/insurancesell.git .
```

### Option B: FTP Upload
1. Zip the entire project folder (excluding `vendor/` and `node_modules/`)
2. Upload the zip to Hostinger File Manager → `public_html/`
3. Extract the zip

---

## Step 2: Configure Domain Root

> [!IMPORTANT]
> Hostinger serves from `public_html/`. Laravel's entry point is `public/index.php`.
> You need to point the domain to `public_html/public/` or use the redirect method below.

### Method: Root .htaccess Redirect
Create `public_html/.htaccess` (NOT inside `public/`):

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

---

## Step 3: Create Database

1. Go to **hPanel → Databases → MySQL Databases**
2. Create a new database (e.g., `u123456789_insurance`)
3. Note down: **Database Name**, **Username**, **Password**

---

## Step 4: Configure .env

```bash
# Copy the example
cp .env.example .env

# Edit with your details
nano .env
```

Update these values:
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

## Step 5: Run Deploy Script

```bash
# Make the script executable
chmod +x deploy.sh

# Run deployment
bash deploy.sh
```

This will automatically:
- ✅ Install Composer dependencies
- ✅ Generate APP_KEY
- ✅ Run all migrations
- ✅ Seed the database (admin user, settings, all 50 posts, pages)
- ✅ Create storage symlink
- ✅ Build production cache
- ✅ Set file permissions

---

## Step 6: Verify

1. **Website:** Visit `https://yourdomain.com`
2. **Admin Panel:** Visit `https://yourdomain.com/admin`
3. **Login:** Use the email/password from your `.env`
4. **SEO Check:** Visit `https://yourdomain.com/robots.txt` and `https://yourdomain.com/sitemap.xml`

---

## Step 7: Configure AdSense

1. Login to admin panel → **AdSense Manager**
2. Paste your AdSense ad codes in each slot
3. Update `ads.txt` content with your publisher ID
4. Go to **Site Settings** → Update site name, logo, and social links

---

## Post-Deployment Checklist

- [ ] Change admin password after first login
- [ ] Update `APP_URL` in `.env` to your real domain
- [ ] Add real AdSense code in admin panel
- [ ] Update `ads.txt` with your real publisher ID
- [ ] Submit sitemap to Google Search Console
- [ ] Enable Hostinger SSL (free Let's Encrypt)
- [ ] Test all pages load correctly
- [ ] Verify admin panel is accessible

---

## Common Issues

### 500 Internal Server Error
```bash
# Check permissions
chmod -R 775 storage bootstrap/cache

# Check logs
tail -50 storage/logs/laravel.log
```

### Storage Images Not Loading
```bash
php artisan storage:link
```

### Admin Panel Not Loading (404)
```bash
# Clear and rebuild cache
php artisan route:clear
php artisan route:cache
```

### Database Connection Error
- Verify DB credentials in `.env`
- Hostinger uses `localhost` for DB_HOST (not 127.0.0.1)
