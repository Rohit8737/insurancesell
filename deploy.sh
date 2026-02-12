#!/bin/bash
# ============================================
# InsuranceSell - Hostinger Deployment Script
# Run this via SSH on your Hostinger server
# ============================================

echo "🚀 Starting InsuranceSell Deployment..."

# 1. Install dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# 2. Generate app key (only if not set)
if ! grep -q "APP_KEY=base64:" .env; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force
fi

# 3. Run migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# 4. Seed database (first time only — comment out after first run)
echo "🌱 Seeding database..."
php artisan db:seed --force

# 5. Create storage symlink
echo "🔗 Creating storage symlink..."
php artisan storage:link 2>/dev/null || true

# 5b. Create upload directories
echo "📁 Creating upload directories..."
mkdir -p storage/app/public/videos
mkdir -p storage/app/public/posts/images
mkdir -p storage/app/public/posts/videos
mkdir -p storage/app/public/posts

# 6. Clear all caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# 7. Cache for production performance
echo "⚡ Building production cache..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 8. Set permissions
echo "🔒 Setting permissions..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

echo ""
echo "✅ Deployment Complete!"
echo "🌐 Visit: $(grep APP_URL .env | cut -d'=' -f2)"
echo "🔐 Admin: $(grep APP_URL .env | cut -d'=' -f2)/admin"
echo ""
echo "📌 Admin Login:"
echo "   Email: $(grep ADMIN_EMAIL .env | cut -d'=' -f2)"
echo "   Password: (from your .env ADMIN_PASSWORD)"
echo "   ⚠️ CHANGE THIS IMMEDIATELY after first login!"
