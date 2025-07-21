<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - Nexitel POS</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
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

        .login-card {
            width: 400px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-container img {
            max-width: 180px;
            height: auto;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #2d3748;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .form-control {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            margin-top: 1rem;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-primary:active {
            transform: translateY(-1px);
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .form-check-input {
            width: 1rem;
            height: 1rem;
            border-radius: 0.25rem;
            border: 2px solid #e2e8f0;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        .form-check-label {
            color: #4a5568;
            font-size: 0.875rem;
            cursor: pointer;
        }

        .form-links {
            text-align: center;
            margin-top: 1.5rem;
        }

        .form-links a {
            color: #667eea;
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
            background: #667eea;
            transition: width 0.3s ease;
        }

        .form-links a:hover::after {
            width: 100%;
        }

        .form-links a:hover {
            color: #764ba2;
        }

        .portal-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
        }

        .portal-links a {
            color: #6c757d;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .portal-links a:hover {
            color: #764ba2;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
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
            border-left: 0.25rem solid #dc2626;
        }

        .alert-success {
            background: linear-gradient(135deg, #d1e7dd, #bef5ca);
            color: #155724;
            border-left: 0.25rem solid #155724;
        }

        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
                margin: 10px;
                min-height: auto;
                max-width: 500px;
            }

            .logo-container {
                margin-bottom: 1.5rem;
            }

            .portal-links {
                display: block;
                margin: 0.5rem 0;
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
            border-top: 5px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .input-group-text {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-right: none;
        }

        .form-control.with-icon {
            border-left: none;
        }
    </style>
</head>

<body>
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>

    <div class="login-card">
        <div class="logo-container">
            <img src="{{ asset('images/logo.jpg') }}" alt="Nexitel Logo">
        </div>
        
        <h4 class="text-center mb-4">Admin Portal Login</h4>
        
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}" class="login-form" id="loginForm">
            @csrf
            
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-user"></i>
                    </span>
                    <input type="text" 
                           class="form-control with-icon @error('username') is-invalid @enderror" 
                           name="username" 
                           value="{{ old('username') }}" 
                           placeholder="Username" 
                           required 
                           autofocus>
                </div>
                @error('username')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" 
                           class="form-control with-icon @error('password') is-invalid @enderror" 
                           name="password" 
                           placeholder="Password" 
                           required>
                </div>
                @error('password')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        Remember Me
                    </label>
                </div>
                
                <a href="{{ route('password.request') }}" class="btn-link">Forgot Password?</a>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-sign-in-alt me-2"></i>Login
            </button>
        </form>
        
        <div class="login-footer">
            <p>© {{ date('Y') }} Nexitel POS System. All rights reserved.</p>
            
            <div class="portal-links">
                <a href="{{ route('customer.login') }}">Customer Portal</a>
                <span>|</span>
                <a href="{{ route('retailer.login') }}">Retailer Portal</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
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
