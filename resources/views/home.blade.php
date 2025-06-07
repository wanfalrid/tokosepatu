@extends('layouts.app')

@section('title', 'ShoeMart - Toko Sepatu Premium Terlengkap')

@section('content')
<!-- Hero Section -->
<section class="hero-section position-relative overflow-hidden" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 80vh;">
    <div class="container h-100">
        <div class="row align-items-center h-100" style="min-height: 70vh;">
            <div class="col-lg-6" data-aos="fade-right">
                <h1 class="display-3 font-poppins text-white fw-bold mb-4">
                    Temukan Sepatu 
                    <span class="text-warning">Impian</span> Anda
                </h1>
                <p class="lead text-white-50 mb-4">
                    Koleksi sepatu premium dengan kualitas terbaik, desain terkini, dan harga terjangkau. 
                    Dari casual hingga formal, kami punya semuanya!
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('shop') }}" class="btn btn-warning btn-lg px-4 py-3 fw-semibold">
                        <i class="fas fa-shopping-bag me-2"></i>Belanja Sekarang
                    </a>
                    <a href="#featured-products" class="btn btn-outline-light btn-lg px-4 py-3 fw-semibold">
                        <i class="fas fa-arrow-down me-2"></i>Lihat Koleksi
                    </a>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <div class="hero-image text-center">
                    <img src="https://images.unsplash.com/photo-1549298916-b41d501d3772?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                         alt="Premium Shoes" 
                         class="img-fluid animate-pulse" 
                         style="max-height: 500px; filter: drop-shadow(0 20px 40px rgba(0,0,0,0.3));">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Floating Elements -->
    <div class="position-absolute" style="top: 20%; left: 10%; animation: float 3s ease-in-out infinite;">
        <div class="bg-white rounded-circle p-3 shadow" style="width: 60px; height: 60px;">
            <i class="fas fa-star text-warning fs-4"></i>
        </div>
    </div>
    <div class="position-absolute" style="top: 60%; right: 15%; animation: float 3s ease-in-out infinite 1s;">
        <div class="bg-white rounded-circle p-3 shadow" style="width: 80px; height: 80px;">
            <i class="fas fa-heart text-danger fs-3"></i>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="text-center p-4">
                    <div class="bg-primary rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-shipping-fast text-white fs-3"></i>
                    </div>
                    <h5 class="fw-bold">Gratis Ongkir</h5>
                    <p class="text-muted">Untuk pembelian minimal Rp 500.000</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="text-center p-4">
                    <div class="bg-success rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-medal text-white fs-3"></i>
                    </div>
                    <h5 class="fw-bold">Kualitas Premium</h5>
                    <p class="text-muted">Sepatu berkualitas tinggi dari brand ternama</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="text-center p-4">
                    <div class="bg-warning rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-undo text-white fs-3"></i>
                    </div>
                    <h5 class="fw-bold">Garansi Tukar</h5>
                    <p class="text-muted">30 hari garansi tukar jika tidak puas</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="text-center p-4">
                    <div class="bg-info rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-headset text-white fs-3"></i>
                    </div>
                    <h5 class="fw-bold">Customer Service</h5>
                    <p class="text-muted">Layanan pelanggan 24/7 siap membantu</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section id="featured-products" class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 font-poppins fw-bold mb-3">Produk Terbaru</h2>
            <p class="lead text-muted">Koleksi sepatu terbaru dengan desain modern dan kualitas premium</p>
        </div>
        
        <div class="row g-4">
            @forelse($produkTerbaru as $index => $produk)
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                <div class="card product-card h-100 border-0 shadow-sm">
                    <div class="position-relative overflow-hidden">
                        <img src="{{ $produk->gambar ?: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' }}" 
                             class="card-img-top" 
                             alt="{{ $produk->nama_produk }}"
                             style="height: 250px; object-fit: cover; transition: transform 0.3s ease;">
                        
                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-danger">Baru</span>
                        </div>
                        
                        <div class="product-overlay">
                            <button class="btn btn-primary btn-sm" onclick="addToCart('{{ $produk->id_produk }}')">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                            <a href="{{ route('produk.detail', $produk->id_produk) }}" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="card-title fw-bold mb-0">{{ $produk->nama_produk }}</h6>
                            <small class="text-muted">{{ $produk->merek }}</small>
                        </div>
                        <p class="text-primary fw-bold mb-2">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">Stok: {{ $produk->stok }}</small>
                            <div class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-warning"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada produk tersedia.</p>
            </div>
            @endforelse
        </div>
        
        @if($produkTerbaru->count() > 0)
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('shop') }}" class="btn btn-primary btn-lg px-5">
                <i class="fas fa-eye me-2"></i>Lihat Semua Produk
            </a>
        </div>
        @endif
    </div>
</section>

<!-- Popular Products Section -->
@if($produkPopuler->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 font-poppins fw-bold mb-3">Produk Populer</h2>
            <p class="lead text-muted">Sepatu pilihan yang paling banyak diminati pelanggan</p>
        </div>
        
        <div class="row g-4">
            @foreach($produkPopuler as $index => $produk)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                <div class="card product-card h-100 border-0 shadow">
                    <div class="position-relative overflow-hidden">
                        <img src="{{ $produk->gambar ?: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' }}" 
                             class="card-img-top" 
                             alt="{{ $produk->nama_produk }}"
                             style="height: 250px; object-fit: cover;">
                        
                        <div class="position-absolute top-0 start-0 m-2">
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-fire me-1"></i>Populer
                            </span>
                        </div>
                        
                        <div class="product-overlay">
                            <button class="btn btn-primary btn-sm" onclick="addToCart('{{ $produk->id_produk }}')">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                            <a href="{{ route('produk.detail', $produk->id_produk) }}" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="card-title fw-bold mb-0">{{ $produk->nama_produk }}</h6>
                            <small class="text-muted">{{ $produk->merek }}</small>
                        </div>
                        <p class="text-primary fw-bold mb-2">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">Stok: {{ $produk->stok }}</small>
                            <div class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-warning"></i>
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

<!-- Newsletter Section -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <h3 class="text-white font-poppins fw-bold mb-3">Dapatkan Update Terbaru</h3>
                <p class="text-white-50 mb-4">Jadilah yang pertama mengetahui produk baru, diskon, dan penawaran spesial dari ShoeMart</p>
                
                <form class="row g-2 justify-content-center">
                    <div class="col-md-6">
                        <input type="email" class="form-control form-control-lg" placeholder="Masukkan email Anda" required>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-warning btn-lg w-100">
                            <i class="fas fa-paper-plane me-2"></i>Subscribe
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    .product-card {
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-10px);
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

    .rating i {
        font-size: 0.8rem;
    }
</style>
@endpush
@endsection
