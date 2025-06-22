@extends('layouts.admin')

@section('page-title', 'Manajemen Produk')

@section('content')
<div class="product-management">
    <!-- Header Section -->
    <div class="page-header" data-aos="fade-down">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-box me-3"></i>Manajemen Produk
                </h1>
                <p class="page-subtitle">Kelola semua produk sepatu di toko Anda</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.produk.create') }}" class="btn btn-primary btn-add-product">
                    <i class="fas fa-plus me-2"></i>Tambah Produk
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5" data-aos="fade-up">
        <div class="col-md-3">
            <div class="stats-mini-card stats-primary">
                <div class="stats-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-number">{{ $produk->total() }}</div>
                    <div class="stats-label">Total Produk</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-mini-card stats-success">
                <div class="stats-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-number">{{ $produk->where('stok', '>', 0)->count() }}</div>
                    <div class="stats-label">Stok Tersedia</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-mini-card stats-warning">
                <div class="stats-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-number">{{ $produk->whereBetween('stok', [1, 5])->count() }}</div>
                    <div class="stats-label">Stok Menipis</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-mini-card stats-danger">
                <div class="stats-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-number">{{ $produk->where('stok', 0)->count() }}</div>
                    <div class="stats-label">Habis Stok</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="filter-section" data-aos="fade-up" data-aos-delay="100">
        <div class="card">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Cari Produk</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" 
                                   class="form-control" 
                                   name="search" 
                                   placeholder="Nama produk..." 
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Merek</label>
                        <select class="form-select" name="merek">
                            <option value="">Semua Merek</option>
                            @foreach($produk->pluck('merek')->unique()->filter() as $merek)
                                <option value="{{ $merek }}" {{ request('merek') == $merek ? 'selected' : '' }}>
                                    {{ $merek }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" name="kategori">
                            <option value="">Semua Kategori</option>
                            @foreach($produk->pluck('kategori')->unique()->filter() as $kategori)
                                <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                                    {{ $kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Status Stok</label>
                        <select class="form-select" name="stok_status">
                            <option value="">Semua Status</option>
                            <option value="tersedia" {{ request('stok_status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="menipis" {{ request('stok_status') == 'menipis' ? 'selected' : '' }}>Menipis</option>
                            <option value="habis" {{ request('stok_status') == 'habis' ? 'selected' : '' }}>Habis</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-1"></i>Filter
                            </button>
                            <a href="{{ route('admin.produk.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-undo me-1"></i>Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="products-table" data-aos="fade-up" data-aos-delay="200">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-table me-2"></i>
                        Daftar Produk
                    </h5>
                    <div class="table-actions">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary btn-sm view-grid active" data-view="grid">
                                <i class="fas fa-th"></i>
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm view-list" data-view="list">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                @if($produk->count() > 0)
                    <!-- Grid View -->
                    <div class="products-grid" id="gridView">
                        <div class="row g-4 p-4">
                            @foreach($produk as $item)
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="product-card">
                                    <div class="product-image">                                        <img src="{{ $item->image_url ?: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80' }}" 
                                             alt="{{ $item->nama_produk }}" 
                                             class="img-fluid">
                                        
                                        <div class="product-overlay">
                                            <div class="product-actions">
                                                <a href="{{ route('admin.produk.show', $item->id_produk) }}" 
                                                   class="btn btn-primary btn-sm" 
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.produk.edit', $item->id_produk) }}" 
                                                   class="btn btn-warning btn-sm" 
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-danger btn-sm delete-product" 
                                                        data-id="{{ $item->id_produk }}" 
                                                        data-name="{{ $item->nama_produk }}"
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <!-- Stock Badge -->
                                        @if($item->stok == 0)
                                            <span class="stock-badge badge-danger">Habis</span>
                                        @elseif($item->stok <= 5)
                                            <span class="stock-badge badge-warning">Menipis</span>
                                        @else
                                            <span class="stock-badge badge-success">Tersedia</span>
                                        @endif
                                    </div>
                                    
                                    <div class="product-info">
                                        <div class="product-brand">{{ $item->merek }}</div>
                                        <h6 class="product-name">{{ $item->nama_produk }}</h6>
                                        <div class="product-meta">
                                            <span class="product-category">{{ $item->kategori }}</span>
                                            <span class="product-stock">Stok: {{ $item->stok }}</span>
                                        </div>
                                        <div class="product-price">
                                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                                        </div>                                        <div class="product-date">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $item->dibuat_pada ? \Carbon\Carbon::parse($item->dibuat_pada)->format('d/m/Y') : 'N/A' }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- List View -->
                    <div class="products-list d-none" id="listView">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($produk as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">                                                <img src="{{ $item->image_url ?: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=60&q=80' }}" 
                                                     alt="{{ $item->nama_produk }}" 
                                                     class="product-thumb me-3">
                                                <div>
                                                    <div class="fw-semibold">{{ $item->nama_produk }}</div>
                                                    <small class="text-muted">{{ $item->merek }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $item->kategori }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-success">
                                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-semibold">{{ $item->stok }} unit</span>
                                        </td>
                                        <td>
                                            @if($item->stok == 0)
                                                <span class="badge bg-danger">Habis</span>
                                            @elseif($item->stok <= 5)
                                                <span class="badge bg-warning">Menipis</span>
                                            @else
                                                <span class="badge bg-success">Tersedia</span>
                                            @endif
                                        </td>                                        <td>
                                            <span class="text-muted">
                                                {{ $item->dibuat_pada ? \Carbon\Carbon::parse($item->dibuat_pada)->format('d/m/Y') : 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.produk.show', $item->id_produk) }}" 
                                                   class="btn btn-outline-primary btn-sm" 
                                                   title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.produk.edit', $item->id_produk) }}" 
                                                   class="btn btn-outline-warning btn-sm" 
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-outline-danger btn-sm delete-product" 
                                                        data-id="{{ $item->id_produk }}" 
                                                        data-name="{{ $item->nama_produk }}"
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="empty-state text-center py-5">
                        <div class="empty-icon mb-3">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <h5>Tidak ada produk ditemukan</h5>
                        <p class="text-muted">Belum ada produk yang sesuai dengan filter yang dipilih</p>
                        <a href="{{ route('admin.produk.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Produk Pertama
                        </a>
                    </div>
                @endif
            </div>
              @if($produk->hasPages())
            <div class="card-footer border-0 bg-transparent">
                <div class="pagination-wrapper">
                    <!-- Pagination Info -->
                    <div class="pagination-info">
                        <div class="info-text">
                            <i class="fas fa-info-circle me-2"></i>
                            Menampilkan <strong>{{ $produk->firstItem() }}</strong> - <strong>{{ $produk->lastItem() }}</strong> 
                            dari <strong>{{ $produk->total() }}</strong> produk
                        </div>
                        <div class="page-info">
                            Halaman <strong>{{ $produk->currentPage() }}</strong> dari <strong>{{ $produk->lastPage() }}</strong>
                        </div>
                    </div>
                    
                    <!-- Custom Pagination -->
                    <nav class="pagination-nav">
                        <div class="pagination-controls">
                            <!-- First Page -->
                            @if($produk->currentPage() > 1)
                                <a href="{{ $produk->url(1) }}" class="pagination-btn pagination-first" title="Halaman Pertama">
                                    <i class="fas fa-angle-double-left"></i>
                                </a>
                            @else
                                <span class="pagination-btn pagination-first disabled">
                                    <i class="fas fa-angle-double-left"></i>
                                </span>
                            @endif
                            
                            <!-- Previous Page -->
                            @if($produk->previousPageUrl())
                                <a href="{{ $produk->previousPageUrl() }}" class="pagination-btn pagination-prev" title="Halaman Sebelumnya">
                                    <i class="fas fa-angle-left"></i>
                                </a>
                            @else
                                <span class="pagination-btn pagination-prev disabled">
                                    <i class="fas fa-angle-left"></i>
                                </span>
                            @endif
                            
                            <!-- Page Numbers -->
                            <div class="pagination-numbers">
                                @php
                                    $start = max(1, $produk->currentPage() - 2);
                                    $end = min($produk->lastPage(), $produk->currentPage() + 2);
                                @endphp
                                
                                @if($start > 1)
                                    <a href="{{ $produk->url(1) }}" class="pagination-number">1</a>
                                    @if($start > 2)
                                        <span class="pagination-dots">...</span>
                                    @endif
                                @endif
                                
                                @for($i = $start; $i <= $end; $i++)
                                    @if($i == $produk->currentPage())
                                        <span class="pagination-number active">{{ $i }}</span>
                                    @else
                                        <a href="{{ $produk->url($i) }}" class="pagination-number">{{ $i }}</a>
                                    @endif
                                @endfor
                                
                                @if($end < $produk->lastPage())
                                    @if($end < $produk->lastPage() - 1)
                                        <span class="pagination-dots">...</span>
                                    @endif
                                    <a href="{{ $produk->url($produk->lastPage()) }}" class="pagination-number">{{ $produk->lastPage() }}</a>
                                @endif
                            </div>
                            
                            <!-- Next Page -->
                            @if($produk->nextPageUrl())
                                <a href="{{ $produk->nextPageUrl() }}" class="pagination-btn pagination-next" title="Halaman Selanjutnya">
                                    <i class="fas fa-angle-right"></i>
                                </a>
                            @else
                                <span class="pagination-btn pagination-next disabled">
                                    <i class="fas fa-angle-right"></i>
                                </span>
                            @endif
                            
                            <!-- Last Page -->
                            @if($produk->currentPage() < $produk->lastPage())
                                <a href="{{ $produk->url($produk->lastPage()) }}" class="pagination-btn pagination-last" title="Halaman Terakhir">
                                    <i class="fas fa-angle-double-right"></i>
                                </a>
                            @else
                                <span class="pagination-btn pagination-last disabled">
                                    <i class="fas fa-angle-double-right"></i>
                                </span>
                            @endif
                        </div>
                        
                        <!-- Per Page Selector -->
                        <div class="per-page-selector">
                            <label for="perPage" class="per-page-label">
                                <i class="fas fa-list me-2"></i>Per halaman:
                            </label>
                            <select id="perPage" class="form-select form-select-sm" onchange="changePerPage(this.value)">
                                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                    </nav>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus produk <strong id="productName"></strong>?</p>
                <p class="text-muted mb-0">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .product-management {
        padding: 2rem;
    }

    .page-header {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e9ecef;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }

    .page-title i {
        color: #007bff;
    }

    .page-subtitle {
        color: #6c757d;
        margin: 0;
    }

    .btn-add-product {
        background: linear-gradient(45deg, #007bff, #0056b3);
        border: none;
        border-radius: 50px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,123,255,0.3);
    }

    .btn-add-product:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,123,255,0.4);
    }

    .stats-mini-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        border: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stats-mini-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .stats-mini-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        border-radius: 15px 15px 0 0;
    }

    .stats-primary::before {
        background: linear-gradient(90deg, #007bff, #0056b3);
    }

    .stats-success::before {
        background: linear-gradient(90deg, #28a745, #1e7e34);
    }

    .stats-warning::before {
        background: linear-gradient(90deg, #ffc107, #d39e00);
    }

    .stats-danger::before {
        background: linear-gradient(90deg, #dc3545, #c82333);
    }

    .stats-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        float: right;
        opacity: 0.3;
    }

    .stats-primary .stats-icon {
        background: linear-gradient(45deg, #007bff, #0056b3);
        color: white;
    }

    .stats-success .stats-icon {
        background: linear-gradient(45deg, #28a745, #1e7e34);
        color: white;
    }

    .stats-warning .stats-icon {
        background: linear-gradient(45deg, #ffc107, #d39e00);
        color: white;
    }

    .stats-danger .stats-icon {
        background: linear-gradient(45deg, #dc3545, #c82333);
        color: white;
    }

    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.25rem;
    }

    .stats-label {
        font-size: 0.875rem;
        color: #6c757d;
        font-weight: 500;
    }

    .filter-section {
        margin-bottom: 2rem;
    }

    .filter-section .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }

    .products-table .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }

    .card-header {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-bottom: 1px solid #e9ecef;
        border-radius: 15px 15px 0 0 !important;
        padding: 1.5rem 2rem;
    }

    .card-title {
        font-weight: 600;
        color: #2c3e50;
    }

    .product-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }

    .product-image {
        position: relative;
        overflow: hidden;
        height: 200px;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image img {
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
        opacity: 0;
        transition: all 0.3s ease;
    }

    .product-card:hover .product-overlay {
        opacity: 1;
    }

    .product-actions {
        display: flex;
        gap: 0.5rem;
    }

    .product-actions .btn {
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
    }

    .stock-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-success {
        background: linear-gradient(45deg, #28a745, #20c997);
        color: white;
    }

    .badge-warning {
        background: linear-gradient(45deg, #ffc107, #fd7e14);
        color: white;
    }

    .badge-danger {
        background: linear-gradient(45deg, #dc3545, #e83e8c);
        color: white;
    }

    .product-info {
        padding: 1.5rem;
    }

    .product-brand {
        color: #007bff;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.5rem;
    }

    .product-name {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.75rem;
        font-size: 1rem;
        line-height: 1.3;
    }

    .product-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
        font-size: 0.75rem;
    }

    .product-category {
        background: #f8f9fa;
        color: #6c757d;
        padding: 0.25rem 0.5rem;
        border-radius: 20px;
        font-weight: 500;
    }

    .product-stock {
        color: #6c757d;
        font-weight: 500;
    }

    .product-price {
        font-size: 1.125rem;
        font-weight: 700;
        color: #28a745;
        margin-bottom: 0.5rem;
    }

    .product-date {
        font-size: 0.75rem;
    }

    .product-thumb {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
    }

    .empty-state {
        padding: 4rem 2rem;
    }

    .empty-icon i {
        font-size: 4rem;
        color: #dee2e6;
    }

    .view-grid.active,
    .view-list.active {
        background: #007bff;
        color: white;
    }

    .table th {
        background: #f8f9fa;
        border: none;
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.875rem;
        padding: 1rem;
    }

    .table td {
        border: none;
        padding: 1rem;
        vertical-align: middle;
    }

    .table tbody tr {
        border-bottom: 1px solid #f1f3f4;
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background: #f8f9fa;
    }    .pagination-info {
        color: #6c757d;
        font-size: 0.875rem;
    }

    /* Enhanced Pagination Styles */
    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem 0;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .pagination-info .info-text {
        font-size: 0.95rem;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .pagination-info .page-info {
        font-size: 0.875rem;
        color: #6c757d;
    }

    .pagination-nav {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .pagination-controls {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        background: white;
        border-radius: 12px;
        padding: 0.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .pagination-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        text-decoration: none;
        color: #6c757d;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .pagination-btn:hover:not(.disabled) {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }

    .pagination-btn.disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .pagination-numbers {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        margin: 0 0.5rem;
    }

    .pagination-number {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        text-decoration: none;
        color: #495057;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }

    .pagination-number:hover {
        background: #f8f9fa;
        border-color: var(--primary-color);
        color: var(--primary-color);
        transform: translateY(-1px);
    }

    .pagination-number.active {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border-color: var(--primary-color);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        transform: translateY(-2px);
    }

    .pagination-dots {
        color: #6c757d;
        padding: 0 0.5rem;
        font-weight: bold;
    }

    .per-page-selector {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: white;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .per-page-label {
        font-size: 0.875rem;
        color: #495057;
        font-weight: 500;
        margin: 0;
        white-space: nowrap;
    }

    .per-page-selector .form-select {
        min-width: 80px;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 0.375rem 2rem 0.375rem 0.75rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }

    .per-page-selector .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }    /* Responsive */
    @media (max-width: 768px) {
        .product-management {
            padding: 1rem;
        }
        
        .page-header {
            text-align: center;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
        
        .page-actions {
            margin-top: 1rem;
        }
        
        /* Responsive Pagination */
        .pagination-wrapper {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
        }
        
        .pagination-nav {
            flex-direction: column;
            gap: 1rem;
        }
        
        .pagination-controls {
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .pagination-numbers {
            margin: 0;
        }
        
        .pagination-number,
        .pagination-btn {
            width: 35px;
            height: 35px;
            font-size: 0.875rem;
        }
        
        .per-page-selector {
            justify-content: center;
        }
        
        .pagination-info {
            text-align: center;
        }
    }
    
    @media (max-width: 576px) {
        .pagination-controls {
            padding: 0.25rem;
        }
        
        .pagination-number,
        .pagination-btn {
            width: 32px;
            height: 32px;
            font-size: 0.8rem;
        }
        
        .pagination-numbers {
            gap: 0.125rem;
        }
        
        /* Hide some pagination elements on very small screens */
        .pagination-first,
        .pagination-last {
            display: none;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // View toggle
    const viewButtons = document.querySelectorAll('[data-view]');
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const view = this.dataset.view;
            
            // Remove active class from all buttons
            viewButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            if (view === 'grid') {
                gridView.classList.remove('d-none');
                listView.classList.add('d-none');
            } else {
                gridView.classList.add('d-none');
                listView.classList.remove('d-none');
            }
        });
    });

    // Delete product
    const deleteButtons = document.querySelectorAll('.delete-product');
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const deleteForm = document.getElementById('deleteForm');
    const productNameSpan = document.getElementById('productName');    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.id;
            const productName = this.dataset.name;
            
            productNameSpan.textContent = productName;
            deleteForm.action = `{{ url('admin/produk') }}/${productId}`;
            
            deleteModal.show();
        });
    });

    // Auto-submit filter form on select change
    const filterSelects = document.querySelectorAll('.filter-section select');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            this.closest('form').submit();        });
    });

    // Success message
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    @endif
});

// Pagination Functions
function changePerPage(perPage) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', perPage);
    url.searchParams.delete('page'); // Reset to first page when changing per_page
    window.location.href = url.toString();
}

// Add loading animation to pagination links
document.addEventListener('DOMContentLoaded', function() {
    const paginationLinks = document.querySelectorAll('.pagination-number, .pagination-btn');
    
    paginationLinks.forEach(link => {
        if (!link.classList.contains('disabled') && !link.classList.contains('active')) {
            link.addEventListener('click', function(e) {
                // Add loading state
                this.style.opacity = '0.6';
                this.style.pointerEvents = 'none';
                
                // Add loading icon
                const originalContent = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                
                // Don't prevent navigation, just show loading
                setTimeout(() => {
                    if (this.style.opacity === '0.6') {
                        this.innerHTML = originalContent;
                        this.style.opacity = '1';
                        this.style.pointerEvents = 'auto';
                    }
                }, 3000);
            });
        }
    });
    
    // Add smooth scroll to top when pagination is used
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('page') || urlParams.has('per_page')) {
        document.querySelector('.page-header').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
});
</script>
@endpush
@endsection
