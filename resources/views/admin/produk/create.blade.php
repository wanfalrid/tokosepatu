@extends('layouts.admin')

@section('page-title', 'Tambah Produk')

@section('content')
<div class="product-form-container">
    <!-- Header Section -->
    <div class="page-header" data-aos="fade-down">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-plus-circle me-3"></i>Tambah Produk Baru
                </h1>
                <p class="page-subtitle">Tambahkan produk sepatu baru ke dalam inventori</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.produk.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
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
                        <i class="fas fa-info-circle me-2"></i>Informasi Produk
                    </h3>
                </div>
                <div class="form-card-body">
                    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf
                        
                        <div class="row g-4">
                            <!-- Product Name -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                           id="nama" name="nama" placeholder="Nama Produk" value="{{ old('nama') }}" required>
                                    <label for="nama">
                                        <i class="fas fa-tag me-2"></i>Nama Produk
                                    </label>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Brand & Category -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select @error('merek') is-invalid @enderror" id="merek" name="merek" required>
                                        <option value="">Pilih Merek</option>
                                        <option value="Nike" {{ old('merek') == 'Nike' ? 'selected' : '' }}>Nike</option>
                                        <option value="Adidas" {{ old('merek') == 'Adidas' ? 'selected' : '' }}>Adidas</option>
                                        <option value="Puma" {{ old('merek') == 'Puma' ? 'selected' : '' }}>Puma</option>
                                        <option value="Converse" {{ old('merek') == 'Converse' ? 'selected' : '' }}>Converse</option>
                                        <option value="Vans" {{ old('merek') == 'Vans' ? 'selected' : '' }}>Vans</option>
                                        <option value="New Balance" {{ old('merek') == 'New Balance' ? 'selected' : '' }}>New Balance</option>
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
                                        <option value="Running" {{ old('kategori') == 'Running' ? 'selected' : '' }}>Running</option>
                                        <option value="Casual" {{ old('kategori') == 'Casual' ? 'selected' : '' }}>Casual</option>
                                        <option value="Formal" {{ old('kategori') == 'Formal' ? 'selected' : '' }}>Formal</option>
                                        <option value="Sport" {{ old('kategori') == 'Sport' ? 'selected' : '' }}>Sport</option>
                                        <option value="Sneakers" {{ old('kategori') == 'Sneakers' ? 'selected' : '' }}>Sneakers</option>
                                        <option value="Boots" {{ old('kategori') == 'Boots' ? 'selected' : '' }}>Boots</option>
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
                                           id="harga" name="harga" placeholder="Harga" value="{{ old('harga') }}" 
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
                                           id="stok" name="stok" placeholder="Stok" value="{{ old('stok') }}" 
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
                                           id="ukuran" name="ukuran" placeholder="Ukuran" value="{{ old('ukuran') }}" 
                                           required>
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
                                           id="warna" name="warna" placeholder="Warna" value="{{ old('warna') }}" 
                                           required>
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
                                              style="height: 120px">{{ old('deskripsi') }}</textarea>
                                    <label for="deskripsi">
                                        <i class="fas fa-file-text me-2"></i>Deskripsi Produk
                                    </label>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Image Upload -->
                            <div class="col-12">
                                <div class="image-upload-section">
                                    <label class="form-label">
                                        <i class="fas fa-image me-2"></i>Gambar Produk
                                    </label>
                                    <div class="image-upload-wrapper">
                                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" 
                                               id="gambar" name="gambar" accept="image/*" onchange="previewImage(this)">
                                        <div class="image-preview" id="imagePreview">
                                            <div class="preview-placeholder">
                                                <i class="fas fa-image"></i>
                                                <span>Pilih gambar untuk pratinjau</span>
                                            </div>
                                        </div>
                                    </div>
                                    @error('gambar')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="col-12">
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary btn-submit">
                                        <i class="fas fa-save me-2"></i>Simpan Produk
                                    </button>
                                    <button type="reset" class="btn btn-outline-secondary btn-reset">
                                        <i class="fas fa-undo me-2"></i>Reset Form
                                    </button>
                                </div>
                            </div>
                        </div>
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
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    padding: 2rem;
    color: white;
    text-align: center;
}

.form-title {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 600;
}

.form-card-body {
    padding: 2.5rem;
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
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
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
    border-color: var(--primary-color);
    background: rgba(0, 123, 255, 0.05);
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
}

.btn-submit {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
}

.btn-reset {
    padding: 0.75rem 2rem;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-reset:hover {
    transform: translateY(-2px);
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
                <span>Pilih gambar untuk pratinjau</span>
            </div>
        `;
    }
}

document.getElementById('productForm').addEventListener('submit', function(e) {
    const submitBtn = document.querySelector('.btn-submit');
    submitBtn.classList.add('loading');
    
    // Disable all form inputs
    const inputs = this.querySelectorAll('input, select, textarea, button');
    inputs.forEach(input => input.disabled = true);
});

// Auto-format price input
document.getElementById('harga').addEventListener('input', function(e) {
    let value = e.target.value.replace(/[^\d]/g, '');
    if (value) {
        e.target.value = parseInt(value).toLocaleString('id-ID');
    }
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
