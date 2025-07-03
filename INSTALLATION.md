# Nexitel POS System - Installation Guide

## System Requirements

- PHP 8.1 or higher
- MySQL 5.7+ or PostgreSQL 10+
- Composer
- Node.js & NPM (optional, for asset compilation)

## Installation Steps

### 1. Clone or Download the Project

\`\`\`bash
git clone <repository-url> nexitel-pos
cd nexitel-pos
\`\`\`

### 2. Install Dependencies

\`\`\`bash
composer install
\`\`\`

### 3. Environment Setup

\`\`\`bash
cp .env.example .env
php artisan key:generate
\`\`\`

### 4. Database Configuration

Edit `.env` file with your database credentials:

\`\`\`env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nexitel_pos
DB_USERNAME=your_username
DB_PASSWORD=your_password
\`\`\`

### 5. Install Spatie Permission

\`\`\`bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
\`\`\`

### 6. Run Migrations and Seeders

\`\`\`bash
php artisan migrate
php artisan db:seed --class=RolePermissionSeeder
\`\`\`

### 7. Create Storage Link

\`\`\`bash
php artisan storage:link
\`\`\`

### 8. Start the Application

\`\`\`bash
php artisan serve
\`\`\`

Visit: `http://localhost:8000`

## Default Login Credentials

- **Username:** admin
- **Password:** password

## Features

✅ **Employee Management** - Role-based access control
✅ **Customer Management** - Complete customer profiles
✅ **Invoice System** - PDF generation and email
✅ **Activation Tracking** - Profit calculation
✅ **SIM Order Management** - Inventory tracking
✅ **Dashboard Analytics** - Real-time reporting
✅ **Document Management** - File uploads per customer
✅ **Export Functionality** - Excel reports

## Roles & Permissions

- **Admin** - Full system access
- **Manager** - Operations and customer management
- **Accountant** - Billing and financial reports
- **Sales Agent** - Customer and activation management
- **Technical Support** - Customer support functions

## Troubleshooting

### Permission Issues
\`\`\`bash
chmod -R 775 storage bootstrap/cache
\`\`\`

### Clear Cache
\`\`\`bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
\`\`\`

### Database Issues
- Ensure database exists and credentials are correct
- Check PHP extensions: `php -m | grep -E 'pdo|mysql'`

## Support

For technical support or customization requests, please contact the development team.

## Security

- Change default admin password immediately
- Configure proper file permissions
- Use HTTPS in production
- Regular database backups recommended
