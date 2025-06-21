@extends('layouts.app')

@section('title', 'Pembayaran - ShoeMart')

@section('content')
<div class="payment-container">
    <div class="container py-5">
        <!-- Payment Header -->
        <div class="payment-header text-center mb-5" data-aos="fade-down">
            <h1 class="payment-title">
                <i class="fas fa-credit-card me-3"></i>Pembayaran
            </h1>
            <p class="payment-subtitle">Selesaikan pembayaran Anda</p>
            
            <!-- Progress Steps -->
            <div class="checkout-steps">
                <div class="step completed">
                    <div class="step-number"><i class="fas fa-check"></i></div>
                    <div class="step-label">Keranjang</div>
                </div>
                <div class="step-line completed"></div>
                <div class="step completed">
                    <div class="step-number"><i class="fas fa-check"></i></div>
                    <div class="step-label">Checkout</div>
                </div>
                <div class="step-line completed"></div>
                <div class="step active">
                    <div class="step-number">3</div>
                    <div class="step-label">Pembayaran</div>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-number">4</div>
                    <div class="step-label">Selesai</div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Order Summary -->
                <div class="payment-card mb-4" data-aos="fade-up">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-receipt me-2"></i>Detail Pesanan
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="order-info">
                            <div class="info-row">
                                <span class="info-label">Nomor Pesanan:</span>
                                <span class="info-value">{{ $pesanan->id_pesanan }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Total Pembayaran:</span>
                                <span class="info-value total-amount">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Penerima:</span>
                                <span class="info-value">{{ $pesanan->nama_penerima }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Alamat:</span>
                                <span class="info-value">{{ $pesanan->alamat_pengiriman }}</span>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="order-items mt-4">
                            <h6 class="section-subtitle">Item Pesanan:</h6>
                            @foreach($pesanan->detailPesanan as $detail)
                            <div class="order-item">
                                <div class="item-info">
                                    <span class="item-name">{{ $detail->produk->nama_produk }}</span>
                                    <span class="item-qty">x{{ $detail->jumlah }}</span>
                                </div>
                                <span class="item-price">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="payment-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-credit-card me-2"></i>Pembayaran
                        </h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="payment-info mb-4">
                            <i class="fas fa-shield-alt text-success fa-3x mb-3"></i>
                            <h5>Pembayaran Aman dengan Midtrans</h5>
                            <p class="text-muted">Sistem pembayaran yang aman dan terpercaya</p>
                        </div>

                        <!-- Midtrans Snap Container -->
                        <div id="snap-container" class="mb-4"></div>

                        <button id="pay-button" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-credit-card me-2"></i>Bayar Sekarang
                        </button>

                        <div class="payment-note mt-4">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Anda akan diarahkan ke halaman pembayaran yang aman
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="text-center mt-4">
                    <a href="{{ route('checkout.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Checkout
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-color: #28a745;
    --shadow-soft: 0 10px 25px rgba(0,0,0,0.1);
    --shadow-medium: 0 15px 35px rgba(0,0,0,0.15);
}

.payment-container {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 100vh;
}

.payment-header {
    margin-bottom: 3rem;
}

.payment-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 1rem;
}

.payment-subtitle {
    color: #6c757d;
    font-size: 1.2rem;
}

.checkout-steps {
    display: flex;
    justify-content: center;
    align-items: center;
    max-width: 600px;
    margin: 0 auto;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
}

.step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #e9ecef;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    margin-bottom: 0.5rem;
    transition: all 0.3s ease;
}

.step.active .step-number {
    background: var(--primary-gradient);
    color: white;
}

.step.completed .step-number {
    background: var(--success-color);
    color: white;
}

.step-label {
    font-size: 0.9rem;
    color: #6c757d;
    font-weight: 500;
}

.step.active .step-label,
.step.completed .step-label {
    color: var(--success-color);
    font-weight: 600;
}

.step-line {
    width: 80px;
    height: 2px;
    background: #e9ecef;
    margin: 0 1rem;
}

.step-line.completed {
    background: var(--success-color);
}

.payment-card {
    background: white;
    border-radius: 15px;
    box-shadow: var(--shadow-soft);
    overflow: hidden;
    transition: all 0.3s ease;
}

.payment-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-medium);
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 1.5rem;
    border-bottom: 1px solid #dee2e6;
}

.card-title {
    margin: 0;
    color: #333;
    font-size: 1.3rem;
    font-weight: 600;
}

.card-body {
    padding: 2rem;
}

.order-info {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 12px;
    margin-bottom: 1rem;
}

.info-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.75rem;
}

.info-row:last-child {
    margin-bottom: 0;
}

.info-label {
    color: #6c757d;
    font-weight: 500;
}

.info-value {
    color: #333;
    font-weight: 600;
}

.total-amount {
    color: var(--primary-color);
    font-size: 1.2rem;
    font-weight: 700;
}

.section-subtitle {
    color: #333;
    font-weight: 600;
    margin-bottom: 1rem;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 0.5rem;
}

.order-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f8f9fa;
}

.order-item:last-child {
    border-bottom: none;
}

.item-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.item-name {
    color: #333;
    font-weight: 500;
}

.item-qty {
    color: #6c757d;
    font-size: 0.9rem;
}

.item-price {
    color: var(--primary-color);
    font-weight: 600;
}

.payment-info {
    text-align: center;
}

#snap-container {
    min-height: 400px;
    border: 2px dashed #e9ecef;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
}

.btn-primary {
    background: var(--primary-gradient);
    border: none;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.payment-note {
    background: #e7f3ff;
    padding: 1rem;
    border-radius: 8px;
    border-left: 4px solid #007bff;
}

@media (max-width: 768px) {
    .checkout-steps {
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .step-line {
        display: none;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .info-row {
        flex-direction: column;
        gap: 0.25rem;
    }
}
</style>

<!-- Midtrans Snap -->
<script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ $clientKey }}"></script>

<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        // Trigger snap popup
        window.snap.embed('{{ $snapToken }}', {
            embedId: 'snap-container',
            onSuccess: function(result) {
                console.log('Payment success:', result);
                // Redirect to success page
                window.location.href = '{{ route("checkout.success", $pesanan->id_pesanan) }}';
            },
            onPending: function(result) {
                console.log('Payment pending:', result);
                alert('Pembayaran pending. Silakan selesaikan pembayaran Anda.');
            },
            onError: function(result) {
                console.log('Payment error:', result);
                alert('Terjadi kesalahan dalam pembayaran. Silakan coba lagi.');
            },
            onClose: function() {
                console.log('Customer closed the popup without finishing the payment');
            }
        });
        
        // Hide the pay button after clicking
        payButton.style.display = 'none';
    });
    
    // Auto-trigger payment if page loads
    document.addEventListener('DOMContentLoaded', function() {
        // Optionally auto-open the payment popup
        // payButton.click();
    });
</script>
@endsection
