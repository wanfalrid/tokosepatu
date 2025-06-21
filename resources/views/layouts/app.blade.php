<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ShoeMart - Toko Sepatu Premium')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --gold-color: #f39c12;
            --text-dark: #2c3e50;
            --text-light: #7f8c8d;
            --bg-light: #f8f9fa;
            --shadow: 0 10px 30px rgba(0,0,0,0.1);
            --shadow-hover: 0 20px 40px rgba(0,0,0,0.15);
            --border-radius: 15px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }

        /* Navbar Styles */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            transition: var(--transition);
            padding: 1rem 0;
        }

        .navbar.scrolled {
            padding: 0.5rem 0;
            box-shadow: 0 2px 30px rgba(0,0,0,0.15);
        }

        .navbar-brand {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--primary-color) !important;
            text-decoration: none;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            color: var(--text-dark) !important;
            margin: 0 0.5rem;
            position: relative;
            transition: var(--transition);
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 50%;
            background: var(--secondary-color);
            transition: var(--transition);
            transform: translateX(-50%);
        }

        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: 100%;
        }        .cart-icon {
            position: relative;
            color: var(--text-dark);
            font-size: 1.2rem;
            margin-left: 1rem;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--accent-color);
            color: white;
            border-radius: 50%;
            font-size: 0.7rem;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* User Dropdown Styles */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-radius: var(--border-radius);
            padding: 0.5rem 0;
            min-width: 220px;
        }

        .dropdown-item {
            padding: 0.75rem 1.25rem;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .dropdown-item:hover {
            background: var(--bg-light);
            color: var(--secondary-color);
        }

        .dropdown-header {
            padding: 0.75rem 1.25rem;
            margin-bottom: 0;
            font-size: 0.85rem;
            color: var(--text-dark);
        }        .dropdown-divider {
            margin: 0.5rem 0;
        }

        /* User Avatar Styles */
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--secondary-color);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: var(--transition);
        }        .user-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .user-avatar-small {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--secondary-color);
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        /* Button Styles */
        .btn-primary {
            background: linear-gradient(135deg, var(--secondary-color), #2980b9);
            border: none;
            border-radius: var(--border-radius);
            padding: 12px 30px;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.4);
        }

        .btn-outline-primary {
            border: 2px solid var(--secondary-color);
            color: var(--secondary-color);
            border-radius: var(--border-radius);
            padding: 12px 30px;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-outline-primary:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.3);
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            transition: var(--transition);
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
        }

        /* Footer Styles */
        .footer {
            background: linear-gradient(135deg, var(--primary-color), #34495e);
            color: white;
            padding: 3rem 0 1rem;
            margin-top: 5rem;
        }

        .footer h5 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .footer a {
            color: #bdc3c7;
            text-decoration: none;
            transition: var(--transition);
        }

        .footer a:hover {
            color: white;
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

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .animate-pulse {
            animation: pulse 2s infinite;
        }

        /* Loading Spinner */
        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--secondary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.5rem;
            }
            
            .navbar-nav {
                text-align: center;
                margin-top: 1rem;
            }
            
            .navbar-nav .nav-link {
                margin: 0.5rem 0;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top" id="navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-shoe-prints me-2"></i>ShoeMart
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('shop') ? 'active' : '' }}" href="{{ route('shop') }}">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Kontak</a>
                    </li>
                </ul>
                  <div class="d-flex align-items-center">
                    <form class="d-flex me-3" action="{{ route('produk.search') }}" method="GET">
                        <input class="form-control me-2" type="search" name="q" placeholder="Cari sepatu..." aria-label="Search" value="{{ request('q') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    
                    <a href="{{ route('cart.index') }}" class="cart-icon me-3">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-badge cart-count" id="cart-count">{{ $cartCount ?? 0 }}</span>
                    </a>
                      @auth('customer')
                        <!-- Customer Dropdown Menu -->
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @if(Auth::guard('customer')->user()->hasFoto())
                                    <img src="{{ Auth::guard('customer')->user()->foto_url }}" 
                                         alt="Foto Profil" 
                                         class="user-avatar me-2">
                                @else
                                    <i class="fas fa-user me-2"></i>
                                @endif
                                <span class="d-none d-sm-inline">{{ Auth::guard('customer')->user()->nama }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">                                <li>
                                    <h6 class="dropdown-header d-flex align-items-center">
                                        @if(Auth::guard('customer')->user()->hasFoto())
                                            <img src="{{ Auth::guard('customer')->user()->foto_url }}" 
                                                 alt="Foto Profil" 
                                                 class="user-avatar-small me-2">
                                        @else
                                            <i class="fas fa-user-circle me-2"></i>
                                        @endif
                                        {{ Auth::guard('customer')->user()->nama }}
                                    </h6>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('auth.profile') }}">
                                        <i class="fas fa-user-edit me-2"></i>Profil Saya
                                    </a>
                                </li>                                <li>
                                    <a class="dropdown-item" href="{{ route('auth.orders') }}">
                                        <i class="fas fa-shopping-bag me-2"></i>Pesanan Saya
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-heart me-2"></i>Wishlist
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('auth.logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <!-- Guest Buttons -->
                        <div class="d-flex gap-2">
                            <a href="{{ route('auth.login') }}" class="btn btn-outline-primary">
                                <i class="fas fa-sign-in-alt me-1"></i>
                                <span class="d-none d-sm-inline">Masuk</span>
                            </a>
                            <a href="{{ route('auth.register') }}" class="btn btn-primary">
                                <i class="fas fa-user-plus me-1"></i>
                                <span class="d-none d-sm-inline">Daftar</span>
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main style="margin-top: 100px;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5><i class="fas fa-shoe-prints me-2"></i>ShoeMart</h5>
                    <p>Toko sepatu premium dengan koleksi terlengkap dan kualitas terbaik. Temukan sepatu impian Anda di sini!</p>
                    <div class="social-links">
                        <a href="#" class="me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Menu</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('shop') }}">Produk</a></li>
                        <li><a href="{{ route('about') }}">Tentang</a></li>
                        <li><a href="{{ route('contact') }}">Kontak</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Kategori</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Sepatu Olahraga</a></li>
                        <li><a href="#">Sepatu Formal</a></li>
                        <li><a href="#">Sepatu Casual</a></li>
                        <li><a href="#">Sepatu Boots</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Kontak</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-map-marker-alt me-2"></i>Jl. Sepatu No. 123, Jakarta</li>
                        <li><i class="fas fa-phone me-2"></i>+62 812-3456-7890</li>
                        <li><i class="fas fa-envelope me-2"></i>info@shoemart.com</li>
                    </ul>
                </div>
            </div>
            
            <hr style="border-color: #34495e;">
            <div class="row">
                <div class="col-12 text-center">
                    <p>&copy; {{ date('Y') }} ShoeMart. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // CSRF Token setup for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Update cart count
        function updateCartCount() {
            const cart = JSON.parse(sessionStorage.getItem('cart') || '{}');
            const count = Object.keys(cart).length;
            $('#cart-count').text(count);
        }

        // Add to cart functionality
        function addToCart(idProduk) {
            $.ajax({
                url: '{{ route("cart.add") }}',
                method: 'POST',
                data: {
                    id_produk: idProduk
                },
                success: function(response) {
                    if (response.success) {
                        $('#cart-count').text(response.cart_count);
                        
                        // Show success message
                        const toast = `
                            <div class="toast position-fixed top-0 end-0 m-3" role="alert" style="z-index: 9999;">
                                <div class="toast-header bg-success text-white">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <strong class="me-auto">Berhasil!</strong>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                                </div>
                                <div class="toast-body">
                                    ${response.message}
                                </div>
                            </div>
                        `;
                        
                        $('body').append(toast);
                        $('.toast').toast('show');
                        
                        // Remove toast after shown
                        $('.toast').on('hidden.bs.toast', function() {
                            $(this).remove();
                        });
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        }

        // Initialize cart count on page load
        $(document).ready(function() {
            updateCartCount();
        });
    </script>
    
    @stack('scripts')
</body>
</html>