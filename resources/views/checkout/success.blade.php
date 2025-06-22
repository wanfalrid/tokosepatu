@extends('layouts.app')

@section('title', 'Pesanan Berhasil')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <!-- Success Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden text-center">
                <!-- Success Icon -->
                <div class="bg-gradient-to-r from-green-500 to-emerald-500 px-8 py-12">
                    <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
                        <i class="fas fa-check text-4xl text-white"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Pesanan Berhasil!</h1>
                    <p class="text-green-100">Terima kasih atas kepercayaan Anda berbelanja di ShoeMart</p>
                </div>

                <!-- Order Details -->
                <div class="p-8">
                    @if(isset($order))
                    <div class="bg-gray-50 rounded-xl p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Pesanan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                            <div>
                                <p class="text-sm text-gray-600">Nomor Pesanan</p>
                                <p class="font-semibold text-gray-800">{{ $order->id_pesanan }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Tanggal Pesanan</p>
                                <p class="font-semibold text-gray-800">{{ $order->tanggal_pesanan->format('d M Y, H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Pesanan</p>
                                <p class="font-semibold text-green-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Status Pesanan</p>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    @if($order->detailPesanan->count() > 0)
                    <div class="bg-gray-50 rounded-xl p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Produk yang Dipesan</h3>
                        <div class="space-y-4">
                            @foreach($order->detailPesanan as $detail)                            <div class="flex items-center space-x-4 p-4 bg-white rounded-lg">                                <img src="{{ $detail->produk->image_url }}" 
                                     alt="{{ $detail->produk->nama }}" 
                                     class="w-16 h-16 object-cover rounded-lg">
                                <div class="flex-1 text-left">
                                    <h4 class="font-semibold text-gray-800">{{ $detail->produk->nama }}</h4>
                                    <p class="text-sm text-gray-600">
                                        {{ $detail->jumlah }} x Rp {{ number_format($detail->harga, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-800">
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @endif

                    <!-- Next Steps -->
                    <div class="bg-blue-50 rounded-xl p-6 mb-6">
                        <h3 class="text-lg font-semibold text-blue-800 mb-4">
                            <i class="fas fa-info-circle mr-2"></i>
                            Langkah Selanjutnya
                        </h3>
                        <div class="text-left space-y-3">
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-semibold">1</div>
                                <p class="text-blue-700">Kami akan memproses pesanan Anda dalam 1-2 hari kerja.</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-semibold">2</div>
                                <p class="text-blue-700">Pesanan akan dikirim sesuai alamat yang Anda berikan.</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-semibold">3</div>
                                <p class="text-blue-700">Anda akan menerima notifikasi email untuk setiap update pesanan.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('home') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class="fas fa-home mr-2"></i>
                            Kembali ke Beranda
                        </a>
                        
                        <a href="{{ route('shop') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 bg-white rounded-lg hover:bg-gray-50 transition duration-200">
                            <i class="fas fa-shopping-bag mr-2"></i>
                            Belanja Lagi
                        </a>
                          @auth('customer')
                        <a href="{{ route('auth.orders') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 border border-blue-300 text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-200">
                            <i class="fas fa-list-alt mr-2"></i>
                            Lihat Pesanan Saya
                        </a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="mt-8 text-center">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">
                        <i class="fas fa-headset mr-2 text-blue-500"></i>
                        Butuh Bantuan?
                    </h3>
                    <p class="text-gray-600 mb-4">Tim customer service kami siap membantu Anda 24/7</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('contact') }}" 
                           class="inline-flex items-center justify-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-200">
                            <i class="fab fa-whatsapp mr-2"></i>
                            WhatsApp
                        </a>
                        <a href="mailto:support@shoemart.com" 
                           class="inline-flex items-center justify-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">
                            <i class="fas fa-envelope mr-2"></i>
                            Email
                        </a>
                        <a href="tel:+62-21-1234-5678" 
                           class="inline-flex items-center justify-center px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-200">
                            <i class="fas fa-phone mr-2"></i>
                            Telepon
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
