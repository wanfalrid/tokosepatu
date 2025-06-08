@extends('layouts.admin')

@section('page-title', 'Detail Produk')

@section('content')
<div class="product-detail-container">
    <!-- Header Section -->
    <div class="page-header" data-aos="fade-down">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-eye me-3"></i>Detail Produk
                </h1>
                <p class="page-subtitle">Informasi lengkap produk: {{ $produk->nama }}</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.produk.index') }}" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <a href="{{ route('admin.produk.edit', $produk->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Edit Produk
                </a>
            </div>
        </div>
    </div>

    <!-- Product Detail Card -->
    <div class="row g-4" data-aos="fade-up">
        <!-- Product Image -->
        <div class="col-lg-5">
            <div class="product-image-card">
                <div class="product-image-wrapper">
                    @if($produk->gambar)
                        <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}" class="product-image">
                    @else
                        <div class="no-image-placeholder">
                            <i class="fas fa-image"></i>
                            <span>Tidak ada gambar</span>
                        </div>
                    @endif
                    
                    <!-- Stock Status Badge -->
                    <div class="stock-badge {{ $produk->stok > 0 ? 'in-stock' : 'out-of-stock' }}">
                        @if($produk->stok > 0)
                            <i class="fas fa-check-circle me-1"></i>Stok Tersedia
                        @else
                            <i class="fas fa-times-circle me-1"></i>Stok Habis
                        @endif
                    </div>
                    
                    <!-- Category Badge -->
                    <div class="category-badge">
                        <i class="fas fa-tag me-1"></i>{{ $produk->kategori }}
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="quick-actions">
                    <button class="action-btn action-edit" onclick="location.href='{{ route('admin.produk.edit', $produk->id) }}'">
                        <i class="fas fa-edit"></i>
                        <span>Edit</span>
                    </button>
                    <button class="action-btn action-duplicate" onclick="duplicateProduct()">
                        <i class="fas fa-copy"></i>
                        <span>Duplikat</span>
                    </button>
                    <button class="action-btn action-delete" onclick="confirmDelete()">
                        <i class="fas fa-trash"></i>
                        <span>Hapus</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Product Information -->
        <div class="col-lg-7">
            <div class="product-info-card">
                <!-- Product Header -->
                <div class="product-header">
                    <div class="product-id">ID: #{{ $produk->id }}</div>
                    <h2 class="product-name">{{ $produk->nama }}</h2>
                    <div class="product-brand">
                        <i class="fas fa-crown me-2"></i>{{ $produk->merek }}
                    </div>
                </div>

                <!-- Product Details Grid -->
                <div class="product-details-grid">
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Harga</div>
                            <div class="detail-value price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Stok</div>
                            <div class="detail-value {{ $produk->stok > 10 ? 'text-success' : ($produk->stok > 0 ? 'text-warning' : 'text-danger') }}">
                                {{ $produk->stok }} unit
                            </div>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-list"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Kategori</div>
                            <div class="detail-value">{{ $produk->kategori }}</div>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-ruler"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Ukuran</div>
                            <div class="detail-value">{{ $produk->ukuran }}</div>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-palette"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Warna</div>
                            <div class="detail-value">{{ $produk->warna }}</div>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Ditambahkan</div>
                            <div class="detail-value">{{ $produk->created_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Product Description -->
                @if($produk->deskripsi)
                <div class="product-description">
                    <h4 class="description-title">
                        <i class="fas fa-file-text me-2"></i>Deskripsi Produk
                    </h4>
                    <div class="description-content">
                        {{ $produk->deskripsi }}
                    </div>
                </div>
                @endif

                <!-- Product Statistics -->
                <div class="product-stats">
                    <h4 class="stats-title">
                        <i class="fas fa-chart-bar me-2"></i>Statistik Produk
                    </h4>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-value">{{ $produk->detailPesanan->count() }}</div>
                            <div class="stat-label">Total Penjualan</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $produk->detailPesanan->sum('jumlah') }}</div>
                            <div class="stat-label">Unit Terjual</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">Rp {{ number_format($produk->detailPesanan->sum('subtotal'), 0, ',', '.') }}</div>
                            <div class="stat-label">Total Revenue</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $produk->updated_at->diffForHumans() }}</div>
                            <div class="stat-label">Terakhir Update</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Section -->
    @if($produk->detailPesanan->count() > 0)
    <div class="recent-orders-section" data-aos="fade-up" data-aos-delay="200">
        <div class="section-header">
            <h3 class="section-title">
                <i class="fas fa-shopping-cart me-2"></i>Pesanan Terbaru
            </h3>
            <p class="section-subtitle">5 pesanan terbaru untuk produk ini</p>
        </div>
        
        <div class="orders-table-card">
            <div class="table-responsive">
                <table class="table orders-table">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produk->detailPesanan()->with('pesanan.pelanggan')->latest()->take(5)->get() as $detail)
                        <tr class="order-row">
                            <td>
                                <span class="order-id">#{{ $detail->pesanan->id }}</span>
                            </td>
                            <td>
                                <div class="customer-info">
                                    <div class="customer-name">{{ $detail->pesanan->pelanggan->nama }}</div>
                                    <div class="customer-email">{{ $detail->pesanan->pelanggan->email }}</div>
                                </div>
                            </td>
                            <td>
                                <span class="quantity-badge">{{ $detail->jumlah }} unit</span>
                            </td>
                            <td>
                                <span class="amount">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <span class="date">{{ $detail->created_at->format('d M Y') }}</span>
                                <div class="time">{{ $detail->created_at->format('H:i') }}</div>
                            </td>
                            <td>
                                <span class="status-badge status-{{ strtolower($detail->pesanan->status) }}">
                                    {{ $detail->pesanan->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Delete Form (Hidden) -->
<form id="deleteForm" action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<style>
.product-detail-container {
    padding: 2rem 0;
}

.product-image-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: all 0.3s ease;
}

.product-image-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.product-image-wrapper {
    position: relative;
    height: 400px;
    overflow: hidden;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-image-wrapper:hover .product-image {
    transform: scale(1.05);
}

.no-image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    color: #6c757d;
    font-size: 1.2rem;
}

.no-image-placeholder i {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.stock-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
}

.stock-badge.in-stock {
    background: rgba(40, 167, 69, 0.9);
    color: white;
}

.stock-badge.out-of-stock {
    background: rgba(220, 53, 69, 0.9);
    color: white;
}

.category-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(0, 123, 255, 0.9);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
}

.quick-actions {
    display: flex;
    padding: 1.5rem;
    gap: 1rem;
    background: #f8f9fa;
}

.action-btn {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem;
    border: none;
    border-radius: 12px;
    transition: all 0.3s ease;
    cursor: pointer;
    font-size: 0.875rem;
    font-weight: 600;
}

.action-btn i {
    font-size: 1.5rem;
}

.action-edit {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.action-duplicate {
    background: linear-gradient(135deg, #17a2b8, #20c997);
    color: white;
}

.action-delete {
    background: linear-gradient(135deg, #dc3545, #fd7e14);
    color: white;
}

.action-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}

.product-info-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    padding: 2.5rem;
    height: fit-content;
}

.product-header {
    margin-bottom: 2rem;
    text-align: center;
    border-bottom: 1px solid #e9ecef;
    padding-bottom: 2rem;
}

.product-id {
    display: inline-block;
    background: var(--primary-color);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.product-name {
    font-size: 2rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 0.5rem;
}

.product-brand {
    color: #6c757d;
    font-size: 1.1rem;
    font-weight: 500;
}

.product-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.detail-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

.detail-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.detail-content {
    flex: 1;
}

.detail-label {
    font-size: 0.875rem;
    color: #6c757d;
    margin-bottom: 0.25rem;
}

.detail-value {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
}

.detail-value.price {
    color: var(--primary-color);
    font-size: 1.3rem;
}

.product-description {
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 12px;
}

.description-title {
    color: #333;
    margin-bottom: 1rem;
    font-size: 1.2rem;
}

.description-content {
    color: #666;
    line-height: 1.6;
}

.product-stats {
    padding: 1.5rem;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-radius: 12px;
}

.stats-title {
    color: #333;
    margin-bottom: 1.5rem;
    font-size: 1.2rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 1rem;
}

.stat-item {
    text-align: center;
    padding: 1rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.875rem;
    color: #6c757d;
}

.recent-orders-section {
    margin-top: 3rem;
}

.section-header {
    text-align: center;
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 0.5rem;
}

.section-subtitle {
    color: #6c757d;
    font-size: 1.1rem;
}

.orders-table-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.orders-table {
    margin: 0;
}

.orders-table thead th {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    border: none;
    padding: 1.5rem 1rem;
    font-weight: 600;
}

.order-row {
    transition: all 0.3s ease;
}

.order-row:hover {
    background: #f8f9fa;
    transform: scale(1.01);
}

.order-row td {
    padding: 1.5rem 1rem;
    vertical-align: middle;
    border-bottom: 1px solid #e9ecef;
}

.order-id {
    font-weight: 600;
    color: var(--primary-color);
}

.customer-info .customer-name {
    font-weight: 600;
    color: #333;
}

.customer-info .customer-email {
    font-size: 0.875rem;
    color: #6c757d;
}

.quantity-badge {
    background: #e9ecef;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
}

.amount {
    font-weight: 600;
    color: var(--primary-color);
}

.date {
    font-weight: 600;
    color: #333;
}

.time {
    font-size: 0.875rem;
    color: #6c757d;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-badge.status-pending {
    background: #fff3cd;
    color: #856404;
}

.status-badge.status-diproses {
    background: #d1ecf1;
    color: #0c5460;
}

.status-badge.status-dikirim {
    background: #d4edda;
    color: #155724;
}

.status-badge.status-selesai {
    background: #d1ecf1;
    color: #0c5460;
}

.status-badge.status-dibatalkan {
    background: #f8d7da;
    color: #721c24;
}

@media (max-width: 768px) {
    .product-details-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .quick-actions {
        flex-direction: column;
    }
    
    .action-btn {
        flex-direction: row;
        justify-content: center;
    }
    
    .orders-table-card {
        font-size: 0.875rem;
    }
}
</style>

<script>
function confirmDelete() {
    if (confirm('Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.')) {
        document.getElementById('deleteForm').submit();
    }
}

function duplicateProduct() {
    if (confirm('Apakah Anda ingin membuat duplikat produk ini?')) {
        // Redirect to create page with prefilled data
        const currentUrl = new URL(window.location.href);
        window.location.href = `{{ route('admin.produk.create') }}?duplicate={{ $produk->id }}`;
    }
}

// Add smooth scrolling for internal links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});
</script>
@endsection
