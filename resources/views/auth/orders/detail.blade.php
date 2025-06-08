@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->id_pesanan . ' - ShoeMart')

@section('content')
<div class="order-detail-container">
    <div class="container py-5">
        <!-- Page Header -->
        <div class="page-header text-center mb-5" data-aos="fade-down">
            <div class="breadcrumb-nav mb-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('auth.profile') }}">Profil</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('auth.orders') }}">Riwayat Pesanan</a></li>
                        <li class="breadcrumb-item active">Detail Pesanan</li>
                    </ol>
                </nav>
            </div>
            <h1 class="page-title">
                <i class="fas fa-receipt me-3"></i>Detail Pesanan #{{ $order->id_pesanan }}
            </h1>
            <p class="page-subtitle">Informasi lengkap pesanan Anda</p>
        </div>

        <div class="row">
            <!-- Order Summary -->
            <div class="col-lg-8">
                <!-- Order Status Card -->
                <div class="order-status-card mb-4" data-aos="fade-up">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-info-circle me-2"></i>Status Pesanan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="status-info">
                                    <span class="status-badge status-{{ strtolower($order->status_pesanan) }}">
                                        @switch($order->status_pesanan)
                                            @case('pending')
                                                <i class="fas fa-clock me-1"></i>Menunggu Konfirmasi
                                                @break
                                            @case('diproses')
                                                <i class="fas fa-cog me-1"></i>Sedang Diproses
                                                @break
                                            @case('dikirim')
                                                <i class="fas fa-truck me-1"></i>Dalam Pengiriman
                                                @break
                                            @case('selesai')
                                                <i class="fas fa-check-circle me-1"></i>Pesanan Selesai
                                                @break
                                            @case('dibatalkan')
                                                <i class="fas fa-times-circle me-1"></i>Pesanan Dibatalkan
                                                @break
                                        @endswitch
                                    </span>
                                    <p class="status-description mt-2 mb-0">
                                        @switch($order->status_pesanan)
                                            @case('pending')
                                                Pesanan Anda sedang menunggu konfirmasi dari admin.
                                                @break
                                            @case('diproses')
                                                Pesanan Anda sedang diproses dan akan segera dikirim.
                                                @break
                                            @case('dikirim')
                                                Pesanan Anda sedang dalam perjalanan ke alamat tujuan.
                                                @break
                                            @case('selesai')
                                                Pesanan Anda telah berhasil diselesaikan.
                                                @break
                                            @case('dibatalkan')
                                                Pesanan Anda telah dibatalkan.
                                                @break
                                        @endswitch
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="order-actions">
                                    @if($order->status_pesanan === 'dikirim' && $order->nomor_resi)
                                    <a href="{{ route('auth.orders.tracking', $order->id_pesanan) }}" 
                                       class="btn btn-primary">
                                        <i class="fas fa-map-marker-alt me-2"></i>Lacak Pesanan
                                    </a>
                                    @endif
                                    @if($order->status_pesanan === 'selesai')
                                    <button class="btn btn-success" disabled>
                                        <i class="fas fa-check me-2"></i>Pesanan Selesai
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="order-items-card mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-shopping-bag me-2"></i>Item Pesanan
                        </h5>
                    </div>
                    <div class="card-body">
                        @foreach($order->detailPesanan as $item)
                        <div class="order-item">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <div class="product-image">
                                        <img src="{{ $item->produk->gambar }}" alt="{{ $item->produk->nama_produk }}" class="product-thumb">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="product-info">
                                        <h6 class="product-name">{{ $item->produk->nama_produk }}</h6>
                                        <p class="product-details">
                                            <small class="text-muted">{{ $item->produk->merek }} • {{ $item->produk->warna }}</small>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <div class="item-quantity">
                                        <span class="quantity-badge">{{ $item->jumlah }}x</span>
                                    </div>
                                </div>
                                <div class="col-md-1.5 text-center">
                                    <div class="item-price">
                                        <span class="price">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-1.5 text-end">
                                    <div class="item-total">
                                        <span class="total-price">Rp {{ number_format($item->harga_satuan * $item->jumlah, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Order Info Sidebar -->
            <div class="col-lg-4">
                <!-- Order Summary -->
                <div class="order-summary-card mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-calculator me-2"></i>Ringkasan Pesanan
                        </h5>
                    </div>
                    <div class="card-body">
                        @php
                            $subtotal = $order->detailPesanan->sum(function($item) {
                                return $item->harga_satuan * $item->jumlah;
                            });
                            $tax = $subtotal * 0.11;
                            $shipping = 0;
                            $total = $order->total_harga;
                        @endphp
                        
                        <div class="summary-row">
                            <span class="summary-label">Subtotal</span>
                            <span class="summary-value">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Pajak (11%)</span>
                            <span class="summary-value">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Ongkos Kirim</span>
                            <span class="summary-value">Gratis</span>
                        </div>
                        <hr>
                        <div class="summary-row total-row">
                            <span class="summary-label">Total</span>
                            <span class="summary-value">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Order Details -->
                <div class="order-details-card mb-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-info me-2"></i>Informasi Pesanan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="detail-item">
                            <span class="detail-label">ID Pesanan</span>
                            <span class="detail-value">#{{ $order->id_pesanan }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Tanggal Pesanan</span>
                            <span class="detail-value">{{ $order->tanggal_pesanan->format('d M Y H:i') }}</span>
                        </div>
                        @if($order->nomor_resi)
                        <div class="detail-item">
                            <span class="detail-label">Nomor Resi</span>
                            <span class="detail-value">{{ $order->nomor_resi }}</span>
                        </div>
                        @endif
                        @if($order->estimasi_selesai)
                        <div class="detail-item">
                            <span class="detail-label">Estimasi Selesai</span>
                            <span class="detail-value">{{ $order->estimasi_selesai->format('d M Y') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Payment Info -->
                @if($order->pembayaran)
                <div class="payment-info-card" data-aos="fade-up" data-aos-delay="500">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-credit-card me-2"></i>Informasi Pembayaran
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="detail-item">
                            <span class="detail-label">Metode Pembayaran</span>
                            <span class="detail-value">{{ ucfirst($order->pembayaran->metode_pembayaran ?? 'N/A') }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Status Pembayaran</span>
                            <span class="payment-status payment-{{ strtolower($order->pembayaran->status_pembayaran ?? 'pending') }}">
                                {{ ucfirst($order->pembayaran->status_pembayaran ?? 'Pending') }}
                            </span>
                        </div>
                        @if($order->pembayaran->tanggal_pembayaran)
                        <div class="detail-item">
                            <span class="detail-label">Tanggal Pembayaran</span>
                            <span class="detail-value">{{ $order->pembayaran->tanggal_pembayaran->format('d M Y H:i') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('auth.orders') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Riwayat Pesanan
            </a>
        </div>
    </div>
</div>

@push('styles')
<style>
.order-detail-container {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    position: relative;
}

.order-detail-container::before {
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

.order-status-card,
.order-items-card,
.order-summary-card,
.order-details-card,
.payment-info-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.card-header {
    background: #f8f9fa;
    padding: 1.5rem;
    border-bottom: 1px solid #e9ecef;
}

.card-title {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
}

.card-body {
    padding: 1.5rem;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    display: inline-block;
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

.status-description {
    color: #6c757d;
    font-size: 0.95rem;
}

.order-item {
    padding: 1.5rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.order-item:last-child {
    border-bottom: none;
}

.product-thumb {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
}

.product-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
}

.product-details {
    margin: 0;
    color: #6c757d;
}

.quantity-badge {
    background: #e9ecef;
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-weight: 600;
    color: #495057;
}

.price, .total-price {
    font-weight: 600;
    color: #333;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
}

.summary-label {
    color: #6c757d;
}

.summary-value {
    font-weight: 600;
    color: #333;
}

.total-row {
    font-size: 1.1rem;
    font-weight: 700;
}

.total-row .summary-value {
    color: #007bff;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-label {
    color: #6c757d;
    font-weight: 500;
}

.detail-value {
    font-weight: 600;
    color: #333;
}

.payment-status {
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
}

.payment-pending {
    background: #fff3cd;
    color: #856404;
}

.payment-paid {
    background: #d1e7dd;
    color: #0f5132;
}

.payment-failed {
    background: #f8d7da;
    color: #721c24;
}

@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .order-item .row > div {
        text-align: center !important;
        margin-bottom: 1rem;
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
