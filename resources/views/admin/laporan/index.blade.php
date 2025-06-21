@extends('layouts.admin')

@section('title', 'Laporan')
@section('page-title', 'Laporan & Analitik')

@section('content')
<div class="container-fluid">
    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Laporan</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.laporan.index') }}" class="row align-items-end">
                        <div class="col-md-4">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                   value="{{ $startDate }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="end_date" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                   value="{{ $endDate }}" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Filter
                            </button>
                            <a href="{{ route('admin.laporan.exportSales') }}?start_date={{ $startDate }}&end_date={{ $endDate }}" 
                               class="btn btn-success">
                                <i class="fas fa-download me-2"></i>Export
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Overview -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-primary text-white">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="ms-3">
                            <h3 class="stats-number">{{ number_format($salesData['total_pesanan']) }}</h3>
                            <p class="stats-label">Total Pesanan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-success text-white">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="ms-3">
                            <h3 class="stats-number">Rp {{ number_format($salesData['total_pendapatan'], 0, ',', '.') }}</h3>
                            <p class="stats-label">Total Pendapatan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-info text-white">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="ms-3">
                            <h3 class="stats-number">Rp {{ number_format($salesData['rata_rata_order'], 0, ',', '.') }}</h3>
                            <p class="stats-label">Rata-rata Order</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-warning text-white">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="ms-3">
                            <h3 class="stats-number">{{ number_format($customerData['pelanggan_baru']) }}</h3>
                            <p class="stats-label">Pelanggan Baru</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-area me-2"></i>Tren Penjualan</h5>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Status Pesanan</h5>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Reports -->
    <div class="row">
        <!-- Top Products -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-star me-2"></i>Produk Terlaris</h5>
                </div>
                <div class="card-body">
                    @if($productData['top_products']->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-center">Terjual</th>
                                        <th class="text-end">Pendapatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productData['top_products'] as $product)
                                    <tr>
                                        <td>{{ Str::limit($product->nama_produk, 30) }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">{{ $product->total_terjual }}</span>
                                        </td>
                                        <td class="text-end">Rp {{ number_format($product->total_pendapatan, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-box fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada data produk untuk periode ini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top Customers -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-crown me-2"></i>Pelanggan Teratas</h5>
                </div>
                <div class="card-body">
                    @if($customerData['top_customers']->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Pelanggan</th>
                                        <th class="text-center">Pesanan</th>
                                        <th class="text-end">Total Belanja</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customerData['top_customers'] as $customer)
                                    <tr>
                                        <td>{{ Str::limit($customer->nama, 20) }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-success">{{ $customer->total_pesanan }}</span>
                                        </td>
                                        <td class="text-end">Rp {{ number_format($customer->total_belanja, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada data pelanggan untuk periode ini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Product & Customer Summary -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-boxes me-2"></i>Ringkasan Produk</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <h4 class="text-primary">{{ number_format($productData['total_products']) }}</h4>
                            <small class="text-muted">Total Produk</small>
                        </div>
                        <div class="col-4">
                            <h4 class="text-warning">{{ number_format($productData['low_stock']) }}</h4>
                            <small class="text-muted">Stok Rendah</small>
                        </div>
                        <div class="col-4">
                            <h4 class="text-danger">{{ number_format($productData['out_of_stock']) }}</h4>
                            <small class="text-muted">Habis Stok</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user-friends me-2"></i>Ringkasan Pelanggan</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <h4 class="text-primary">{{ number_format($customerData['total_pelanggan']) }}</h4>
                            <small class="text-muted">Total Pelanggan</small>
                        </div>
                        <div class="col-4">
                            <h4 class="text-success">{{ number_format($customerData['pelanggan_aktif']) }}</h4>
                            <small class="text-muted">Aktif</small>
                        </div>
                        <div class="col-4">
                            <h4 class="text-info">{{ number_format($customerData['pelanggan_baru']) }}</h4>
                            <small class="text-muted">Baru (Periode)</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Sales Trend Chart
const salesCtx = document.getElementById('salesChart').getContext('2d');
const salesChart = new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: @json($chartData['labels']),
        datasets: [{
            label: 'Penjualan Harian',
            data: @json($chartData['data']),
            borderColor: 'rgb(99, 102, 241)',
            backgroundColor: 'rgba(99, 102, 241, 0.1)',
            tension: 0.1,
            fill: true
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
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});

// Order Status Pie Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
const statusLabels = @json($salesData['status_breakdown']->pluck('status_pesanan'));
const statusData = @json($salesData['status_breakdown']->pluck('total'));

const statusChart = new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: statusLabels.map(status => {
            const statusMap = {
                'menunggu': 'Menunggu',
                'diproses': 'Diproses',
                'dikirim': 'Dikirim',
                'selesai': 'Selesai'
            };
            return statusMap[status] || status;
        }),
        datasets: [{
            data: statusData,
            backgroundColor: [
                '#6366f1',
                '#8b5cf6', 
                '#06b6d4',
                '#10b981',
                '#ef4444'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Set default date to today
document.getElementById('end_date').max = new Date().toISOString().split('T')[0];
</script>
@endpush

@endsection
