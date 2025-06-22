@extends('layouts.admin')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Sistem')

@section('content')
<div class="container-fluid">
    <!-- Settings Navigation -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills" id="settingsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="profile-tab" data-bs-toggle="pill" data-bs-target="#profile" 
                                    type="button" role="tab" aria-controls="profile" aria-selected="true">
                                <i class="fas fa-user me-2"></i>Profil Admin
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="password-tab" data-bs-toggle="pill" data-bs-target="#password" 
                                    type="button" role="tab" aria-controls="password" aria-selected="false">
                                <i class="fas fa-lock me-2"></i>Ubah Password
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="system-tab" data-bs-toggle="pill" data-bs-target="#system" 
                                    type="button" role="tab" aria-controls="system" aria-selected="false">
                                <i class="fas fa-cogs me-2"></i>Pengaturan Sistem
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="maintenance-tab" data-bs-toggle="pill" data-bs-target="#maintenance" 
                                    type="button" role="tab" aria-controls="maintenance" aria-selected="false">
                                <i class="fas fa-tools me-2"></i>Maintenance
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-content" id="settingsTabContent">
        <!-- Profile Tab -->
        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-user me-2"></i>Profil Admin</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.pengaturan.updateProfile') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">                                    <div class="col-md-6 form-group mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $admin->nama_lengkap ?? '') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email', $admin->email ?? '') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                  <div class="form-group mb-3">
                                    <label for="phone" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', $admin->telepon ?? '') }}" 
                                           placeholder="08123456789">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="avatar" class="form-label">Foto Profil</label>
                                    <input type="file" class="form-control @error('avatar') is-invalid @enderror" 
                                           id="avatar" name="avatar" accept="image/*">
                                    <small class="form-text text-muted">Format: JPG, JPEG, PNG, GIF. Maksimal 2MB.</small>
                                    @error('avatar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Foto Profil Saat Ini</h5>
                        </div>                        <div class="card-body text-center">
                            @if(isset($admin->foto) && $admin->foto)
                                <img src="{{ asset('storage/avatars/' . $admin->foto) }}" 
                                     alt="Avatar {{ $admin->nama_lengkap ?? 'Admin' }}" 
                                     class="img-fluid rounded-circle mb-3"
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                     style="width: 150px; height: 150px;">
                                    <i class="fas fa-user fa-4x text-white"></i>
                                </div>
                            @endif
                            <h6>{{ $admin->nama_lengkap ?? 'Admin' }}</h6>
                            <p class="text-muted">{{ $admin->email ?? '' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Password Tab -->
        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-lock me-2"></i>Ubah Password</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.pengaturan.updatePassword') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="form-group mb-3">
                                    <label for="current_password" class="form-label">Password Saat Ini</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                               id="current_password" name="current_password" required>
                                        <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="new_password" class="form-label">Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                               id="new_password" name="new_password" minlength="6" required>
                                        <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" 
                                               id="new_password_confirmation" name="new_password_confirmation" required>
                                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-key me-2"></i>Ubah Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Settings Tab -->
        <div class="tab-pane fade" id="system" role="tabpanel" aria-labelledby="system-tab">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Pengaturan Sistem</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pengaturan.updateSystem') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="site_name" class="form-label">Nama Situs</label>
                                    <input type="text" class="form-control" id="site_name" name="site_name" 
                                           value="{{ old('site_name', $systemSettings['site_name']) }}" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="contact_email" class="form-label">Email Kontak</label>
                                    <input type="email" class="form-control" id="contact_email" name="contact_email" 
                                           value="{{ old('contact_email', $systemSettings['contact_email']) }}" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="contact_phone" class="form-label">Telepon Kontak</label>
                                    <input type="text" class="form-control" id="contact_phone" name="contact_phone" 
                                           value="{{ old('contact_phone', $systemSettings['contact_phone']) }}">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="timezone" class="form-label">Zona Waktu</label>
                                    <select class="form-control" id="timezone" name="timezone" required>
                                        <option value="Asia/Jakarta" {{ $systemSettings['timezone'] === 'Asia/Jakarta' ? 'selected' : '' }}>
                                            Asia/Jakarta (WIB)
                                        </option>
                                        <option value="Asia/Makassar" {{ $systemSettings['timezone'] === 'Asia/Makassar' ? 'selected' : '' }}>
                                            Asia/Makassar (WITA)
                                        </option>
                                        <option value="Asia/Jayapura" {{ $systemSettings['timezone'] === 'Asia/Jayapura' ? 'selected' : '' }}>
                                            Asia/Jayapura (WIT)
                                        </option>
                                    </select>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="currency" class="form-label">Mata Uang</label>
                                    <select class="form-control" id="currency" name="currency" required>
                                        <option value="IDR" {{ $systemSettings['currency'] === 'IDR' ? 'selected' : '' }}>
                                            IDR (Rupiah)
                                        </option>
                                        <option value="USD" {{ $systemSettings['currency'] === 'USD' ? 'selected' : '' }}>
                                            USD (Dollar)
                                        </option>
                                    </select>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="items_per_page" class="form-label">Item Per Halaman</label>
                                    <input type="number" class="form-control" id="items_per_page" name="items_per_page" 
                                           value="{{ old('items_per_page', $systemSettings['items_per_page']) }}" 
                                           min="5" max="100" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="site_description" class="form-label">Deskripsi Situs</label>
                            <textarea class="form-control" id="site_description" name="site_description" rows="3">{{ old('site_description', $systemSettings['site_description']) }}</textarea>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $systemSettings['address']) }}</textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Simpan Pengaturan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Maintenance Tab -->
        <div class="tab-pane fade" id="maintenance" role="tabpanel" aria-labelledby="maintenance-tab">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-broom me-2"></i>Cache Management</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Bersihkan cache aplikasi untuk memastikan perubahan terbaru diterapkan.</p>
                            
                            <button type="button" class="btn btn-warning" onclick="clearCache()">
                                <i class="fas fa-trash me-2"></i>Bersihkan Cache
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-download me-2"></i>Backup Data</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Buat backup database untuk mengamankan data aplikasi.</p>
                            
                            <button type="button" class="btn btn-info" onclick="createBackup()">
                                <i class="fas fa-database me-2"></i>Buat Backup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Sistem</h5>
                        </div>
                        <div class="card-body">
                            <button type="button" class="btn btn-secondary mb-3" onclick="loadSystemInfo()">
                                <i class="fas fa-sync me-2"></i>Muat Info Sistem
                            </button>
                            
                            <div id="systemInfo" class="d-none">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody id="systemInfoTable">
                                            <!-- System info will be loaded here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Loading functions
function showLoading() {
    Swal.fire({
        title: 'Loading...',
        text: 'Sedang memproses permintaan Anda',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
}

function hideLoading() {
    Swal.close();
}

// Password visibility toggles
document.getElementById('toggleCurrentPassword').addEventListener('click', function() {
    togglePasswordVisibility('current_password', this);
});

document.getElementById('toggleNewPassword').addEventListener('click', function() {
    togglePasswordVisibility('new_password', this);
});

document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
    togglePasswordVisibility('new_password_confirmation', this);
});

function togglePasswordVisibility(fieldId, button) {
    const field = document.getElementById(fieldId);
    const icon = button.querySelector('i');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Clear cache function
function clearCache() {
    if (confirm('Apakah Anda yakin ingin membersihkan cache? Ini akan menghapus semua cache aplikasi.')) {
        showLoading();
        
        fetch('{{ route("admin.pengaturan.clearCache") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                Swal.fire('Berhasil!', 'Cache berhasil dibersihkan.', 'success');
            } else {
                Swal.fire('Error!', data.message || 'Gagal membersihkan cache.', 'error');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            Swal.fire('Error!', 'Terjadi kesalahan saat membersihkan cache.', 'error');
        });
    }
}

// Create backup function
function createBackup() {
    if (confirm('Buat backup database sekarang? Proses ini mungkin memakan waktu beberapa menit.')) {
        showLoading();
        
        fetch('{{ route("admin.pengaturan.backup") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                Swal.fire('Berhasil!', 'Backup berhasil dibuat.', 'success');
            } else {
                Swal.fire('Error!', data.message || 'Gagal membuat backup.', 'error');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            Swal.fire('Error!', 'Terjadi kesalahan saat membuat backup.', 'error');
        });
    }
}

// Load system info
function loadSystemInfo() {
    showLoading();
    
    fetch('{{ route("admin.pengaturan.systemInfo") }}')
    .then(response => response.json())
    .then(data => {
        hideLoading();
        
        const tableBody = document.getElementById('systemInfoTable');
        tableBody.innerHTML = '';
        
        Object.entries(data).forEach(([key, value]) => {
            const row = `
                <tr>
                    <td class="fw-bold">${key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}</td>
                    <td>${value}</td>
                </tr>
            `;
            tableBody.innerHTML += row;
        });
        
        document.getElementById('systemInfo').classList.remove('d-none');
    })
    .catch(error => {
        hideLoading();
        console.error('Error:', error);
        Swal.fire('Error!', 'Gagal memuat informasi sistem.', 'error');
    });
}

// Avatar preview
document.getElementById('avatar').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        // File size check (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar. Maksimal 2MB.');
            this.value = '';
            return;
        }
        
        // File type check
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!validTypes.includes(file.type)) {
            alert('Format file tidak valid. Gunakan JPG, JPEG, PNG, atau GIF.');
            this.value = '';
            return;
        }
    }
});

// Phone number formatting
document.getElementById('phone').addEventListener('input', function() {
    let value = this.value.replace(/\D/g, '');
    
    if (value.length > 0 && !value.startsWith('08')) {
        if (value.startsWith('8')) {
            value = '0' + value;
        } else if (value.startsWith('62')) {
            value = '0' + value.substring(2);
        }
    }
    
    if (value.length > 15) {
        value = value.substring(0, 15);
    }
    
    this.value = value;
});
</script>
@endpush

@endsection
