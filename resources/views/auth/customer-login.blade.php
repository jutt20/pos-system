<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Customer Login - {{ config('app.name', 'Nexitel POS') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            animation: backgroundMove 20s ease-in-out infinite;
        }

        @keyframes backgroundMove {
            0%, 100% { transform: translateX(0) translateY(0); }
            25% { transform: translateX(-10px) translateY(-10px); }
            50% { transform: translateX(10px) translateY(-5px); }
            75% { transform: translateX(-5px) translateY(10px); }
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.15);
            padding: 0;
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            min-height: 650px;
            display: flex;
            position: relative;
            z-index: 1;
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-left {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            color: white;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            flex: 1;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: float 15s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .logo-container {
            position: relative;
            z-index: 2;
            margin-bottom: 40px;
            animation: logoFloat 3s ease-in-out infinite;
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .logo {
            width: 90px;
            height: 90px;
            border-radius: 22px;
            object-fit: contain;
            background: rgba(255, 255, 255, 0.2);
            padding: 15px;
            backdrop-filter: blur(10px);
            border: 3px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .welcome-text {
            position: relative;
            z-index: 2;
        }

        .welcome-text h2 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 25px;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            animation: textGlow 2s ease-in-out infinite alternate;
        }

        @keyframes textGlow {
            from { text-shadow: 0 4px 15px rgba(0, 0, 0, 0.3); }
            to { text-shadow: 0 4px 25px rgba(255, 255, 255, 0.3); }
        }

        .welcome-text p {
            font-size: 1.2rem;
            opacity: 0.9;
            line-height: 1.7;
            margin-bottom: 40px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            width: 100%;
            max-width: 300px;
        }

        .feature-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 16px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            animation: featureFloat 4s ease-in-out infinite;
        }

        .feature-item:nth-child(even) {
            animation-delay: 2s;
        }

        @keyframes featureFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }

        .feature-item:hover {
            transform: translateY(-5px) scale(1.05);
            background: rgba(255, 255, 255, 0.2);
        }

        .feature-item i {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #ffd700;
            display: block;
        }

        .feature-item span {
            font-size: 0.9rem;
            font-weight: 500;
        }

        .login-right {
            padding: 60px 50px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: white;
        }

        .login-form {
            max-width: 400px;
            width: 100%;
        }

        .form-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .form-title h3 {
            color: #2d3748;
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 15px;
            position: relative;
        }

        .form-title h3::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            border-radius: 2px;
        }

        .form-title p {
            color: #718096;
            font-size: 1.1rem;
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 30px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 10px;
            color: #2d3748;
            font-weight: 600;
            font-size: 1rem;
        }

        .form-control {
            width: 100%;
            padding: 18px 25px;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
            font-family: 'Inter', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: #8b5cf6;
            background: white;
            box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
            transform: translateY(-2px);
        }

        .input-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            margin-top: 15px;
            font-size: 1.1rem;
        }

        .btn-login {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(139, 92, 246, 0.4);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            border: 2px solid #e2e8f0;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: #8b5cf6;
            border-color: #8b5cf6;
        }

        .form-check-label {
            color: #4a5568;
            font-size: 0.95rem;
            cursor: pointer;
        }

        .form-links {
            text-align: center;
            margin-top: 30px;
        }

        .form-links a {
            color: #8b5cf6;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
        }

        .form-links a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #8b5cf6;
            transition: width 0.3s ease;
        }

        .form-links a:hover::after {
            width: 100%;
        }

        .form-links a:hover {
            color: #7c3aed;
        }

        .portal-links {
            text-align: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #f1f5f9;
        }

        .portal-links p {
            color: #718096;
            margin-bottom: 20px;
            font-size: 1rem;
            font-weight: 500;
        }

        .portal-link {
            display: inline-block;
            margin: 0 15px 10px;
            padding: 12px 20px;
            background: linear-gradient(135deg, #f8f9fa, #e2e8f0);
            color: #4a5568;
            text-decoration: none;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .portal-link:hover {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.3);
        }

        .alert {
            padding: 18px 25px;
            border-radius: 16px;
            margin-bottom: 30px;
            border: none;
            animation: alertSlide 0.5s ease-out;
        }

        @keyframes alertSlide {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
            border-left: 5px solid #dc2626;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                margin: 10px;
                min-height: auto;
                max-width: 500px;
            }

            .login-left {
                padding: 40px 30px;
                min-height: 400px;
            }

            .login-right {
                padding: 40px 30px;
            }

            .welcome-text h2 {
                font-size: 2.2rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
                max-width: 250px;
            }

            .portal-link {
                display: block;
                margin: 10px 0;
            }
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #8b5cf6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>

<body>
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>

    <div class="login-container">
        <div class="login-left">
            <div class="logo-container">
                <img src="{{ asset('images/logo.jpg') }}" alt="Nexitel Logo" class="logo">
            </div>
            <div class="welcome-text">
                <h2>Customer Portal</h2>
                <p>Access your account, view invoices, track orders, and manage your services with ease.</p>
                <div class="features-grid">
                    <div class="feature-item">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>View Invoices</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-shipping-fast"></i>
                        <span>Track Orders</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-user-cog"></i>
                        <span>Account Settings</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-headset"></i>
                        <span>Support</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="login-right">
            <form method="POST" action="{{ route('customer.login') }}" class="login-form" id="loginForm">
                @csrf
                
                <div class="form-title">
                    <h3>Customer Access</h3>
                    <p>Sign in to your customer account</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="form-group">
                    <label for="username" class="form-label">Username or Email</label>
                    <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus autocomplete="username">
                    <i class="fas fa-user input-icon"></i>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                    <i class="fas fa-lock input-icon"></i>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                    <label class="form-check-label" for="remember_me">
                        Remember me
                    </label>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Access Customer Portal
                </button>

                <div class="form-links">
                    <a href="#">
                        Forgot your password?
                    </a>
                </div>

                <div class="portal-links">
                    <p>Access other portals:</p>
                    <a href="{{ route('login') }}" class="portal-link">
                        <i class="fas fa-users-cog"></i> Staff Portal
                    </a>
                    <a href="{{ route('retailer.login') }}" class="portal-link">
                        <i class="fas fa-store"></i> Retailer Portal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.getElementById('loginForm').addEventListener('submit', function() {
            document.getElementById('loadingOverlay').style.display = 'flex';
        });

        // Add some interactive effects
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>
