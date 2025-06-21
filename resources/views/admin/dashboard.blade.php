@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<div class="dashboard-content">
    <!-- Stats Cards -->
    <div class="row g-4 mb-5" data-aos="fade-up">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-card-primary">
                <div class="stats-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-number">{{ number_format($totalProduk) }}</div>
                    <div class="stats-label">Total Produk</div>
                </div>
                <div class="stats-trend">
                    <i class="fas fa-arrow-up"></i>
                    <span>+12% dari bulan lalu</span>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-card-success">
                <div class="stats-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-number">{{ number_format($totalPesanan) }}</div>
                    <div class="stats-label">Total Pesanan</div>
                </div>
                <div class="stats-trend">
                    <i class="fas fa-arrow-up"></i>
                    <span>+8% dari bulan lalu</span>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-card-info">
                <div class="stats-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-number">{{ number_format($totalPelanggan) }}</div>
                    <div class="stats-label">Total Pelanggan</div>
                </div>
                <div class="stats-trend">
                    <i class="fas fa-arrow-up"></i>
                    <span>+15% dari bulan lalu</span>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-card-warning">
                <div class="stats-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-number">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                    <div class="stats-label">Total Pendapatan</div>
                </div>
                <div class="stats-trend">
                    <i class="fas fa-arrow-up"></i>
                    <span>+23% dari bulan lalu</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-5">
        <div class="col-lg-8" data-aos="fade-right">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-chart-line me-2"></i>
                        Penjualan Bulanan
                    </h5>
                    <div class="card-actions">
                        <select class="form-select form-select-sm">
                            <option>2024</option>
                            <option>2023</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="300"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4" data-aos="fade-left">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-chart-pie me-2"></i>
                        Status Pesanan
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="orderStatusChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row g-4">
        <!-- Recent Orders -->
        <div class="col-lg-8" data-aos="fade-up">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-clock me-2"></i>
                        Pesanan Terbaru
                    </h5>
                    <a href="{{ route('admin.pesanan.index') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>Pelanggan</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pesananTerbaru as $pesanan)
                                <tr>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $pesanan->id_pesanan }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar me-2">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $pesanan->nama_penerima }}</div>
                                                <small class="text-muted">{{ $pesanan->email_penerima }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success">
                                            Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>                                        <span class="badge 
                                            @if($pesanan->status_pesanan == 'menunggu') bg-warning
                                            @elseif($pesanan->status_pesanan == 'diproses') bg-info
                                            @elseif($pesanan->status_pesanan == 'dikirim') bg-primary
                                            @elseif($pesanan->status_pesanan == 'selesai') bg-success
                                            @else bg-danger
                                            @endif">
                                            {{ ucfirst($pesanan->status_pesanan) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted">
                                            {{ $pesanan->tanggal_pesanan->format('d/m/Y H:i') }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.pesanan.show', $pesanan->id_pesanan) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        Belum ada pesanan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Widgets -->
        <div class="col-lg-4">
            <!-- Top Products -->
            <div class="dashboard-card mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-star me-2"></i>
                        Produk Terlaris
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($topProduk as $produk)
                    <div class="product-item d-flex align-items-center mb-3">
                        <div class="product-image me-3">
                            <img src="{{ $produk->gambar ?: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=80&q=80' }}" 
                                 alt="{{ $produk->nama_produk }}" 
                                 class="rounded">
                        </div>
                        <div class="product-info flex-grow-1">
                            <div class="product-name">{{ $produk->nama_produk }}</div>
                            <div class="product-meta">
                                <span class="text-success fw-semibold">{{ $produk->total_terjual ?? 0 }} terjual</span>
                                <span class="text-muted ms-2">{{ $produk->merek }}</span>
                            </div>
                        </div>
                        <div class="product-price">
                            <span class="fw-bold">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center">Belum ada data produk terlaris</p>
                    @endforelse
                </div>
            </div>

            <!-- Low Stock Alert -->
            @if($stokRendah->count() > 0)
            <div class="dashboard-card" data-aos="fade-up" data-aos-delay="200">
                <div class="card-header">
                    <h5 class="card-title text-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Stok Menipis
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($stokRendah as $produk)
                    <div class="alert alert-warning d-flex align-items-center mb-2">
                        <i class="fas fa-box me-2"></i>
                        <div class="flex-grow-1">
                            <strong>{{ $produk->nama_produk }}</strong>
                            <br>
                            <small>Stok tersisa: {{ $produk->stok }} unit</small>
                        </div>
                        <a href="{{ route('admin.produk.edit', $produk->id_produk) }}" 
                           class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .dashboard-content {
        padding: 2rem;
    }

    .stats-card {
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
        border-radius: 20px;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        animation: fadeInUp 0.6s ease-out;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #007bff, #0056b3);
        border-radius: 20px 20px 0 0;
    }

    .stats-card-primary::before {
        background: linear-gradient(90deg, #007bff, #0056b3);
    }

    .stats-card-success::before {
        background: linear-gradient(90deg, #28a745, #1e7e34);
    }

    .stats-card-info::before {
        background: linear-gradient(90deg, #17a2b8, #117a8b);
    }

    .stats-card-warning::before {
        background: linear-gradient(90deg, #ffc107, #d39e00);
    }

    .stats-icon {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        opacity: 0.2;
    }

    .stats-card-primary .stats-icon {
        background: linear-gradient(45deg, #007bff, #0056b3);
        color: white;
    }

    .stats-card-success .stats-icon {
        background: linear-gradient(45deg, #28a745, #1e7e34);
        color: white;
    }

    .stats-card-info .stats-icon {
        background: linear-gradient(45deg, #17a2b8, #117a8b);
        color: white;
    }

    .stats-card-warning .stats-icon {
        background: linear-gradient(45deg, #ffc107, #d39e00);
        color: white;
    }

    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        background: linear-gradient(45deg, #2c3e50, #34495e);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stats-label {
        font-size: 1rem;
        color: #6c757d;
        font-weight: 500;
        margin-bottom: 1rem;
    }

    .stats-trend {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: #28a745;
        font-weight: 500;
    }

    .stats-trend i {
        font-size: 0.75rem;
    }

    .dashboard-card {
        background: white;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: all 0.3s ease;
        animation: fadeInUp 0.6s ease-out;
    }

    .dashboard-card:hover {
        box-shadow: 0 20px 40px rgba(0,0,0,0.12);
    }

    .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #e9ecef;
        padding: 1.5rem 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-title {
        margin: 0;
        font-size: 1.125rem;
        font-weight: 600;
        color: #2c3e50;
        display: flex;
        align-items: center;
    }

    .card-title i {
        color: #007bff;
    }

    .card-actions {
        display: flex;
        gap: 0.5rem;
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
        transform: translateX(2px);
    }

    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(45deg, #007bff, #0056b3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.875rem;
    }

    .product-item {
        padding: 1rem;
        border-radius: 12px;
        background: #f8f9fa;
        transition: all 0.3s ease;
    }

    .product-item:hover {
        background: #e9ecef;
        transform: translateX(5px);
    }

    .product-image img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
    }

    .product-name {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }

    .product-meta {
        font-size: 0.75rem;
    }

    .product-price {
        text-align: right;
        font-size: 0.875rem;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Chart containers */
    #salesChart, #orderStatusChart {
        max-height: 300px !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-content {
            padding: 1rem;
        }
        
        .stats-card {
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .stats-number {
            font-size: 2rem;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const salesData = @json($salesData);
    
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Penjualan',
                data: Array.from({length: 12}, (_, i) => {
                    const monthData = salesData.find(item => item.month === i + 1);
                    return monthData ? monthData.total_revenue : 0;
                }),
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#007bff',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        }
                    },
                    grid: {
                        color: '#f1f3f4'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            elements: {
                point: {
                    hoverBackgroundColor: '#007bff'
                }
            }
        }
    });

    // Order Status Chart
    const statusCtx = document.getElementById('orderStatusChart').getContext('2d');
    
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'],
            datasets: [{
                data: [25, 35, 20, 15, 5], // Sample data
                backgroundColor: [
                    '#ffc107',
                    '#17a2b8',
                    '#007bff',
                    '#28a745',
                    '#dc3545'
                ],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection
