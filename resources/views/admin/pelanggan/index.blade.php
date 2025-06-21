@extends('layouts.admin')

@section('title', 'Kelola Pelanggan')
@section('page-title', 'Kelola Pelanggan')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-users me-2"></i>Kelola Pelanggan
                    </h1>
                    <p class="text-muted mb-0">Manajemen data pelanggan toko sepatu</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.pelanggan.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Pelanggan
                    </a>
                    <button class="btn btn-success" onclick="exportData()">
                        <i class="fas fa-download me-2"></i>Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Cari Pelanggan</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Nama, email, atau telepon">
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status Akun</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i>Cari
                                </button>
                                <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i>Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary">
                            <i class="fas fa-users text-white"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0">{{ $pelanggan->total() }}</h5>
                            <small class="text-muted">Total Pelanggan</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-success">
                            <i class="fas fa-user-check text-white"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0">{{ \App\Models\Pelanggan::where('status_akun', 'aktif')->count() }}</h5>
                            <small class="text-muted">Pelanggan Aktif</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-warning">
                            <i class="fas fa-user-times text-white"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0">{{ \App\Models\Pelanggan::where('status_akun', 'nonaktif')->count() }}</h5>
                            <small class="text-muted">Nonaktif</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-danger">
                            <i class="fas fa-user-slash text-white"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0">{{ \App\Models\Pelanggan::where('status_akun', 'suspended')->count() }}</h5>
                            <small class="text-muted">Suspended</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customers Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Daftar Pelanggan</h6>
                        <div class="d-flex gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                                <label class="form-check-label" for="selectAll">
                                    Pilih Semua
                                </label>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                                        data-bs-toggle="dropdown">
                                    Aksi Massal
                                </button>                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" onclick="bulkAction('activate')">
                                        <i class="fas fa-check me-2"></i>Aktifkan
                                    </a></li>
                                    <li><a class="dropdown-item" href="#" onclick="bulkAction('deactivate')">
                                        <i class="fas fa-times me-2"></i>Nonaktifkan
                                    </a></li>
                                    <li><a class="dropdown-item" href="#" onclick="bulkAction('suspend')">
                                        <i class="fas fa-ban me-2"></i>Suspend
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="#" onclick="bulkAction('delete')">
                                        <i class="fas fa-trash me-2"></i>Hapus
                                    </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll">
                                        </div>
                                    </th>
                                    <th class="border-0">Pelanggan</th>
                                    <th class="border-0">Kontak</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0">Total Pesanan</th>
                                    <th class="border-0 d-none d-md-table-cell">Terdaftar</th>
                                    <th class="border-0">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pelanggan as $customer)
                                <tr class="customer-row">
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input customer-checkbox" type="checkbox" 
                                                   value="{{ $customer->id_pelanggan }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="customer-avatar me-3">
                                                @if($customer->foto)
                                                    <img src="{{ asset('storage/' . $customer->foto) }}" 
                                                         alt="{{ $customer->nama }}" class="avatar">
                                                @else
                                                    <div class="avatar-placeholder">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $customer->nama }}</h6>
                                                <small class="text-muted">#{{ $customer->id_pelanggan }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="mb-1">
                                                <i class="fas fa-envelope text-muted me-1"></i>
                                                <span class="small">{{ $customer->email }}</span>
                                            </div>
                                            <div>
                                                <i class="fas fa-phone text-muted me-1"></i>
                                                <span class="small">{{ $customer->telepon }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ strtolower($customer->status_akun) }}">
                                            @switch($customer->status_akun)
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
                                                    {{ ucfirst($customer->status_akun) }}
                                            @endswitch
                                        </span>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $customer->pesanan->count() }}</strong> pesanan
                                            <br>
                                            <small class="text-muted">
                                                Rp {{ number_format($customer->pesanan->sum('total_harga'), 0, ',', '.') }}
                                            </small>
                                        </div>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <div class="date-info">
                                            <div>{{ $customer->dibuat_pada instanceof \Illuminate\Support\Carbon ? $customer->dibuat_pada->format('d M Y') : ($customer->dibuat_pada ? date('d M Y', strtotime($customer->dibuat_pada)) : 'N/A') }}</div>
                                            <small class="text-muted">{{ $customer->dibuat_pada instanceof \Illuminate\Support\Carbon ? $customer->dibuat_pada->format('H:i') : ($customer->dibuat_pada ? date('H:i', strtotime($customer->dibuat_pada)) : 'N/A') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.pelanggan.show', $customer->id_pelanggan) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.pelanggan.edit', $customer->id_pelanggan) }}" 
                                               class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-info" 
                                                    onclick="toggleStatus('{{ $customer->id_pelanggan }}')" 
                                                    title="Toggle Status">
                                                <i class="fas fa-toggle-on"></i>
                                            </button>
                                            <div class="dropdown d-inline">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                        type="button" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ route('admin.pelanggan.show', $customer->id_pelanggan) }}">
                                                        <i class="fas fa-eye me-2"></i>Lihat Detail
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="{{ route('admin.pelanggan.edit', $customer->id_pelanggan) }}">
                                                        <i class="fas fa-edit me-2"></i>Edit
                                                    </a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#" 
                                                           onclick="deleteCustomer('{{ $customer->id_pelanggan }}')">
                                                        <i class="fas fa-trash me-2"></i>Hapus
                                                    </a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                            <h5>Belum ada pelanggan</h5>
                                            <p class="text-muted">Tambah pelanggan pertama untuk memulai.</p>
                                            <a href="{{ route('admin.pelanggan.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus me-2"></i>Tambah Pelanggan
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($pelanggan->hasPages())
                <div class="card-footer bg-white border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Menampilkan {{ $pelanggan->firstItem() }} - {{ $pelanggan->lastItem() }} 
                            dari {{ $pelanggan->total() }} pelanggan
                        </div>
                        {{ $pelanggan->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.stat-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
}

.customer-avatar .avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.avatar-placeholder {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
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

.action-buttons {
    display: flex;
    gap: 0.25rem;
    align-items: center;
}

.empty-state {
    padding: 2rem;
}

.customer-row:hover {
    background-color: #f8f9fa;
}

@media (max-width: 768px) {
    .action-buttons .btn:not(.dropdown-toggle) {
        display: none;
    }
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

// Delete customer
function deleteCustomer(customerId) {
    if (confirm('Apakah Anda yakin ingin menghapus pelanggan ini? Tindakan ini tidak dapat dibatalkan.')) {
        fetch(`/admin/pelanggan/${customerId}`, {
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
                alert(data.message || 'Gagal menghapus pelanggan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus pelanggan');
        });
    }
}

// Export data
function exportData() {
    window.location.href = '{{ route("admin.pelanggan.export") }}';
}

// Bulk actions
function bulkAction(action) {
    const checkedBoxes = document.querySelectorAll('.customer-checkbox:checked');
    const customerIds = Array.from(checkedBoxes).map(cb => cb.value);
    
    if (customerIds.length === 0) {
        alert('Pilih minimal satu pelanggan untuk diproses');
        return;
    }
    
    let confirmMessage = '';
    switch(action) {
        case 'delete':
            confirmMessage = `Hapus ${customerIds.length} pelanggan yang dipilih? Tindakan ini tidak dapat dibatalkan.`;
            break;
        case 'activate':
            confirmMessage = `Aktifkan ${customerIds.length} pelanggan yang dipilih?`;
            break;
        case 'deactivate':
            confirmMessage = `Nonaktifkan ${customerIds.length} pelanggan yang dipilih?`;
            break;
        case 'suspend':
            confirmMessage = `Suspend ${customerIds.length} pelanggan yang dipilih?`;
            break;
        default:
            alert('Aksi tidak valid');
            return;
    }
    
    if (confirm(confirmMessage)) {
        // Show loading state
        const button = event.target;
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        button.disabled = true;
        
        fetch('{{ route("admin.pelanggan.bulkAction") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action: action,
                ids: customerIds
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert(data.message || 'Gagal memproses aksi massal');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memproses aksi massal');
        })
        .finally(() => {
            button.innerHTML = originalText;
            button.disabled = false;
        });
    }
}

// Select all functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.customer-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
});

// Auto-submit filter form on change
document.querySelectorAll('#status').forEach(element => {
    element.addEventListener('change', function() {
        this.form.submit();
    });
});
</script>
@endsection
