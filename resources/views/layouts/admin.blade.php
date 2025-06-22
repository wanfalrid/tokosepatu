<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - ShoeMart Admin</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #8b5cf6;
            --accent-color: #06b6d4;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #1f2937;
            --light-color: #f8fafc;
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --border-radius: 12px;
            --box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --box-shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: var(--dark-color);
            overflow-x: hidden;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
            transition: var(--transition);
            overflow-y: auto;
            box-shadow: var(--box-shadow-lg);
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .sidebar-brand {
            color: white;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: var(--transition);
        }

        .sidebar.collapsed .sidebar-brand .brand-text {
            opacity: 0;
            visibility: hidden;
        }

        .sidebar-toggle {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            background: var(--primary-color);
            border: 3px solid white;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.8rem;
        }

        .sidebar-toggle:hover {
            background: var(--secondary-color);
            transform: translateY(-50%) scale(1.1);
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-item {
            margin: 0.25rem 0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--accent-color);
            transform: scaleY(0);
            transition: var(--transition);
        }

        .nav-link:hover,
        .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .nav-link.active::before,
        .nav-link:hover::before {
            transform: scaleY(1);
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 0.875rem 0;
        }

        .sidebar.collapsed .nav-text {
            opacity: 0;
            visibility: hidden;
        }

        .nav-icon {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            transition: var(--transition);
            min-height: 100vh;
        }

        .sidebar.collapsed + .main-content {
            margin-left: var(--sidebar-collapsed-width);
            width: calc(100% - var(--sidebar-collapsed-width));
        }

        /* Header */
        .header {
            background: white;
            padding: 1rem 2rem;
            box-shadow: var(--box-shadow);
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
        }

        .header-content {
            display: flex;
            justify-content: between;
            align-items: center;
        }

        .page-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-left: auto;
        }

        .notification-btn,
        .profile-btn {
            background: var(--light-color);
            border: none;
            padding: 0.75rem;
            border-radius: var(--border-radius);
            color: var(--dark-color);
            cursor: pointer;
            transition: var(--transition);
            position: relative;
        }

        .notification-btn:hover,
        .profile-btn:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Content Area */
        .content {
            padding: 2rem;
        }

        /* Cards */
        .card {
            background: white;
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--box-shadow-lg);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid #e5e7eb;
            padding: 1.5rem;
            font-weight: 600;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Stats Cards */
        .stats-card {
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            margin: 0;
        }

        .stats-label {
            color: #6b7280;
            font-size: 0.9rem;
            margin: 0;
        }

        /* Buttons */
        .btn {
            border-radius: var(--border-radius);
            font-weight: 500;
            transition: var(--transition);
            border: none;
            padding: 0.75rem 1.5rem;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        .btn-success {
            background: var(--success-color);
        }

        .btn-warning {
            background: var(--warning-color);
        }

        .btn-danger {
            background: var(--danger-color);
        }

        /* Tables */
        .table {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
        }

        .table th {
            background: var(--light-color);
            border: none;
            font-weight: 600;
            color: var(--dark-color);
            padding: 1rem;
        }

        .table td {
            border: none;
            padding: 1rem;
            vertical-align: middle;
        }

        .table tbody tr {
            transition: var(--transition);
        }

        .table tbody tr:hover {
            background: rgba(99, 102, 241, 0.05);
        }

        /* Form Controls */
        .form-control,
        .form-select {
            border: 2px solid #e5e7eb;
            border-radius: var(--border-radius);
            padding: 0.75rem;
            transition: var(--transition);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-slide-in-right {
            animation: slideInRight 0.6s ease-out;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .header {
                padding: 1rem;
            }

            .content {
                padding: 1rem;
            }
        }

        /* Loading */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            backdrop-filter: blur(5px);
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #e5e7eb;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-color);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                    <i class="fas fa-shoe-prints"></i>
                    <span class="brand-text">ShoeMart Admin</span>
                </a>
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.produk.index') }}" class="nav-link {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        <span class="nav-text">Produk</span>
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="{{ route('admin.pesanan.index') }}" class="nav-link {{ request()->routeIs('admin.pesanan.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <span class="nav-text">Pesanan</span>
                    </a>
                </div>
                  <div class="nav-item">
                    <a href="{{ route('admin.pelanggan.index') }}" class="nav-link {{ request()->routeIs('admin.pelanggan.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <span class="nav-text">Pelanggan</span>
                    </a>
                </div>
                  <div class="nav-item">
                    <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <span class="nav-text">Laporan</span>
                    </a>
                </div>
                  <div class="nav-item">
                    <a href="{{ route('admin.pengaturan.index') }}" class="nav-link {{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <span class="nav-text">Pengaturan</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <div class="header-content">
                    <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                    
                    <div class="header-actions">
                        <button class="notification-btn" title="Notifikasi">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">3</span>
                        </button>
                        
                        <div class="dropdown">
                            <button class="profile-btn dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i>
                            </button>                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('admin.pengaturan.index') }}"><i class="fas fa-user me-2"></i>Profil</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.pengaturan.index') }}"><i class="fas fa-cog me-2"></i>Pengaturan</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="content">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show animate-fade-in-up" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show animate-fade-in-up" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay d-none" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Sidebar toggle
            $('#sidebarToggle').click(function() {
                $('#sidebar').toggleClass('collapsed');
                $(this).find('i').toggleClass('fa-chevron-left fa-chevron-right');
            });

            // Mobile sidebar toggle
            $('.mobile-menu-btn').click(function() {
                $('#sidebar').toggleClass('mobile-open');
            });

            // Auto-hide alerts
            setTimeout(function() {
                $('.alert').fadeOut();
            }, 5000);

            // Loading overlay functions
            window.showLoading = function() {
                $('#loadingOverlay').removeClass('d-none');
            };

            window.hideLoading = function() {
                $('#loadingOverlay').addClass('d-none');
            };

            // Animate elements on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fade-in-up');
                    }
                });
            }, observerOptions);

            // Observe all cards and tables
            document.querySelectorAll('.card, .table').forEach(el => {
                observer.observe(el);
            });

            // CSRF token setup for AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
