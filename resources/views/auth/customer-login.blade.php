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
            background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.15);
            padding: 0;
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            min-height: 600px;
            display: flex;
        }

        .login-left {
            background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%);
            color: white;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            flex: 1;
        }

        .login-right {
            padding: 60px 50px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: white;
        }

        .form-control {
            border-radius: 16px;
            border: 2px solid #e2e8f0;
            padding: 18px 25px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #6f42c1;
            box-shadow: 0 0 0 4px rgba(111, 66, 193, 0.1);
        }

        .btn-login {
            background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%);
            border: none;
            border-radius: 16px;
            padding: 18px;
            font-size: 1.2rem;
            font-weight: 600;
            color: white;
            width: 100%;
            margin-top: 20px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(111, 66, 193, 0.4);
        }

        .portal-links a {
            color: #6f42c1;
            text-decoration: none;
            font-weight: 600;
        }

        .portal-links a:hover {
            color: #e83e8c;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-left">
            <div class="logo-container mb-4">
                <img src="{{ asset('images/logo.jpg') }}" alt="Nexitel Logo" class="logo" style="width: 90px; height: 90px; border-radius: 22px;">
            </div>
            <div class="welcome-text">
                <h2>Customer Portal</h2>
                <p>Access your customer dashboard and manage your account, orders, and invoices with ease.</p>
                <div class="features-grid mt-4">
                    <div class="feature-item">
                        <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                        <p>Order Management</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="login-right">
            <form method="POST" action="{{ route('customer.login') }}" class="login-form">
                @csrf
                
                <div class="form-title text-center mb-5">
                    <h3>Customer Login</h3>
                    <p>Sign in to your customer account</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="form-group mb-4">
                    <label for="username" class="form-label">Email or Username</label>
                    <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>
                </div>

                <div class="form-group mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                    <label class="form-check-label" for="remember_me">
                        Remember me for 30 days
                    </label>
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Sign In to Customer Portal
                </button>

                <div class="portal-links text-center mt-4">
                    <p>Access other portals:</p>
                    <a href="{{ route('staff.login') }}" class="me-3">
                        <i class="fas fa-users"></i> Staff Portal
                    </a>
                    <a href="{{ route('retailer.login') }}">
                        <i class="fas fa-store"></i> Retailer Portal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
