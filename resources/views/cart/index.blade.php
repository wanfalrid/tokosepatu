@extends('layouts.app')

@section('title', 'Keranjang Belanja - Toko Sepatu')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" data-aos="fade-down">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Keranjang</li>
                </ol>
            </nav>
            
            <h1 class="display-4 fw-bold text-center mb-5" data-aos="fade-up">
                <i class="fas fa-shopping-cart text-primary me-3"></i>Keranjang Belanja
            </h1>
        </div>
    </div>

    @if(empty($cart))
        <div class="row justify-content-center" data-aos="fade-up">
            <div class="col-lg-6 text-center">
                <div class="empty-cart-illustration mb-4">
                    <i class="fas fa-shopping-cart display-1 text-muted"></i>
                </div>
                <h3 class="text-muted mb-3">Keranjang Belanja Kosong</h3>
                <p class="text-muted mb-4">Sepertinya Anda belum menambahkan produk apapun ke keranjang belanja.</p>
                <a href="{{ route('shop') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                </a>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm" data-aos="fade-right">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Item dalam Keranjang</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Subtotal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0; @endphp
                                    @foreach($cart as $item)
                                    @php $subtotal = $item['harga'] * $item['quantity']; $total += $subtotal; @endphp
                                    <tr data-product-id="{{ $item['id_produk'] }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('images/products/' . $item['gambar']) }}" 
                                                     alt="{{ $item['nama_produk'] }}" 
                                                     class="rounded me-3" 
                                                     style="width: 80px; height: 80px; object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-1">{{ $item['nama_produk'] }}</h6>
                                                    <small class="text-muted">Sepatu Premium</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <strong class="text-primary">Rp {{ number_format($item['harga'], 0, ',', '.') }}</strong>
                                        </td>
                                        <td class="align-middle">
                                            <div class="input-group" style="width: 120px;">
                                                <button class="btn btn-outline-secondary btn-sm quantity-btn" 
                                                        type="button" 
                                                        data-action="decrease"
                                                        data-product-id="{{ $item['id_produk'] }}">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" 
                                                       class="form-control form-control-sm text-center quantity-input" 
                                                       value="{{ $item['quantity'] }}" 
                                                       min="1"
                                                       data-product-id="{{ $item['id_produk'] }}">
                                                <button class="btn btn-outline-secondary btn-sm quantity-btn" 
                                                        type="button" 
                                                        data-action="increase"
                                                        data-product-id="{{ $item['id_produk'] }}">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <strong class="subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                                        </td>
                                        <td class="align-middle">
                                            <button class="btn btn-outline-danger btn-sm remove-item" 
                                                    data-product-id="{{ $item['id_produk'] }}"
                                                    title="Hapus dari keranjang">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4" data-aos="fade-up">
                    <a href="{{ route('shop') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Lanjut Belanja
                    </a>
                    <button class="btn btn-outline-danger" id="clear-cart">
                        <i class="fas fa-trash me-2"></i>Kosongkan Keranjang
                    </button>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top" data-aos="fade-left" style="top: 100px;">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span id="cart-subtotal">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Ongkos Kirim:</span>
                            <span class="text-success">Gratis</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Pajak (11%):</span>
                            <span id="cart-tax">Rp {{ number_format($total * 0.11, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong class="text-primary" id="cart-total">Rp {{ number_format($total + ($total * 0.11), 0, ',', '.') }}</strong>
                        </div>
                          <div class="d-grid gap-2">
                            <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg" id="checkout-btn">
                                <i class="fas fa-credit-card me-2"></i>Checkout
                            </a>
                            <button class="btn btn-outline-secondary">
                                <i class="fas fa-heart me-2"></i>Simpan ke Wishlist
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                Pembayaran aman dan terpercaya
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Promo Code Section -->
                <div class="card shadow-sm mt-4" data-aos="fade-left" data-aos-delay="100">
                    <div class="card-body">
                        <h6 class="card-title"><i class="fas fa-tag me-2"></i>Kode Promo</h6>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Masukkan kode promo">
                            <button class="btn btn-outline-primary" type="button">
                                <i class="fas fa-check"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Trust Badges -->
                <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="row g-2">
                        <div class="col-4">
                            <div class="p-2 bg-light rounded">
                                <i class="fas fa-truck text-primary mb-1"></i>
                                <small class="d-block">Gratis Ongkir</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 bg-light rounded">
                                <i class="fas fa-undo text-success mb-1"></i>
                                <small class="d-block">Easy Return</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 bg-light rounded">
                                <i class="fas fa-shield-alt text-warning mb-1"></i>
                                <small class="d-block">Garansi</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <i class="fas fa-check-circle text-success display-4 mb-3"></i>
                <h5 class="modal-title mb-3">Berhasil!</h5>
                <p id="success-message">Operasi berhasil dilakukan.</p>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .empty-cart-illustration i {
        opacity: 0.3;
    }
    
    .quantity-input {
        width: 60px;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    
    .btn {
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-1px);
    }
    
    .sticky-top {
        z-index: 1020;
    }
    
    .trust-badge {
        transition: all 0.3s ease;
    }
    
    .trust-badge:hover {
        transform: scale(1.05);
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Update quantity
    $('.quantity-btn').click(function() {
        const productId = $(this).data('product-id');
        const action = $(this).data('action');
        const input = $(`.quantity-input[data-product-id="${productId}"]`);
        let quantity = parseInt(input.val());
        
        if (action === 'increase') {
            quantity++;
        } else if (action === 'decrease' && quantity > 1) {
            quantity--;
        }
        
        input.val(quantity);
        updateCart(productId, quantity);
    });
    
    // Update quantity on input change
    $('.quantity-input').change(function() {
        const productId = $(this).data('product-id');
        const quantity = parseInt($(this).val());
        
        if (quantity > 0) {
            updateCart(productId, quantity);
        }
    });
    
    // Remove item
    $('.remove-item').click(function() {
        const productId = $(this).data('product-id');
        
        Swal.fire({
            title: 'Hapus Item?',
            text: 'Apakah Anda yakin ingin menghapus item ini dari keranjang?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                removeFromCart(productId);
            }
        });
    });
      // Clear cart
    $('#clear-cart').click(function() {
        Swal.fire({
            title: 'Kosongkan Keranjang?',
            text: 'Semua item akan dihapus dari keranjang belanja.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Kosongkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                clearCart();
            }
        });
    });
    
    function updateCart(productId, quantity) {
        $.ajax({
            url: '{{ route("cart.update") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id_produk: productId,
                quantity: quantity
            },
            success: function(response) {
                if (response.success) {
                    updateCartDisplay();
                    showSuccessMessage('Keranjang berhasil diperbarui!');
                }
            },
            error: function() {
                Swal.fire('Error!', 'Terjadi kesalahan saat memperbarui keranjang.', 'error');
            }
        });
    }
    
    function removeFromCart(productId) {
        $.ajax({
            url: '{{ route("cart.remove") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id_produk: productId
            },
            success: function(response) {
                if (response.success) {
                    $(`tr[data-product-id="${productId}"]`).fadeOut(300, function() {
                        $(this).remove();
                        updateCartDisplay();
                        updateCartCount(response.cart_count);
                        
                        if (response.cart_count === 0) {
                            location.reload();
                        }
                    });
                    
                    Swal.fire('Dihapus!', 'Item berhasil dihapus dari keranjang.', 'success');
                }
            },
            error: function() {
                Swal.fire('Error!', 'Terjadi kesalahan saat menghapus item.', 'error');
            }
        });
    }
    
    function clearCart() {
        $.ajax({
            url: '{{ route("cart.clear") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire('Berhasil!', 'Keranjang berhasil dikosongkan.', 'success').then(() => {
                        location.reload();
                    });
                }
            },
            error: function() {
                Swal.fire('Error!', 'Terjadi kesalahan saat mengosongkan keranjang.', 'error');
            }
        });
    }
    
    function updateCartDisplay() {
        let subtotal = 0;
        
        $('tr[data-product-id]').each(function() {
            const quantity = parseInt($(this).find('.quantity-input').val());
            const price = parseInt($(this).find('td:nth-child(2) strong').text().replace(/[^\d]/g, ''));
            const itemSubtotal = price * quantity;
            
            $(this).find('.subtotal').text('Rp ' + itemSubtotal.toLocaleString('id-ID'));
            subtotal += itemSubtotal;
        });
        
        const tax = subtotal * 0.11;
        const total = subtotal + tax;
        
        $('#cart-subtotal').text('Rp ' + subtotal.toLocaleString('id-ID'));
        $('#cart-tax').text('Rp ' + Math.round(tax).toLocaleString('id-ID'));
        $('#cart-total').text('Rp ' + Math.round(total).toLocaleString('id-ID'));
    }
    
    function updateCartCount(count) {
        $('.cart-count').text(count);
    }
    
    function showSuccessMessage(message) {
        $('#success-message').text(message);
        $('#successModal').modal('show');
    }
});
</script>
@endpush
