<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Retailer Portal')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --retailer-primary: #8b5cf6;
            --retailer-secondary: #a855f7;
            --retailer-accent: #c084fc;
            --retailer-dark: #6d28d9;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #3b82f6;
            --sidebar-width: 280px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f8fafc;
            color: #334155;
            line-height: 1.6;
            min-height: 100vh;
        }

        /* Retailer Sidebar */
        .retailer-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--retailer-primary) 0%, var(--retailer-dark) 100%);
            color: white;
            padding: 0;
            overflow-y: auto;
            z-index: 999;
            box-shadow: 4px 0 20px rgba(139, 92, 246, 0.15);
        }

        .retailer-header {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.1);
        }

        .retailer-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            text-decoration: none;
            margin-bottom: 16px;
        }

        .retailer-brand i {
            background: rgba(255,255,255,0.2);
            padding: 12px;
            border-radius: 12px;
            font-size: 1.2rem;
        }

        .retailer-brand-text h3 {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
        }

        .retailer-brand-text span {
            font-size: 0.8rem;
            opacity: 0.8;
        }

        .account-balance {
            background: rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 16px;
            margin-top: 16px;
            backdrop-filter: blur(10px);
        }

        .balance-label {
            font-size: 0.85rem;
            opacity: 0.8;
            margin-bottom: 4px;
        }

        .balance-amount {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
        }

        .customer-support {
            background: rgba(255,255,255,0.05);
            border-radius: 12px;
            padding: 16px;
            margin: 20px;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .support-title {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 12px;
            color: white;
        }

        .support-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            font-size: 0.8rem;
            opacity: 0.9;
        }

        .support-item i {
            width: 16px;
            text-align: center;
        }

        .retailer-nav {
            list-style: none;
            padding: 20px 0;
            margin: 0;
        }

        .retailer-nav li {
            margin-bottom: 4px;
        }

        .retailer-nav a {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
            font-weight: 500;
        }

        .retailer-nav a:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left-color: rgba(255,255,255,0.5);
            transform: translateX(4px);
        }

        .retailer-nav a.active {
            background: rgba(255,255,255,0.15);
            color: white;
            border-left-color: white;
            box-shadow: inset 0 0 20px rgba(255,255,255,0.1);
        }

        .retailer-nav i {
            width: 20px;
            margin-right: 12px;
            text-align: center;
            font-size: 1rem;
        }

        .live-chat-btn {
            margin: 20px;
            background: var(--success-color);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 16px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s;
        }

        .live-chat-btn:hover {
            background: #059669;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        /* Main Content */
        .retailer-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            background: #f8fafc;
        }

        .retailer-header-bar {
            background: white;
            padding: 20px 30px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .header-title {
            flex: 1;
        }

        .header-title h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        .header-title p {
            color: #64748b;
            margin: 0;
            font-size: 0.9rem;
        }

        .header-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .retailer-badge {
            background: linear-gradient(135deg, var(--retailer-primary), var(--retailer-secondary));
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .logout-btn {
            background: #64748b;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }

        .logout-btn:hover {
            background: #475569;
            color: white;
            text-decoration: none;
        }

        .retailer-content {
            padding: 30px;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #f1f5f9;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--retailer-primary), var(--retailer-secondary));
        }

        .stat-header {
            display: flex;
            justify-content: between;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .stat-title {
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 500;
        }

        .stat-icon {
            color: var(--retailer-primary);
            font-size: 1.2rem;
        }

        .stat-value {
            font-size: 2.2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .stat-value.success {
            color: var(--success-color);
        }

        .stat-value.info {
            color: var(--info-color);
        }

        .stat-subtitle {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        /* Service Cards */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
            margin-bottom: 30px;
        }

        .service-card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #f1f5f9;
            text-align: center;
            transition: all 0.3s;
        }

        .service-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }

        .service-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 20px;
            color: white;
        }

        .service-icon.purple {
            background: linear-gradient(135deg, var(--retailer-primary), var(--retailer-secondary));
        }

        .service-icon.orange {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .service-icon.green {
            background: linear-gradient(135deg, var(--success-color), #059669);
        }

        .service-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .service-description {
            color: #64748b;
            margin-bottom: 16px;
            font-size: 0.9rem;
        }

        .service-status {
            font-size: 0.85rem;
            font-weight: 600;
            padding: 4px 0;
        }

        .service-status.available {
            color: var(--retailer-primary);
        }

        .service-status.orders {
            color: #f59e0b;
        }

        /* Content Sections */
        .content-section {
            background: white;
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #f1f5f9;
        }

        .section-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-actions {
            display: flex;
            gap: 12px;
        }

        /* Tables */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .data-table th {
            background: #f8fafc;
            padding: 16px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 1px solid #e2e8f0;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-table td {
            padding: 16px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            color: #334155;
        }

        .data-table tr:hover {
            background: #f8fafc;
        }

        /* Status Badges */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-completed {
            background: #dcfce7;
            color: #166534;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-failed {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--retailer-primary), var(--retailer-secondary));
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--retailer-secondary), var(--retailer-dark));
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.4);
        }

        .btn-outline {
            border: 1px solid #e5e7eb;
            background: white;
            color: #374151;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-outline:hover {
            background: #f9fafb;
            color: #111827;
            text-decoration: none;
            border-color: #d1d5db;
        }

        /* Filters */
        .filters-section {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .filters-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .filter-label {
            font-size: 0.9rem;
            font-weight: 500;
            color: #374151;
        }

        .form-control, .form-select {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--retailer-primary);
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
            outline: none;
        }

        .text-orange { color: #E65100; }

        /* Live Chat */
        .chat-widget {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 350px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            z-index: 1000;
            overflow: hidden;
            transform: translateY(100%);
            transition: transform 0.3s;
        }

        .chat-widget.show {
            transform: translateY(0);
        }

        .chat-header {
            background: var(--success-color);
            color: white;
            padding: 16px 20px;
            display: flex;
            justify-content: between;
            align-items: center;
        }

        .chat-title {
            font-weight: 600;
            margin: 0;
        }

        .chat-close {
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .chat-body {
            padding: 20px;
            height: 200px;
            overflow-y: auto;
        }

        .chat-message {
            background: #f1f5f9;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 12px;
            font-size: 0.9rem;
        }

        .chat-time {
            font-size: 0.75rem;
            color: #64748b;
            margin-top: 4px;
        }

        .chat-input {
            padding: 16px 20px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            gap: 12px;
        }

        .chat-input input {
            flex: 1;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 8px 16px;
            font-size: 0.9rem;
        }

        .chat-send {
            background: var(--success-color);
            color: white;
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .retailer-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .retailer-sidebar.show {
                transform: translateX(0);
            }

            .retailer-main {
                margin-left: 0;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }

            .filters-grid {
                grid-template-columns: 1fr;
            }

            .chat-widget {
                width: calc(100% - 40px);
                right: 20px;
                left: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Retailer Sidebar -->
    <div class="retailer-sidebar" id="retailerSidebar">
        <div class="retailer-header">
            <a href="{{ route('retailer.dashboard') }}" class="retailer-brand">
                <i class="fas fa-store"></i>
                <div class="retailer-brand-text">
                    <h3>Retailer Portal</h3>
                    <span>retailer1</span>
                </div>
            </a>
            
            <div class="account-balance">
                <div class="balance-label">Account Balance</div>
                <div class="balance-amount">$500.00</div>
            </div>
        </div>
        
        <div class="customer-support">
            <div class="support-title">Customer Support</div>
            <div class="support-item">
                <i class="fas fa-user"></i>
                <span>Contact: Sarah Johnson</span>
            </div>
            <div class="support-item">
                <i class="fas fa-phone"></i>
                <span>+1 (555) 123-4567</span>
            </div>
            <div class="support-item">
                <i class="fas fa-envelope"></i>
                <span>support@posrecharge.com</span>
            </div>
        </div>
        
        <ul class="retailer-nav">
            <li><a href="{{ route('retailer.dashboard') }}" class="{{ request()->routeIs('retailer.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a></li>
            <li><a href="{{ route('retailer.transactions') }}" class="{{ request()->routeIs('retailer.transactions') ? 'active' : '' }}">
                <i class="fas fa-history"></i> Transaction History
            </a></li>
            <li><a href="{{ route('retailer.reports') }}" class="{{ request()->routeIs('retailer.reports') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Daily Reports
            </a></li>
        </ul>
        
        <a href="#" class="live-chat-btn" onclick="toggleChat()">
            <i class="fas fa-comments"></i>
            Live Agent Chat
        </a>
    </div>

    <!-- Main Content -->
    <div class="retailer-main">
        <div class="retailer-header-bar">
            <div class="header-title">
                <h1>@yield('page-title', 'Retailer Portal')</h1>
                <p>@yield('page-subtitle', 'Welcome back, retailer1')</p>
            </div>
            <div class="header-actions">
                <span class="retailer-badge">Retailer</span>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <a href="#" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
            </div>
        </div>
        
        <div class="retailer-content">
            @yield('content')
        </div>
    </div>

    <!-- Live Chat Widget -->
    <div class="chat-widget" id="chatWidget">
        <div class="chat-header">
            <h6 class="chat-title">Live Agent - Sarah</h6>
            <button class="chat-close" onclick="toggleChat()">×</button>
        </div>
        <div class="chat-body">
            <div class="chat-message">
                Hello! I'm Sarah from customer support. How can I help you today?
                <div class="chat-time">Now</div>
            </div>
        </div>
        <div class="chat-input">
            <input type="text" placeholder="Type your message...">
            <button class="chat-send">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleChat() {
            const chatWidget = document.getElementById('chatWidget');
            chatWidget.classList.toggle('show');
        }

        function toggleSidebar() {
            document.getElementById('retailerSidebar').classList.toggle('show');
        }

        // Close chat when clicking outside
        document.addEventListener('click', function(event) {
            const chatWidget = document.getElementById('chatWidget');
            const liveChatBtn = document.querySelector('.live-chat-btn');
            
            if (!chatWidget.contains(event.target) && !liveChatBtn.contains(event.target)) {
                chatWidget.classList.remove('show');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
