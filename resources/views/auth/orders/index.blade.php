@extends('layouts.app')

@section('title', 'Riwayat Pesanan - ShoeMart')

@section('content')
<div class="orders-history-container">
    <div class="container py-5">
        <!-- Page Header -->
        <div class="page-header text-center mb-5" data-aos="fade-down">
            <div class="breadcrumb-nav mb-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('auth.profile') }}">Profil</a></li>
                        <li class="breadcrumb-item active">Riwayat Pesanan</li>
                    </ol>
                </nav>
            </div>
            <h1 class="page-title">
                <i class="fas fa-history me-3"></i>Riwayat Pesanan
            </h1>
            <p class="page-subtitle">Lihat dan pantau semua pesanan Anda</p>
        </div>

        <!-- Customer Info -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="customer-info-card" data-aos="fade-up">
                    <div class="d-flex align-items-center">
                        <div class="customer-avatar me-3">
                            <i class="fas fa-user-circle fa-3x text-primary"></i>
                        </div>
                        <div class="customer-details flex-grow-1">
                            <h5 class="mb-1">{{ Auth::guard('customer')->user()->nama }}</h5>
                            <p class="text-muted mb-0">{{ Auth::guard('customer')->user()->email }}</p>
                        </div>
                        <div class="customer-actions">
                            <a href="{{ route('auth.profile') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-user-edit me-1"></i>Edit Profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        <div class="orders-list" data-aos="fade-up" data-aos-delay="200">
            @if($orders->count() > 0)
                @foreach($orders as $order)
                <div class="order-card mb-4">
                    <div class="order-header">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <div class="order-id">
                                    <h6 class="mb-1">#{{ $order->id_pesanan }}</h6>
                                    <small class="text-muted">{{ $order->tanggal_pesanan->format('d M Y') }}</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="order-status">
                                    <span class="status-badge status-{{ strtolower($order->status_pesanan) }}">
                                        @switch($order->status_pesanan)
                                            @case('pending')
                                                <i class="fas fa-clock me-1"></i>Menunggu
                                                @break
                                            @case('diproses')
                                                <i class="fas fa-cog me-1"></i>Diproses
                                                @break
                                            @case('dikirim')
                                                <i class="fas fa-truck me-1"></i>Dikirim
                                                @break
                                            @case('selesai')
                                                <i class="fas fa-check-circle me-1"></i>Selesai
                                                @break
                                            @case('dibatalkan')
                                                <i class="fas fa-times-circle me-1"></i>Dibatalkan
                                                @break
                                            @default
                                                {{ ucfirst($order->status_pesanan) }}
                                        @endswitch
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="order-total">
                                    <h6 class="mb-0">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</h6>
                                    <small class="text-muted">{{ $order->detailPesanan->sum('jumlah') }} item</small>
                                </div>
                            </div>
                            <div class="col-md-3 text-end">
                                <div class="order-actions">
                                    <a href="{{ route('auth.orders.detail', $order->id_pesanan) }}" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>Detail
                                    </a>
                                    @if($order->status_pesanan === 'dikirim' && $order->nomor_resi)
                                    <a href="{{ route('auth.orders.tracking', $order->id_pesanan) }}" 
                                       class="btn btn-outline-info btn-sm">
                                        <i class="fas fa-map-marker-alt me-1"></i>Lacak
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="order-body">
                        <div class="order-items">
                            @foreach($order->detailPesanan->take(3) as $item)
                            <div class="order-item">
                                <div class="d-flex align-items-center">
                                    <div class="item-image me-3">
                                        <img src="{{ $item->produk->image_url }}" alt="{{ $item->produk->nama_produk }}" class="product-thumb">
                                    </div>
                                    <div class="item-info flex-grow-1">
                                        <h6 class="item-name mb-1">{{ $item->produk->nama_produk }}</h6>
                                        <p class="item-details mb-0">
                                            <small class="text-muted">{{ $item->jumlah }}x - Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</small>
                                        </p>
                                    </div>
                                    <div class="item-total">
                                        <span class="fw-bold">Rp {{ number_format($item->harga_satuan * $item->jumlah, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                            @if($order->detailPesanan->count() > 3)
                            <div class="more-items text-center py-2">
                                <small class="text-muted">+{{ $order->detailPesanan->count() - 3 }} item lainnya</small>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Pagination -->
                @if($orders->hasPages())
                <div class="pagination-wrapper mt-5" data-aos="fade-up">
                    <div class="d-flex justify-content-center">
                        {{ $orders->links() }}
                    </div>
                </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="empty-state text-center py-5" data-aos="fade-up">
                    <div class="empty-icon mb-4">
                        <i class="fas fa-shopping-bag fa-4x text-muted"></i>
                    </div>
                    <h4 class="empty-title">Belum Ada Pesanan</h4>
                    <p class="empty-text text-muted mb-4">Anda belum memiliki riwayat pesanan. Mulai berbelanja sekarang!</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-cart me-2"></i>Mulai Belanja
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
.orders-history-container {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    position: relative;
}

.orders-history-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 300px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    z-index: 1;
}

.container {
    position: relative;
    z-index: 2;
}

.page-header {
    color: white;
    margin-bottom: 2rem;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
}

.breadcrumb {
    background: none;
    padding: 0;
}

.breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
}

.breadcrumb-item.active {
    color: white;
}

.customer-info-card {
    background: white;
    padding: 1.5rem;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.order-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.order-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.order-header {
    background: #f8f9fa;
    padding: 1.5rem;
    border-bottom: 1px solid #e9ecef;
}

.order-body {
    padding: 1.5rem;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.status-diproses {
    background: #d1ecf1;
    color: #0c5460;
}

.status-dikirim {
    background: #d4edda;
    color: #155724;
}

.status-selesai {
    background: #d1e7dd;
    color: #0f5132;
}

.status-dibatalkan {
    background: #f8d7da;
    color: #721c24;
}

.order-item {
    padding: 1rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.order-item:last-child {
    border-bottom: none;
}

.product-thumb {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
}

.item-name {
    font-size: 1rem;
    font-weight: 600;
    color: #333;
}

.empty-state {
    background: white;
    padding: 4rem 2rem;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.empty-icon {
    opacity: 0.5;
}

.empty-title {
    color: #333;
    margin-bottom: 1rem;
}

.empty-text {
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .order-card .row > div {
        text-align: center !important;
        margin-bottom: 1rem;
    }
    
    .order-actions {
        text-align: center !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Initialize AOS
AOS.init();
</script>
@endpush
@endsection
