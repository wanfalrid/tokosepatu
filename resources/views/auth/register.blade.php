@extends('layouts.app')

@section('title', 'Daftar Akun - ShoeMart')

@section('content')
<!-- Main Container with Gradient Background -->
<div class="min-h-screen bg-gradient-to-br from-indigo-500 via-purple-600 to-purple-800 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 shadow-lg mb-4">
                <i class="fas fa-user-plus text-white text-2xl"></i>
            </div>
            <h2 class="text-4xl font-bold text-white mb-2">Daftar Akun Baru</h2>
            <p class="text-indigo-100">Bergabunglah dengan ShoeMart dan nikmati pengalaman berbelanja terbaik</p>
        </div>

        <!-- Registration Form Card -->
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl p-8">
            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-red-500 mt-1 mr-3"></i>
                        <div>
                            <h3 class="text-sm font-semibold text-red-800 mb-2">Terdapat beberapa kesalahan:</h3>
                            <ul class="text-sm text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-center">
                                        <i class="fas fa-dot-circle text-red-500 mr-2 text-xs"></i>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Registration Form -->
            <form method="POST" action="{{ route('auth.store') }}" id="registerForm" class="space-y-6">
                @csrf
                
                <!-- Full Name -->
                <div>
                    <label for="nama_lengkap" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user text-indigo-500 mr-2"></i>
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input 
                        id="nama_lengkap" 
                        name="nama_lengkap" 
                        type="text" 
                        required
                        value="{{ old('nama_lengkap') }}"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 @error('nama_lengkap') border-red-300 @enderror"
                        placeholder="Masukkan nama lengkap Anda"
                    >
                    @error('nama_lengkap')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-envelope text-indigo-500 mr-2"></i>
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        required 
                        value="{{ old('email') }}"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 @error('email') border-red-300 @enderror"
                        placeholder="nama@email.com"
                    >
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="nomor_telepon" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-phone text-indigo-500 mr-2"></i>
                        Nomor Telepon <span class="text-red-500">*</span>
                    </label>
                    <input 
                        id="nomor_telepon" 
                        name="nomor_telepon" 
                        type="tel" 
                        required 
                        value="{{ old('nomor_telepon') }}"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 @error('nomor_telepon') border-red-300 @enderror"
                        placeholder="08xxxxxxxxxx"
                    >
                    @error('nomor_telepon')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Birth Date -->
                <div>
                    <label for="tanggal_lahir" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-calendar text-indigo-500 mr-2"></i>
                        Tanggal Lahir <span class="text-gray-400">(Opsional)</span>
                    </label>
                    <input 
                        id="tanggal_lahir" 
                        name="tanggal_lahir" 
                        type="date" 
                        value="{{ old('tanggal_lahir') }}"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 @error('tanggal_lahir') border-red-300 @enderror"
                    >
                    @error('tanggal_lahir')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div>
                    <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-map-marker-alt text-indigo-500 mr-2"></i>
                        Alamat <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="alamat" 
                        name="alamat" 
                        rows="3" 
                        required
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 resize-none @error('alamat') border-red-300 @enderror"
                        placeholder="Masukkan alamat lengkap Anda"
                    >{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock text-indigo-500 mr-2"></i>
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            required 
                            class="w-full px-4 py-3 pr-12 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 @error('password') border-red-300 @enderror"
                            placeholder="Minimal 8 karakter"
                        >
                        <button 
                            type="button" 
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                            onclick="togglePasswordVisibility('password', 'eyeIcon1')"
                        >
                            <i id="eyeIcon1" class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-sm mt-1">Password harus minimal 8 karakter</p>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock text-indigo-500 mr-2"></i>
                        Konfirmasi Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            id="password_confirmation" 
                            name="password_confirmation"
                            type="password" 
                            required 
                            class="w-full px-4 py-3 pr-12 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200"
                            placeholder="Ulangi password Anda"
                        >
                        <button 
                            type="button" 
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                            onclick="togglePasswordVisibility('password_confirmation', 'eyeIcon2')"
                        >
                            <i id="eyeIcon2" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Terms & Conditions -->
                <div>
                    <label class="flex items-start space-x-3">
                        <input 
                            type="checkbox" 
                            id="terms" 
                            name="terms" 
                            required
                            class="mt-1 h-4 w-4 text-indigo-600 border-2 border-gray-300 rounded focus:ring-indigo-500 focus:ring-2"
                        >
                        <span class="text-sm text-gray-700">
                            Saya menyetujui 
                            <a href="#" class="text-indigo-600 hover:text-indigo-700 font-semibold">Syarat & Ketentuan</a> 
                            dan 
                            <a href="#" class="text-indigo-600 hover:text-indigo-700 font-semibold">Kebijakan Privasi</a> 
                            ShoeMart
                        </span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-bold py-4 px-6 rounded-xl hover:from-indigo-600 hover:to-purple-700 focus:ring-4 focus:ring-indigo-200 transform hover:scale-105 transition-all duration-200 shadow-lg"
                >
                    <i class="fas fa-user-plus mr-2"></i>
                    Daftar Sekarang
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500">Sudah punya akun?</span>
                </div>
            </div>

            <!-- Login Link -->
            <div class="text-center">
                <a href="{{ route('auth.login') }}" 
                   class="inline-flex items-center justify-center w-full px-6 py-3 border-2 border-indigo-500 text-indigo-600 font-semibold rounded-xl hover:bg-indigo-50 focus:ring-4 focus:ring-indigo-200 transition-all duration-200">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Masuk ke akun Anda
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-indigo-100 text-sm">&copy; {{ date('Y') }} ShoeMart. Semua hak dilindungi.</p>
        </div>
    </div>
</div>

<script>
function togglePasswordVisibility(inputId, iconId) {
    const passwordInput = document.getElementById(inputId);
    const eyeIcon = document.getElementById(iconId);
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.className = 'fas fa-eye-slash';
    } else {
        passwordInput.type = 'password';
        eyeIcon.className = 'fas fa-eye';
    }
}

// Form validation
document.getElementById('registerForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    
    if (password !== confirmPassword) {
        e.preventDefault();
        
        // Show error message
        const alertDiv = document.createElement('div');
        alertDiv.className = 'bg-red-50 border border-red-200 rounded-xl p-4 mb-6';
        alertDiv.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                <span class="text-red-800">Password dan konfirmasi password tidak cocok!</span>
            </div>
        `;
        
        const form = document.getElementById('registerForm');
        form.insertBefore(alertDiv, form.firstChild);
        
        // Remove alert after 5 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
        
        return false;
    }
    
    if (password.length < 8) {
        e.preventDefault();
        
        // Show error message
        const alertDiv = document.createElement('div');
        alertDiv.className = 'bg-red-50 border border-red-200 rounded-xl p-4 mb-6';
        alertDiv.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                <span class="text-red-800">Password harus minimal 8 karakter!</span>
            </div>
        `;
        
        const form = document.getElementById('registerForm');
        form.insertBefore(alertDiv, form.firstChild);
        
        // Remove alert after 5 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
        
        return false;
    }
});

// Phone number formatting
document.getElementById('nomor_telepon').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.startsWith('0')) {
        e.target.value = value;
    } else if (value.startsWith('62')) {
        e.target.value = '0' + value.substring(2);
    }
});

// Enhanced form interactions
document.addEventListener('DOMContentLoaded', function() {
    // Add focus effects to form controls
    const formControls = document.querySelectorAll('input, textarea');
    formControls.forEach(control => {
        control.addEventListener('focus', function() {
            this.parentElement.classList.add('transform', 'scale-105');
        });
        
        control.addEventListener('blur', function() {
            this.parentElement.classList.remove('transform', 'scale-105');
        });
    });
});
</script>
@endsection
