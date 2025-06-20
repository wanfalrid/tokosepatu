@extends('layouts.app')

@section('title', 'Masuk - ShoeMart')

@section('content')
<div class="auth-container">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="auth-card" data-aos="fade-up">
                    <div class="row g-0">
                        <!-- Left Side - Image & Brand -->
                        <div class="col-lg-6 d-none d-lg-flex auth-image-side">
                            <div class="auth-brand-content">
                                <div class="brand-logo" data-aos="fade-right">
                                    <i class="fas fa-shoe-prints"></i>
                                    <h2>ShoeMart</h2>
                                    <p>Your Premium Shoe Destination</p>
                                </div>
                                
                                <div class="auth-features">
                                    <div class="feature-item" data-aos="fade-up" data-aos-delay="100">
                                        <i class="fas fa-shopping-bag"></i>
                                        <div>
                                            <h5>Koleksi Premium</h5>
                                            <p>Berbagai merek sepatu ternama dengan kualitas terbaik</p>
                                        </div>
                                    </div>
                                    
                                    <div class="feature-item" data-aos="fade-up" data-aos-delay="200">
                                        <i class="fas fa-shipping-fast"></i>
                                        <div>
                                            <h5>Pengiriman Cepat</h5>
                                            <p>Gratis ongkir ke seluruh Indonesia untuk pembelian minimal</p>
                                        </div>
                                    </div>
                                    
                                    <div class="feature-item" data-aos="fade-up" data-aos-delay="300">
                                        <i class="fas fa-shield-alt"></i>
                                        <div>
                                            <h5>Garansi Resmi</h5>
                                            <p>100% original dengan garansi resmi dari brand</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Side - Login Form -->
                        <div class="col-lg-6 auth-form-side">
                            <div class="auth-form-container" data-aos="fade-left">
                                <div class="auth-header text-center mb-4">
                                    <div class="auth-icon">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                    <h3 class="auth-title">Selamat Datang Kembali</h3>
                                    <p class="auth-subtitle">Masuk ke akun ShoeMart Anda</p>
                                </div>

                                @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert" data-aos="shake">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                                @endif

                                @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert" data-aos="fade-in">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                                @endif

                                <form action="{{ route('login') }}" method="POST" class="auth-form">
                                    @csrf
                                    
                                    <div class="form-group mb-3">
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
                                                   placeholder="masukkan@email.com"
                                                   required>
                                        </div>
                                        @error('email')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group mb-3">
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
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group mb-4">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                                <label class="form-check-label" for="remember">
                                                    Ingat saya
                                                </label>
                                            </div>
                                            <a href="#" class="forgot-password">Lupa password?</a>
                                        </div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary btn-auth w-100 mb-4">
                                        <i class="fas fa-sign-in-alt me-2"></i>
                                        Masuk
                                    </button>
                                </form>
                                
                                <div class="auth-footer text-center">                                    <p class="mb-0">Belum punya akun? 
                                        <a href="{{ route('auth.register') }}" class="register-link">Daftar sekarang</a>
                                    </p>
                                    
                                    <div class="back-to-home mt-3">
                                        <a href="{{ route('home') }}" class="text-decoration-none">
                                            <i class="fas fa-arrow-left me-2"></i>
                                            Kembali ke Beranda
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .auth-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        padding: 2rem 0;
    }

    .auth-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        min-height: 600px;
    }

    .auth-image-side {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.9) 0%, rgba(118, 75, 162, 0.9) 100%),
                    url('https://images.unsplash.com/photo-1549298916-b41d501d3772?ixlib=rb-4.0.3') center/cover;
        position: relative;
        align-items: center;
        justify-content: center;
        color: white;
        padding: 3rem;
    }

    .auth-brand-content {
        text-align: center;
        width: 100%;
    }

    .brand-logo {
        margin-bottom: 3rem;
    }

    .brand-logo i {
        font-size: 4rem;
        margin-bottom: 1rem;
        display: block;
        text-shadow: 0 4px 8px rgba(0,0,0,0.3);
    }

    .brand-logo h2 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .brand-logo p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 0;
    }

    .auth-features {
        text-align: left;
        max-width: 400px;
        margin: 0 auto;
    }

    .feature-item {
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
        padding: 1rem;
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
        backdrop-filter: blur(5px);
        transition: all 0.3s ease;
    }

    .feature-item:hover {
        transform: translateY(-2px);
        background: rgba(255,255,255,0.15);
    }

    .feature-item i {
        font-size: 2rem;
        margin-right: 1rem;
        width: 50px;
        text-align: center;
        color: #fff;
    }

    .feature-item h5 {
        margin-bottom: 0.25rem;
        font-weight: 600;
        color: #fff;
    }

    .feature-item p {
        margin: 0;
        font-size: 0.9rem;
        opacity: 0.9;
        line-height: 1.4;
    }

    .auth-form-side {
        display: flex;
        align-items: center;
        padding: 3rem 2rem;
    }

    .auth-form-container {
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
    }

    .auth-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(45deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: white;
        font-size: 2rem;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .auth-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .auth-subtitle {
        color: #666;
        margin-bottom: 0;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .input-group-text {
        background: #f8f9fa;
        border-color: #dee2e6;
        color: #666;
    }

    .form-control {
        border-left: none;
        padding: 0.75rem 1rem;
        border-color: #dee2e6;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .form-control:focus + .input-group-text,
    .input-group:focus-within .input-group-text {
        border-color: #667eea;
        background: linear-gradient(45deg, #667eea, #764ba2);
        color: white;
    }

    .toggle-password {
        cursor: pointer;
        background: #f8f9fa;
        border-color: #dee2e6;
        border-left: none;
        transition: all 0.3s ease;
    }

    .toggle-password:hover {
        background: #e9ecef;
    }

    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }

    .forgot-password {
        color: #667eea;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .forgot-password:hover {
        color: #764ba2;
        text-decoration: underline;
    }

    .btn-auth {
        background: linear-gradient(45deg, #667eea, #764ba2);
        border: none;
        padding: 0.75rem 2rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-auth:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }

    .btn-auth:active {
        transform: translateY(0);
    }

    .register-link {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .register-link:hover {
        color: #764ba2;
        text-decoration: underline;
    }

    .back-to-home a {
        color: #666;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .back-to-home a:hover {
        color: #667eea;
        transform: translateX(-3px);
    }

    /* Responsive */
    @media (max-width: 991px) {
        .auth-form-side {
            padding: 2rem 1rem;
        }
        
        .auth-title {
            font-size: 1.5rem;
        }
        
        .brand-logo h2 {
            font-size: 2rem;
        }
    }

    @media (max-width: 576px) {
        .auth-container {
            padding: 1rem 0;
        }
        
        .auth-form-container {
            padding: 0 0.5rem;
        }
        
        .auth-title {
            font-size: 1.3rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
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
document.querySelector('.auth-form').addEventListener('submit', function() {
    const submitBtn = this.querySelector('.btn-auth');
    submitBtn.innerHTML = '<div class="spinner-border spinner-border-sm me-2"></div>Masuk...';
    submitBtn.disabled = true;
});

// Real-time validation
document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('blur', function() {
        if (this.checkValidity()) {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        } else {
            this.classList.remove('is-valid');
            this.classList.add('is-invalid');
        }
    });
});
</script>
@endpush
