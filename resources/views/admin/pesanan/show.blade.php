@extends('layouts.admin')

@section('page-title', 'Detail Pesanan')

@section('content')
<div class="order-detail-container">
    <!-- Header Section -->
    <div class="page-header" data-aos="fade-down">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-receipt me-3"></i>Detail Pesanan #{{ $pesanan->id }}
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
                <div class="timeline-item {{ in_array($pesanan->status, ['pending', 'diproses', 'dikirim', 'selesai']) ? 'active' : '' }}">
                    <div class="timeline-marker">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="timeline-content">
                        <h6>Pesanan Dibuat</h6>
                        <p>{{ $pesanan->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                
                <div class="timeline-item {{ in_array($pesanan->status, ['diproses', 'dikirim', 'selesai']) ? 'active' : '' }}">
                    <div class="timeline-marker">
                        <i class="fas fa-cog"></i>
                    </div>
                    <div class="timeline-content">
                        <h6>Sedang Diproses</h6>
                        <p>Pesanan sedang dipersiapkan</p>
                    </div>
                </div>
                
                <div class="timeline-item {{ in_array($pesanan->status, ['dikirim', 'selesai']) ? 'active' : '' }}">
                    <div class="timeline-marker">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="timeline-content">
                        <h6>Sedang Dikirim</h6>
                        <p>Pesanan dalam perjalanan</p>
                    </div>
                </div>
                
                <div class="timeline-item {{ $pesanan->status == 'selesai' ? 'active' : '' }}">
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
                <div class="card-body">
                    <div class="summary-item">
                        <span class="summary-label">ID Pesanan:</span>
                        <span class="summary-value">#{{ $pesanan->id }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Tanggal Pesanan:</span>
                        <span class="summary-value">{{ $pesanan->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Status:</span>
                        <span class="status-badge status-{{ strtolower($pesanan->status) }}">
                            {{ ucfirst($pesanan->status) }}
                        </span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Total Item:</span>
                        <span class="summary-value">{{ $pesanan->detailPesanan->sum('jumlah') }} item</span>
                    </div>
                    <div class="summary-item total-item">
                        <span class="summary-label">Total Pembayaran:</span>
                        <span class="summary-value total-amount">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</span>
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
                    @if($pesanan->pembayaran)
                        <div class="payment-details">
                            <div class="payment-status">
                                <span class="payment-badge payment-{{ strtolower($pesanan->pembayaran->status) }}">
                                    {{ ucfirst($pesanan->pembayaran->status) }}
                                </span>
                            </div>
                            <div class="payment-info-item">
                                <span class="payment-label">Metode:</span>
                                <span class="payment-value">{{ $pesanan->pembayaran->metode }}</span>
                            </div>                            <div class="payment-info-item">
                                <span class="payment-label">Jumlah:</span>
                                <span class="payment-value">Rp {{ number_format($pesanan->pembayaran->jumlah_bayar, 0, ',', '.') }}</span>
                            </div>
                            <div class="payment-info-item">
                                <span class="payment-label">Tanggal:</span>
                                <span class="payment-value">{{ $pesanan->pembayaran->created_at->format('d M Y, H:i') }}</span>
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
                    <div class="item-row">
                        <div class="item-image">
                            @if($detail->produk->gambar)
                                <img src="{{ asset('storage/' . $detail->produk->gambar) }}" alt="{{ $detail->produk->nama }}">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
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
                        </div>
                        <div class="total-row">
                            <span class="total-label">Ongkos Kirim:</span>
                            <span class="total-value">Rp 0</span>
                        </div>
                        <div class="total-row final-total">
                            <span class="total-label">Total:</span>
                            <span class="total-value">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</span>
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
                        <select class="form-select status-select" onchange="updateOrderStatus(this.value)">
                            <option value="pending" {{ $pesanan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diproses" {{ $pesanan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="dikirim" {{ $pesanan->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="selesai" {{ $pesanan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ $pesanan->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    
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
        fetch(`/admin/pesanan/{{ $pesanan->id }}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: newStatus })
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
    window.open(`/admin/pesanan/{{ $pesanan->id }}/invoice`, '_blank');
}

function sendNotification() {
    if (confirm('Kirim notifikasi status pesanan ke pelanggan?')) {
        fetch(`/admin/pesanan/{{ $pesanan->id }}/notify`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Notifikasi berhasil dikirim');
            } else {
                alert('Gagal mengirim notifikasi');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengirim notifikasi');
        });
    }
}

function deleteOrder() {
    if (confirm('Apakah Anda yakin ingin menghapus pesanan ini? Tindakan ini tidak dapat dibatalkan.')) {
        fetch(`/admin/pesanan/{{ $pesanan->id }}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
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
@endsection
