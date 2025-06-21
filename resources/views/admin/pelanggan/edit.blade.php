@extends('layouts.admin')

@section('title', 'Edit Pelanggan')
@section('page-title', 'Edit Pelanggan')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Pelanggan</h1>
        <a href="{{ route('admin.pelanggan.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-8">
            <!-- Form Edit Pelanggan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Data Pelanggan</h6>
                </div>
                <div class="card-body">
                    <form id="editPelangganForm" action="{{ route('admin.pelanggan.update', $pelanggan->id_pelanggan) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Nama -->
                            <div class="col-md-6 form-group">
                                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                       id="nama" name="nama" value="{{ old('nama', $pelanggan->nama) }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 form-group">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $pelanggan->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Telepon -->
                            <div class="col-md-6 form-group">
                                <label for="telepon" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                                       id="telepon" name="telepon" value="{{ old('telepon', $pelanggan->telepon) }}" 
                                       placeholder="08123456789">
                                @error('telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="col-md-6 form-group">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                       id="tanggal_lahir" name="tanggal_lahir" 
                                       value="{{ old('tanggal_lahir', $pelanggan->tanggal_lahir ? $pelanggan->tanggal_lahir->format('Y-m-d') : '') }}">
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="form-group">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" name="alamat" rows="3" 
                                      placeholder="Masukkan alamat lengkap">{{ old('alamat', $pelanggan->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status Akun -->
                        <div class="form-group">
                            <label for="status_akun" class="form-label">Status Akun <span class="text-danger">*</span></label>
                            <select class="form-control @error('status_akun') is-invalid @enderror" 
                                    id="status_akun" name="status_akun" required>
                                <option value="">Pilih Status</option>
                                <option value="aktif" {{ old('status_akun', $pelanggan->status_akun) === 'aktif' ? 'selected' : '' }}>
                                    Aktif
                                </option>
                                <option value="nonaktif" {{ old('status_akun', $pelanggan->status_akun) === 'nonaktif' ? 'selected' : '' }}>
                                    Non-Aktif
                                </option>
                                <option value="suspended" {{ old('status_akun', $pelanggan->status_akun) === 'suspended' ? 'selected' : '' }}>
                                    Suspended
                                </option>
                            </select>
                            @error('status_akun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Foto Profil -->
                        <div class="form-group">
                            <label for="foto" class="form-label">Foto Profil</label>
                            <input type="file" class="form-control-file @error('foto') is-invalid @enderror" 
                                   id="foto" name="foto" accept="image/*">
                            <small class="form-text text-muted">
                                Format yang diizinkan: JPG, JPEG, PNG, GIF. Maksimal 2MB.
                            </small>
                            @error('foto')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Section -->
                        <div class="card border-warning mb-3">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0">
                                    <i class="fas fa-lock"></i> Ubah Password
                                </h6>
                                <small>Kosongkan jika tidak ingin mengubah password</small>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Password Baru -->
                                    <div class="col-md-6 form-group">
                                        <label for="kata_sandi" class="form-label">Password Baru</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control @error('kata_sandi') is-invalid @enderror" 
                                                   id="kata_sandi" name="kata_sandi" minlength="6"
                                                   placeholder="Minimal 6 karakter">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @error('kata_sandi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Konfirmasi Password -->
                                    <div class="col-md-6 form-group">
                                        <label for="kata_sandi_confirmation" class="form-label">Konfirmasi Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" 
                                                   id="kata_sandi_confirmation" name="kata_sandi_confirmation"
                                                   placeholder="Ulangi password baru">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="passwordMatchError" class="invalid-feedback" style="display: none;">
                                            Password tidak cocok
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-end">
                            <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Current Profile Section -->
        <div class="col-xl-4 col-lg-4">
            <!-- Current Profile Photo -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Foto Profil Saat Ini</h6>
                </div>
                <div class="card-body text-center">
                    @if($pelanggan->foto && $pelanggan->hasFoto())
                        <img src="{{ $pelanggan->getFotoUrl() }}" 
                             alt="Foto {{ $pelanggan->nama }}" 
                             class="img-fluid rounded-circle mb-3"
                             style="width: 150px; height: 150px; object-fit: cover;">
                        <p class="text-muted">Foto profil yang sedang digunakan</p>
                    @else
                        <div class="bg-secondary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                             style="width: 150px; height: 150px;">
                            <i class="fas fa-user fa-4x text-white"></i>
                        </div>
                        <p class="text-muted">Belum ada foto profil</p>
                    @endif
                </div>
            </div>

            <!-- Preview New Photo -->
            <div class="card shadow mb-4" id="previewCard" style="display: none;">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Preview Foto Baru</h6>
                </div>
                <div class="card-body text-center">
                    <img id="previewImage" src="" alt="Preview" 
                         class="img-fluid rounded-circle mb-3"
                         style="width: 150px; height: 150px; object-fit: cover;">
                    <p class="text-muted">Preview foto yang akan diupload</p>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Info Pelanggan</h6>
                </div>
                <div class="card-body">
                    <div class="row no-gutters align-items-center mb-2">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                ID Pelanggan
                            </div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                {{ $pelanggan->id_pelanggan }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="row no-gutters align-items-center mb-2">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Terdaftar Sejak
                            </div>
                            <div class="h6 mb-0 text-gray-800">
                                @if($pelanggan->dibuat_pada instanceof \Carbon\Carbon)
                                    {{ $pelanggan->dibuat_pada->format('d M Y H:i') }}
                                @else
                                    {{ date('d M Y H:i', strtotime($pelanggan->dibuat_pada)) }}
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Pesanan
                            </div>
                            <div class="h6 mb-0 text-gray-800">
                                {{ $pelanggan->pesanan()->count() }} pesanan
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
$(document).ready(function() {
    // Toggle password visibility
    $('#togglePassword').click(function() {
        var passwordField = $('#kata_sandi');
        var icon = $(this).find('i');
        
        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $('#togglePasswordConfirm').click(function() {
        var passwordField = $('#kata_sandi_confirmation');
        var icon = $(this).find('i');
        
        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Password confirmation validation
    $('#kata_sandi_confirmation').on('input', function() {
        var password = $('#kata_sandi').val();
        var confirmPassword = $(this).val();
        var errorDiv = $('#passwordMatchError');
        
        if (password && confirmPassword && password !== confirmPassword) {
            $(this).addClass('is-invalid');
            errorDiv.show();
        } else {
            $(this).removeClass('is-invalid');
            errorDiv.hide();
        }
    });

    // Phone number formatting
    $('#telepon').on('input', function() {
        var value = $(this).val().replace(/\D/g, ''); // Remove non-digits
        
        // Ensure starts with 08
        if (value.length > 0 && !value.startsWith('08')) {
            if (value.startsWith('8')) {
                value = '0' + value;
            } else if (value.startsWith('62')) {
                value = '0' + value.substring(2);
            }
        }
        
        // Limit to reasonable length
        if (value.length > 15) {
            value = value.substring(0, 15);
        }
        
        $(this).val(value);
    });

    // Photo preview
    $('#foto').change(function() {
        var file = this.files[0];
        if (file) {
            // Check file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                $(this).val('');
                $('#previewCard').hide();
                return;
            }

            // Check file type
            var validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                alert('Format file tidak valid. Gunakan JPG, JPEG, PNG, atau GIF.');
                $(this).val('');
                $('#previewCard').hide();
                return;
            }

            var reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImage').attr('src', e.target.result);
                $('#previewCard').show();
            };
            reader.readAsDataURL(file);
        } else {
            $('#previewCard').hide();
        }
    });

    // Form validation
    $('#editPelangganForm').submit(function(e) {
        var password = $('#kata_sandi').val();
        var confirmPassword = $('#kata_sandi_confirmation').val();
        
        // Check password confirmation if password is provided
        if (password && password !== confirmPassword) {
            e.preventDefault();
            alert('Password dan konfirmasi password tidak cocok.');
            return false;
        }

        // Show loading state
        $(this).find('button[type="submit"]').prop('disabled', true).html(
            '<i class="fas fa-spinner fa-spin"></i> Menyimpan...'
        );
    });
});
</script>
@endpush

@endsection
