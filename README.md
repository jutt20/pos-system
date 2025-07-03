# Nexitel Point of Sales System

A comprehensive Point of Sales system built with Laravel featuring role-based access control, customer management, billing, and reporting.

## Features

- **Role-Based Access Control** using Spatie Laravel Permission
- **Employee Management** with customizable roles and permissions
- **Customer Management** with detailed profiles and document storage
- **Billing System** with invoice generation and PDF export
- **SIM Order Management** with inventory tracking
- **Activation Management** with profit tracking
- **Dashboard** with analytics and charts
- **File Management** for customer documents
- **Modern UI** with Bootstrap and custom styling

## Installation

1. Clone the repository
2. Run `composer install`
3. Copy `.env.example` to `.env`
4. Configure your database settings in `.env`
5. Run `php artisan key:generate`
6. Run `php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"`
7. Run `php artisan migrate`
8. Run `php artisan db:seed --class=RolePermissionSeeder`
9. Run `php artisan storage:link`
10. Run `php artisan serve`

## Default Credentials

- **Username:** admin
- **Password:** password

## Roles & Permissions

- **Admin:** Full system access
- **Manager:** Customer, billing, and operations management
- **Accountant:** Billing and financial reports
- **Sales Agent:** Customer management and activations
- **Technical Support:** Customer support and activations

## Key Components

### Models
- Employee (with Spatie roles)
- Customer
- Invoice & InvoiceItem
- SimOrder
- Activation
- CustomerDocument

### Controllers
- DashboardController (analytics)
- EmployeeController (staff management)
- CustomerController (client management)
- InvoiceController (billing)
- ActivationController (service activations)
- SimOrderController (inventory)

### Features
- PDF invoice generation
- Excel export capabilities
- File upload and management
- Real-time dashboard charts
- Role-based navigation
- Responsive design

## Technology Stack

- **Backend:** Laravel 10
- **Authentication:** Laravel Auth with custom Employee guard
- **Permissions:** Spatie Laravel Permission
- **Frontend:** Bootstrap 5, Chart.js
- **Database:** MySQL/PostgreSQL
- **PDF Generation:** DomPDF
- **Excel Export:** Maatwebsite Excel

## Usage

1. **Admin Setup:** Create employee accounts and assign roles
2. **Customer Management:** Add customers and assign to employees
3. **Billing:** Create invoices and track payments
4. **Activations:** Record service activations and track profit
5. **Inventory:** Manage SIM card orders and inventory
6. **Reports:** View analytics and export data

## Security

- Role-based access control
- CSRF protection
- Input validation
- File upload security
- Session management

## Support

For support and customization, please contact the development team.
