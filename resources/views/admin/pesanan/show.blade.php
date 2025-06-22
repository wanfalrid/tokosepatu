@extends('layouts.admin')

@section('page-title', 'Detail Pesanan')

@section('content')
<div class="order-detail-container">
    <!-- Header Section -->
    <div class="page-header" data-aos="fade-down">
        <div class="d-flex justify-content-between align-items-center">
            <div>                <h1 class="page-title">
                    <i class="fas fa-receipt me-3"></i>Detail Pesanan #{{ $pesanan->id_pesanan }}
                </h1>
                <p class="page-subtitle">Informasi lengkap pesanan pelanggan</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.pesanan.index') }}" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <button class="btn btn-primary" onclick="printInvoice()">
                    <i class="fas fa-print me-2"></i>Cetak Invoice
                </button>
            </div>
        </div>
    </div>

    <!-- Order Status Timeline -->
    <div class="status-timeline-section" data-aos="fade-up">
        <div class="timeline-card">
            <h4 class="timeline-title">
                <i class="fas fa-clock me-2"></i>Status Pesanan
            </h4>
            <div class="status-timeline">
                <div class="timeline-item {{ in_array($pesanan->status_pesanan, ['menunggu', 'diproses', 'dikirim', 'selesai']) ? 'active' : '' }}">
                    <div class="timeline-marker">
                        <i class="fas fa-shopping-cart"></i>
                    </div>                    <div class="timeline-content">
                        <h6>Pesanan Dibuat</h6>
                        <p>{{ $pesanan->dibuat_pada instanceof \Illuminate\Support\Carbon ? $pesanan->dibuat_pada->format('d M Y, H:i') : ($pesanan->dibuat_pada ? date('d M Y, H:i', strtotime($pesanan->dibuat_pada)) : 'N/A') }}</p>
                    </div>
                </div>
                
                <div class="timeline-item {{ in_array($pesanan->status_pesanan, ['diproses', 'dikirim', 'selesai']) ? 'active' : '' }}">
                    <div class="timeline-marker">
                        <i class="fas fa-cog"></i>
                    </div>
                    <div class="timeline-content">
                        <h6>Sedang Diproses</h6>
                        <p>Pesanan sedang dipersiapkan</p>
                    </div>
                </div>
                
                <div class="timeline-item {{ in_array($pesanan->status_pesanan, ['dikirim', 'selesai']) ? 'active' : '' }}">
                    <div class="timeline-marker">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="timeline-content">
                        <h6>Sedang Dikirim</h6>
                        <p>Pesanan dalam perjalanan</p>
                    </div>
                </div>
                
                <div class="timeline-item {{ $pesanan->status_pesanan == 'selesai' ? 'active' : '' }}">
                    <div class="timeline-marker">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="timeline-content">
                        <h6>Pesanan Selesai</h6>
                        <p>Pesanan telah diterima</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Information Grid -->
    <div class="row g-4" data-aos="fade-up" data-aos-delay="100">
        <!-- Customer Information -->
        <div class="col-lg-4">
            <div class="info-card customer-card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-user me-2"></i>Informasi Pelanggan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="customer-avatar">
                        <div class="avatar-circle">
                            {{ strtoupper(substr($pesanan->pelanggan->nama, 0, 1)) }}
                        </div>
                    </div>
                    <div class="customer-details">
                        <h6 class="customer-name">{{ $pesanan->pelanggan->nama }}</h6>
                        <div class="customer-info-item">
                            <i class="fas fa-envelope me-2"></i>
                            <span>{{ $pesanan->pelanggan->email }}</span>
                        </div>
                        <div class="customer-info-item">
                            <i class="fas fa-phone me-2"></i>
                            <span>{{ $pesanan->pelanggan->telepon }}</span>
                        </div>
                        <div class="customer-info-item">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <span>{{ $pesanan->alamat_pengiriman }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="info-card order-summary-card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-file-invoice me-2"></i>Ringkasan Pesanan
                    </h5>
                </div>
                <div class="card-body">                    <div class="summary-item">
                        <span class="summary-label">ID Pesanan:</span>
                        <span class="summary-value">#{{ $pesanan->id_pesanan }}</span>
                    </div><div class="summary-item">
                        <span class="summary-label">Tanggal Pesanan:</span>
                        <span class="summary-value">{{ $pesanan->dibuat_pada instanceof \Illuminate\Support\Carbon ? $pesanan->dibuat_pada->format('d M Y, H:i') : ($pesanan->dibuat_pada ? date('d M Y, H:i', strtotime($pesanan->dibuat_pada)) : 'N/A') }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Status:</span>                        <span class="status-badge status-{{ strtolower($pesanan->status_pesanan) }}">
                            {{ ucfirst($pesanan->status_pesanan) }}
                        </span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Total Item:</span>
                        <span class="summary-value">{{ $pesanan->detailPesanan->sum('jumlah') }} item</span>
                    </div>                    <div class="summary-item total-item">
                        <span class="summary-label">Total Pembayaran:</span>
                        <span class="summary-value total-amount">
                            Rp {{ number_format($pesanan->total_harga ?: $pesanan->detailPesanan->sum('subtotal'), 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="col-lg-4">
            <div class="info-card payment-card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-credit-card me-2"></i>Informasi Pembayaran
                    </h5>
                </div>
                <div class="card-body">
                    @if($pesanan->pembayaran)                        <div class="payment-details">
                            <div class="payment-status">
                                <span class="payment-badge payment-{{ strtolower($pesanan->pembayaran->status_pembayaran) }}">
                                    {{ ucfirst($pesanan->pembayaran->status_pembayaran) }}
                                </span>
                            </div>                            <div class="payment-info-item">
                                <span class="payment-label">Jumlah:</span>
                                <span class="payment-value">
                                    Rp {{ number_format($pesanan->pembayaran->jumlah_bayar ?? ($pesanan->total_harga ?: $pesanan->detailPesanan->sum('subtotal')), 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="payment-info-item">
                                <span class="payment-label">Tanggal:</span>
                                <span class="payment-value">{{ $pesanan->pembayaran->tanggal_pembayaran->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                    @else
                        <div class="no-payment">
                            <i class="fas fa-exclamation-triangle"></i>
                            <p>Belum ada informasi pembayaran</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="order-items-section" data-aos="fade-up" data-aos-delay="200">
        <div class="items-card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-shopping-bag me-2"></i>Item Pesanan
                </h5>
            </div>
            <div class="card-body">
                <div class="items-list">
                    @foreach($pesanan->detailPesanan as $detail)
                    <div class="item-row">                        <div class="item-image">
                            <img src="{{ $detail->produk->image_url }}" alt="{{ $detail->produk->nama }}">
                        </div>
                        <div class="item-details">
                            <h6 class="item-name">{{ $detail->produk->nama }}</h6>
                            <div class="item-meta">
                                <span class="item-brand">{{ $detail->produk->merek }}</span>
                                <span class="item-separator">•</span>
                                <span class="item-category">{{ $detail->produk->kategori }}</span>
                            </div>
                            <div class="item-specs">
                                <span class="item-size">Ukuran: {{ $detail->produk->ukuran }}</span>
                                <span class="item-separator">•</span>
                                <span class="item-color">Warna: {{ $detail->produk->warna }}</span>
                            </div>
                        </div>
                        <div class="item-quantity">
                            <div class="quantity-label">Jumlah</div>
                            <div class="quantity-value">{{ $detail->jumlah }}</div>
                        </div>
                        <div class="item-price">
                            <div class="price-label">Harga Satuan</div>
                            <div class="price-value">Rp {{ number_format($detail->harga, 0, ',', '.') }}</div>
                        </div>
                        <div class="item-subtotal">
                            <div class="subtotal-label">Subtotal</div>
                            <div class="subtotal-value">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Order Total -->
                <div class="order-total-section">
                    <div class="total-calculations">
                        <div class="total-row">
                            <span class="total-label">Subtotal:</span>
                            <span class="total-value">Rp {{ number_format($pesanan->detailPesanan->sum('subtotal'), 0, ',', '.') }}</span>
                        </div>                        <div class="total-row">
                            <span class="total-label">Ongkos Kirim:</span>
                            <span class="total-value">Rp {{ number_format($pesanan->ongkos_kirim ?? 0, 0, ',', '.') }}</span>
                        </div>                        <div class="total-row final-total">
                            <span class="total-label">Total:</span>
                            <span class="total-value">
                                Rp {{ number_format(($pesanan->total_harga ?: $pesanan->detailPesanan->sum('subtotal')) + ($pesanan->ongkos_kirim ?? 0), 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Actions -->
    <div class="order-actions-section" data-aos="fade-up" data-aos-delay="300">
        <div class="actions-card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-cogs me-2"></i>Aksi Pesanan
                </h5>
            </div>
            <div class="card-body">
                <div class="action-buttons">
                    <div class="status-actions">
                        <label class="form-label">Ubah Status Pesanan:</label>
                        <select class="form-select status-select" onchange="updateOrderStatus(this.value)">                            <option value="menunggu" {{ $pesanan->status_pesanan == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="diproses" {{ $pesanan->status_pesanan == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="dikirim" {{ $pesanan->status_pesanan == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="selesai" {{ $pesanan->status_pesanan == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ $pesanan->status_pesanan == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    
                    <!-- Form Input Nomor Resi (hanya untuk status diproses) -->
                    @if($pesanan->status_pesanan == 'diproses')
                    <div class="resi-form-section mt-4">
                        <h6 class="mb-3">
                            <i class="fas fa-shipping-fast me-2"></i>Input Nomor Resi
                        </h6>
                        <form id="resiForm" onsubmit="submitResi(event)">
                            @csrf
                            <div class="row g-3">                                <div class="col-md-4">
                                    <label class="form-label">Kurir:</label>
                                    <select class="form-select" id="courier" name="courier" required>
                                        <option value="">Pilih Kurir</option>
                                        <option value="jne" {{ $pesanan->kurir == 'jne' ? 'selected' : '' }}>JNE</option>
                                        <option value="pos" {{ $pesanan->kurir == 'pos' ? 'selected' : '' }}>POS Indonesia</option>
                                        <option value="tiki" {{ $pesanan->kurir == 'tiki' ? 'selected' : '' }}>TIKI</option>
                                        <option value="anteraja" {{ $pesanan->kurir == 'anteraja' ? 'selected' : '' }}>AnterAja</option>
                                        <option value="sicepat" {{ $pesanan->kurir == 'sicepat' ? 'selected' : '' }}>SiCepat</option>
                                        <option value="jnt" {{ $pesanan->kurir == 'jnt' ? 'selected' : '' }}>J&T Express</option>
                                        <option value="ninja" {{ $pesanan->kurir == 'ninja' ? 'selected' : '' }}>Ninja Express</option>
                                        <option value="idexpress" {{ $pesanan->kurir == 'idexpress' ? 'selected' : '' }}>ID Express</option>
                                        <option value="spx" {{ $pesanan->kurir == 'spx' ? 'selected' : '' }}>Shopee Express</option>
                                        <option value="lion" {{ $pesanan->kurir == 'lion' ? 'selected' : '' }}>Lion Parcel</option>
                                        <option value="wahana" {{ $pesanan->kurir == 'wahana' ? 'selected' : '' }}>Wahana</option>
                                        <option value="first" {{ $pesanan->kurir == 'first' ? 'selected' : '' }}>First Logistics</option>
                                        <option value="rex" {{ $pesanan->kurir == 'rex' ? 'selected' : '' }}>REX Express</option>
                                        <option value="sap" {{ $pesanan->kurir == 'sap' ? 'selected' : '' }}>SAP Express</option>
                                        <option value="jet" {{ $pesanan->kurir == 'jet' ? 'selected' : '' }}>JET Express</option>
                                        <option value="dse" {{ $pesanan->kurir == 'dse' ? 'selected' : '' }}>21 Express</option>
                                        <option value="dakota" {{ $pesanan->kurir == 'dakota' ? 'selected' : '' }}>Dakota Cargo</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nomor Resi:</label>
                                    <input type="text" class="form-control" id="awb" name="awb" 
                                           placeholder="Masukkan nomor resi" 
                                           value="{{ $pesanan->nomor_resi }}" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fas fa-save me-1"></i>Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif
                    
                    <!-- Tracking Information (jika ada nomor resi) -->
                    @if($pesanan->nomor_resi)
                    <div class="tracking-section mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">
                                <i class="fas fa-route me-2"></i>Tracking Paket
                            </h6>
                            <button class="btn btn-outline-primary btn-sm" onclick="trackPackage()">
                                <i class="fas fa-sync-alt me-1"></i>Refresh Tracking
                            </button>
                        </div>
                        
                        <div id="trackingInfo" class="tracking-info">
                            <div class="text-center p-3">
                                <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                Loading tracking information...
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="quick-actions">
                        <button class="btn btn-primary" onclick="printInvoice()">
                            <i class="fas fa-print me-2"></i>Cetak Invoice
                        </button>
                        <button class="btn btn-info" onclick="sendNotification()">
                            <i class="fas fa-envelope me-2"></i>Kirim Notifikasi
                        </button>
                        <button class="btn btn-outline-danger" onclick="deleteOrder()">
                            <i class="fas fa-trash me-2"></i>Hapus Pesanan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.order-detail-container {
    padding: 2rem 0;
}

.status-timeline-section {
    margin-bottom: 2rem;
}

.timeline-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    padding: 2rem;
}

.timeline-title {
    color: #333;
    margin-bottom: 2rem;
    font-size: 1.3rem;
}

.status-timeline {
    display: flex;
    justify-content: space-between;
    position: relative;
    padding: 1rem 0;
}

.status-timeline::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 2px;
    background: #e9ecef;
    z-index: 1;
}

.timeline-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    z-index: 2;
    flex: 1;
}

.timeline-marker {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 1.2rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.timeline-item.active .timeline-marker {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    transform: scale(1.1);
}

.timeline-content {
    text-align: center;
}

.timeline-content h6 {
    color: #333;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.timeline-content p {
    color: #6c757d;
    font-size: 0.9rem;
    margin: 0;
}

.info-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    height: 100%;
    transition: all 0.3s ease;
}

.info-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 1.5rem;
    border-bottom: 1px solid #dee2e6;
}

.card-title {
    margin: 0;
    color: #333;
    font-size: 1.1rem;
    font-weight: 600;
}

.card-body {
    padding: 1.5rem;
}

.customer-avatar {
    text-align: center;
    margin-bottom: 1.5rem;
}

.avatar-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    font-weight: 700;
    margin: 0 auto;
}

.customer-name {
    text-align: center;
    color: #333;
    margin-bottom: 1rem;
    font-size: 1.2rem;
}

.customer-info-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.8rem;
    color: #666;
}

.customer-info-item i {
    width: 20px;
    color: var(--primary-color);
}

.summary-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #f8f9fa;
}

.summary-item.total-item {
    border-bottom: 2px solid var(--primary-color);
    margin-top: 1rem;
    padding-top: 1rem;
}

.summary-label {
    color: #6c757d;
    font-weight: 500;
}

.summary-value {
    color: #333;
    font-weight: 600;
}

.total-amount {
    color: var(--primary-color);
    font-size: 1.2rem;
    font-weight: 700;
}

.status-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
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
    background: #cce7ff;
    color: #004085;
}

.status-selesai {
    background: #d4edda;
    color: #155724;
}

.status-dibatalkan {
    background: #f8d7da;
    color: #721c24;
}

.payment-details {
    text-align: center;
}

.payment-status {
    margin-bottom: 1.5rem;
}

.payment-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
}

.payment-lunas {
    background: #d4edda;
    color: #155724;
}

.payment-pending {
    background: #fff3cd;
    color: #856404;
}

.payment-gagal {
    background: #f8d7da;
    color: #721c24;
}

.payment-info-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.8rem;
}

.payment-label {
    color: #6c757d;
}

.payment-value {
    color: #333;
    font-weight: 600;
}

.no-payment {
    text-align: center;
    color: #6c757d;
    padding: 2rem 0;
}

.no-payment i {
    font-size: 3rem;
    margin-bottom: 1rem;
    color: #dee2e6;
}

.items-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 2rem;
}

.item-row {
    display: grid;
    grid-template-columns: 80px 1fr auto auto auto;
    gap: 1.5rem;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid #f8f9fa;
    transition: all 0.3s ease;
}

.item-row:hover {
    background: #f8f9fa;
}

.item-row:last-child {
    border-bottom: none;
}

.item-image {
    width: 80px;
    height: 80px;
    border-radius: 12px;
    overflow: hidden;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
}

.item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image {
    color: #dee2e6;
    font-size: 2rem;
}

.item-details {
    flex: 1;
}

.item-name {
    color: #333;
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
    font-weight: 600;
}

.item-meta, .item-specs {
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.item-separator {
    margin: 0 0.5rem;
}

.item-quantity, .item-price, .item-subtotal {
    text-align: center;
}

.quantity-label, .price-label, .subtotal-label {
    color: #6c757d;
    font-size: 0.8rem;
    margin-bottom: 0.25rem;
}

.quantity-value, .price-value, .subtotal-value {
    color: #333;
    font-weight: 600;
    font-size: 1rem;
}

.subtotal-value {
    color: var(--primary-color);
    font-size: 1.1rem;
}

.order-total-section {
    background: #f8f9fa;
    padding: 2rem;
    margin-top: 1rem;
}

.total-calculations {
    max-width: 400px;
    margin-left: auto;
}

.total-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
}

.total-row.final-total {
    border-top: 2px solid var(--primary-color);
    padding-top: 1rem;
    margin-top: 1rem;
    font-size: 1.2rem;
    font-weight: 700;
}

.total-row.final-total .total-value {
    color: var(--primary-color);
}

.actions-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.action-buttons {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 2rem;
    align-items: start;
}

.status-actions .form-label {
    color: #333;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.status-select {
    border-radius: 12px;
    border: 2px solid #e9ecef;
    padding: 0.75rem;
}

.status-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.quick-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.quick-actions .btn {
    border-radius: 12px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.quick-actions .btn:hover {
    transform: translateY(-2px);
}

/* Resi Form Styling */
.resi-form-section {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 1.5rem;
    border: 2px dashed #dee2e6;
}

.resi-form-section h6 {
    color: #495057;
    font-weight: 600;
    margin-bottom: 1rem;
}

/* Tracking Section Styling */
.tracking-section {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border-left: 4px solid #007bff;
}

.tracking-info {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 1rem;
}

.tracking-summary {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
}

.tracking-status {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.tracking-date {
    opacity: 0.9;
    font-size: 0.9rem;
}

.tracking-history {
    max-height: 300px;
    overflow-y: auto;
}

.tracking-item {
    display: flex;
    align-items: flex-start;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e9ecef;
    position: relative;
}

.tracking-item:last-child {
    border-bottom: none;
}

.tracking-item::before {
    content: '';
    width: 10px;
    height: 10px;
    background: #007bff;
    border-radius: 50%;
    margin-right: 1rem;
    margin-top: 0.25rem;
    flex-shrink: 0;
}

.tracking-item:first-child::before {
    background: #28a745;
}

.tracking-content {
    flex: 1;
}

.tracking-desc {
    font-weight: 500;
    color: #495057;
    margin-bottom: 0.25rem;
}

.tracking-time {
    font-size: 0.85rem;
    color: #6c757d;
}

.tracking-location {
    font-size: 0.85rem;
    color: #007bff;
    font-style: italic;
}

@media (max-width: 768px) {
    .status-timeline {
        flex-direction: column;
        gap: 2rem;
    }
    
    .status-timeline::before {
        top: 0;
        bottom: 0;
        left: 25px;
        right: auto;
        width: 2px;
        height: auto;
    }
    
    .timeline-item {
        flex-direction: row;
        text-align: left;
    }
    
    .timeline-marker {
        margin-bottom: 0;
        margin-right: 1rem;
    }
    
    .item-row {
        grid-template-columns: 1fr;
        gap: 1rem;
        text-align: center;
    }
    
    .item-details {
        text-align: center;
    }
    
    .action-buttons {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .quick-actions {
        justify-content: center;
    }
}
</style>

<script>
function updateOrderStatus(newStatus) {
    if (confirm(`Apakah Anda yakin ingin mengubah status pesanan menjadi ${newStatus}?`)) {
        fetch(`/admin/pesanan/{{ $pesanan->id_pesanan }}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status_pesanan: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal mengubah status pesanan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengubah status pesanan');
        });
    }
}

function printInvoice() {
    window.open(`/admin/pesanan/{{ $pesanan->id_pesanan }}/invoice`, '_blank');
}

function sendNotification() {
    if (confirm('Kirim notifikasi status pesanan ke pelanggan?')) {
        fetch(`/admin/pesanan/{{ $pesanan->id_pesanan }}/notify`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Notifikasi berhasil dikirim!');
            }
        });
    }
}

// Submit nomor resi
function submitResi(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    const submitButton = form.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    
    // Show loading
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...';
    submitButton.disabled = true;
      fetch(`/admin/pesanan/{{ $pesanan->id_pesanan }}/resi`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(async response => {
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const text = await response.text();
            console.error('Response is not JSON:', text);
            throw new Error('Server returned non-JSON response');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Nomor resi berhasil disimpan',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            
            // Reload page to show tracking section
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            throw new Error(data.message || 'Gagal menyimpan nomor resi');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: error.message || 'Terjadi kesalahan saat menyimpan nomor resi'
        });
    })
    .finally(() => {
        // Reset button
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    });
}

// Track package using BinderByte API
function trackPackage() {
    const trackingInfo = document.getElementById('trackingInfo');
    const pesananId = '{{ $pesanan->id_pesanan }}';
    
    // Show loading
    trackingInfo.innerHTML = `
        <div class="text-center p-3">
            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
            Mengambil informasi tracking...
        </div>
    `;
      fetch(`/admin/pesanan/${pesananId}/track`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(async response => {
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const text = await response.text();
            console.error('Response is not JSON:', text);
            throw new Error('Server returned non-JSON response');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            displayTrackingInfo(data.tracking);
        } else {
            throw new Error(data.message || 'Gagal mengambil informasi tracking');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        trackingInfo.innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                ${error.message || 'Gagal mengambil informasi tracking'}
                <button class="btn btn-sm btn-outline-danger ms-2" onclick="trackPackage()">
                    <i class="fas fa-redo me-1"></i>Coba Lagi
                </button>
            </div>
        `;
    });
}

// Display tracking information
function displayTrackingInfo(tracking) {
    const trackingInfo = document.getElementById('trackingInfo');
    
    if (!tracking || !tracking.summary) {
        trackingInfo.innerHTML = `
            <div class="alert alert-warning">
                <i class="fas fa-info-circle me-2"></i>
                Informasi tracking belum tersedia
            </div>
        `;
        return;
    }
    
    const summary = tracking.summary;
    const history = tracking.history || [];
    
    let statusColor = 'primary';
    if (summary.status === 'DELIVERED') statusColor = 'success';
    else if (summary.status === 'ON_TRANSIT') statusColor = 'info';
    else if (summary.status === 'PICKUP') statusColor = 'warning';
    
    let trackingHtml = `
        <div class="tracking-summary bg-${statusColor} text-white">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="tracking-status">${summary.status || 'Unknown'}</div>
                    <div class="tracking-date">${summary.date || 'N/A'}</div>
                    ${summary.desc ? `<div class="mt-2"><small>${summary.desc}</small></div>` : ''}
                </div>
                <div class="text-end">
                    <div><small>AWB: ${summary.awb || 'N/A'}</small></div>
                    <div><small>${summary.courier || 'Unknown Courier'}</small></div>
                </div>
            </div>
        </div>
    `;
    
    if (history.length > 0) {
        trackingHtml += `
            <div class="tracking-history">
                <h6 class="mb-3">
                    <i class="fas fa-history me-2"></i>Riwayat Pengiriman
                </h6>
        `;
        
        history.forEach(item => {
            trackingHtml += `
                <div class="tracking-item">
                    <div class="tracking-content">
                        <div class="tracking-desc">${item.desc || 'No description'}</div>
                        <div class="tracking-time">
                            <i class="fas fa-clock me-1"></i>${item.date || 'No date'}
                        </div>
                        ${item.location ? `<div class="tracking-location">📍 ${item.location}</div>` : ''}
                    </div>
                </div>
            `;
        });
        
        trackingHtml += '</div>';
    }
    
    trackingInfo.innerHTML = trackingHtml;
}

// Auto-load tracking info on page load
document.addEventListener('DOMContentLoaded', function() {
    @if($pesanan->nomor_resi)
        trackPackage();
    @endif
});

function deleteOrder() {
    if (confirm('Apakah Anda yakin ingin menghapus pesanan ini? Tindakan ini tidak dapat dibatalkan.')) {
        fetch(`/admin/pesanan/{{ $pesanan->id_pesanan }}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())        .then(data => {
            if (data.success) {
                window.location.href = '/admin/pesanan';
            } else {
                alert('Gagal menghapus pesanan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus pesanan');
        });
    }
}
</script>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
/* Custom styles for SweetAlert2 */
.swal2-popup {
    border-radius: 10px;
    font-family: 'Poppins', sans-serif;
}

.swal2-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #333;
}

.swal2-content {
    font-size: 1rem;
    color: #666;
}

.swal2-confirm {
    background: var(--primary-color);
    color: white;
    border-radius: 5px;
    padding: 0.5rem 1rem;
    font-weight: 500;
    transition: background 0.3s ease;
}

.swal2-confirm:hover {
    background: darken(var(--primary-color), 10%);
}

.swal2-cancel {
    color: var(--primary-color);
    font-weight: 500;
    transition: color 0.3s ease;
}

.swal2-cancel:hover {
    color: darken(var(--primary-color), 10%);
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@endsection
