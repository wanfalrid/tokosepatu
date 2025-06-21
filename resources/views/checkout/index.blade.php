@extends('layouts.app')

@section('title', 'Checkout - ShoeMart')

@section('content')
<div class="checkout-container">
    <div class="container py-5">
        <!-- Checkout Header -->
        <div class="checkout-header text-center mb-5" data-aos="fade-down">
            <h1 class="checkout-title">
                <i class="fas fa-shopping-cart me-3"></i>Checkout
            </h1>
            <p class="checkout-subtitle">Selesaikan pembelian Anda</p>
            
            <!-- Progress Steps -->
            <div class="checkout-steps">
                <div class="step active">
                    <div class="step-number">1</div>
                    <div class="step-label">Keranjang</div>
                </div>
                <div class="step-line"></div>
                <div class="step active">
                    <div class="step-number">2</div>
                    <div class="step-label">Checkout</div>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-label">Pembayaran</div>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-number">4</div>
                    <div class="step-label">Selesai</div>
                </div>
            </div>
        </div>        <!-- Customer Status Info -->
        @if($customer)
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-info border-0 shadow-sm" role="alert" data-aos="fade-up">
                    <div class="d-flex align-items-center">
                        <div class="alert-icon me-3">
                            <i class="fas fa-user-check fa-2x text-info"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="alert-heading mb-1">
                                <i class="fas fa-check-circle me-2"></i>Selamat datang kembali, {{ $customer->nama }}!
                            </h5>
                            <p class="mb-2">Anda login sebagai <strong>{{ $customer->email }}</strong></p>
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Data Anda telah terisi otomatis. Anda dapat mengubahnya jika diperlukan.
                            </small>
                        </div>                        <div class="alert-actions">
                            <a href="{{ route('auth.profile') }}" class="btn btn-outline-info btn-sm me-2">
                                <i class="fas fa-user-edit me-1"></i>Edit Profil
                            </a>
                            <a href="{{ route('auth.orders') }}" class="btn btn-outline-primary btn-sm me-2">
                                <i class="fas fa-shopping-bag me-1"></i>Pesanan Saya
                            </a>
                            <a href="{{ route('auth.logout') }}" class="btn btn-outline-secondary btn-sm"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                            </a>
                            <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif        <form id="checkoutForm" action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="row g-4">
                <!-- Customer Information -->
                <div class="col-lg-8">
                    <div class="checkout-section" data-aos="fade-up">
                        <div class="section-card">
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="fas fa-user me-2"></i>Informasi Pelanggan
                                </h3>
                            </div>
                            <div class="section-body">
                                <div class="row g-3">                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                                   id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap" 
                                                   value="{{ old('nama_lengkap', $customer ? $customer->nama : '') }}" required>
                                            <label for="nama_lengkap">
                                                <i class="fas fa-user me-2"></i>Nama Lengkap
                                            </label>
                                            @error('nama_lengkap')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" placeholder="Email" 
                                                   value="{{ old('email', $customer ? $customer->email : '') }}" required>
                                            <label for="email">
                                                <i class="fas fa-envelope me-2"></i>Email
                                            </label>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="tel" class="form-control @error('telepon') is-invalid @enderror" 
                                                   id="telepon" name="telepon" placeholder="Nomor Telepon" 
                                                   value="{{ old('telepon', $customer ? $customer->telepon : '') }}" required>
                                            <label for="telepon">
                                                <i class="fas fa-phone me-2"></i>Nomor Telepon
                                            </label>
                                            @error('telepon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                                   id="tanggal_lahir" name="tanggal_lahir" 
                                                   value="{{ old('tanggal_lahir') }}">
                                            <label for="tanggal_lahir">
                                                <i class="fas fa-calendar me-2"></i>Tanggal Lahir (Opsional)
                                            </label>
                                            @error('tanggal_lahir')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                                      id="alamat" name="alamat" 
                                                      placeholder="Alamat Lengkap" style="height: 120px" 
                                                      required>{{ old('alamat', $customer ? $customer->alamat : '') }}</textarea>
                                            <label for="alamat">
                                                <i class="fas fa-map-marker-alt me-2"></i>Alamat Lengkap
                                            </label>
                                            @error('alamat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Method -->
                    <div class="checkout-section" data-aos="fade-up" data-aos-delay="100">
                        <div class="section-card">
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="fas fa-truck me-2"></i>Metode Pengiriman
                                </h3>
                            </div>
                            <div class="section-body">
                                <div class="shipping-options">
                                    <div class="shipping-option">
                                        <input type="radio" class="form-check-input" id="regular" name="shipping_method" value="regular" checked>
                                        <label class="shipping-label" for="regular">
                                            <div class="shipping-info">
                                                <h5>Reguler</h5>
                                                <p>5-7 hari kerja</p>
                                            </div>
                                            <div class="shipping-price">
                                                <span class="price">Gratis</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="shipping-option">
                                        <input type="radio" class="form-check-input" id="express" name="shipping_method" value="express">
                                        <label class="shipping-label" for="express">
                                            <div class="shipping-info">
                                                <h5>Express</h5>
                                                <p>2-3 hari kerja</p>
                                            </div>
                                            <div class="shipping-price">
                                                <span class="price">Rp 25.000</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="shipping-option">
                                        <input type="radio" class="form-check-input" id="sameday" name="shipping_method" value="sameday">
                                        <label class="shipping-label" for="sameday">
                                            <div class="shipping-info">
                                                <h5>Same Day</h5>
                                                <p>Hari yang sama</p>
                                            </div>
                                            <div class="shipping-price">
                                                <span class="price">Rp 50.000</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="checkout-section" data-aos="fade-up" data-aos-delay="200">
                        <div class="section-card">
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="fas fa-credit-card me-2"></i>Metode Pembayaran
                                </h3>
                            </div>                            <div class="section-body">                                <div class="payment-options">                                    <div class="payment-option">
                                        <input type="radio" class="form-check-input" id="midtrans" name="payment_method" value="midtrans" checked>
                                        <label class="payment-label" for="midtrans">
                                            <div class="payment-icon">
                                                <i class="fas fa-credit-card"></i>
                                            </div>
                                            <div class="payment-info">
                                                <h5>Pembayaran Online</h5>
                                                <p>Credit Card, Bank Transfer, E-Wallet</p>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="payment-option">
                                        <input type="radio" class="form-check-input" id="cod" name="payment_method" value="cod">
                                        <label class="payment-label" for="cod">
                                            <div class="payment-icon">
                                                <i class="fas fa-money-bill-wave"></i>
                                            </div>
                                            <div class="payment-info">
                                                <h5>Cash on Delivery</h5>
                                                <p>Bayar saat barang tiba</p>
                                            </div>
                                        </label>
                                    </div>                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="order-summary-section" data-aos="fade-up" data-aos-delay="300">
                        <div class="summary-card sticky-top">
                            <div class="summary-header">
                                <h3 class="summary-title">
                                    <i class="fas fa-receipt me-2"></i>Ringkasan Pesanan
                                </h3>
                            </div>
                            <div class="summary-body">
                                <!-- Cart Items -->
                                <div class="cart-items">
                                    @php
                                        $cart = session('cart', []);
                                        $subtotal = 0;
                                    @endphp
                                    
                                    @if(empty($cart))
                                        <div class="empty-cart">
                                            <i class="fas fa-shopping-cart"></i>
                                            <p>Keranjang kosong</p>
                                        </div>                                    @else
                                        @foreach($cart as $id => $item)
                                            @php $subtotal += $item['harga'] * $item['quantity']; @endphp
                                            <div class="cart-item">
                                                <div class="item-image">
                                                    @if($item['gambar'])
                                                        <img src="{{ asset('storage/' . $item['gambar']) }}" alt="{{ $item['nama_produk'] }}">
                                                    @else
                                                        <div class="no-image">
                                                            <i class="fas fa-image"></i>
                                                        </div>
                                                    @endif
                                                </div>                                                <div class="item-details">
                                                    <h6 class="item-name">{{ $item['nama_produk'] }}</h6>
                                                    <div class="item-meta">
                                                        <span class="item-brand">{{ $item['merek'] ?? '' }}</span>
                                                        <span class="item-quantity">x{{ $item['quantity'] }}</span>
                                                    </div>
                                                    <div class="item-price">
                                                        Rp {{ number_format($item['harga'], 0, ',', '.') }}
                                                    </div>
                                                </div>
                                                <div class="item-total">
                                                    Rp {{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                @if(!empty($cart))                                <!-- Order Calculation -->
                                <div class="order-calculation">
                                    <div class="calculation-row">
                                        <span class="calc-label">Subtotal:</span>
                                        <span class="calc-value" id="subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="calculation-row">
                                        <span class="calc-label">Ongkos Kirim:</span>
                                        <span class="calc-value" id="shipping-cost">Gratis</span>
                                    </div>
                                    <div class="calculation-row">
                                        <span class="calc-label">Pajak (11%):</span>
                                        <span class="calc-value" id="tax-amount">Rp {{ number_format($subtotal * 0.11, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="calculation-row total-row">
                                        <span class="calc-label">Total:</span>
                                        <span class="calc-value total-amount" id="total-amount">Rp {{ number_format($subtotal + ($subtotal * 0.11), 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <!-- Order Actions -->
                                <div class="order-actions">
                                    <button type="submit" class="btn btn-primary btn-place-order" id="placeOrderBtn">
                                        <i class="fas fa-lock me-2"></i>Buat Pesanan
                                    </button>
                                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary btn-back-cart">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Keranjang
                                    </a>
                                </div>
                                @else
                                <div class="order-actions">
                                    <a href="{{ route('shop') }}" class="btn btn-primary">
                                        <i class="fas fa-shopping-bag me-2"></i>Belanja Sekarang
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.checkout-container {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 100vh;
    padding-top: 2rem;
}

.checkout-header {
    margin-bottom: 3rem;
}

.checkout-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 1rem;
}

.checkout-subtitle {
    color: #6c757d;
    font-size: 1.2rem;
    margin-bottom: 2rem;
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
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
}

.step-label {
    font-size: 0.9rem;
    color: #6c757d;
    font-weight: 500;
}

.step.active .step-label {
    color: var(--primary-color);
    font-weight: 600;
}

.step-line {
    width: 80px;
    height: 2px;
    background: #e9ecef;
    margin: 0 1rem;
}

.checkout-section {
    margin-bottom: 2rem;
}

.section-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: all 0.3s ease;
}

.section-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
}

.section-header {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 1.5rem;
    border-bottom: 1px solid #dee2e6;
}

.section-title {
    margin: 0;
    color: #333;
    font-size: 1.3rem;
    font-weight: 600;
}

.section-body {
    padding: 2rem;
}

.form-floating {
    margin-bottom: 1rem;
}

.form-floating > .form-control {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 1rem 0.75rem 0.5rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-floating > .form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    transform: translateY(-2px);
}

.form-floating > label {
    padding: 1rem 0.75rem;
    color: #6c757d;
    font-weight: 500;
}

.shipping-options, .payment-options {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.shipping-option, .payment-option {
    position: relative;
}

.shipping-option input[type="radio"], .payment-option input[type="radio"] {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

.shipping-label, .payment-label {
    display: flex;
    align-items: center;
    padding: 1.5rem;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
}

.shipping-label:hover, .payment-label:hover {
    border-color: var(--primary-color);
    background: rgba(0, 123, 255, 0.05);
    transform: translateY(-2px);
}

.shipping-option input[type="radio"]:checked + .shipping-label,
.payment-option input[type="radio"]:checked + .payment-label {
    border-color: var(--primary-color);
    background: rgba(0, 123, 255, 0.1);
    box-shadow: 0 5px 15px rgba(0, 123, 255, 0.2);
}

.shipping-info, .payment-info {
    flex: 1;
}

.shipping-info h5, .payment-info h5 {
    margin: 0 0 0.25rem 0;
    color: #333;
    font-weight: 600;
}

.shipping-info p, .payment-info p {
    margin: 0;
    color: #6c757d;
    font-size: 0.9rem;
}

.shipping-price {
    text-align: right;
}

.shipping-price .price {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--primary-color);
}

.payment-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    margin-right: 1rem;
}

.order-summary-section {
    position: sticky;
    top: 2rem;
}

.summary-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.summary-header {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    padding: 1.5rem;
    color: white;
}

.summary-title {
    margin: 0;
    font-size: 1.3rem;
    font-weight: 600;
}

.summary-body {
    padding: 1.5rem;
}

.cart-items {
    margin-bottom: 1.5rem;
}

.cart-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid #f8f9fa;
}

.cart-item:last-child {
    border-bottom: none;
}

.item-image {
    width: 60px;
    height: 60px;
    border-radius: 8px;
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
    font-size: 1.5rem;
}

.item-details {
    flex: 1;
}

.item-name {
    margin: 0 0 0.25rem 0;
    font-size: 0.95rem;
    font-weight: 600;
    color: #333;
}

.item-meta {
    font-size: 0.85rem;
    color: #6c757d;
    margin-bottom: 0.25rem;
}

.item-price {
    font-size: 0.9rem;
    color: var(--primary-color);
    font-weight: 600;
}

.item-total {
    font-weight: 700;
    color: #333;
}

.empty-cart {
    text-align: center;
    padding: 2rem 0;
    color: #6c757d;
}

.empty-cart i {
    font-size: 3rem;
    margin-bottom: 1rem;
    color: #dee2e6;
}

.order-calculation {
    border-top: 1px solid #e9ecef;
    padding-top: 1rem;
    margin-bottom: 1.5rem;
}

.calculation-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.75rem;
}

.calculation-row.total-row {
    border-top: 2px solid var(--primary-color);
    padding-top: 1rem;
    margin-top: 1rem;
    font-size: 1.1rem;
    font-weight: 700;
}

.calc-label {
    color: #6c757d;
}

.calc-value {
    color: #333;
    font-weight: 600;
}

.total-amount {
    color: var(--primary-color);
    font-size: 1.3rem;
}

.order-actions {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.btn-place-order {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border: none;
    padding: 1rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.btn-place-order:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
}

.btn-back-cart {
    padding: 0.75rem 1rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-back-cart:hover {
    transform: translateY(-2px);
}

.is-invalid {
    border-color: #dc3545 !important;
    animation: shake 0.5s ease-in-out;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: #dc3545;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Loading state */
.btn-place-order.loading {
    pointer-events: none;
    position: relative;
    color: transparent;
}

.btn-place-order.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 20px;
    height: 20px;
    border: 2px solid #ffffff;
    border-top: 2px solid transparent;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}

@media (max-width: 768px) {
    .checkout-steps {
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .step-line {
        display: none;
    }
    
    .section-body {
        padding: 1.5rem;
    }
    
    .shipping-label, .payment-label {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .payment-icon {
        margin-right: 0;
    }
    
    .order-summary-section {
        position: static;
        margin-top: 2rem;
    }
}
</style>
@endsection

@push('scripts')
<!-- Midtrans Snap JS -->
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="{{ config('midtrans.clientKey') }}"></script>

<script>
// Shipping cost calculation
const shippingCosts = {
    'regular': 0,
    'express': 25000,
    'sameday': 50000
};

// Update shipping cost when method changes
document.querySelectorAll('input[name="shipping_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        updateTotal();
    });
});

// Payment method change handler
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const placeOrderBtn = document.getElementById('placeOrderBtn');
        
        if (this.value === 'midtrans') {
            placeOrderBtn.innerHTML = '<i class="fas fa-credit-card me-2"></i>Konfirmasi Pembelian';
        } else {
            placeOrderBtn.innerHTML = '<i class="fas fa-lock me-2"></i>Buat Pesanan';
        }
    });
});

function updateTotal() {
    const selectedShipping = document.querySelector('input[name="shipping_method"]:checked').value;
    const shippingCost = shippingCosts[selectedShipping];
    const subtotalText = document.getElementById('subtotal').textContent;
    const subtotal = parseInt(subtotalText.replace(/[^0-9]/g, ''));
    
    // Calculate tax (11%)
    const tax = Math.round(subtotal * 0.11);
    
    // Calculate total = subtotal + shipping + tax
    const total = subtotal + shippingCost + tax;
    
    // Update shipping cost display
    const shippingCostElement = document.getElementById('shipping-cost');
    if (shippingCost === 0) {
        shippingCostElement.textContent = 'Gratis';
    } else {
        shippingCostElement.textContent = 'Rp ' + shippingCost.toLocaleString('id-ID');
    }
    
    // Update tax display
    document.getElementById('tax-amount').textContent = 'Rp ' + tax.toLocaleString('id-ID');
    
    // Update total
    document.getElementById('total-amount').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

function createSnapTokenAndRedirect() {
    // Validate form first
    const form = document.getElementById('checkoutForm');
    const formData = new FormData(form);
    
    // Check required fields
    const requiredFields = ['nama_lengkap', 'email', 'telepon', 'alamat'];
    let hasError = false;
    
    requiredFields.forEach(field => {
        const input = form.querySelector(`[name="${field}"]`);
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            hasError = true;
        } else {
            input.classList.remove('is-invalid');
        }
    });
    
    if (hasError) {
        alert('Mohon lengkapi semua field yang diperlukan terlebih dahulu.');
        return;
    }
    
    // Show loading on button
    const placeOrderBtn = document.getElementById('placeOrderBtn');
    placeOrderBtn.classList.add('loading');
    placeOrderBtn.disabled = true;
    
    // Create snap token
    fetch('{{ route("checkout.create-snap-token") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.snap_token) {
            // Redirect to Midtrans payment page
            window.snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    console.log('Payment success:', result);
                    handlePaymentResult(result, 'success');
                },
                onPending: function(result) {
                    console.log('Payment pending:', result);
                    handlePaymentResult(result, 'pending');
                },
                onError: function(result) {
                    console.log('Payment error:', result);
                    alert('Pembayaran gagal! Silakan coba lagi.');
                    // Reset button state
                    placeOrderBtn.classList.remove('loading');
                    placeOrderBtn.disabled = false;
                },
                onClose: function() {
                    console.log('Payment popup closed');
                    // Reset button state when user closes payment window
                    placeOrderBtn.classList.remove('loading');
                    placeOrderBtn.disabled = false;
                }
            });
        } else {
            throw new Error(data.error || 'Gagal membuat token pembayaran');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error: ' + error.message + '\nSilakan periksa data Anda dan coba lagi.');
        // Reset button state
        placeOrderBtn.classList.remove('loading');
        placeOrderBtn.disabled = false;
    });
}

function hidePaymentSection() {
    // Function kept for compatibility but not needed anymore
    console.log('hidePaymentSection called - not needed in redirect mode');
}

function handlePaymentResult(result, status) {
    // Send payment result to server
    fetch('{{ route("checkout.payment-callback") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            order_id: result.order_id,
            transaction_status: result.transaction_status,
            status_code: result.status_code,
            gross_amount: result.gross_amount,
            signature_key: result.signature_key,
            payment_type: result.payment_type,
            transaction_id: result.transaction_id,
            fraud_status: result.fraud_status
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            if (status === 'success') {
                alert('Pembayaran berhasil! Terima kasih atas pesanan Anda.');
            } else {
                alert('Pembayaran sedang diproses. Kami akan mengirim konfirmasi via email.');
            }
            
            // Redirect to success page
            window.location.href = '{{ url("checkout/success") }}/' + data.order_id;
        } else {
            throw new Error(data.error || 'Gagal memproses pembayaran');
        }
    })
    .catch(error => {
        console.error('Error processing payment:', error);
        alert('Terjadi kesalahan saat memproses pembayaran: ' + error.message);
    });
}

// Form submission handler
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Always prevent default submission
    
    const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
    const placeOrderBtn = document.getElementById('placeOrderBtn');
    
    if (selectedPaymentMethod === 'cod') {
        // COD: Submit form normally
        placeOrderBtn.classList.add('loading');
        
        // Disable all form inputs
        const inputs = this.querySelectorAll('input, select, textarea, button');
        inputs.forEach(input => input.disabled = true);
        
        // Submit form
        this.submit();
    } else if (selectedPaymentMethod === 'midtrans') {
        // Midtrans: Create snap token and redirect to payment page
        createSnapTokenAndRedirect();
    }
});

// Real-time form validation
document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('blur', function() {
        if (this.checkValidity()) {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        } else {
            this.classList.remove('is-valid');
            this.classList.add('is-invalid');
        }
    });    // No need to re-create snap token on field changes in redirect mode
    input.addEventListener('change', function() {
        // Just validate the field
        if (this.checkValidity()) {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        }
    });
});

// Phone number formatting
document.getElementById('telepon').addEventListener('input', function(e) {
    let value = e.target.value.replace(/[^\d]/g, '');
    if (value.startsWith('0')) {
        value = '+62' + value.slice(1);
    } else if (!value.startsWith('+62')) {
        value = '+62' + value;
    }
    e.target.value = value;
});

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateTotal();
    
    // Set initial button text based on selected payment method
    const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
    const placeOrderBtn = document.getElementById('placeOrderBtn');
    
    if (selectedPaymentMethod === 'midtrans') {
        placeOrderBtn.innerHTML = '<i class="fas fa-credit-card me-2"></i>Konfirmasi Pembelian';
    } else {
        placeOrderBtn.innerHTML = '<i class="fas fa-lock me-2"></i>Buat Pesanan';
    }
});
</script>
@endpush
