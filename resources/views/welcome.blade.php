<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Nexitel POS') }} - Welcome</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .hero-section {
            padding: 100px 0;
            text-align: center;
            color: white;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 30px;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 50px;
            opacity: 0.9;
        }

        .portal-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .portal-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .portal-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.2);
            text-decoration: none;
            color: inherit;
        }

        .portal-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: white;
        }

        .staff-portal .portal-icon {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .retailer-portal .portal-icon {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .customer-portal .portal-icon {
            background: linear-gradient(135deg, #6f42c1, #e83e8c);
        }

        .order-portal .portal-icon {
            background: linear-gradient(135deg, #fd7e14, #ffc107);
        }

        .portal-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #2d3748;
        }

        .portal-description {
            color: #718096;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .portal-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .retailer-portal .portal-btn {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .customer-portal .portal-btn {
            background: linear-gradient(135deg, #6f42c1, #e83e8c);
        }

        .order-portal .portal-btn {
            background: linear-gradient(135deg, #fd7e14, #ffc107);
        }

        .portal-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .features-section {
            background: white;
            padding: 80px 0;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .feature-item {
            text-align: center;
            padding: 30px 20px;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 1.5rem;
        }

        .footer {
            background: #2d3748;
            color: white;
            padding: 40px 0;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title">Nexitel POS System</h1>
            <p class="hero-subtitle">Complete Point of Sale Solution for SIM Card Management</p>
            
            <div class="portal-cards">
                <a href="{{ route('staff.login') }}" class="portal-card staff-portal">
                    <div class="portal-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="portal-title">Staff Portal</h3>
                    <p class="portal-description">
                        Access the main dashboard to manage customers, employees, invoices, activations, and comprehensive reporting.
                    </p>
                    <button class="portal-btn">
                        <i class="fas fa-sign-in-alt me-2"></i>Staff Login
                    </button>
                </a>

                <a href="{{ route('retailer.login') }}" class="portal-card retailer-portal">
                    <div class="portal-icon">
                        <i class="fas fa-store"></i>
                    </div>
                    <h3 class="portal-title">Retailer Portal</h3>
                    <p class="portal-description">
                        Retailer-specific dashboard with sales analytics, transaction management, and business reports.
                    </p>
                    <button class="portal-btn">
                        <i class="fas fa-sign-in-alt me-2"></i>Retailer Login
                    </button>
                </a>

                <a href="{{ route('customer.login') }}" class="portal-card customer-portal">
                    <div class="portal-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <h3 class="portal-title">Customer Portal</h3>
                    <p class="portal-description">
                        Customer dashboard to view orders, invoices, activations, and manage account information.
                    </p>
                    <button class="portal-btn">
                        <i class="fas fa-sign-in-alt me-2"></i>Customer Login
                    </button>
                </a>

                <a href="{{ route('sim-order.create') }}" class="portal-card order-portal">
                    <div class="portal-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3 class="portal-title">Order SIM Cards</h3>
                    <p class="portal-description">
                        Place new SIM card orders online with delivery options and real-time tracking capabilities.
                    </p>
                    <button class="portal-btn">
                        <i class="fas fa-plus me-2"></i>Place Order
                    </button>
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2>System Features</h2>
                <p class="lead">Comprehensive POS solution with advanced features</p>
            </div>
            
            <div class="feature-grid">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h4>Analytics & Reports</h4>
                    <p>Real-time business analytics with comprehensive reporting and data visualization.</p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-sim-card"></i>
                    </div>
                    <h4>SIM Management</h4>
                    <p>Complete SIM card inventory management with stock tracking and activation features.</p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <h4>Invoice System</h4>
                    <p>Professional invoicing system with PDF generation and payment tracking.</p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h4>Order Tracking</h4>
                    <p>Real-time order tracking with multiple delivery options and status updates.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} Nexitel POS System. All rights reserved.</p>
            <p>
                <a href="#" class="text-light me-3">Privacy Policy</a>
                <a href="#" class="text-light me-3">Terms of Service</a>
                <a href="#" class="text-light">Support</a>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
