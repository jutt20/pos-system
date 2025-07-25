<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'POS System')</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
      :root {
          --primary-color: #2563eb;
          --primary-dark: #1d4ed8;
          --secondary-color: #64748b;
          --success-color: #16a34a;
          --danger-color: #dc2626;
          --warning-color: #d97706;
          --info-color: #0891b2;
          --light-color: #f8fafc;
          --dark-color: #1e293b;
          --sidebar-width: 280px;
      }

      * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
      }

      body {
          font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
          background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
          color: #334155;
          line-height: 1.6;
          min-height: 100vh;
      }

      /* Modern App Header */
      .app-header {
          background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
          color: white;
          padding: 0;
          box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
          position: sticky;
          top: 0;
          z-index: 1000;
          border-bottom: 1px solid rgba(255, 255, 255, 0.1);
          display: flex;
          align-items: center;
      }

      .header-logo {
          position: relative;
          /* Change from fixed to relative */
          left: auto;
          /* Remove fixed positioning */
          top: auto;
          /* Remove fixed positioning */
          z-index: 999;
          background: rgba(0, 0, 0, 0.1);
          padding: 8px 12px;
          border-radius: 12px;
          backdrop-filter: blur(10px);
          margin-right: 20px;
          /* Add some margin to separate from other elements */
      }

      .header-content {
          display: flex;
          justify-content: space-between;
          overflow: visible;
          align-items: center;
          max-width: 100%;
          padding: 16px 32px;
          /* margin-left: var(--sidebar-width); */
          min-height: 70px;
          flex: 1;
          z-index: 1000;
          position: relative;
      }

      .header-left {
          display: flex;
          align-items: center;
          gap: 24px;
          /* margin-left: calc(-1 * var(--sidebar-width) + 20px); */
      }

      .mobile-menu-toggle,
      .desktop-menu-toggle {
          background: rgba(255, 255, 255, 0.1);
          border: 1px solid rgba(255, 255, 255, 0.2);
          border-radius: 8px;
          padding: 8px 12px;
          color: white;
          cursor: pointer;
          transition: all 0.2s;
      }

      .mobile-menu-toggle {
          display: none;
      }

      .desktop-menu-toggle {
          display: block;
      }

      .mobile-menu-toggle:hover,
      .desktop-menu-toggle:hover {
          background: rgba(255, 255, 255, 0.2);
      }

      .breadcrumb-nav {
          display: flex;
          align-items: center;
          gap: 12px;
          font-size: 0.9rem;
          background: rgba(255, 255, 255, 0.1);
          padding: 8px 16px;
          border-radius: 20px;
          backdrop-filter: blur(10px);
      }

      .breadcrumb-nav a {
          color: rgba(255, 255, 255, 0.8);
          text-decoration: none;
          transition: color 0.2s;
          font-weight: 500;
      }

      .breadcrumb-nav a:hover {
          color: white;
      }

      .breadcrumb-nav .separator {
          color: rgba(255, 255, 255, 0.5);
          margin: 0 4px;
      }

      .breadcrumb-current {
          color: white;
          font-weight: 600;
      }

      .header-brand {
          display: flex;
          align-items: center;
          gap: 12px;
          color: white;
          text-decoration: none;
          transition: all 0.2s;
      }

      .header-brand:hover {
          color: white;
          text-decoration: none;
          opacity: 0.9;
      }

      .header-logo-img {
          width: 40px;
          height: 40px;
          border-radius: 8px;
          object-fit: contain;
          background: white;
          padding: 4px;
          display: block;
      }

      .header-brand-text {
          display: flex;
          flex-direction: column;
      }

      .brand-name {
          font-size: 1.1rem;
          font-weight: 700;
          line-height: 1;
      }

      .brand-subtitle {
          font-size: 0.75rem;
          opacity: 0.8;
          line-height: 1;
      }

      .header-right {
          display: flex;
          align-items: center;
          gap: 20px;
      }

      .user-dropdown {
          background: rgba(255, 255, 255, 0.1);
          border: 1px solid rgba(255, 255, 255, 0.2);
          border-radius: 16px;
          padding: 8px 16px;
          color: white;
          text-decoration: none;
          display: flex;
          align-items: center;
          gap: 12px;
          transition: all 0.3s;
          min-width: 220px;
          backdrop-filter: blur(10px);
      }

      .user-dropdown:hover {
          background: rgba(255, 255, 255, 0.2);
          color: white;
          text-decoration: none;
          transform: translateY(-2px);
          box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
      }

      .user-avatar {
          width: 40px;
          height: 40px;
          border-radius: 50%;
          background: linear-gradient(135deg, #3b82f6, #8b5cf6);
          display: flex;
          align-items: center;
          justify-content: center;
          font-weight: 700;
          font-size: 0.9rem;
          border: 2px solid rgba(255, 255, 255, 0.2);
      }

      .user-info {
          flex: 1;
      }

      .user-name {
          font-weight: 600;
          font-size: 0.95rem;
          margin-bottom: 2px;
      }

      .user-role {
          font-size: 0.75rem;
          opacity: 0.8;
          color: #94a3b8;
      }

      .dropdown-chevron {
          transition: transform 0.2s;
          opacity: 0.7;
      }

      .user-dropdown:hover .dropdown-chevron {
          transform: rotate(180deg);
      }

      .dropdown-menu {
          border: none;
          box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
          border-radius: 16px;
          padding: 12px 0;
          min-width: 240px;
          margin-top: 8px;
          backdrop-filter: blur(20px);
          background: rgba(255, 255, 255, 0.95);
      }

      .dropdown-header {
          padding: 16px 20px 12px;
          border-bottom: 1px solid #e5e7eb;
          margin-bottom: 8px;
      }

      .dropdown-header .user-avatar {
          width: 50px;
          height: 50px;
          margin-bottom: 8px;
      }

      .dropdown-header .user-name {
          font-size: 1rem;
          color: #111827;
          margin-bottom: 4px;
      }

      .dropdown-header .user-email {
          font-size: 0.85rem;
          color: #6b7280;
          margin-bottom: 2px;
      }

      .dropdown-header .user-role {
          font-size: 0.75rem;
          color: #9ca3af;
      }

      .dropdown-item {
          padding: 12px 20px;
          color: #374151;
          transition: all 0.2s;
          display: flex;
          align-items: center;
          gap: 12px;
          font-weight: 500;
      }

      .dropdown-item:hover {
          background: linear-gradient(135deg, #f8fafc, #e2e8f0);
          color: #111827;
          transform: translateX(4px);
      }

      .dropdown-item i {
          width: 18px;
          text-align: center;
          opacity: 0.7;
      }

      .dropdown-divider {
          margin: 8px 0;
          border-color: #e5e7eb;
      }

      /* Enhanced Sidebar */
      .sidebar {
          position: fixed;
          left: 0;
          top: 0;
          width: var(--sidebar-width);
          height: 100vh;
          background: linear-gradient(180deg, #1e293b 0%, #334155 100%);
          color: white;
          padding: 0;
          overflow-y: auto;
          z-index: 999;
          box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
          transition: transform 0.3s ease;
      }

      .sidebar.collapsed {
          width: 80px;
      }

      .sidebar.collapsed .header-logo {
          padding: 8px;
      }

      .sidebar.collapsed .header-brand {
          justify-content: center;
      }

      .sidebar.collapsed .sidebar-brand-text,
      .sidebar.collapsed .sidebar-subtitle,
      .sidebar.collapsed .nav-text,
      .sidebar.collapsed .header-brand-text {
          display: none;
      }

      .sidebar.collapsed .sidebar-brand {
          justify-content: center;
      }

      .sidebar.collapsed .sidebar-nav a {
          justify-content: center;
          padding: 16px 10px;
      }

      .main-content.sidebar-collapsed {
          margin-left: 80px;
      }

      /* .header-content.sidebar-collapsed {
          margin-left: 140px;
      } */

      .header-content.sidebar-collapsed .header-left {
          margin-left: 20px;
      }

      .sidebar-header {
          padding: 24px 20px;
          border-bottom: 1px solid rgba(255, 255, 255, 0.1);
          background: rgba(0, 0, 0, 0.2);
          position: relative;
      }

      .sidebar-brand {
          display: flex;
          align-items: center;
          gap: 12px;
          color: white;
          text-decoration: none;
      }

      .sidebar-logo {
          width: 40px;
          height: 40px;
          border-radius: 8px;
          object-fit: contain;
          background: white;
          padding: 4px;
      }

      .sidebar-brand-text h3 {
          font-size: 1.4rem;
          font-weight: 700;
          margin: 0;
      }

      .sidebar-subtitle {
          font-size: 0.8rem;
          opacity: 0.7;
          margin-top: 4px;
      }

      .sidebar-toggle {
          position: absolute;
          top: 20px;
          right: -15px;
          background: #1e293b;
          border: 2px solid rgba(255, 255, 255, 0.1);
          border-radius: 50%;
          width: 30px;
          height: 30px;
          display: flex;
          align-items: center;
          justify-content: center;
          color: white;
          cursor: pointer;
          transition: all 0.3s;
          z-index: 1001;
      }

      .sidebar-toggle:hover {
          background: #334155;
          border-color: rgba(255, 255, 255, 0.3);
      }

      .sidebar-nav {
          list-style: none;
          padding: 20px 0;
          margin: 0;
      }

      .sidebar-nav li {
          margin-bottom: 4px;
      }

      .sidebar-nav a {
          display: flex;
          align-items: center;
          padding: 16px 20px;
          color: rgba(255, 255, 255, 0.8);
          text-decoration: none;
          transition: all 0.3s;
          border-left: 3px solid transparent;
          position: relative;
          font-weight: 500;
          white-space: nowrap;
      }

      .sidebar-nav a:hover {
          background: rgba(255, 255, 255, 0.1);
          color: white;
          border-left-color: #3b82f6;
          transform: translateX(4px);
      }

      .sidebar-nav a.active {
          background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(139, 92, 246, 0.2));
          color: white;
          border-left-color: #3b82f6;
          box-shadow: inset 0 0 20px rgba(59, 130, 246, 0.1);
      }

      .sidebar-nav i {
          width: 20px;
          margin-right: 12px;
          text-align: center;
          font-size: 1.1rem;
      }

      /* Main Content */
      .main-content {
          margin-left: var(--sidebar-width);
          min-height: 100vh;
          background: transparent;
          padding-top: 20px;
      }

      .main-container {
          max-width: 100%;
          margin: 0;
          padding: 30px;
      }

      /* Enhanced Page Header */
      .page-header {
          display: flex;
          justify-content: space-between;
          align-items: flex-start;
          margin-bottom: 30px;
          background: white;
          padding: 30px;
          border-radius: 16px;
          box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
          border: 1px solid rgba(255, 255, 255, 0.2);
          position: relative;
          overflow: hidden;
      }

      .page-header::before {
          content: '';
          position: absolute;
          top: 0;
          left: 0;
          right: 0;
          height: 4px;
          background: linear-gradient(90deg, #3b82f6, #8b5cf6, #06b6d4);
      }

      .page-header-content {
          flex: 1;
      }

      .page-title {
          font-size: 2.2rem;
          font-weight: 700;
          color: #111827;
          margin: 0 0 8px 0;
          display: flex;
          align-items: center;
          gap: 12px;
      }

      .page-title i {
          background: linear-gradient(45deg, #3b82f6, #8b5cf6);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
          background-clip: text;
      }

      .page-subtitle {
          color: #6b7280;
          font-size: 1rem;
          margin: 0;
          font-weight: 400;
      }

      .header-actions {
          display: flex;
          gap: 12px;
          align-items: center;
          flex-shrink: 0;
      }

      /* Enhanced Buttons */
      .btn-primary {
          background: linear-gradient(135deg, #3b82f6, #2563eb);
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
          box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
      }

      .btn-primary:hover {
          background: linear-gradient(135deg, #2563eb, #1d4ed8);
          color: white;
          text-decoration: none;
          transform: translateY(-2px);
          box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
      }

      .btn-secondary {
          background: linear-gradient(135deg, #64748b, #475569);
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
          box-shadow: 0 4px 15px rgba(100, 116, 139, 0.3);
      }

      .btn-secondary:hover {
          background: linear-gradient(135deg, #475569, #334155);
          color: white;
          text-decoration: none;
          transform: translateY(-2px);
          box-shadow: 0 6px 20px rgba(100, 116, 139, 0.4);
      }

      .btn-sm {
          padding: 8px 16px;
          font-size: 0.875rem;
          border-radius: 8px;
          border: 1px solid #e5e7eb;
          background: white;
          color: #374151;
          text-decoration: none;
          transition: all 0.2s;
          font-weight: 500;
      }

      .btn-sm:hover {
          background: #f9fafb;
          color: #111827;
          text-decoration: none;
          border-color: #d1d5db;
          transform: translateY(-1px);
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

      /* Enhanced Content Sections */
      .content-section {
          background: white;
          border-radius: 16px;
          padding: 30px;
          margin-bottom: 30px;
          box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
          border: 1px solid rgba(255, 255, 255, 0.2);
          position: relative;
          overflow: hidden;
      }

      .section-header {
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-bottom: 24px;
      }

      .section-title {
          font-size: 1.4rem;
          font-weight: 600;
          color: #111827;
          margin: 0;
          display: flex;
          align-items: center;
          gap: 8px;
      }

      .section-actions {
          display: flex;
          gap: 12px;
          align-items: center;
      }

      /* Enhanced Stats Grid */
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
          box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
          border: 1px solid rgba(255, 255, 255, 0.2);
          transition: all 0.3s;
          position: relative;
          overflow: hidden;
          display: flex;
          align-items: center;
          gap: 20px;
      }

      .stat-card:hover {
          transform: translateY(-4px);
          box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
      }

      .stat-icon {
          width: 60px;
          height: 60px;
          border-radius: 16px;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 1.5rem;
          color: white;
          flex-shrink: 0;
      }

      .stat-icon.blue {
          background: linear-gradient(135deg, #3b82f6, #1d4ed8);
      }

      .stat-icon.green {
          background: linear-gradient(135deg, #10b981, #059669);
      }

      .stat-icon.purple {
          background: linear-gradient(135deg, #8b5cf6, #7c3aed);
      }

      .stat-icon.orange {
          background: linear-gradient(135deg, #f59e0b, #d97706);
      }

      .stat-content {
          flex: 1;
      }

      .stat-label {
          font-size: 0.9rem;
          color: #6b7280;
          margin-bottom: 4px;
          font-weight: 500;
      }

      .stat-value {
          font-size: 2rem;
          font-weight: 700;
          color: #111827;
          margin-bottom: 4px;
      }

      .stat-value.green {
          color: var(--success-color);
      }

      .stat-value.blue {
          color: var(--primary-color);
      }

      .stat-change {
          font-size: 0.8rem;
          font-weight: 500;
      }

      .stat-change.positive {
          color: #059669;
      }

      .stat-change.negative {
          color: #dc2626;
      }

      /* Enhanced Tables */
      .table-responsive {
          border-radius: 12px;
          overflow-x: scroll !important;
          overflow: hidden;
          box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      }

      .data-table {
          width: 100%;
          border-collapse: collapse;
          margin: 0;
          background: white;
      }

      .data-table th {
          background: linear-gradient(135deg, #f8fafc, #e2e8f0);
          padding: 16px;
          text-align: left;
          font-weight: 600;
          color: #374151;
          border: none;
          font-size: 0.9rem;
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
          background: linear-gradient(135deg, #f8fafc, #f1f5f9);
      }

      .data-table tr:last-child td {
          border-bottom: none;
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

      .status-paid {
          background: linear-gradient(135deg, #dcfce7, #bbf7d0);
          color: #166534;
      }

      .status-unpaid {
          background: linear-gradient(135deg, #fee2e2, #fecaca);
          color: #991b1b;
      }

      .status-active {
          background: linear-gradient(135deg, #dbeafe, #bfdbfe);
          color: #1e40af;
      }

      .status-pending {
          background: linear-gradient(135deg, #fef3c7, #fde68a);
          color: #92400e;
      }

      .status-delivered {
          background: linear-gradient(135deg, #dcfce7, #bbf7d0);
          color: #166534;
      }

      .status-cancelled {
          background: linear-gradient(135deg, #fee2e2, #fecaca);
          color: #991b1b;
      }

      /* Text Colors */
      .text-success {
          color: var(--success-color) !important;
      }

      .text-danger {
          color: var(--danger-color) !important;
      }

      /* Action Buttons */
      .action-buttons {
          display: flex;
          gap: 8px;
          align-items: center;
      }

      /* Alerts */
      .alert {
          border-radius: 12px;
          border: none;
          padding: 16px 20px;
          margin-bottom: 24px;
          display: flex;
          align-items: center;
          gap: 12px;
      }

      .alert-success {
          background: linear-gradient(135deg, #ecfdf5, #d1fae5);
          color: #065f46;
      }

      .alert-danger {
          background: linear-gradient(135deg, #fef2f2, #fee2e2);
          color: #991b1b;
      }

      /* Empty States */
      .empty-state {
          text-align: center;
          padding: 60px 20px;
      }

      .empty-state i {
          opacity: 0.3;
          margin-bottom: 16px;
      }

      .empty-state h5 {
          color: #6b7280;
          margin-bottom: 8px;
      }

      .empty-state p {
          color: #9ca3af;
          margin-bottom: 20px;
      }

      /* Form Controls */
      .form-control,
      .form-select {
          border: 1px solid #e5e7eb;
          border-radius: 8px;
          padding: 12px 16px;
          font-size: 0.9rem;
          transition: all 0.2s;
      }

      .form-control:focus,
      .form-select:focus {
          border-color: #3b82f6;
          box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
          outline: none;
      }

      /* Enhanced Mobile and Responsive Design */
      @media (max-width: 768px) {
          .sidebar {
              transform: translateX(-100%);
              width: var(--sidebar-width);
          }

          .sidebar.show {
              transform: translateX(0);
          }

          .sidebar.collapsed {
              width: var(--sidebar-width);
          }

          .main-content,
          .header-content {
              margin-left: 0;
          }

          .mobile-menu-toggle {
              display: block;
          }

          .desktop-menu-toggle {
              display: none;
          }

          .header-logo {
              position: relative;
              left: auto;
              top: auto;
              margin-right: 16px;
              background: none;
              padding: 0;
          }

          .brand-name {
              font-size: 1rem;
          }

          .brand-subtitle {
              font-size: 0.7rem;
          }

          .page-header {
              flex-direction: column;
              gap: 20px;
              align-items: stretch;
          }

          .header-actions {
              justify-content: center;
          }

          .stats-grid {
              grid-template-columns: 1fr;
          }

          .stat-card {
              flex-direction: column;
              text-align: center;
              gap: 16px;
          }

          .user-dropdown {
              min-width: auto;
          }

          .sidebar-toggle {
              display: none;
          }
      }

      /* Desktop sidebar transitions */
      @media (min-width: 769px) {

          .sidebar,
          .main-content,
          .header-content {
              transition: all 0.3s ease;
          }

          .sidebar {
              overflow-x: hidden;
          }
      }

      @media (max-width: 768px) {
          .header-logo {
              margin-right: 0;
              padding: 8px;
          }

          .header-brand-text {
              display: none;
          }
      }
  </style>
</head>

<body>
  <!-- Enhanced Header -->
  <div class="app-header">

      <div class="header-content">
          <div class="header-left">
              <div class="header-logo">
                  <a href="{{ route('dashboard') }}" class="header-brand">
                      <img src="{{ asset('images/logo.jpg') }}" alt="Nexitel Logo" class="header-logo-img">
                      <div class="header-brand-text">
                          <span class="brand-name">Nexitel POS</span>
                          <span class="brand-subtitle">Point of Sales</span>
                      </div>
                  </a>
              </div>

              <button class="mobile-menu-toggle" onclick="toggleSidebar()">
                  <i class="fas fa-bars"></i>
              </button>

              <button class="desktop-menu-toggle" onclick="toggleSidebarCollapse()">
                  <i class="fas fa-bars"></i>
              </button>

              <div class="breadcrumb-nav">
                  <a href="{{ route('dashboard') }}">
                      <i class="fas fa-home"></i>
                  </a>
                  @if(!request()->routeIs('dashboard'))
                  <span class="separator">•</span>
                  <span class="breadcrumb-current">@yield('title', 'Page')</span>
                  @endif
              </div>
          </div>

          <div class="header-right">

              <div class="dropdown">
                  <a href="#" class="user-dropdown" data-bs-toggle="dropdown">
                      <div class="user-avatar">
                          @if(auth('employee')->check())
                          {{ strtoupper(substr(auth('employee')->user()->name, 0, 2)) }}
                          @else
                          AD
                          @endif
                      </div>
                      <div class="user-info">
                          <div class="user-name">
                              @if(auth('employee')->check())
                              {{ auth('employee')->user()->name }}
                              @else
                              Admin User
                              @endif
                          </div>
                          <div class="user-role">
                              @if(auth('employee')->check() && auth('employee')->user()->roles->count() > 0)
                              {{ auth('employee')->user()->roles->pluck('name')->join(', ') }}
                              @else
                              Administrator
                              @endif
                          </div>
                      </div>
                      <i class="fas fa-chevron-down dropdown-chevron"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                      <li class="dropdown-header">
                          <div class="user-avatar">
                              @if(auth('employee')->check())
                              {{ strtoupper(substr(auth('employee')->user()->name, 0, 2)) }}
                              @else
                              AD
                              @endif
                          </div>
                          <div class="user-name">
                              @if(auth('employee')->check())
                              {{ auth('employee')->user()->name }}
                              @else
                              Admin User
                              @endif
                          </div>
                          <div class="user-email">
                              @if(auth('employee')->check())
                              {{ auth('employee')->user()->email }}
                              @else
                              admin@nexitel.com
                              @endif
                          </div>
                          <div class="user-role">
                              @if(auth('employee')->check() && auth('employee')->user()->roles->count() > 0)
                              {{ auth('employee')->user()->roles->pluck('name')->join(', ') }}
                              @else
                              Administrator
                              @endif
                          </div>
                      </li>
                      <li>
                          <hr class="dropdown-divider">
                      </li>
                      <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                              <i class="fas fa-user"></i> Profile Settings
                          </a></li>
                      @if(auth('employee')->check() && auth('employee')->user()->hasRole('Super Admin'))
                      <li><a class="dropdown-item" href="{{ route('roles.index') }}">
                              <i class="fas fa-users-cog"></i> Role Management
                          </a></li>
                      @endif
                      <li><a class="dropdown-item" href="#">
                              <i class="fas fa-cog"></i> Account Settings
                          </a></li>
                      <li>
                          <hr class="dropdown-divider">
                      </li>
                      <li>
                          <form method="POST" action="{{ route('logout') }}">
                              @csrf
                              <button type="submit" class="dropdown-item">
                                  <i class="fas fa-sign-out-alt"></i> Logout
                              </button>
                          </form>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
  </div>

  <!-- Enhanced Sidebar -->
  <div class="sidebar" id="sidebar">
      <div class="sidebar-header">
          <a href="{{ route('dashboard') }}" class="sidebar-brand">
              <img src="{{ asset('images/logo.jpg') }}" alt="Nexitel Logo" class="sidebar-logo">
              <div class="sidebar-brand-text">
                  <h3>Nexitel POS</h3>
                  <div class="sidebar-subtitle">Point of Sales System</div>
              </div>
          </a>
          <button class="sidebar-toggle" onclick="toggleSidebarCollapse()" title="Toggle Sidebar">
              <i class="fas fa-chevron-left" id="toggle-icon"></i>
          </button>
      </div>

      <ul class="sidebar-nav">
          <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                  <i class="fas fa-tachometer-alt"></i> <span class="nav-text">Dashboard</span>
              </a></li>

          @can('manage employees')
          <li><a href="{{ route('employees.index') }}" class="{{ request()->routeIs('employees.*') ? 'active' : '' }}">
                  <i class="fas fa-users"></i> <span class="nav-text">Employees</span>
              </a></li>
          @endcan

          @can('manage customers')
          <li><a href="{{ route('customers.index') }}" class="{{ request()->routeIs('customers.*') ? 'active' : '' }}">
                  <i class="fas fa-user-friends"></i> <span class="nav-text">Customers</span>
              </a></li>
          @endcan

          @can('manage invoices')
          <li><a href="{{ route('invoices.index') }}" class="{{ request()->routeIs('invoices.*') ? 'active' : '' }}">
                  <i class="fas fa-file-invoice"></i> <span class="nav-text">Invoices</span>
              </a></li>
          @endcan

          @can('manage activations')
          <li><a href="{{ route('activations.index') }}" class="{{ request()->routeIs('activations.*') ? 'active' : '' }}">
                  <i class="fas fa-mobile-alt"></i> <span class="nav-text">Activations</span>
              </a></li>
          @endcan

          @can('manage orders')
          <li><a href="{{ route('sim-orders.index') }}" class="{{ request()->routeIs('sim-orders.*') ? 'active' : '' }}">
                  <i class="fas fa-shopping-cart"></i> <span class="nav-text">SIM Orders</span>
              </a></li>
          @endcan

          @can('manage sim stock')
          <li>
              <a href="{{ route('sim-stocks.index') }}" class="{{ request()->routeIs('sim-stocks.*') ? 'active' : '' }}">
                  <i class="fas fa-boxes"></i> <span class="nav-text">SIM Stock</span>
              </a>
          </li>
          @endcan


          @can('view reports')
          <li><a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
                  <i class="fas fa-chart-bar"></i> <span class="nav-text">Reports</span>
              </a></li>
          @endcan

          @if(auth('employee')->check() && auth('employee')->user()->hasRole('Super Admin'))
          <li><a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">
                  <i class="fas fa-users-cog"></i> <span class="nav-text">Role Management</span>
              </a></li>
          @endif
      </ul>
  </div>

  <!-- Main Content -->
  <div class="main-content">
      @if(session('success'))
      <div class="main-container">
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              <i class="fas fa-check-circle"></i>
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
      </div>
      @endif

      @if(session('error'))
      <div class="main-container">
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="fas fa-exclamation-circle"></i>
              {{ session('error') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
      </div>
      @endif

      @yield('content')
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
      function toggleSidebar() {
          document.getElementById('sidebar').classList.toggle('show');
      }

      function toggleSidebarCollapse() {
          const sidebar = document.getElementById('sidebar');
          const mainContent = document.querySelector('.main-content');
          const headerContent = document.querySelector('.header-content');
          const toggleIcon = document.getElementById('toggle-icon');

          sidebar.classList.toggle('collapsed');
          mainContent.classList.toggle('sidebar-collapsed');
          headerContent.classList.toggle('sidebar-collapsed');

          // Update toggle icon
          if (sidebar.classList.contains('collapsed')) {
              toggleIcon.className = 'fas fa-chevron-right';
              localStorage.setItem('sidebarCollapsed', 'true');
          } else {
              toggleIcon.className = 'fas fa-chevron-left';
              localStorage.setItem('sidebarCollapsed', 'false');
          }
      }

      // Restore sidebar state on page load
      document.addEventListener('DOMContentLoaded', function() {
          const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
          if (isCollapsed) {
              const sidebar = document.getElementById('sidebar');
              const mainContent = document.querySelector('.main-content');
              const headerContent = document.querySelector('.header-content');
              const toggleIcon = document.getElementById('toggle-icon');

              sidebar.classList.add('collapsed');
              mainContent.classList.add('sidebar-collapsed');
              headerContent.classList.add('sidebar-collapsed');
              toggleIcon.className = 'fas fa-chevron-right';
          }
      });

      // Close sidebar when clicking outside on mobile
      document.addEventListener('click', function(event) {
          const sidebar = document.getElementById('sidebar');
          const toggle = document.querySelector('.mobile-menu-toggle');
          const sidebarToggle = document.querySelector('.sidebar-toggle');

          if (window.innerWidth <= 768 &&
              !sidebar.contains(event.target) &&
              !toggle.contains(event.target) &&
              !sidebarToggle.contains(event.target)) {
              sidebar.classList.remove('show');
          }
      });

      // Add smooth hover effects for better UX
      document.querySelectorAll('.sidebar-nav a').forEach(link => {
          link.addEventListener('mouseenter', function() {
              if (!document.getElementById('sidebar').classList.contains('collapsed')) {
                  this.style.transform = 'translateX(8px)';
              }
          });

          link.addEventListener('mouseleave', function() {
              this.style.transform = 'translateX(0)';
          });
      });
  </script>

  @stack('scripts')
</body>

</html>
