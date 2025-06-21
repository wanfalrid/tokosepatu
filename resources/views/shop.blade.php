@extends('layouts.app')

@section('title', 'Belanja Sepatu - ShoeMart')

@section('content')
<!-- Page Header -->
<section class="page-header py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center text-white">
                <h1 class="display-4 font-poppins fw-bold mb-3" data-aos="fade-up">Koleksi Sepatu Premium</h1>
                <p class="lead mb-0" data-aos="fade-up" data-aos-delay="100">Temukan sepatu impian Anda dari berbagai brand ternama</p>
            </div>
        </div>
    </div>
</section>

<!-- Filters Section -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('produk.search') }}" method="GET" class="filter-form">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Cari Produk</label>
                            <input type="text" 
                                   class="form-control" 
                                   name="q" 
                                   placeholder="Nama sepatu..." 
                                   value="{{ request('q') }}">
                        </div>
                        
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Merek</label>
                            <select class="form-select" name="merek">
                                <option value="">Semua Merek</option>
                                @if(isset($merek))
                                    @foreach($merek as $m)
                                        <option value="{{ $m->merek }}" {{ request('merek') == $m->merek ? 'selected' : '' }}>
                                            {{ $m->merek }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Harga Min</label>
                            <input type="number" 
                                   class="form-control" 
                                   name="harga_min" 
                                   placeholder="Rp 0" 
                                   value="{{ request('harga_min') }}">
                        </div>
                        
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Harga Max</label>
                            <input type="number" 
                                   class="form-control" 
                                   name="harga_max" 
                                   placeholder="Rp 999999999" 
                                   value="{{ request('harga_max') }}">
                        </div>
                        
                        <div class="col-md-3">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary flex-fill">
                                    <i class="fas fa-search me-2"></i>Filter
                                </button>
                                <a href="{{ route('shop') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-undo me-2"></i>Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="py-5">
    <div class="container">
        <!-- Results Info -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h5 class="mb-0" data-aos="fade-right">
                    Menampilkan {{ $produk->count() }} dari {{ $produk->total() }} produk
                    @if(request('q'))
                        untuk "<strong>{{ request('q') }}</strong>"
                    @endif
                </h5>
            </div>
            <div class="col-md-6 text-md-end" data-aos="fade-left">
                <div class="d-flex justify-content-md-end align-items-center gap-3">
                    <label class="form-label mb-0 fw-semibold">Urutkan:</label>
                    <select class="form-select" style="width: auto;" onchange="sortProducts(this.value)">
                        <option value="terbaru">Terbaru</option>
                        <option value="harga_rendah">Harga Terendah</option>
                        <option value="harga_tinggi">Harga Tertinggi</option>
                        <option value="nama">Nama A-Z</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Products Grid -->
        @if($produk->count() > 0)
        <div class="row g-4" id="products-grid">
            @foreach($produk as $index => $item)
            <div class="col-lg-3 col-md-6 product-item" data-aos="fade-up" data-aos-delay="{{ ($index % 4 + 1) * 100 }}">
                <div class="card product-card h-100 border-0 shadow-sm">
                    <div class="position-relative overflow-hidden">
                        <img src="{{ $item->gambar ?: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' }}" 
                             class="card-img-top" 
                             alt="{{ $item->nama_produk }}"
                             style="height: 250px; object-fit: cover;">
                        
                        <!-- Stock Badge -->
                        @if($item->stok <= 5 && $item->stok > 0)
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge bg-warning text-dark">Stok Terbatas!</span>
                            </div>
                        @elseif($item->stok == 0)
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge bg-danger">Habis</span>
                            </div>
                        @endif
                        
                        <!-- Product Overlay -->
                        <div class="product-overlay">
                            @if($item->stok > 0)
                                <button class="btn btn-primary btn-sm" onclick="addToCart('{{ $item->id_produk }}')">
                                    <i class="fas fa-cart-plus me-1"></i>Keranjang
                                </button>
                            @endif
                            <a href="{{ route('produk.detail', $item->id_produk) }}" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-eye me-1"></i>Detail
                            </a>
                        </div>
                        
                        <!-- Wishlist Button -->
                        <button class="btn btn-light btn-sm position-absolute top-0 end-0 m-2 wishlist-btn" data-id="{{ $item->id_produk }}">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                    
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="card-title fw-bold mb-0 text-truncate">{{ $item->nama_produk }}</h6>
                            <small class="text-muted ms-2">{{ $item->merek }}</small>
                        </div>
                        
                        <p class="text-primary fw-bold fs-5 mb-2">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                        
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <small class="text-muted d-block">
                                    <i class="fas fa-box me-1"></i>Stok: {{ $item->stok }}
                                </small>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">
                                    <i class="fas fa-palette me-1"></i>{{ $item->warna }}
                                </small>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-warning" style="font-size: 0.8rem;"></i>
                                @endfor
                                <small class="text-muted ms-1">(4.8)</small>
                            </div>
                            
                            @if($item->stok > 0)
                                <button class="btn btn-outline-primary btn-sm" onclick="addToCart('{{ $item->id_produk }}')">
                                    <i class="fas fa-plus"></i>
                                </button>
                            @else
                                <span class="badge bg-secondary">Habis</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($produk->hasPages())
        <div class="row mt-5">
            <div class="col-12">
                <nav aria-label="Products pagination" data-aos="fade-up">
                    {{ $produk->withQueryString()->links('pagination::bootstrap-4') }}
                </nav>
            </div>
        </div>
        @endif
        
        @else
        <!-- No Products Found -->
        <div class="row">
            <div class="col-12 text-center py-5" data-aos="fade-up">
                <div class="mb-4">
                    <i class="fas fa-search text-muted" style="font-size: 4rem;"></i>
                </div>
                <h4 class="fw-bold mb-3">Produk Tidak Ditemukan</h4>
                <p class="text-muted mb-4">Maaf, tidak ada produk yang sesuai dengan kriteria pencarian Anda.</p>
                <a href="{{ route('shop') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Semua Produk
                </a>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Quick Add to Cart Modal -->
<div class="modal fade" id="quickAddModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah ke Keranjang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-check-circle text-success mb-3" style="font-size: 3rem;"></i>
                <h6 class="fw-bold mb-2">Produk berhasil ditambahkan!</h6>
                <p class="text-muted mb-4">Produk telah ditambahkan ke keranjang belanja Anda.</p>
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Lanjut Belanja</button>
                    <a href="{{ route('cart.index') }}" class="btn btn-primary">Lihat Keranjang</a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .product-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
    }

    .product-card .card-img-top {
        transition: transform 0.3s ease;
    }

    .product-card:hover .card-img-top {
        transform: scale(1.1);
    }

    .product-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.8) 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .product-card:hover .product-overlay {
        opacity: 1;
    }

    .wishlist-btn {
        border-radius: 50%;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .wishlist-btn:hover {
        background: var(--accent-color) !important;
        color: white !important;
    }

    .wishlist-btn.active {
        background: var(--accent-color) !important;
        color: white !important;
    }

    .wishlist-btn.active i {
        transform: scale(1.2);
    }

    .filter-form {
        background: white;
        padding: 1.5rem;
        border-radius: var(--border-radius);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .rating i {
        font-size: 0.8rem;
    }

    /* Loading State */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
    }

    /* Animation for new products */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .product-item.new {
        animation: slideInUp 0.5s ease-out;
    }
</style>
@endpush

@push('scripts')
<script>
    // Sort products
    function sortProducts(sortBy) {
        const url = new URL(window.location);
        url.searchParams.set('sort', sortBy);
        window.location = url;
    }

    // Wishlist functionality
    $(document).on('click', '.wishlist-btn', function(e) {
        e.stopPropagation();
        const btn = $(this);
        const productId = btn.data('id');
        
        btn.toggleClass('active');
        
        if (btn.hasClass('active')) {
            btn.find('i').removeClass('far').addClass('fas');
            // Add to wishlist logic here
        } else {
            btn.find('i').removeClass('fas').addClass('far');
            // Remove from wishlist logic here
        }
    });

    // Enhanced add to cart with modal
    function addToCart(idProduk) {
        $.ajax({
            url: '{{ route("cart.add") }}',
            method: 'POST',
            data: {
                id_produk: idProduk
            },
            beforeSend: function() {
                $(`button[onclick="addToCart('${idProduk}')"]`).prop('disabled', true)
                    .html('<div class="spinner-border spinner-border-sm me-1"></div>Loading...');
            },
            success: function(response) {
                if (response.success) {
                    $('#cart-count').text(response.cart_count);
                    $('#quickAddModal').modal('show');
                    
                    // Reset button
                    $(`button[onclick="addToCart('${idProduk}')"]`).prop('disabled', false)
                        .html('<i class="fas fa-cart-plus me-1"></i>Keranjang');
                }
            },
            error: function() {
                alert('Terjadi kesalahan. Silakan coba lagi.');
                $(`button[onclick="addToCart('${idProduk}')"]`).prop('disabled', false)
                    .html('<i class="fas fa-cart-plus me-1"></i>Keranjang');
            }
        });
    }

    // Filter form auto-submit on select change
    $('.filter-form select').on('change', function() {
        $(this).closest('form').submit();
    });

    // Smooth scroll for pagination
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        
        $('html, body').animate({
            scrollTop: $('#products-grid').offset().top - 100
        }, 500);
        
        setTimeout(() => {
            window.location = url;
        }, 500);
    });
</script>
@endpush
@endsection