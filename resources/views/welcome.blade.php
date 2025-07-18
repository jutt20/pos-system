<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Nexitel</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .welcome-container {
            background: white;
            border-radius: 24px;
            padding: 60px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 600px;
            width: 100%;
            margin: 20px;
        }

        .nexitel-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #3b82f6, #10b981);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            font-size: 2rem;
            color: white;
            font-weight: 700;
        }

        .welcome-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 16px;
            background: linear-gradient(135deg, #3b82f6, #10b981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .welcome-subtitle {
            font-size: 1.2rem;
            color: #64748b;
            margin-bottom: 16px;
        }

        .welcome-description {
            color: #64748b;
            margin-bottom: 40px;
            font-size: 1rem;
            line-height: 1.6;
        }

        .staff-portal-btn {
            background: linear-gradient(135deg, #3b82f6, #10b981);
            color: white;
            padding: 16px 32px;
            border: none;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 30px;
            transition: all 0.3s;
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.3);
        }

        .staff-portal-btn:hover {
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(59, 130, 246, 0.4);
        }

        .portal-options {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 30px;
        }

        .portal-btn {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px 24px;
            text-decoration: none;
            color: #374151;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 180px;
            justify-content: center;
        }

        .portal-btn:hover {
            color: #374151;
            text-decoration: none;
            border-color: #3b82f6;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.15);
        }

        .portal-btn.retailer {
            border-color: #8b5cf6;
        }

        .portal-btn.retailer:hover {
            border-color: #8b5cf6;
            box-shadow: 0 4px 20px rgba(139, 92, 246, 0.15);
        }

        .portal-btn.customer {
            border-color: #10b981;
        }

        .portal-btn.customer:hover {
            border-color: #10b981;
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.15);
        }

        .portal-icon {
            font-size: 1.2rem;
        }

        .retailer .portal-icon {
            color: #8b5cf6;
        }

        .customer .portal-icon {
            color: #10b981;
        }

        @media (max-width: 768px) {
            .welcome-container {
                padding: 40px 30px;
                margin: 20px;
            }

            .welcome-title {
                font-size: 2rem;
            }

            .portal-options {
                flex-direction: column;
                align-items: center;
            }

            .portal-btn {
                width: 100%;
                max-width: 250px;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <div class="nexitel-logo">
            N
        </div>
        
        <h1 class="welcome-title">Welcome to Nexitel</h1>
        <p class="welcome-subtitle">Next Generation Network</p>
        
        <p class="welcome-description">
            Staff Portal - Wireless Services & Global Recharge<br>
            Login required to access Nexitel services and international recharge platform
        </p>
        
        <a href="{{ route('login') }}" class="staff-portal-btn">
            <i class="fas fa-user-tie"></i>
            Staff Portal Login
            <i class="fas fa-arrow-right"></i>
        </a>
        
        <div class="portal-options">
            <a href="{{ route('retailer.dashboard') }}" class="portal-btn retailer">
                <i class="fas fa-store portal-icon"></i>
                Retailer Portal
            </a>
            
            <a href="{{ route('customer-portal.dashboard') }}" class="portal-btn customer">
                <i class="fas fa-user portal-icon"></i>
                Customer Portal
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
