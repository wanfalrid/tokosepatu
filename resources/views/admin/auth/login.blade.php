<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - ShoeMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-background"></div>
          <div class="container-fluid" style="min-height: 100vh;">
            <div class="row" style="min-height: 100vh;">
                <!-- Left Side - Branding -->
                <div class="col-lg-6 d-none d-lg-flex login-brand-side">
                    <div class="brand-content" data-aos="fade-right">
                        <div class="brand-logo mb-4">
                            <i class="fas fa-shoe-prints brand-icon"></i>
                            <h1 class="brand-name">ShoeMart</h1>
                            <p class="brand-tagline">Admin Panel</p>
                        </div>
                        
                        <div class="brand-features">
                            <div class="feature-item" data-aos="fade-up" data-aos-delay="100">
                                <div class="feature-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="feature-content">
                                    <h4>Dashboard Analytics</h4>
                                    <p>Monitor penjualan dan performa toko secara real-time</p>
                                </div>
                            </div>
                            
                            <div class="feature-item" data-aos="fade-up" data-aos-delay="200">
                                <div class="feature-icon">
                                    <i class="fas fa-boxes"></i>
                                </div>
                                <div class="feature-content">
                                    <h4>Manajemen Produk</h4>
                                    <p>Kelola stok dan katalog produk dengan mudah</p>
                                </div>
                            </div>
                            
                            <div class="feature-item" data-aos="fade-up" data-aos-delay="300">
                                <div class="feature-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div class="feature-content">
                                    <h4>Order Management</h4>
                                    <p>Proses dan track pesanan pelanggan secara efisien</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                  <!-- Right Side - Login Form -->
                <div class="col-lg-6 d-flex align-items-stretch login-form-side">
                    <div class="login-form-container d-flex flex-column justify-content-center w-100" data-aos="fade-left">
                        <div class="login-header text-center mb-5">
                            <div class="login-icon mb-3">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <h2 class="login-title">Selamat Datang</h2>
                            <p class="login-subtitle">Masuk ke panel admin ShoeMart</p>
                        </div>
                        
                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" data-aos="shake">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif
                        
                        <form action="{{ route('admin.login') }}" method="POST" class="login-form">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           placeholder="admin@shoemart.com"
                                           required>
                                </div>
                                @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group mb-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           placeholder="••••••••"
                                           required>
                                    <button type="button" class="input-group-text toggle-password" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">
                                        Ingat saya
                                    </label>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-login w-100 mb-4">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Masuk ke Dashboard
                            </button>
                        </form>
                          <div class="login-footer text-center">
                            <div class="register-link mb-3">
                                <p class="mb-1">Belum punya akun admin?</p>
                                <a href="{{ route('admin.register') }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-user-plus me-2"></i>
                                    Daftar Admin Baru
                                </a>
                            </div>
                            
                            <div class="demo-credentials">
                                <small class="text-muted">
                                    <strong>Demo Credentials:</strong><br>
                                    Email: admin@shoemart.com<br>
                                    Password: admin123
                                </small>
                            </div>
                            
                            <div class="back-to-store mt-3">
                                <a href="{{ route('home') }}" class="text-decoration-none">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Kembali ke Toko
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Floating Elements -->
        <div class="floating-elements">
            <div class="floating-element floating-element-1"></div>
            <div class="floating-element floating-element-2"></div>
            <div class="floating-element floating-element-3"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true
        });

        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Form animation on submit
        document.querySelector('.login-form').addEventListener('submit', function() {
            const submitBtn = this.querySelector('.btn-login');
            submitBtn.innerHTML = '<div class="spinner-border spinner-border-sm me-2"></div>Masuk...';
            submitBtn.disabled = true;
        });

        // Floating animation
        function animateFloatingElements() {
            const elements = document.querySelectorAll('.floating-element');
            elements.forEach((element, index) => {
                element.style.animation = `float ${3 + index}s ease-in-out infinite`;
                element.style.animationDelay = `${index * 0.5}s`;
            });
        }

        animateFloatingElements();
    </script>

    <style>
        :root {
            --primary-color: #007bff;
            --primary-dark: #0056b3;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --dark-color: #343a40;
            --light-color: #f8f9fa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            min-height: 100vh;
        }

        .login-container {
            min-height: 100vh;
            position: relative;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .login-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><pattern id="grid" width="50" height="50" patternUnits="userSpaceOnUse"><path d="M 50 0 L 0 0 0 50" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }        .login-brand-side {
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255,255,255,0.2);
            position: relative;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            min-height: 100vh;
            overflow-y: auto;
        }

        .brand-content {
            text-align: center;
            color: white;
        }

        .brand-logo {
            margin-bottom: 3rem;
        }

        .brand-icon {
            font-size: 4rem;
            color: #fff;
            margin-bottom: 1rem;
            display: block;
            text-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }

        .brand-name {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .brand-tagline {
            font-size: 1.2rem;
            opacity: 0.9;
            font-weight: 300;
        }

        .brand-features {
            text-align: left;
            max-width: 400px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: rgba(255,255,255,0.1);
            border-radius: 15px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            transform: translateY(-5px);
            background: rgba(255,255,255,0.15);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(45deg, #007bff, #0056b3);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .feature-icon i {
            font-size: 1.5rem;
            color: white;
        }

        .feature-content h4 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .feature-content p {
            font-size: 0.9rem;
            opacity: 0.9;
            margin: 0;
            line-height: 1.4;
        }        .login-form-side {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            padding: 2rem;
            min-height: 100vh;
            overflow-y: auto;
        }        .login-form-container {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            margin: auto;
        }

        .login-header {
            text-align: center;
        }

        .login-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            animation: pulse 2s infinite;
        }

        .login-icon i {
            font-size: 2rem;
            color: white;
        }

        .login-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            color: var(--secondary-color);
            font-size: 1rem;
        }

        .form-group {
            position: relative;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .input-group {
            position: relative;
        }

        .input-group-text {
            background: linear-gradient(45deg, #f8f9fa, #e9ecef);
            border: 2px solid #e9ecef;
            border-right: none;
            color: var(--secondary-color);
            transition: all 0.3s ease;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-left: none;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255,255,255,0.9);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
            background: white;
        }

        .form-control:focus + .input-group-text,
        .input-group:focus-within .input-group-text {
            border-color: var(--primary-color);
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
        }

        .toggle-password {
            cursor: pointer;
            background: linear-gradient(45deg, #f8f9fa, #e9ecef);
            border: 2px solid #e9ecef;
            border-left: none;
            transition: all 0.3s ease;
        }

        .toggle-password:hover {
            background: linear-gradient(45deg, #e9ecef, #dee2e6);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-login {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            border: none;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,123,255,0.3);
        }

        .btn-login:active {
            transform: translateY(0);
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

        .demo-credentials {
            background: linear-gradient(45deg, #f8f9fa, #e9ecef);
            padding: 1rem;
            border-radius: 10px;
            border: 1px solid #dee2e6;
        }

        .back-to-store a {
            color: var(--primary-color);
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-to-store a:hover {
            color: var(--primary-dark);
            transform: translateX(-3px);
        }

        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .floating-element {
            position: absolute;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }

        .floating-element-1 {
            width: 100px;
            height: 100px;
            top: 10%;
            left: 10%;
        }

        .floating-element-2 {
            width: 150px;
            height: 150px;
            top: 60%;
            right: 10%;
        }

        .floating-element-3 {
            width: 80px;
            height: 80px;
            bottom: 20%;
            left: 5%;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }        /* Responsive */
        @media (max-width: 991px) {
            .login-form-side {
                background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(248,249,250,0.95) 100%);
                min-height: 100vh;
                padding: 2rem 1rem;
            }
            
            .login-form-container {
                padding: 1rem;
                max-height: none;
            }
            
            .brand-name {
                font-size: 2rem;
            }
        }

        @media (max-width: 576px) {
            .login-container {
                padding: 1rem 0;
            }
            
            .login-form-side {
                padding: 1rem;
            }
            
            .login-form-container {
                padding: 1rem 0.5rem;
                max-width: 100%;
            }
            
            .login-title {
                font-size: 1.75rem;
            }
        }
    </style>
</body>
</html>
