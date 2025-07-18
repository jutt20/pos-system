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
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            padding: 0;
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            min-height: 600px;
            display: flex;
        }

        .login-left {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 60px 40px;
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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="50" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="30" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .logo-container {
            position: relative;
            z-index: 2;
            margin-bottom: 30px;
        }

        .logo {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            object-fit: contain;
            background: rgba(255, 255, 255, 0.2);
            padding: 12px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .welcome-text {
            position: relative;
            z-index: 2;
        }

        .welcome-text h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .welcome-text p {
            font-size: 1.1rem;
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .features-list {
            list-style: none;
            padding: 0;
            text-align: left;
        }

        .features-list li {
            padding: 8px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .features-list i {
            color: #ffd700;
            font-size: 1.1rem;
        }

        .login-right {
            padding: 60px 50px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form {
            max-width: 400px;
            width: 100%;
        }

        .form-title {
            text-align: center;
            margin-bottom: 40px;
        }

        .form-title h3 {
            color: #333;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .form-title p {
            color: #666;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            outline: none;
            border-color: #10b981;
            background: white;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            margin-top: 12px;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .form-links {
            text-align: center;
            margin-top: 30px;
        }

        .form-links a {
            color: #10b981;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .form-links a:hover {
            color: #059669;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            border: none;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
            border-left: 4px solid #dc2626;
        }

        .portal-links {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e1e5e9;
        }

        .portal-links p {
            color: #666;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        .portal-link {
            display: inline-block;
            margin: 0 10px;
            padding: 8px 16px;
            background: #f8f9fa;
            color: #10b981;
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .portal-link:hover {
            background: #10b981;
            color: white;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                margin: 10px;
                min-height: auto;
            }

            .login-left {
                padding: 40px 30px;
                min-height: 300px;
            }

            .login-right {
                padding: 40px 30px;
            }

            .welcome-text h2 {
                font-size: 2rem;
            }

            .features-list {
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-left">
            <div class="logo-container">
                <img src="{{ asset('images/logo.jpg') }}" alt="Nexitel Logo" class="logo">
            </div>
            <div class="welcome-text">
                <h2>Customer Portal</h2>
                <p>Access your account and manage your services with our easy-to-use customer portal.</p>
                <ul class="features-list">
                    <li><i class="fas fa-mobile-alt"></i> View Activations</li>
                    <li><i class="fas fa-shopping-cart"></i> Track Orders</li>
                    <li><i class="fas fa-file-invoice"></i> View Invoices</li>
                    <li><i class="fas fa-headset"></i> Customer Support</li>
                    <li><i class="fas fa-user-cog"></i> Account Settings</li>
                </ul>
            </div>
        </div>

        <div class="login-right">
            <form method="POST" action="{{ route('customer.login') }}" class="login-form">
                @csrf
                
                <div class="form-title">
                    <h3>Welcome Back</h3>
                    <p>Sign in to your customer account</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                    <i class="fas fa-envelope input-icon"></i>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                    <i class="fas fa-lock input-icon"></i>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                        <label class="form-check-label" for="remember_me">
                            Remember me
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Sign In to Customer Portal
                </button>

                <div class="form-links">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            Forgot your password?
                        </a>
                    @endif
                </div>

                <div class="portal-links">
                    <p>Access other portals:</p>
                    <a href="{{ route('login') }}" class="portal-link">
                        <i class="fas fa-user-tie"></i> Staff Portal
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
</body>
</html>
