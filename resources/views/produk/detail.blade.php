@extends('layouts.app')

@section('title', $produk->nama_produk . ' - ShoeMart')

@section('content')
<!-- Product Detail Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Product Images -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="product-gallery">
                    <div class="main-image mb-3">
                        <img src="{{ $produk->gambar ?: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}" 
                             class="img-fluid rounded-3 shadow-lg" 
                             alt="{{ $produk->nama_produk }}"
                             id="mainProductImage"
                             style="width: 100%; height: 500px; object-fit: cover;">
                    </div>
                    
                    <!-- Thumbnail Images -->
                    <div class="thumbnail-images d-flex gap-2">
                        <img src="{{ $produk->gambar ?: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80' }}" 
                             class="img-thumbnail thumbnail-img active" 
                             style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                             onclick="changeMainImage(this.src)">
                        <img src="https://images.unsplash.com/photo-1549298916-b41d501d3772?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" 
                             class="img-thumbnail thumbnail-img" 
                             style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                             onclick="changeMainImage(this.src)">
                        <img src="https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" 
                             class="img-thumbnail thumbnail-img" 
                             style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                             onclick="changeMainImage(this.src)">
                        <img src="https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" 
                             class="img-thumbnail thumbnail-img" 
                             style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                             onclick="changeMainImage(this.src)">
                    </div>
                </div>
            </div>
            
            <!-- Product Info -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="product-info">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('shop') }}" class="text-decoration-none">Produk</a></li>
                            <li class="breadcrumb-item active">{{ $produk->nama_produk }}</li>
                        </ol>
                    </nav>
                    
                    <!-- Product Title & Brand -->
                    <div class="mb-3">
                        <span class="badge bg-primary mb-2">{{ $produk->merek }}</span>
                        <h1 class="display-6 font-poppins fw-bold mb-2">{{ $produk->nama_produk }}</h1>
                        
                        <!-- Rating -->
                        <div class="d-flex align-items-center mb-3">
                            <div class="rating me-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-warning"></i>
                                @endfor
                            </div>
                            <span class="text-muted">(4.8/5 dari 124 review)</span>
                        </div>
                    </div>
                    
                    <!-- Price -->
                    <div class="price-section mb-4">
                        <h2 class="text-primary fw-bold mb-2">Rp {{ number_format($produk->harga, 0, ',', '.') }}</h2>
                        <p class="text-muted mb-0">Harga sudah termasuk PPN</p>
                    </div>
                    
                    <!-- Product Details -->
                    <div class="product-details mb-4">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="detail-item p-3 bg-light rounded-3">
                                    <i class="fas fa-box text-primary mb-2"></i>
                                    <h6 class="fw-bold mb-1">Stok Tersedia</h6>
                                    <p class="mb-0 text-muted">{{ $produk->stok }} unit</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item p-3 bg-light rounded-3">
                                    <i class="fas fa-palette text-primary mb-2"></i>
                                    <h6 class="fw-bold mb-1">Warna</h6>
                                    <p class="mb-0 text-muted">{{ $produk->warna ?: 'Multi Color' }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item p-3 bg-light rounded-3">
                                    <i class="fas fa-ruler text-primary mb-2"></i>
                                    <h6 class="fw-bold mb-1">Ukuran</h6>
                                    <p class="mb-0 text-muted">{{ $produk->ukuran ?: '38-44' }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item p-3 bg-light rounded-3">
                                    <i class="fas fa-shipping-fast text-primary mb-2"></i>
                                    <h6 class="fw-bold mb-1">Pengiriman</h6>
                                    <p class="mb-0 text-muted">1-3 hari kerja</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Size Selection -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Pilih Ukuran:</h6>
                        <div class="size-options d-flex flex-wrap gap-2">
                            @php
                                $sizes = ['38', '39', '40', '41', '42', '43', '44'];
                            @endphp
                            @foreach($sizes as $size)
                            <button class="btn btn-outline-primary size-btn" data-size="{{ $size }}">
                                {{ $size }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Quantity & Add to Cart -->
                    <div class="mb-4">
                        <div class="row g-3">
                            <div class="col-4">
                                <label class="form-label fw-bold">Jumlah:</label>
                                <div class="input-group">
                                    <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity()">-</button>
                                    <input type="number" class="form-control text-center" id="quantity" value="1" min="1" max="{{ $produk->stok }}">
                                    <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity()">+</button>
                                </div>
                            </div>
                            <div class="col-8">
                                <label class="form-label fw-bold">&nbsp;</label>
                                @if($produk->stok > 0)
                                <button class="btn btn-primary btn-lg w-100" onclick="addToCartWithQuantity()">
                                    <i class="fas fa-cart-plus me-2"></i>Tambah ke Keranjang
                                </button>
                                @else
                                <button class="btn btn-secondary btn-lg w-100" disabled>
                                    <i class="fas fa-times me-2"></i>Stok Habis
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="action-buttons d-flex gap-2 mb-4">
                        <button class="btn btn-outline-danger btn-lg flex-fill">
                            <i class="fas fa-heart me-2"></i>Wishlist
                        </button>
                        <button class="btn btn-outline-info btn-lg flex-fill">
                            <i class="fas fa-share-alt me-2"></i>Bagikan
                        </button>
                    </div>
                    
                    <!-- Features -->
                    <div class="features">
                        <div class="row g-2 text-center">
                            <div class="col-4">
                                <i class="fas fa-shield-alt text-success mb-2 d-block"></i>
                                <small class="fw-semibold">Garansi Resmi</small>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-undo text-warning mb-2 d-block"></i>
                                <small class="fw-semibold">30 Hari Tukar</small>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-truck text-info mb-2 d-block"></i>
                                <small class="fw-semibold">Gratis Ongkir</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Product Description -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-tabs mb-4" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">
                            Deskripsi
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab">
                            Spesifikasi
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">
                            Review (124)
                        </button>
                    </li>
                </ul>
                
                <div class="tab-content" id="productTabsContent">
                    <!-- Description Tab -->
                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                        <div class="bg-white p-4 rounded-3 shadow-sm">
                            <h5 class="fw-bold mb-3">Tentang Produk</h5>
                            <p class="text-muted mb-4">
                                {{ $produk->deskripsi ?: 'Sepatu berkualitas premium dengan desain modern dan kenyamanan maksimal. Dibuat dengan material terbaik dan teknologi terdepan untuk mendukung aktivitas harian Anda. Cocok untuk berbagai kesempatan, mulai dari olahraga hingga aktivitas kasual.' }}
                            </p>
                            
                            <h6 class="fw-bold mb-3">Keunggulan Produk:</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Material berkualitas tinggi dan tahan lama</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Desain ergonomis untuk kenyamanan maksimal</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Sol anti-slip untuk keamanan ekstra</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Cocok untuk berbagai aktivitas</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Mudah dibersihkan dan dirawat</li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Specifications Tab -->
                    <div class="tab-pane fade" id="specifications" role="tabpanel">
                        <div class="bg-white p-4 rounded-3 shadow-sm">
                            <h5 class="fw-bold mb-3">Spesifikasi Produk</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <td class="fw-bold">Merek</td>
                                            <td>{{ $produk->merek }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Nama Produk</td>
                                            <td>{{ $produk->nama_produk }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Warna</td>
                                            <td>{{ $produk->warna ?: 'Multi Color' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Ukuran Tersedia</td>
                                            <td>{{ $produk->ukuran ?: '38-44' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Material Upper</td>
                                            <td>Synthetic Leather & Mesh</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Material Sol</td>
                                            <td>Rubber Outsole</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Berat</td>
                                            <td>±350 gram</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Kondisi</td>
                                            <td>Baru</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Reviews Tab -->
                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                        <div class="bg-white p-4 rounded-3 shadow-sm">
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <h2 class="display-4 fw-bold text-primary">4.8</h2>
                                        <div class="rating mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star text-warning fs-5"></i>
                                            @endfor
                                        </div>
                                        <p class="text-muted">124 Review</p>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <!-- Rating Bars -->
                                    @for($i = 5; $i >= 1; $i--)
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="me-2">{{ $i }} <i class="fas fa-star text-warning"></i></span>
                                        <div class="progress flex-fill me-2" style="height: 8px;">
                                            <div class="progress-bar bg-warning" style="width: {{ $i == 5 ? '70' : ($i == 4 ? '20' : '5') }}%"></div>
                                        </div>
                                        <span class="text-muted">{{ $i == 5 ? '87' : ($i == 4 ? '25' : '6') }}</span>
                                    </div>
                                    @endfor
                                </div>
                            </div>
                            
                            <!-- Sample Reviews -->
                            <div class="reviews-list">
                                @for($i = 1; $i <= 3; $i++)
                                <div class="review-item border-bottom pb-3 mb-3">
                                    <div class="d-flex align-items-start">
                                        <div class="avatar bg-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <span class="text-white fw-bold">{{ chr(64 + $i) }}</span>
                                        </div>
                                        <div class="flex-fill">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h6 class="fw-bold mb-1">User{{ $i }}</h6>
                                                    <div class="rating">
                                                        @for($j = 1; $j <= 5; $j++)
                                                            <i class="fas fa-star text-warning"></i>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <small class="text-muted">{{ $i }} hari yang lalu</small>
                                            </div>
                                            <p class="text-muted mb-0">
                                                @if($i == 1)
                                                    Sepatu yang sangat nyaman dan berkualitas! Material premium dan desain yang keren. Highly recommended!
                                                @elseif($i == 2)
                                                    Pengiriman cepat, kualitas sesuai ekspektasi. Sol empuk dan pas di kaki. Worth it banget!
                                                @else
                                                    Sudah beli beberapa kali di sini, selalu puas dengan kualitas dan pelayanannya. Keep it up!
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
@if($produkTerkait->count() > 0)
<section class="py-5">
    <div class="container">
        <h3 class="font-poppins fw-bold mb-4 text-center" data-aos="fade-up">Produk Terkait</h3>
        <div class="row g-4">
            @foreach($produkTerkait as $item)
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card product-card h-100 border-0 shadow-sm">
                    <div class="position-relative overflow-hidden">
                        <img src="{{ $item->gambar ?: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' }}" 
                             class="card-img-top" 
                             alt="{{ $item->nama_produk }}"
                             style="height: 200px; object-fit: cover;">
                        
                        <div class="product-overlay">
                            <button class="btn btn-primary btn-sm" onclick="addToCart('{{ $item->id_produk }}')">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                            <a href="{{ route('produk.detail', $item->id_produk) }}" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <h6 class="card-title fw-bold mb-2">{{ $item->nama_produk }}</h6>
                        <p class="text-primary fw-bold mb-2">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">{{ $item->merek }}</small>
                            <div class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-warning" style="font-size: 0.8rem;"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@push('styles')
<style>
    .thumbnail-img {
        transition: all 0.3s ease;
        opacity: 0.7;
    }

    .thumbnail-img.active,
    .thumbnail-img:hover {
        opacity: 1;
        border-color: var(--primary-color) !important;
    }

    .size-btn {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .size-btn.active {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }

    .product-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .product-card:hover .product-overlay {
        opacity: 1;
    }

    .product-card:hover {
        transform: translateY(-5px);
    }

    .rating i {
        font-size: 1rem;
    }

    #mainProductImage {
        transition: transform 0.3s ease;
    }

    #mainProductImage:hover {
        transform: scale(1.05);
    }

    .detail-item {
        text-align: center;
        transition: all 0.3s ease;
    }

    .detail-item:hover {
        background: var(--secondary-color) !important;
        color: white;
    }

    .detail-item:hover i {
        color: white !important;
    }
</style>
@endpush

@push('scripts')
<script>
    let selectedSize = null;
    
    // Change main product image
    function changeMainImage(src) {
        $('#mainProductImage').attr('src', src);
        $('.thumbnail-img').removeClass('active');
        $(`img[src="${src}"]`).addClass('active');
    }
    
    // Size selection
    $('.size-btn').on('click', function() {
        $('.size-btn').removeClass('active');
        $(this).addClass('active');
        selectedSize = $(this).data('size');
    });
    
    // Quantity controls
    function increaseQuantity() {
        const input = $('#quantity');
        const max = parseInt(input.attr('max'));
        const current = parseInt(input.val());
        if (current < max) {
            input.val(current + 1);
        }
    }
    
    function decreaseQuantity() {
        const input = $('#quantity');
        const current = parseInt(input.val());
        if (current > 1) {
            input.val(current - 1);
        }
    }
    
    // Add to cart with quantity and size
    function addToCartWithQuantity() {
        const quantity = $('#quantity').val();
        
        if (!selectedSize) {
            alert('Silakan pilih ukuran terlebih dahulu!');
            return;
        }
        
        $.ajax({
            url: '{{ route("cart.add") }}',
            method: 'POST',
            data: {
                id_produk: '{{ $produk->id_produk }}',
                quantity: quantity,
                size: selectedSize
            },
            beforeSend: function() {
                $('button[onclick="addToCartWithQuantity()"]').prop('disabled', true)
                    .html('<div class="spinner-border spinner-border-sm me-2"></div>Menambahkan...');
            },
            success: function(response) {
                if (response.success) {
                    $('#cart-count').text(response.cart_count);
                    
                    // Show success toast
                    const toast = `
                        <div class="toast position-fixed top-0 end-0 m-3" role="alert" style="z-index: 9999;">
                            <div class="toast-header bg-success text-white">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong class="me-auto">Berhasil!</strong>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                            </div>
                            <div class="toast-body">
                                ${quantity} item berhasil ditambahkan ke keranjang (Ukuran: ${selectedSize})
                            </div>
                        </div>
                    `;
                    
                    $('body').append(toast);
                    $('.toast').toast('show');
                    $('.toast').on('hidden.bs.toast', function() {
                        $(this).remove();
                    });
                    
                    // Reset button
                    $('button[onclick="addToCartWithQuantity()"]').prop('disabled', false)
                        .html('<i class="fas fa-cart-plus me-2"></i>Tambah ke Keranjang');
                }
            },
            error: function() {
                alert('Terjadi kesalahan. Silakan coba lagi.');
                $('button[onclick="addToCartWithQuantity()"]').prop('disabled', false)
                    .html('<i class="fas fa-cart-plus me-2"></i>Tambah ke Keranjang');
            }
        });
    }
</script>
@endpush
@endsection
