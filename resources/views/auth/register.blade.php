@extends('layouts.app')

@section('title', 'Daftar Akun - ShoeMart')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <!-- Header -->
                <div class="text-center mb-4">
                    <div class="mx-auto d-flex align-items-center justify-content-center mb-3" 
                         style="width: 70px; height: 70px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);">
                        <i class="fas fa-user-plus text-white" style="font-size: 1.8rem;"></i>
                    </div>
                    <h2 class="font-poppins fw-bold text-white mb-2" style="font-size: 2.5rem;">Daftar Akun Baru</h2>
                    <p class="text-white-50 mb-0">Bergabunglah dengan ShoeMart dan nikmati pengalaman berbelanja terbaik</p>
                </div>

                <!-- Registration Form Card -->
                <div class="card shadow-lg border-0" style="border-radius: 20px; backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.95);">
                    <div class="card-body p-5">
                        <!-- Error Messages -->
                        @if ($errors->any())
                            <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 15px;">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-exclamation-triangle text-danger me-3 mt-1"></i>
                                    <div>
                                        <h6 class="alert-heading fw-bold mb-2">Terdapat beberapa kesalahan:</h6>
                                        <ul class="list-unstyled mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li class="mb-1"><i class="fas fa-dot-circle text-danger me-2" style="font-size: 0.6rem;"></i>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif                        <!-- Registration Form -->
                        <form method="POST" action="{{ route('auth.store') }}" id="registerForm">
                            @csrf
                              <!-- Full Name -->
                            <div class="mb-4">
                                <label for="nama" class="form-label fw-semibold">
                                    <i class="fas fa-user text-primary me-2"></i>Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input 
                                    id="nama" 
                                    name="nama" 
                                    type="text" 
                                    required 
                                    value="{{ old('nama') }}"
                                    class="form-control form-control-lg @error('nama') is-invalid @enderror"
                                    style="border-radius: 15px; border: 2px solid #e9ecef; padding: 15px 20px;"
                                    placeholder="Masukkan nama lengkap Anda"
                                >
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="fas fa-envelope text-primary me-2"></i>Email <span class="text-danger">*</span>
                                </label>
                                <input 
                                    id="email" 
                                    name="email" 
                                    type="email" 
                                    required 
                                    value="{{ old('email') }}"
                                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    style="border-radius: 15px; border: 2px solid #e9ecef; padding: 15px 20px;"
                                    placeholder="nama@email.com"
                                >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>                            <!-- Phone -->
                            <div class="mb-4">
                                <label for="telepon" class="form-label fw-semibold">
                                    <i class="fas fa-phone text-primary me-2"></i>Nomor Telepon <span class="text-danger">*</span>
                                </label>
                                <input 
                                    id="telepon" 
                                    name="telepon" 
                                    type="tel" 
                                    required 
                                    value="{{ old('telepon') }}"
                                    class="form-control form-control-lg @error('telepon') is-invalid @enderror"
                                    style="border-radius: 15px; border: 2px solid #e9ecef; padding: 15px 20px;"
                                    placeholder="08xxxxxxxxxx"
                                >
                                @error('telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Birth Date -->
                            <div class="mb-4">
                                <label for="tanggal_lahir" class="form-label fw-semibold">
                                    <i class="fas fa-calendar text-primary me-2"></i>Tanggal Lahir <span class="text-muted">(Opsional)</span>
                                </label>
                                <input 
                                    id="tanggal_lahir" 
                                    name="tanggal_lahir" 
                                    type="date" 
                                    value="{{ old('tanggal_lahir') }}"
                                    class="form-control form-control-lg @error('tanggal_lahir') is-invalid @enderror"
                                    style="border-radius: 15px; border: 2px solid #e9ecef; padding: 15px 20px;"
                                >
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="mb-4">
                                <label for="alamat" class="form-label fw-semibold">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>Alamat <span class="text-danger">*</span>
                                </label>
                                <textarea 
                                    id="alamat" 
                                    name="alamat" 
                                    rows="3" 
                                    required
                                    class="form-control form-control-lg @error('alamat') is-invalid @enderror"
                                    style="border-radius: 15px; border: 2px solid #e9ecef; padding: 15px 20px;"
                                    placeholder="Masukkan alamat lengkap Anda"
                                >{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">
                                    <i class="fas fa-lock text-primary me-2"></i>Password <span class="text-danger">*</span>
                                </label>
                                <div class="position-relative">
                                    <input 
                                        id="password" 
                                        name="password" 
                                        type="password" 
                                        required 
                                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        style="border-radius: 15px; border: 2px solid #e9ecef; padding: 15px 50px 15px 20px;"
                                        placeholder="Minimal 8 karakter"
                                    >
                                    <button 
                                        type="button" 
                                        class="btn position-absolute end-0 top-50 translate-middle-y me-3"
                                        style="border: none; background: none; z-index: 10;"
                                        onclick="togglePasswordVisibility('password', 'eyeIcon1')"
                                    >
                                        <i id="eyeIcon1" class="fas fa-eye text-muted"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Password harus minimal 8 karakter</small>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label fw-semibold">
                                    <i class="fas fa-lock text-primary me-2"></i>Konfirmasi Password <span class="text-danger">*</span>
                                </label>
                                <div class="position-relative">
                                    <input 
                                        id="password_confirmation" 
                                        name="password_confirmation"
                                        type="password" 
                                        required 
                                        class="form-control form-control-lg"
                                        style="border-radius: 15px; border: 2px solid #e9ecef; padding: 15px 50px 15px 20px;"
                                        placeholder="Ulangi password Anda"
                                    >
                                    <button 
                                        type="button" 
                                        class="btn position-absolute end-0 top-50 translate-middle-y me-3"
                                        style="border: none; background: none; z-index: 10;"
                                        onclick="togglePasswordVisibility('password_confirmation', 'eyeIcon2')"
                                    >
                                        <i id="eyeIcon2" class="fas fa-eye text-muted"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Terms & Conditions -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        id="terms" 
                                        name="terms" 
                                        required
                                        style="border-radius: 5px;"
                                    >
                                    <label class="form-check-label" for="terms">
                                        Saya menyetujui <a href="#" class="text-primary text-decoration-none fw-semibold">Syarat & Ketentuan</a> dan <a href="#" class="text-primary text-decoration-none fw-semibold">Kebijakan Privasi</a> ShoeMart
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mb-4">
                                <button 
                                    type="submit" 
                                    class="btn btn-lg text-white fw-bold"
                                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 15px; padding: 15px; box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4); transition: all 0.3s ease;"
                                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 35px rgba(102, 126, 234, 0.6)'"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(102, 126, 234, 0.4)'"
                                >
                                    <i class="fas fa-user-plus me-2"></i>
                                    Daftar Sekarang
                                </button>
                            </div>
                        </form>                        <!-- Divider -->
                        <div class="text-center my-4">
                            <hr class="my-3">
                            <span class="bg-white px-3 text-muted">Sudah punya akun?</span>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center">
                            <a href="{{ route('auth.login') }}" class="btn btn-outline-primary btn-lg fw-semibold" style="border-radius: 15px; border: 2px solid; padding: 12px 30px;">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Masuk ke akun Anda
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-4">
                    <p class="text-white-50 small mb-0">&copy; {{ date('Y') }} ShoeMart. Semua hak dilindungi.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-control:focus {
    border-color: #667eea !important;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25) !important;
}

.form-control.is-invalid:focus {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
}

.btn-outline-primary:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    border-color: transparent !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}
</style>

<script>
function togglePasswordVisibility(inputId, iconId) {
    const passwordInput = document.getElementById(inputId);
    const eyeIcon = document.getElementById(iconId);
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.className = 'fas fa-eye-slash text-muted';
    } else {
        passwordInput.type = 'password';
        eyeIcon.className = 'fas fa-eye text-muted';
    }
}

// Form validation
document.getElementById('registerForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    
    if (password !== confirmPassword) {
        e.preventDefault();
        
        // Show Bootstrap alert
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show';
        alertDiv.innerHTML = `
            <i class="fas fa-exclamation-triangle me-2"></i>
            Password dan konfirmasi password tidak cocok!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        const form = document.getElementById('registerForm');
        form.insertBefore(alertDiv, form.firstChild);
        
        return false;
    }
    
    if (password.length < 8) {
        e.preventDefault();
        
        // Show Bootstrap alert
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show';
        alertDiv.innerHTML = `
            <i class="fas fa-exclamation-triangle me-2"></i>
            Password harus minimal 8 karakter!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        const form = document.getElementById('registerForm');
        form.insertBefore(alertDiv, form.firstChild);
        
        return false;
    }
});

// Phone number formatting
document.getElementById('telepon').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.startsWith('0')) {
        e.target.value = value;
    } else if (value.startsWith('62')) {
        e.target.value = '0' + value.substring(2);
    }
});

// Form styling enhancements
document.addEventListener('DOMContentLoaded', function() {
    // Add focus effects to form controls
    const formControls = document.querySelectorAll('.form-control');
    formControls.forEach(control => {
        control.addEventListener('focus', function() {
            this.style.borderColor = '#667eea';
            this.style.transform = 'scale(1.02)';
        });
        
        control.addEventListener('blur', function() {
            this.style.borderColor = '#e9ecef';
            this.style.transform = 'scale(1)';
        });
    });
});
</script>
@endsection
