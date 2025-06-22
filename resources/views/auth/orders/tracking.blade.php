@extends('layouts.app')

@section('title', 'Lacak Pesanan #' . $order->id_pesanan . ' - ShoeMart')

@section('content')
<div class="order-tracking-container">
    <div class="container py-5">
        <!-- Page Header -->
        <div class="page-header text-center mb-5" data-aos="fade-down">
            <div class="breadcrumb-nav mb-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('auth.orders') }}">Riwayat Pesanan</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('auth.orders.detail', $order->id_pesanan) }}">Detail Pesanan</a></li>
                        <li class="breadcrumb-item active">Lacak Pesanan</li>
                    </ol>
                </nav>
            </div>
            <h1 class="page-title">
                <i class="fas fa-map-marker-alt me-3"></i>Lacak Pesanan #{{ $order->id_pesanan }}
            </h1>
            <p class="page-subtitle">Pantau status pengiriman pesanan Anda secara real-time</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Order Info Card -->
                <div class="order-info-card mb-4" data-aos="fade-up">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-package me-2"></i>Informasi Pengiriman
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Nomor Resi:</label>
                                    <span class="info-value">{{ $order->nomor_resi ?? 'Belum tersedia' }}</span>
                                </div>
                                <div class="info-item">
                                    <label>Kurir:</label>
                                    <span class="info-value">{{ $order->trackingPesanan->first()->kurir ?? 'JNE Regular' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Status Pengiriman:</label>
                                    <span class="status-badge status-{{ strtolower($order->status_pesanan) }}">
                                        @switch($order->status_pesanan)
                                            @case('dikirim')
                                                <i class="fas fa-truck me-1"></i>Dalam Pengiriman
                                                @break
                                            @case('selesai')
                                                <i class="fas fa-check-circle me-1"></i>Terkirim
                                                @break
                                            @default
                                                {{ ucfirst($order->status_pesanan) }}
                                        @endswitch
                                    </span>
                                </div>
                                <div class="info-item">
                                    <label>Estimasi Tiba:</label>
                                    <span class="info-value">{{ $order->estimasi_selesai ? $order->estimasi_selesai->format('d M Y') : '2-3 hari kerja' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tracking Timeline -->
                <div class="tracking-timeline-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-route me-2"></i>Riwayat Pengiriman
                        </h5>
                    </div>
                    <div class="card-body">                        <div class="tracking-timeline">                            @php
                                // Pastikan $baseDate tidak null dengan fallback ke current time
                                $baseDate = $order->dibuat_pada ?? $order->tanggal_pesanan ?? now();
                                
                                // Fungsi helper untuk safe date calculation
                                $safeDateCalc = function($baseDate, $method, $value = null) {
                                    if (!$baseDate) return 'N/A';
                                    try {
                                        $date = $baseDate->copy();
                                        if ($value !== null) {
                                            return $date->$method($value)->format('d M Y H:i');
                                        } else {
                                            return $date->$method()->format('d M Y H:i');
                                        }
                                    } catch (Exception $e) {
                                        return 'N/A';
                                    }
                                };
                                
                                $trackingSteps = [
                                    [
                                        'status' => 'order_placed',
                                        'title' => 'Pesanan Dibuat',
                                        'description' => 'Pesanan Anda telah berhasil dibuat dan akan segera diproses',
                                        'icon' => 'fas fa-shopping-cart',
                                        'completed' => true,
                                        'date' => $baseDate ? $baseDate->format('d M Y H:i') : 'N/A'
                                    ],
                                    [
                                        'status' => 'confirmed',
                                        'title' => 'Pesanan Dikonfirmasi',
                                        'description' => 'Pesanan Anda telah dikonfirmasi dan sedang diproses',
                                        'icon' => 'fas fa-check-circle',
                                        'completed' => in_array($order->status_pesanan, ['diproses', 'dikirim', 'selesai']),
                                        'date' => in_array($order->status_pesanan, ['diproses', 'dikirim', 'selesai']) ? $safeDateCalc($baseDate, 'addHours', 2) : null
                                    ],
                                    [
                                        'status' => 'packed',
                                        'title' => 'Pesanan Dikemas',
                                        'description' => 'Pesanan Anda sedang dikemas dan siap untuk dikirim',
                                        'icon' => 'fas fa-box',
                                        'completed' => in_array($order->status_pesanan, ['dikirim', 'selesai']),
                                        'date' => in_array($order->status_pesanan, ['dikirim', 'selesai']) ? $safeDateCalc($baseDate, 'addHours', 6) : null
                                    ],
                                    [
                                        'status' => 'shipped',
                                        'title' => 'Pesanan Dikirim',
                                        'description' => 'Pesanan Anda sedang dalam perjalanan ke alamat tujuan',
                                        'icon' => 'fas fa-truck',
                                        'completed' => in_array($order->status_pesanan, ['dikirim', 'selesai']),
                                        'date' => in_array($order->status_pesanan, ['dikirim', 'selesai']) ? $safeDateCalc($baseDate, 'addDay') : null
                                    ],
                                    [
                                        'status' => 'delivered',
                                        'title' => 'Pesanan Terkirim',
                                        'description' => 'Pesanan Anda telah berhasil diterima di alamat tujuan',
                                        'icon' => 'fas fa-home',
                                        'completed' => $order->status_pesanan === 'selesai',
                                        'date' => $order->status_pesanan === 'selesai' ? $safeDateCalc($baseDate, 'addDays', 3) : null
                                    ]
                                ];
                            @endphp

                            @foreach($trackingSteps as $index => $step)
                            <div class="timeline-item {{ $step['completed'] ? 'completed' : 'pending' }}">
                                <div class="timeline-marker">
                                    <div class="timeline-icon {{ $step['completed'] ? 'completed' : 'pending' }}">
                                        <i class="{{ $step['icon'] }}"></i>
                                    </div>
                                    @if($index < count($trackingSteps) - 1)
                                    <div class="timeline-line {{ $trackingSteps[$index + 1]['completed'] ? 'completed' : 'pending' }}"></div>
                                    @endif
                                </div>
                                <div class="timeline-content">
                                    <div class="timeline-header">
                                        <h6 class="timeline-title">{{ $step['title'] }}</h6>
                                        @if($step['date'])
                                        <span class="timeline-date">{{ $step['date'] }}</span>
                                        @endif
                                    </div>
                                    <p class="timeline-description">{{ $step['description'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Additional Tracking Info -->
                @if($order->trackingPesanan->count() > 0)
                <div class="tracking-details-card mt-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-clipboard-list me-2"></i>Detail Tracking
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="tracking-details">
                            @foreach($order->trackingPesanan->sortByDesc('tanggal_update') as $tracking)
                            <div class="tracking-detail-item">
                                <div class="detail-timestamp">
                                    {{ $tracking->tanggal_update->format('d M Y H:i') }}
                                </div>
                                <div class="detail-status">
                                    <strong>{{ ucfirst(str_replace('_', ' ', $tracking->status_tracking)) }}</strong>
                                </div>
                                @if($tracking->detail_tracking)
                                <div class="detail-description">
                                    {{ $tracking->detail_tracking }}
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Shipping Info -->
                <div class="shipping-info-card mt-4" data-aos="fade-up" data-aos-delay="600">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-map-marked-alt me-2"></i>Informasi Alamat
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="address-info">
                            <h6>Alamat Tujuan:</h6>
                            <p class="mb-2">{{ $order->nama_penerima ?? Auth::guard('customer')->user()->nama }}</p>
                            <p class="mb-2">{{ $order->telepon_penerima ?? Auth::guard('customer')->user()->telepon }}</p>
                            <p class="mb-0">{{ $order->alamat_pengiriman ?? Auth::guard('customer')->user()->alamat }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="800">
                    <a href="{{ route('auth.orders.detail', $order->id_pesanan) }}" class="btn btn-outline-primary me-3">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Detail
                    </a>
                    @if($order->nomor_resi)
                    <a href="#" class="btn btn-primary" onclick="openExternalTracking()">
                        <i class="fas fa-external-link-alt me-2"></i>Lacak di Website Kurir
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.order-tracking-container {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    position: relative;
}

.order-tracking-container::before {
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

.order-info-card,
.tracking-timeline-card,
.tracking-details-card,
.shipping-info-card {
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

.info-item {
    margin-bottom: 1rem;
}

.info-item label {
    font-weight: 600;
    color: #6c757d;
    display: block;
    margin-bottom: 0.25rem;
}

.info-value {
    font-weight: 600;
    color: #333;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    display: inline-block;
}

.status-dikirim {
    background: #d4edda;
    color: #155724;
}

.status-selesai {
    background: #d1e7dd;
    color: #0f5132;
}

.tracking-timeline {
    position: relative;
}

.timeline-item {
    display: flex;
    margin-bottom: 2rem;
    position: relative;
}

.timeline-marker {
    position: relative;
    margin-right: 1.5rem;
}

.timeline-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    position: relative;
    z-index: 2;
}

.timeline-icon.completed {
    background: #28a745;
    color: white;
}

.timeline-icon.pending {
    background: #e9ecef;
    color: #6c757d;
}

.timeline-line {
    position: absolute;
    top: 50px;
    left: 50%;
    width: 2px;
    height: 60px;
    transform: translateX(-50%);
}

.timeline-line.completed {
    background: #28a745;
}

.timeline-line.pending {
    background: #e9ecef;
}

.timeline-content {
    flex: 1;
    padding-top: 0.5rem;
}

.timeline-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.timeline-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    margin: 0;
}

.timeline-date {
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
}

.timeline-description {
    color: #6c757d;
    margin: 0;
    line-height: 1.5;
}

.tracking-detail-item {
    padding: 1rem;
    border-left: 3px solid #007bff;
    background: #f8f9fa;
    border-radius: 5px;
    margin-bottom: 1rem;
}

.detail-timestamp {
    font-size: 0.875rem;
    color: #6c757d;
    margin-bottom: 0.25rem;
}

.detail-status {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.25rem;
}

.detail-description {
    color: #6c757d;
    font-size: 0.95rem;
}

.address-info h6 {
    color: #333;
    font-weight: 600;
    margin-bottom: 1rem;
}

.address-info p {
    color: #6c757d;
    line-height: 1.5;
}

@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .timeline-item {
        flex-direction: column;
        text-align: center;
    }
    
    .timeline-marker {
        margin-right: 0;
        margin-bottom: 1rem;
        align-self: center;
    }
    
    .timeline-line {
        display: none;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Initialize AOS
AOS.init();

function openExternalTracking() {
    const resi = '{{ $order->nomor_resi }}';
    if (resi) {
        // Open JNE tracking by default - you can customize this based on courier
        window.open(`https://www.jne.co.id/id/tracking/trace`, '_blank');
        
        // Copy resi number to clipboard
        navigator.clipboard.writeText(resi).then(function() {
            alert('Nomor resi telah disalin: ' + resi);
        });
    }
}
</script>
@endpush
@endsection
