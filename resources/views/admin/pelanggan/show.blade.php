@extends('layouts.admin')

@section('title', 'Detail Pelanggan')
@section('page-title', 'Detail Pelanggan')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-user me-2"></i>Detail Pelanggan
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.pelanggan.index') }}">Pelanggan</a></li>
                            <li class="breadcrumb-item active">{{ $pelanggan->nama }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.pelanggan.edit', $pelanggan->id_pelanggan) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit
                    </a>
                    <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Customer Profile -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="customer-avatar mb-3">
                        @if($pelanggan->foto)
                            <img src="{{ asset('storage/' . $pelanggan->foto) }}" 
                                 alt="{{ $pelanggan->nama }}" class="avatar-large">
                        @else
                            <div class="avatar-placeholder-large">
                                <i class="fas fa-user fa-3x"></i>
                            </div>
                        @endif
                    </div>
                    <h4 class="mb-1">{{ $pelanggan->nama }}</h4>
                    <p class="text-muted mb-3">#{{ $pelanggan->id_pelanggan }}</p>
                    
                    <div class="mb-3">
                        <span class="status-badge status-{{ strtolower($pelanggan->status_akun) }}">
                            @switch($pelanggan->status_akun)
                                @case('aktif')
                                    <i class="fas fa-check-circle me-1"></i>Aktif
                                    @break
                                @case('nonaktif')
                                    <i class="fas fa-times-circle me-1"></i>Nonaktif
                                    @break
                                @case('suspended')
                                    <i class="fas fa-ban me-1"></i>Suspended
                                    @break
                                @default
                                    {{ ucfirst($pelanggan->status_akun) }}
                            @endswitch
                        </span>
                    </div>

                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-primary btn-sm" onclick="toggleStatus('{{ $pelanggan->id_pelanggan }}')">
                            <i class="fas fa-toggle-on me-1"></i>Toggle Status
                        </button>
                        <a href="mailto:{{ $pelanggan->email }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-envelope me-1"></i>Email
                        </a>
                        <a href="tel:{{ $pelanggan->telepon }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-phone me-1"></i>Call
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Statistik Pelanggan</h6>
                </div>
                <div class="card-body">
                    <div class="stat-item mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-shopping-bag text-primary me-2"></i>
                                <span>Total Pesanan</span>
                            </div>
                            <strong>{{ $totalPesanan }}</strong>
                        </div>
                    </div>
                    <div class="stat-item mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-money-bill-wave text-success me-2"></i>
                                <span>Total Belanja</span>
                            </div>
                            <strong>Rp {{ number_format($totalBelanja, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                    <div class="stat-item mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-calendar text-info me-2"></i>
                                <span>Member Sejak</span>
                            </div>
                            <strong>{{ $pelanggan->dibuat_pada instanceof \Illuminate\Support\Carbon ? $pelanggan->dibuat_pada->format('M Y') : ($pelanggan->dibuat_pada ? date('M Y', strtotime($pelanggan->dibuat_pada)) : 'N/A') }}</strong>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-chart-line text-warning me-2"></i>
                                <span>Rata-rata Pesanan</span>
                            </div>
                            <strong>Rp {{ $totalPesanan > 0 ? number_format($totalBelanja / $totalPesanan, 0, ',', '.') : '0' }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="col-lg-8">
            <!-- Personal Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Informasi Personal</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="text-muted small">Nama Lengkap</label>
                                <p class="mb-0">{{ $pelanggan->nama }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="text-muted small">Email</label>
                                <p class="mb-0">{{ $pelanggan->email }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="text-muted small">Telepon</label>
                                <p class="mb-0">{{ $pelanggan->telepon }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="text-muted small">Tanggal Lahir</label>
                                <p class="mb-0">
                                    @if($pelanggan->tanggal_lahir)
                                        {{ $pelanggan->tanggal_lahir instanceof \Illuminate\Support\Carbon ? $pelanggan->tanggal_lahir->format('d M Y') : date('d M Y', strtotime($pelanggan->tanggal_lahir)) }}
                                        <small class="text-muted">({{ $pelanggan->tanggal_lahir instanceof \Illuminate\Support\Carbon ? $pelanggan->tanggal_lahir->age : \Carbon\Carbon::parse($pelanggan->tanggal_lahir)->age }} tahun)</small>
                                    @else
                                        <span class="text-muted">Tidak diisi</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="info-item">
                                <label class="text-muted small">Alamat</label>
                                <p class="mb-0">{{ $pelanggan->alamat ?: 'Tidak diisi' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Pesanan Terbaru</h6>
                        <a href="{{ route('admin.pesanan.index', ['customer' => $pelanggan->id_pelanggan]) }}" 
                           class="btn btn-sm btn-outline-primary">
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($pelanggan->pesanan->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">ID Pesanan</th>
                                        <th class="border-0">Tanggal</th>
                                        <th class="border-0">Status</th>
                                        <th class="border-0">Total</th>
                                        <th class="border-0">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pelanggan->pesanan->take(5) as $pesanan)
                                    <tr>
                                        <td>
                                            <strong>#{{ $pesanan->id_pesanan }}</strong>
                                        </td>
                                        <td>
                                            {{ $pesanan->dibuat_pada instanceof \Illuminate\Support\Carbon ? $pesanan->dibuat_pada->format('d M Y') : ($pesanan->dibuat_pada ? date('d M Y', strtotime($pesanan->dibuat_pada)) : 'N/A') }}
                                        </td>
                                        <td>
                                            <span class="status-badge status-{{ strtolower($pesanan->status_pesanan) }}">
                                                {{ ucfirst($pesanan->status_pesanan) }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.pesanan.show', $pesanan->id_pesanan) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                            <h5>Belum ada pesanan</h5>
                            <p class="text-muted">Pelanggan ini belum pernah melakukan pesanan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-large {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #fff;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.avatar-placeholder-large {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    border: 4px solid #fff;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    margin: 0 auto;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
    text-transform: capitalize;
}

.status-aktif {
    background: #d4edda;
    color: #155724;
}

.status-nonaktif {
    background: #f8d7da;
    color: #721c24;
}

.status-suspended {
    background: #fff3cd;
    color: #856404;
}

.status-menunggu {
    background: #fff3cd;
    color: #856404;
}

.status-diproses {
    background: #cce5ff;
    color: #004085;
}

.status-dikirim {
    background: #e7f3ff;
    color: #0056b3;
}

.status-selesai {
    background: #d4edda;
    color: #155724;
}

.status-dibatalkan {
    background: #f8d7da;
    color: #721c24;
}

.stat-item {
    padding: 0.75rem 0;
    border-bottom: 1px solid #f8f9fa;
}

.stat-item:last-child {
    border-bottom: none;
}

.info-item label {
    font-weight: 600;
    margin-bottom: 0.25rem;
    display: block;
}
</style>

<script>
// Toggle status
function toggleStatus(customerId) {
    if (confirm('Apakah Anda yakin ingin mengubah status pelanggan ini?')) {
        fetch(`/admin/pelanggan/${customerId}/toggle-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal mengubah status pelanggan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengubah status pelanggan');
        });
    }
}
</script>
@endsection
