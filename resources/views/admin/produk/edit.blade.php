@extends('layouts.admin')

@section('page-title', 'Edit Produk')

@section('content')
<div class="product-form-container">
    <!-- Header Section -->
    <div class="page-header" data-aos="fade-down">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-edit me-3"></i>Edit Produk
                </h1>
                <p class="page-subtitle">Perbarui informasi produk: {{ $produk->nama_produk }}</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.produk.index') }}" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>                <a href="{{ route('admin.produk.show', $produk->id_produk) }}" class="btn btn-outline-info">
                    <i class="fas fa-eye me-2"></i>Lihat Detail
                </a>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row justify-content-center" data-aos="fade-up">
        <div class="col-lg-8">
            <div class="form-card">
                <div class="form-card-header">
                    <h3 class="form-title">
                        <i class="fas fa-info-circle me-2"></i>Edit Informasi Produk
                    </h3>
                    <div class="product-id-badge">ID: #{{ $produk->id_produk }}</div>
                </div>
                <div class="form-card-body">                    <form action="{{ route('admin.produk.update', $produk->id_produk) }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Debug Info -->
                        @if(config('app.debug'))
                            <div class="alert alert-info mb-3">
                                <small>
                                    Debug: Form Action: {{ route('admin.produk.update', $produk->id_produk) }}<br>
                                    Method: PUT<br>
                                    CSRF Token: {{ csrf_token() }}
                                </small>
                            </div>
                        @endif
                        
                        <div class="row g-4">                            <!-- Product Name -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" 
                                           id="nama_produk" name="nama_produk" placeholder="Nama Produk" 
                                           value="{{ old('nama_produk', $produk->nama_produk) }}" required>                                    <label for="nama_produk">
                                        <i class="fas fa-tag me-2"></i>Nama Produk
                                    </label>
                                    @error('nama_produk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Brand & Category -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select @error('merek') is-invalid @enderror" id="merek" name="merek" required>
                                        <option value="">Pilih Merek</option>
                                        <option value="Nike" {{ old('merek', $produk->merek) == 'Nike' ? 'selected' : '' }}>Nike</option>
                                        <option value="Adidas" {{ old('merek', $produk->merek) == 'Adidas' ? 'selected' : '' }}>Adidas</option>
                                        <option value="Puma" {{ old('merek', $produk->merek) == 'Puma' ? 'selected' : '' }}>Puma</option>
                                        <option value="Converse" {{ old('merek', $produk->merek) == 'Converse' ? 'selected' : '' }}>Converse</option>
                                        <option value="Vans" {{ old('merek', $produk->merek) == 'Vans' ? 'selected' : '' }}>Vans</option>
                                        <option value="New Balance" {{ old('merek', $produk->merek) == 'New Balance' ? 'selected' : '' }}>New Balance</option>
                                    </select>
                                    <label for="merek">
                                        <i class="fas fa-crown me-2"></i>Merek
                                    </label>
                                    @error('merek')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="Running" {{ old('kategori', $produk->kategori) == 'Running' ? 'selected' : '' }}>Running</option>
                                        <option value="Casual" {{ old('kategori', $produk->kategori) == 'Casual' ? 'selected' : '' }}>Casual</option>
                                        <option value="Formal" {{ old('kategori', $produk->kategori) == 'Formal' ? 'selected' : '' }}>Formal</option>
                                        <option value="Sport" {{ old('kategori', $produk->kategori) == 'Sport' ? 'selected' : '' }}>Sport</option>
                                        <option value="Sneakers" {{ old('kategori', $produk->kategori) == 'Sneakers' ? 'selected' : '' }}>Sneakers</option>
                                        <option value="Boots" {{ old('kategori', $produk->kategori) == 'Boots' ? 'selected' : '' }}>Boots</option>
                                    </select>
                                    <label for="kategori">
                                        <i class="fas fa-list me-2"></i>Kategori
                                    </label>
                                    @error('kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Price & Stock -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control @error('harga') is-invalid @enderror" 
                                           id="harga" name="harga" placeholder="Harga" 
                                           value="{{ old('harga', $produk->harga) }}" 
                                           min="0" step="0.01" required>
                                    <label for="harga">
                                        <i class="fas fa-money-bill me-2"></i>Harga (Rp)
                                    </label>
                                    @error('harga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control @error('stok') is-invalid @enderror" 
                                           id="stok" name="stok" placeholder="Stok" 
                                           value="{{ old('stok', $produk->stok) }}" 
                                           min="0" required>
                                    <label for="stok">
                                        <i class="fas fa-boxes me-2"></i>Stok
                                    </label>
                                    @error('stok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Size & Color -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('ukuran') is-invalid @enderror" 
                                           id="ukuran" name="ukuran" placeholder="Ukuran" 
                                           value="{{ old('ukuran', $produk->ukuran) }}" required>
                                    <label for="ukuran">
                                        <i class="fas fa-ruler me-2"></i>Ukuran (contoh: 40, 41, 42)
                                    </label>
                                    @error('ukuran')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('warna') is-invalid @enderror" 
                                           id="warna" name="warna" placeholder="Warna" 
                                           value="{{ old('warna', $produk->warna) }}" required>
                                    <label for="warna">
                                        <i class="fas fa-palette me-2"></i>Warna
                                    </label>
                                    @error('warna')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                              id="deskripsi" name="deskripsi" placeholder="Deskripsi" 
                                              style="height: 120px">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                                    <label for="deskripsi">
                                        <i class="fas fa-file-text me-2"></i>Deskripsi Produk
                                    </label>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Current Image Display -->
                            @if($produk->gambar)
                            <div class="col-12">
                                <div class="current-image-section">
                                    <label class="form-label">
                                        <i class="fas fa-image me-2"></i>Gambar Saat Ini
                                    </label>                                    <div class="current-image-wrapper">
                                        <img src="{{ $produk->image_url }}" alt="{{ $produk->nama_produk }}" class="current-image">
                                        <div class="image-overlay">
                                            <span class="change-text">Klik "Pilih File" untuk mengganti</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Image Upload -->
                            <div class="col-12">
                                <div class="image-upload-section">
                                    <label class="form-label">
                                        <i class="fas fa-upload me-2"></i>{{ $produk->gambar ? 'Ganti Gambar Produk' : 'Upload Gambar Produk' }}
                                    </label>
                                    <div class="image-upload-wrapper">
                                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" 
                                               id="gambar" name="gambar" accept="image/*" onchange="previewImage(this)">
                                        <div class="image-preview" id="imagePreview">
                                            <div class="preview-placeholder">
                                                <i class="fas fa-image"></i>
                                                <span>Pilih gambar baru untuk pratinjau</span>
                                            </div>
                                        </div>
                                    </div>
                                    @error('gambar')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Kosongkan jika tidak ingin mengubah gambar
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="col-12">
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary btn-submit">
                                        <i class="fas fa-save me-2"></i>Update Produk
                                    </button>
                                    <button type="reset" class="btn btn-outline-secondary btn-reset">
                                        <i class="fas fa-undo me-2"></i>Reset Form
                                    </button>
                                    <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                                        <i class="fas fa-trash me-2"></i>Hapus Produk
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>                    <!-- Delete Form (Hidden) -->
                    <form id="deleteForm" action="{{ route('admin.produk.destroy', $produk->id_produk) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.product-form-container {
    padding: 2rem 0;
}

.form-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: all 0.3s ease;
}

.form-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.form-card-header {
    background: linear-gradient(135deg, #28a745, #20c997);
    padding: 2rem;
    color: white;
    text-align: center;
    position: relative;
}

.form-title {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 600;
}

.product-id-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(255, 255, 255, 0.2);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
}

.form-card-body {
    padding: 2.5rem;
}

.current-image-section {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 1rem;
}

.current-image-wrapper {
    position: relative;
    display: inline-block;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
}

.current-image {
    max-width: 200px;
    max-height: 200px;
    object-fit: cover;
    display: block;
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.current-image-wrapper:hover .image-overlay {
    opacity: 1;
}

.change-text {
    color: white;
    font-size: 0.875rem;
    text-align: center;
    padding: 1rem;
}

.form-floating {
    position: relative;
    margin-bottom: 1rem;
}

.form-floating > .form-control,
.form-floating > .form-select {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 1rem 0.75rem 0.5rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-floating > .form-control:focus,
.form-floating > .form-select:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    transform: translateY(-2px);
}

.form-floating > label {
    padding: 1rem 0.75rem;
    color: #6c757d;
    font-weight: 500;
    transition: all 0.3s ease;
}

.image-upload-section {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 1.5rem;
    border: 2px dashed #dee2e6;
    transition: all 0.3s ease;
}

.image-upload-section:hover {
    border-color: #28a745;
    background: rgba(40, 167, 69, 0.05);
}

.image-upload-wrapper {
    position: relative;
}

.image-preview {
    margin-top: 1rem;
    border-radius: 12px;
    overflow: hidden;
    min-height: 200px;
    background: white;
    border: 2px solid #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
}

.preview-placeholder {
    text-align: center;
    color: #6c757d;
    font-size: 1.1rem;
}

.preview-placeholder i {
    font-size: 3rem;
    margin-bottom: 1rem;
    display: block;
}

#imagePreview img {
    max-width: 100%;
    max-height: 300px;
    object-fit: cover;
    border-radius: 8px;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    padding-top: 2rem;
    border-top: 1px solid #e9ecef;
    flex-wrap: wrap;
}

.btn-submit {
    background: linear-gradient(135deg, #28a745, #20c997);
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
}

.btn-reset, .btn-outline-danger {
    padding: 0.75rem 2rem;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-reset:hover, .btn-outline-danger:hover {
    transform: translateY(-2px);
}

.btn-outline-danger:hover {
    box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
}

.form-text {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.5rem;
}

.is-invalid {
    border-color: #dc3545 !important;
    animation: shake 0.5s ease-in-out;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: #dc3545;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Loading Animation */
.btn-submit.loading {
    pointer-events: none;
    position: relative;
    color: transparent;
}

.btn-submit.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 20px;
    height: 20px;
    border: 2px solid #ffffff;
    border-top: 2px solid transparent;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}
</style>

<script>
// Add CSRF token to meta tag if not exists
if (!document.querySelector('meta[name="csrf-token"]')) {
    const metaTag = document.createElement('meta');
    metaTag.name = 'csrf-token';
    metaTag.content = '{{ csrf_token() }}';
    document.head.appendChild(metaTag);
}

function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.innerHTML = `
            <div class="preview-placeholder">
                <i class="fas fa-image"></i>
                <span>Pilih gambar baru untuk pratinjau</span>
            </div>
        `;
    }
}

function confirmDelete() {
    if (confirm('Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.')) {
        document.getElementById('deleteForm').submit();
    }
}

document.getElementById('productForm').addEventListener('submit', function(e) {
    // Prevent double submission
    const submitBtn = document.querySelector('.btn-submit');
    if (submitBtn.classList.contains('loading')) {
        e.preventDefault();
        return false;
    }
    
    // Ensure form method is correct
    const methodInput = this.querySelector('input[name="_method"]');
    if (!methodInput || methodInput.value !== 'PUT') {
        console.error('Form method is not PUT:', methodInput ? methodInput.value : 'missing');
    }
    
    // Ensure CSRF token exists
    const csrfInput = this.querySelector('input[name="_token"]');
    if (!csrfInput) {
        console.error('CSRF token is missing');
    }
    
    submitBtn.classList.add('loading');
    
    // Disable submit button to prevent double submission
    submitBtn.disabled = true;
    
    // Don't disable all inputs, let form submit normally
    console.log('Form submitting to:', this.action, 'with method:', this.method);
});

// Real-time form validation
document.querySelectorAll('.form-control, .form-select').forEach(input => {
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
@endsection
