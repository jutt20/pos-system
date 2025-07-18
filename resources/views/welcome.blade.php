<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Nexitel POS System') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            animation: drift 30s ease-in-out infinite;
        }

        @keyframes drift {
            0%, 100% { transform: translateX(0) translateY(0); }
            25% { transform: translateX(-20px) translateY(-10px); }
            50% { transform: translateX(20px) translateY(-20px); }
            75% { transform: translateX(-10px) translateY(10px); }
        }

        .hero-content {
            position: relative;
            z-index: 2;
            color: white;
            text-align: center;
        }

        .logo-hero {
            width: 120px;
            height: 120px;
            border-radius: 30px;
            object-fit: contain;
            background: rgba(255, 255, 255, 0.15);
            padding: 20px;
            backdrop-filter: blur(20px);
            border: 3px solid rgba(255, 255, 255, 0.2);
            margin: 0 auto 40px;
            display: block;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            animation: logoFloat 6s ease-in-out infinite;
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(2deg); }
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 900;
            margin-bottom: 20px;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            background: linear-gradient(45deg, #fff, #f0f9ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            font-size: 1.4rem;
            margin-bottom: 40px;
            opacity: 0.95;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .portal-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .portal-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .portal-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.6s;
        }

        .portal-card:hover::before {
            left: 100%;
        }

        .portal-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.3);
            background: rgba(255, 255, 255, 0.15);
        }

        .portal-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 25px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            transition: all 0.3s ease;
        }

        .portal-card:hover .portal-icon {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1) rotate(5deg);
        }

        .portal-card h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: white;
        }

        .portal-card p {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .portal-btn {
            display: inline-block;
            padding: 15px 30px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }

        .portal-btn:hover {
            background: white;
            color: #667eea;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.3);
        }

        /* Features Section */
        .features {
            padding: 100px 0;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .features h2 {
            text-align: center;
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 20px;
            color: #1e293b;
        }

        .features-subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: #64748b;
            margin-bottom: 60px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 25px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
        }

        .feature-card h4 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: #1e293b;
        }

        .feature-card p {
            color: #64748b;
            line-height: 1.6;
        }

        /* Footer */
        .footer {
            background: #1e293b;
            color: white;
            padding: 60px 0 30px;
            text-align: center;
        }

        .footer-logo {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            object-fit: contain;
            background: rgba(255, 255, 255, 0.1);
            padding: 10px;
            margin: 0 auto 20px;
            display: block;
        }

        .footer h5 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .footer p {
            opacity: 0.8;
            margin-bottom: 30px;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .footer-links a:hover {
            opacity: 1;
            text-decoration: none;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
            opacity: 0.6;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .portal-cards {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .portal-card {
                padding: 30px 20px;
            }

            .features h2 {
                font-size: 2.2rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .footer-links {
                flex-direction: column;
                gap: 15px;
            }
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 1s ease-out;
        }

        .slide-up {
            animation: slideUp 1s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { 
                opacity: 0;
                transform: translateY(30px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content fade-in">
                <img src="{{ asset('images/logo.jpg') }}" alt="Nexitel Logo" class="logo-hero">
                <h1>Nexitel POS System</h1>
                <p>Comprehensive Point of Sales solution with multi-portal access for staff, retailers, and customers</p>
                
                <div class="portal-cards slide-up">
                    <div class="portal-card">
                        <div class="portal-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h3>Staff Portal</h3>
                        <p>Complete administrative access with role-based permissions for managing all aspects of your business</p>
                        <a href="{{ route('login') }}" class="portal-btn">
                            <i class="fas fa-sign-in-alt me-2"></i>Staff Login
                        </a>
                    </div>
                    
                    <div class="portal-card">
                        <div class="portal-icon">
                            <i class="fas fa-store"></i>
                        </div>
                        <h3>Retailer Portal</h3>
                        <p>Dedicated interface for retailers to manage sales, track commissions, and handle customer activations</p>
                        <a href="{{ route('retailer.login') }}" class="portal-btn">
                            <i class="fas fa-sign-in-alt me-2"></i>Retailer Login
                        </a>
                    </div>
                    
                    <div class="portal-card">
                        <div class="portal-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <h3>Customer Portal</h3>
                        <p>Self-service portal for customers to view orders, track activations, and manage their account</p>
                        <a href="{{ route('customer.login') }}" class="portal-btn">
                            <i class="fas fa-sign-in-alt me-2"></i>Customer Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <h2>Powerful Features</h2>
            <p class="features-subtitle">Everything you need to manage your telecommunications business efficiently</p>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h4>SIM Management</h4>
                    <p>Complete SIM stock management with activation tracking, inventory control, and automated workflows</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <h4>Invoice System</h4>
                    <p>Professional invoicing with PDF generation, payment tracking, and automated billing processes</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <h4>Role Management</h4>
                    <p>Granular permission system with role-based access control for secure multi-user environments</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h4>Analytics & Reports</h4>
                    <p>Comprehensive reporting with real-time analytics, sales tracking, and performance insights</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h4>Real-time Chat</h4>
                    <p>Built-in communication system with Laravel Reverb for instant team collaboration</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4>Secure & Reliable</h4>
                    <p>Enterprise-grade security with data encryption, audit trails, and backup systems</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <img src="{{ asset('images/logo.jpg') }}" alt="Nexitel Logo" class="footer-logo">
            <h5>Nexitel POS System</h5>
            <p>Empowering telecommunications businesses with cutting-edge technology</p>
            
            <div class="footer-links">
                <a href="#features">Features</a>
                <a href="#support">Support</a>
                <a href="#documentation">Documentation</a>
                <a href="#contact">Contact</a>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Nexitel POS System. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Add smooth scrolling and animations
        document.addEventListener('DOMContentLoaded', function() {
            // Animate elements on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe feature cards
            document.querySelectorAll('.feature-card').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'all 0.6s ease';
                observer.observe(card);
            });

            // Add hover effects to portal cards
            document.querySelectorAll('.portal-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px) scale(1.02)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
        });
    </script>
</body>
</html>
