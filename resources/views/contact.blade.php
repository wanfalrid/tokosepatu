@extends('layouts.app')

@section('title', 'Kontak Kami - Toko Sepatu')

@section('content')
<div class="container-fluid p-0">
    <!-- Hero Section -->
    <section class="hero-contact position-relative overflow-hidden">
        <div class="hero-bg"></div>
        <div class="container">
            <div class="row min-vh-50 d-flex align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Kontak</li>
                        </ol>
                    </nav>
                    <h1 class="display-3 fw-bold text-white mb-4">Hubungi Kami</h1>
                    <p class="lead text-white mb-4">Kami siap membantu Anda! Jangan ragu untuk menghubungi tim customer service kami yang berpengalaman.</p>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="hero-image text-center">
                        <img src="https://images.unsplash.com/photo-1423666639041-f56000c27a9a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" 
                             alt="Kontak Kami" class="img-fluid rounded-3 shadow-lg">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Info Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="display-5 fw-bold mb-4">Informasi Kontak</h2>
                    <p class="lead text-muted">Berbagai cara untuk menghubungi kami</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="contact-card h-100 bg-white rounded-3 shadow-sm p-4 text-center hover-lift">
                        <div class="contact-icon bg-primary bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                            <i class="fas fa-phone fa-2x"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Telepon</h4>
                        <p class="text-muted mb-3">Hubungi kami langsung untuk bantuan cepat</p>
                        <div class="contact-details">
                            <p class="mb-2"><strong>Customer Service:</strong></p>
                            <p class="text-primary mb-2">+62 21 1234 5678</p>
                            <p class="text-primary mb-3">+62 812 3456 7890</p>
                            <small class="text-muted">Senin - Sabtu: 09:00 - 18:00</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="contact-card h-100 bg-white rounded-3 shadow-sm p-4 text-center hover-lift">
                        <div class="contact-icon bg-success bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                            <i class="fas fa-envelope fa-2x"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Email</h4>
                        <p class="text-muted mb-3">Kirim email untuk pertanyaan detail</p>
                        <div class="contact-details">
                            <p class="mb-2"><strong>Email Utama:</strong></p>
                            <p class="text-primary mb-2">info@shoemart.com</p>
                            <p class="mb-2"><strong>Support:</strong></p>
                            <p class="text-primary mb-3">support@shoemart.com</p>
                            <small class="text-muted">Respon dalam 24 jam</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="contact-card h-100 bg-white rounded-3 shadow-sm p-4 text-center hover-lift">
                        <div class="contact-icon bg-warning bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                            <i class="fas fa-map-marker-alt fa-2x"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Alamat</h4>
                        <p class="text-muted mb-3">Kunjungi showroom kami</p>
                        <div class="contact-details">
                            <p class="mb-2"><strong>Toko Utama:</strong></p>
                            <p class="mb-2">Jl. Sudirman No. 123<br>Jakarta Pusat, DKI Jakarta<br>10220</p>
                            <p class="mb-3"><strong>Cabang Bandung:</strong></p>
                            <p class="mb-3">Jl. Braga No. 45<br>Bandung, Jawa Barat<br>40111</p>
                            <small class="text-muted">Buka setiap hari</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form & Map Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8" data-aos="fade-right">
                    <div class="contact-form-wrapper">
                        <h3 class="fw-bold mb-4">Kirim Pesan</h3>
                        <p class="text-muted mb-4">Isi formulir di bawah ini dan kami akan segera menghubungi Anda kembali.</p>
                        
                        <form id="contactForm" class="needs-validation" novalidate>
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                    <div class="invalid-feedback">
                                        Silakan masukkan nama lengkap Anda.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div class="invalid-feedback">
                                        Silakan masukkan email yang valid.
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="telepon" class="form-label">Nomor Telepon</label>
                                    <input type="tel" class="form-control" id="telepon" name="telepon" placeholder="+62">
                                </div>
                                <div class="col-12">
                                    <label for="subjek" class="form-label">Subjek <span class="text-danger">*</span></label>
                                    <select class="form-select" id="subjek" name="subjek" required>
                                        <option value="">Pilih subjek...</option>
                                        <option value="pertanyaan_produk">Pertanyaan Produk</option>
                                        <option value="keluhan">Keluhan</option>
                                        <option value="saran">Saran</option>
                                        <option value="kemitraan">Kemitraan</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Silakan pilih subjek pesan.
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="pesan" class="form-label">Pesan <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="pesan" name="pesan" rows="5" required placeholder="Tulis pesan Anda di sini..."></textarea>
                                    <div class="invalid-feedback">
                                        Silakan masukkan pesan Anda.
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter">
                                        <label class="form-check-label" for="newsletter">
                                            Saya ingin menerima newsletter dan penawaran khusus
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg px-5">
                                        <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="col-lg-4" data-aos="fade-left">
                    <div class="contact-sidebar">
                        <!-- Map -->
                        <div class="map-container bg-light rounded-3 p-4 mb-4">
                            <h5 class="fw-bold mb-3">Lokasi Kami</h5>
                            <div class="map-placeholder bg-white rounded-3 p-5 text-center" style="height: 200px;">
                                <i class="fas fa-map-marked-alt fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Peta Interaktif</p>
                                <small class="text-muted">Jakarta Pusat</small>
                            </div>
                        </div>
                        
                        <!-- Business Hours -->
                        <div class="business-hours bg-white rounded-3 shadow-sm p-4 mb-4">
                            <h5 class="fw-bold mb-3">
                                <i class="fas fa-clock me-2 text-primary"></i>Jam Operasional
                            </h5>
                            <div class="hours-list">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Senin - Jumat</span>
                                    <span class="fw-bold">09:00 - 21:00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Sabtu</span>
                                    <span class="fw-bold">09:00 - 22:00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Minggu</span>
                                    <span class="fw-bold">10:00 - 20:00</span>
                                </div>
                                <hr class="my-3">
                                <div class="d-flex justify-content-between">
                                    <span>Status:</span>
                                    <span class="badge bg-success">Buka Sekarang</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Social Media -->
                        <div class="social-media bg-white rounded-3 shadow-sm p-4">
                            <h5 class="fw-bold mb-3">
                                <i class="fas fa-share-alt me-2 text-primary"></i>Ikuti Kami
                            </h5>
                            <div class="social-buttons d-grid gap-2">
                                <a href="#" class="btn btn-outline-primary">
                                    <i class="fab fa-instagram me-2"></i>@shoemart.id
                                </a>
                                <a href="#" class="btn btn-outline-info">
                                    <i class="fab fa-facebook me-2"></i>ShoeMart Indonesia
                                </a>
                                <a href="#" class="btn btn-outline-primary">
                                    <i class="fab fa-twitter me-2"></i>@shoemartid
                                </a>
                                <a href="#" class="btn btn-outline-success">
                                    <i class="fab fa-whatsapp me-2"></i>WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="display-5 fw-bold mb-4">Pertanyaan Umum</h2>
                    <p class="lead text-muted">Jawaban untuk pertanyaan yang sering diajukan</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion" data-aos="fade-up">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Apakah ada garansi untuk produk sepatu?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Ya, semua produk sepatu kami memiliki garansi resmi dari manufacturer. Garansi mencakup cacat produksi dan kerusakan material dalam periode tertentu sesuai dengan brand masing-masing.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Bagaimana cara pengembalian produk?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Kami menerima pengembalian produk dalam waktu 7 hari setelah pembelian dengan kondisi produk masih baru dan lengkap dengan kemasan asli. Silakan hubungi customer service kami untuk prosedur pengembalian.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Apakah bisa COD (Cash on Delivery)?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Ya, kami menyediakan layanan COD untuk area Jakarta, Bogor, Depok, Tangerang, dan Bekasi. Untuk area lain, pembayaran dilakukan melalui transfer bank atau payment gateway yang tersedia.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    Berapa lama waktu pengiriman?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Waktu pengiriman tergantung lokasi: Jakarta 1-2 hari kerja, Jabodetabek 2-3 hari kerja, Jawa 3-5 hari kerja, dan luar Jawa 5-7 hari kerja. Pengiriman express tersedia dengan biaya tambahan.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                    Apakah produk dijamin original?
                                </button>
                            </h2>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Semua produk yang kami jual adalah 100% original dan bergaransi resmi. Kami bekerja sama langsung dengan distributor resmi dan authorized dealer untuk memastikan keaslian produk.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <i class="fas fa-check-circle text-success display-4 mb-3"></i>
                <h5 class="modal-title mb-3">Pesan Terkirim!</h5>
                <p>Terima kasih atas pesan Anda. Tim kami akan segera menghubungi Anda dalam 1x24 jam.</p>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .hero-contact {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        min-height: 60vh;
    }
    
    .hero-bg {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('https://images.unsplash.com/photo-1423666639041-f56000c27a9a?ixlib=rb-4.0.3') center/cover no-repeat;
        opacity: 0.1;
    }
    
    .min-vh-50 {
        min-height: 50vh;
    }
    
    .contact-card {
        transition: all 0.3s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,0.175) !important;
    }
    
    .contact-icon {
        transition: all 0.3s ease;
    }
    
    .contact-card:hover .contact-icon {
        transform: scale(1.1);
    }
    
    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(var(--primary-color-rgb), 0.25);
    }
    
    .map-placeholder {
        border: 2px dashed #dee2e6;
        transition: all 0.3s ease;
    }
    
    .map-placeholder:hover {
        border-color: var(--primary-color);
        background-color: #f8f9fa;
    }
    
    .business-hours .hours-list {
        font-size: 0.9rem;
    }
    
    .social-buttons .btn {
        transition: all 0.3s ease;
    }
    
    .social-buttons .btn:hover {
        transform: translateY(-2px);
    }
    
    .accordion-button:not(.collapsed) {
        background-color: var(--primary-color);
        color: white;
    }
    
    .accordion-button:focus {
        box-shadow: none;
    }
    
    .breadcrumb-item a {
        text-decoration: none;
        opacity: 0.8;
    }
    
    .breadcrumb-item a:hover {
        opacity: 1;
    }
    
    .contact-form-wrapper {
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
    }
    
    @media (max-width: 768px) {
        .contact-form-wrapper {
            padding: 1.5rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Form validation
    $('#contactForm').on('submit', function(e) {
        e.preventDefault();
        
        if (this.checkValidity()) {
            // Simulate form submission
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            
            // Show loading state
            submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...');
            submitBtn.prop('disabled', true);
            
            // Simulate API call
            setTimeout(function() {
                // Reset form
                document.getElementById('contactForm').reset();
                
                // Reset button
                submitBtn.html(originalText);
                submitBtn.prop('disabled', false);
                
                // Show success modal
                $('#successModal').modal('show');
                
                // Remove validation classes
                $('#contactForm').removeClass('was-validated');
                $('.form-control, .form-select').removeClass('is-valid is-invalid');
            }, 2000);
        }
        
        $(this).addClass('was-validated');
    });
    
    // Real-time validation
    $('.form-control, .form-select').on('input change', function() {
        if (this.checkValidity()) {
            $(this).removeClass('is-invalid').addClass('is-valid');
        } else {
            $(this).removeClass('is-valid').addClass('is-invalid');
        }
    });
    
    // Phone number formatting
    $('#telepon').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.startsWith('62')) {
            value = '+' + value;
        } else if (value.startsWith('0')) {
            value = '+62' + value.substring(1);
        } else if (value.length > 0 && !value.startsWith('+')) {
            value = '+62' + value;
        }
        $(this).val(value);
    });
    
    // Smooth scrolling for FAQ links
    $('a[href^="#"]').on('click', function(event) {
        const target = $(this.getAttribute('href'));
        if (target.length) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 100
            }, 1000);
        }
    });
    
    // Auto-resize textarea
    $('#pesan').on('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
    
    // Copy to clipboard functionality for contact info
    $('.contact-details').on('click', 'p.text-primary', function() {
        const text = $(this).text();
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(function() {
                // Show temporary tooltip
                const $this = $(this);
                $this.attr('title', 'Disalin!').tooltip('show');
                setTimeout(function() {
                    $this.tooltip('hide').removeAttr('title');
                }, 1000);
            });
        }
    });
});
</script>
@endpush