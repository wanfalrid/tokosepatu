@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Profil Saya</h1>
            <p class="text-gray-600">Kelola informasi akun Anda</p>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Profile Header -->
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-12 text-white">
                    <div class="flex items-center space-x-6">
                        <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <i class="fas fa-user text-3xl"></i>
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold">{{ $customer->nama }}</h2>
                            <p class="text-blue-100 mt-1">{{ $customer->email }}</p>
                            <div class="flex items-center mt-2 space-x-4">
                                <span class="bg-green-500/20 text-green-100 px-3 py-1 rounded-full text-sm backdrop-blur-sm">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    {{ ucfirst($customer->status_akun) }}
                                </span>                                <span class="text-blue-100 text-sm">
                                    <i class="fas fa-calendar mr-1"></i>
                                    Bergabung sejak 
                                    @if($customer->dibuat_pada)
                                        {{ \Carbon\Carbon::parse($customer->dibuat_pada)->format('M Y') }}
                                    @elseif($customer->created_at)
                                        {{ $customer->created_at->format('M Y') }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Form -->
                <div class="p-8">
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('auth.profile.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Lengkap -->
                            <div class="space-y-2">
                                <label for="nama" class="block text-sm font-semibold text-gray-700">
                                    <i class="fas fa-user mr-2 text-blue-500"></i>Nama Lengkap
                                </label>
                                <input type="text" 
                                       id="nama" 
                                       name="nama" 
                                       value="{{ old('nama', $customer->nama) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('nama') border-red-500 @enderror"
                                       required>
                                @error('nama')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="space-y-2">
                                <label for="email" class="block text-sm font-semibold text-gray-700">
                                    <i class="fas fa-envelope mr-2 text-blue-500"></i>Email
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $customer->email) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('email') border-red-500 @enderror"
                                       required>
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Telepon -->
                            <div class="space-y-2">
                                <label for="telepon" class="block text-sm font-semibold text-gray-700">
                                    <i class="fas fa-phone mr-2 text-blue-500"></i>Nomor Telepon
                                </label>
                                <input type="tel" 
                                       id="telepon" 
                                       name="telepon" 
                                       value="{{ old('telepon', $customer->telepon) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('telepon') border-red-500 @enderror"
                                       required>
                                @error('telepon')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="space-y-2">
                                <label for="tanggal_lahir" class="block text-sm font-semibold text-gray-700">
                                    <i class="fas fa-birthday-cake mr-2 text-blue-500"></i>Tanggal Lahir
                                </label>
                                <input type="date" 
                                       id="tanggal_lahir" 
                                       name="tanggal_lahir" 
                                       value="{{ old('tanggal_lahir', $customer->tanggal_lahir) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('tanggal_lahir') border-red-500 @enderror"
                                       required>
                                @error('tanggal_lahir')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="space-y-2">
                            <label for="alamat" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>Alamat Lengkap
                            </label>
                            <textarea id="alamat" 
                                      name="alamat" 
                                      rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('alamat') border-red-500 @enderror"
                                      required>{{ old('alamat', $customer->alamat) }}</textarea>
                            @error('alamat')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Change Password Section -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                <i class="fas fa-lock mr-2 text-blue-500"></i>Ubah Password
                            </h3>
                            <p class="text-gray-600 text-sm mb-4">Kosongkan jika tidak ingin mengubah password</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Password Baru -->
                                <div class="space-y-2">
                                    <label for="password" class="block text-sm font-semibold text-gray-700">Password Baru</label>
                                    <div class="relative">
                                        <input type="password" 
                                               id="password" 
                                               name="password" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('password') border-red-500 @enderror"
                                               minlength="6">
                                        <button type="button" 
                                                onclick="togglePassword('password')" 
                                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                            <i class="fas fa-eye" id="password-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Konfirmasi Password -->
                                <div class="space-y-2">
                                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Konfirmasi Password</label>
                                    <div class="relative">
                                        <input type="password" 
                                               id="password_confirmation" 
                                               name="password_confirmation" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                               minlength="6">
                                        <button type="button" 
                                                onclick="togglePassword('password_confirmation')" 
                                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                            <i class="fas fa-eye" id="password_confirmation-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between pt-6 border-t">
                            <a href="{{ route('home') }}" 
                               class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition duration-200">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali
                            </a>
                            
                            <button type="submit" 
                                    class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Account Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shopping-bag text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">0</h3>
                    <p class="text-gray-600">Total Pesanan</p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heart text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">0</h3>
                    <p class="text-gray-600">Wishlist</p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-award text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">Bronze</h3>
                    <p class="text-gray-600">Status Member</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const eye = document.getElementById(fieldId + '-eye');
    
    if (field.type === 'password') {
        field.type = 'text';
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
    }
}
</script>
@endsection
