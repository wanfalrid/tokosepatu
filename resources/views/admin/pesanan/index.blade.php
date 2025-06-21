@extends('layouts.admin')

@section('page-title', 'Manajemen Pesanan')

@section('content')
<div class="orders-management">
    <!-- Header Section -->
    <div class="page-header" data-aos="fade-down">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-shopping-cart me-3"></i>Manajemen Pesanan
                </h1>
                <p class="page-subtitle">Kelola semua pesanan pelanggan</p>
            </div>
            <div class="page-actions">
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-download me-2"></i>Export Data
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel me-2"></i>Export Excel</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf me-2"></i>Export PDF</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5" data-aos="fade-up">
        <div class="col-md-3">
            <div class="stats-mini-card stats-primary">
                <div class="stats-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-number">{{ $pesanan->total() }}</div>
                    <div class="stats-label">Total Pesanan</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-mini-card stats-warning">
                <div class="stats-icon">
                    <i class="fas fa-clock"></i>
                </div>                <div class="stats-content">
                    <div class="stats-number">{{ $pesanan->where('status_pesanan', 'menunggu')->count() }}</div>
                    <div class="stats-label">Menunggu Proses</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-mini-card stats-info">
                <div class="stats-icon">
                    <i class="fas fa-truck"></i>
                </div>                <div class="stats-content">
                    <div class="stats-number">{{ $pesanan->where('status_pesanan', 'dikirim')->count() }}</div>
                    <div class="stats-label">Dalam Pengiriman</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-mini-card stats-success">
                <div class="stats-icon">
                    <i class="fas fa-check-circle"></i>
                </div>                <div class="stats-content">
                    <div class="stats-number">{{ $pesanan->where('status_pesanan', 'selesai')->count() }}</div>
                    <div class="stats-label">Selesai</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="filters-section" data-aos="fade-up" data-aos-delay="100">
        <div class="filters-card">
            <div class="filters-header">
                <h4 class="filters-title">
                    <i class="fas fa-filter me-2"></i>Filter & Pencarian
                </h4>
            </div>
            <div class="filters-body">
                <form method="GET" action="{{ route('admin.pesanan.index') }}" class="filter-form">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="search" name="search" 
                                       placeholder="Cari pesanan..." value="{{ request('search') }}">
                                <label for="search">
                                    <i class="fas fa-search me-2"></i>Cari Pesanan
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating">
                                <select class="form-select" id="status" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="dikirim" {{ request('status') == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                                <label for="status">Status</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="date_from" name="date_from" 
                                       value="{{ request('date_from') }}">
                                <label for="date_from">Dari Tanggal</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="date_to" name="date_to" 
                                       value="{{ request('date_to') }}">
                                <label for="date_to">Sampai Tanggal</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating">
                                <select class="form-select" id="per_page" name="per_page">
                                    <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10 per halaman</option>
                                    <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25 per halaman</option>
                                    <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50 per halaman</option>
                                    <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100 per halaman</option>
                                </select>
                                <label for="per_page">Tampilkan</label>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary btn-filter">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="orders-table-section" data-aos="fade-up" data-aos-delay="200">
        <div class="table-card">
            <div class="table-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="table-title">
                        <i class="fas fa-list me-2"></i>Daftar Pesanan
                    </h4>
                    <div class="table-actions">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="selectAll()">
                                <i class="fas fa-check-square me-1"></i>Pilih Semua
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="bulkAction('delete')" id="bulkDeleteBtn" style="display: none;">
                                <i class="fas fa-trash me-1"></i>Hapus Terpilih
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table orders-table">
                    <thead>
                        <tr>
                            <th width="50">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="checkAll">
                                </div>
                            </th>
                            <th>ID</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Pembayaran</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesanan as $order)
                        <tr class="order-row" data-order-id="{{ $order->id }}">
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input order-checkbox" type="checkbox" value="{{ $order->id }}">
                                </div>
                            </td>
                            <td>
                                <div class="order-id-cell">
                                    <span class="order-id">#{{ $order->id }}</span>
                                    <div class="order-date-mobile d-md-none">
                                        {{ $order->created_at->format('d M Y') }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="customer-info">
                                    <div class="customer-name">{{ $order->pelanggan->nama }}</div>
                                    <div class="customer-contact">
                                        <small class="text-muted">{{ $order->pelanggan->email }}</small><br>
                                        <small class="text-muted">{{ $order->pelanggan->telepon }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="total-info">
                                    <div class="total-amount">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                                    <div class="item-count">{{ $order->detailPesanan->sum('jumlah') }} item</div>
                                </div>
                            </td>
                            <td>
                                <div class="status-container">
                                    <span class="status-badge status-{{ strtolower($order->status) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <div class="status-actions">
                                        <select class="form-select form-select-sm status-select" 
                                                onchange="updateStatus({{ $order->id }}, this.value)">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="dikirim" {{ $order->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                            <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="dibatalkan" {{ $order->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                        </select>
                                    </div>
                                </div>
                            </td>                            <td>
                                @if($order->pembayaran)
                                    <span class="payment-badge payment-{{ strtolower($order->pembayaran->status_pembayaran) }}">
                                        {{ ucfirst($order->pembayaran->status_pembayaran) }}
                                    </span>
                                    <div class="payment-amount">
                                        <small class="text-muted">Rp {{ number_format($order->pembayaran->jumlah_bayar, 0, ',', '.') }}</small>
                                    </div>
                                @else
                                    <span class="payment-badge payment-pending">Belum Bayar</span>
                                @endif
                            </td>
                            <td class="d-none d-md-table-cell">
                                <div class="date-info">
                                    <div class="order-date">{{ $order->created_at->format('d M Y') }}</div>
                                    <div class="order-time">{{ $order->created_at->format('H:i') }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.pesanan.show', $order->id) }}" 
                                       class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-success" 
                                            onclick="printInvoice({{ $order->id }})" title="Cetak Invoice">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('admin.pesanan.show', $order->id) }}">
                                                <i class="fas fa-eye me-2"></i>Lihat Detail
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="printInvoice({{ $order->id }})">
                                                <i class="fas fa-print me-2"></i>Cetak Invoice
                                            </a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#" 
                                                   onclick="deleteOrder({{ $order->id }})">
                                                <i class="fas fa-trash me-2"></i>Hapus
                                            </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-shopping-cart empty-icon"></i>
                                    <h5 class="empty-title">Tidak ada pesanan</h5>
                                    <p class="empty-text">Belum ada pesanan yang masuk ke sistem</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($pesanan->hasPages())
            <div class="table-pagination">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="pagination-info">
                        Menampilkan {{ $pesanan->firstItem() }} - {{ $pesanan->lastItem() }} 
                        dari {{ $pesanan->total() }} pesanan
                    </div>
                    <div class="pagination-links">
                        {{ $pesanan->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.orders-management {
    padding: 2rem 0;
}

.stats-mini-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
    height: 100%;
}

.stats-mini-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.stats-primary .stats-icon {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
}

.stats-warning .stats-icon {
    background: linear-gradient(135deg, #ffc107, #fd7e14);
}

.stats-info .stats-icon {
    background: linear-gradient(135deg, #17a2b8, #20c997);
}

.stats-success .stats-icon {
    background: linear-gradient(135deg, #28a745, #20c997);
}

.stats-content {
    flex: 1;
}

.stats-number {
    font-size: 2rem;
    font-weight: 700;
    color: #333;
    line-height: 1;
}

.stats-label {
    color: #6c757d;
    font-size: 0.9rem;
    margin-top: 0.25rem;
}

.filters-section {
    margin-bottom: 2rem;
}

.filters-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.filters-header {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #dee2e6;
}

.filters-title {
    margin: 0;
    color: #333;
    font-size: 1.1rem;
}

.filters-body {
    padding: 1.5rem;
}

.btn-filter {
    height: 58px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.table-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.table-header {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 1.5rem;
    border-bottom: 1px solid #dee2e6;
}

.table-title {
    margin: 0;
    color: #333;
    font-size: 1.2rem;
}

.orders-table {
    margin: 0;
}

.orders-table thead th {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    border: none;
    padding: 1rem;
    font-weight: 600;
    font-size: 0.9rem;
}

.order-row {
    transition: all 0.3s ease;
}

.order-row:hover {
    background: #f8f9fa;
}

.order-row td {
    padding: 1rem;
    vertical-align: middle;
    border-bottom: 1px solid #e9ecef;
}

.order-id {
    font-weight: 600;
    color: var(--primary-color);
    font-size: 1rem;
}

.customer-info .customer-name {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.25rem;
}

.customer-contact {
    font-size: 0.85rem;
}

.total-amount {
    font-weight: 600;
    color: var(--primary-color);
    font-size: 1rem;
}

.item-count {
    font-size: 0.85rem;
    color: #6c757d;
}

.status-container {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.status-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    text-align: center;
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

.status-select {
    border-radius: 8px;
    font-size: 0.8rem;
}

.payment-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    display: inline-block;
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

.payment-method {
    margin-top: 0.25rem;
    font-size: 0.8rem;
}

.date-info .order-date {
    font-weight: 600;
    color: #333;
}

.date-info .order-time {
    font-size: 0.85rem;
    color: #6c757d;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.action-buttons .btn {
    border-radius: 8px;
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-icon {
    font-size: 4rem;
    color: #dee2e6;
    margin-bottom: 1rem;
}

.empty-title {
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.empty-text {
    color: #adb5bd;
    font-size: 0.9rem;
}

.table-pagination {
    padding: 1.5rem;
    background: #f8f9fa;
    border-top: 1px solid #dee2e6;
}

.pagination-info {
    color: #6c757d;
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .stats-mini-card {
        text-align: center;
        flex-direction: column;
    }
    
    .filters-body .row {
        row-gap: 1rem;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .action-buttons .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
// Checkbox handling
document.getElementById('checkAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.order-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    toggleBulkActions();
});

document.querySelectorAll('.order-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', toggleBulkActions);
});

function toggleBulkActions() {
    const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    
    if (checkedBoxes.length > 0) {
        bulkDeleteBtn.style.display = 'inline-block';
    } else {
        bulkDeleteBtn.style.display = 'none';
    }
}

function selectAll() {
    const checkAll = document.getElementById('checkAll');
    checkAll.checked = true;
    checkAll.dispatchEvent(new Event('change'));
}

// Status update
function updateStatus(orderId, newStatus) {
    if (confirm(`Apakah Anda yakin ingin mengubah status pesanan #${orderId} menjadi ${newStatus}?`)) {
        fetch(`/admin/pesanan/${orderId}/status`, {
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

// Delete order
function deleteOrder(orderId) {
    if (confirm(`Apakah Anda yakin ingin menghapus pesanan #${orderId}? Tindakan ini tidak dapat dibatalkan.`)) {
        fetch(`/admin/pesanan/${orderId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
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

// Print invoice
function printInvoice(orderId) {
    window.open(`/admin/pesanan/${orderId}/invoice`, '_blank');
}

// Bulk actions
function bulkAction(action) {
    const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
    const orderIds = Array.from(checkedBoxes).map(cb => cb.value);
    
    if (orderIds.length === 0) {
        alert('Pilih minimal satu pesanan untuk diproses');
        return;
    }
    
    if (action === 'delete') {
        if (confirm(`Apakah Anda yakin ingin menghapus ${orderIds.length} pesanan yang dipilih? Tindakan ini tidak dapat dibatalkan.`)) {
            // Implement bulk delete
            console.log('Bulk delete:', orderIds);
        }
    }
}

// Auto-submit filter form
document.querySelectorAll('.filter-form select, .filter-form input[type="date"]').forEach(element => {
    element.addEventListener('change', function() {
        this.form.submit();
    });
});

// Real-time search with debounce
let searchTimeout;
document.getElementById('search').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        this.form.submit();
    }, 500);
});
</script>
@endsection
