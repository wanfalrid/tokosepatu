@extends('layouts.app')

@section('title', 'Tentang Kami - Toko Sepatu')

@section('content')
<div class="container-fluid p-0">
    <!-- Hero Section -->
    <section class="hero-about position-relative overflow-hidden">
        <div class="hero-bg"></div>
        <div class="container">
            <div class="row min-vh-50 d-flex align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Tentang Kami</li>
                        </ol>
                    </nav>
                    <h1 class="display-3 fw-bold text-white mb-4">Tentang Kami</h1>
                    <p class="lead text-white mb-4">Lebih dari sekadar toko sepatu, kami adalah passion untuk style dan kualitas yang tak terkompromikan.</p>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="hero-image text-center">
                        <img src="https://images.unsplash.com/photo-1549298916-b41d501d3772?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" 
                             alt="Tentang Kami" class="img-fluid rounded-3 shadow-lg">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Story Section -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" 
                         alt="Our Story" class="img-fluid rounded-3 shadow">
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <h2 class="display-5 fw-bold mb-4">Cerita Kami</h2>
                    <p class="lead mb-4">Dimulai dari passion sederhana terhadap sepatu berkualitas, ShoeMart lahir dengan misi membawa koleksi sepatu premium terbaik dunia ke Indonesia.</p>
                    <p class="mb-4">Sejak 2018, kami telah melayani ribuan pelanggan dengan komitmen pada kualitas, kenyamanan, dan style yang tak lekang oleh waktu. Setiap sepatu yang kami jual telah melalui seleksi ketat untuk memastikan standar tertinggi.</p>
                    <div class="row g-4">
                        <div class="col-6">
                            <div class="counter-item text-center">
                                <h3 class="display-6 fw-bold text-primary mb-2">5000+</h3>
                                <p class="text-muted">Pelanggan Puas</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="counter-item text-center">
                                <h3 class="display-6 fw-bold text-primary mb-2">100+</h3>
                                <p class="text-muted">Brand Premium</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="display-5 fw-bold mb-4">Nilai-Nilai Kami</h2>
                    <p class="lead text-muted">Prinsip yang memandu setiap langkah perjalanan kami</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 border-0 shadow-sm hover-lift">
                        <div class="card-body text-center p-4">
                            <div class="icon-box bg-primary bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                                <i class="fas fa-gem fa-2x"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Kualitas Premium</h4>
                            <p class="text-muted">Kami hanya menyediakan sepatu dengan kualitas terbaik dari brand-brand ternama dunia.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100 border-0 shadow-sm hover-lift">
                        <div class="card-body text-center p-4">
                            <div class="icon-box bg-success bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                                <i class="fas fa-heart fa-2x"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Pelayanan Terbaik</h4>
                            <p class="text-muted">Kepuasan pelanggan adalah prioritas utama kami dengan pelayanan yang ramah dan profesional.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="card h-100 border-0 shadow-sm hover-lift">
                        <div class="card-body text-center p-4">
                            <div class="icon-box bg-warning bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                                <i class="fas fa-rocket fa-2x"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Inovasi</h4>
                            <p class="text-muted">Selalu menghadirkan tren terbaru dan teknologi sepatu terdepan untuk kenyamanan maksimal.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="display-5 fw-bold mb-4">Tim Kami</h2>
                    <p class="lead text-muted">Orang-orang hebat di balik kesuksesan ShoeMart</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="team-card text-center">
                        <div class="team-image mb-4">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&q=80" 
                                 alt="Ahmad Rizki" class="rounded-circle shadow" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <h5 class="fw-bold mb-2">Ahmad Rizki</h5>
                        <p class="text-primary mb-3">Founder & CEO</p>
                        <p class="text-muted small">Visioner di balik ShoeMart dengan pengalaman 10+ tahun di industri fashion.</p>
                        <div class="social-links">
                            <a href="#" class="btn btn-outline-primary btn-sm rounded-circle me-2">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary btn-sm rounded-circle">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="team-card text-center">
                        <div class="team-image mb-4">
                            <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&q=80" 
                                 alt="Sari Indah" class="rounded-circle shadow" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <h5 class="fw-bold mb-2">Sari Indah</h5>
                        <p class="text-primary mb-3">Head of Design</p>
                        <p class="text-muted small">Ahli fashion dengan mata yang tajam untuk tren sepatu terkini dan gaya yang timeless.</p>
                        <div class="social-links">
                            <a href="#" class="btn btn-outline-primary btn-sm rounded-circle me-2">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary btn-sm rounded-circle">
                                <i class="fab fa-behance"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="team-card text-center">
                        <div class="team-image mb-4">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&q=80" 
                                 alt="Budi Santoso" class="rounded-circle shadow" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <h5 class="fw-bold mb-2">Budi Santoso</h5>
                        <p class="text-primary mb-3">Operations Manager</p>
                        <p class="text-muted small">Memastikan setiap proses berjalan lancar dari inventory hingga pengiriman.</p>
                        <div class="social-links">
                            <a href="#" class="btn btn-outline-primary btn-sm rounded-circle me-2">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary btn-sm rounded-circle">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="team-card text-center">
                        <div class="team-image mb-4">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&q=80" 
                                 alt="Maya Sinta" class="rounded-circle shadow" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <h5 class="fw-bold mb-2">Maya Sinta</h5>
                        <p class="text-primary mb-3">Customer Relations</p>
                        <p class="text-muted small">Berdedikasi memberikan pengalaman terbaik untuk setiap pelanggan ShoeMart.</p>
                        <div class="social-links">
                            <a href="#" class="btn btn-outline-primary btn-sm rounded-circle me-2">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary btn-sm rounded-circle">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Achievements Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row text-center">
                <div class="col-12 mb-5" data-aos="fade-up">
                    <h2 class="display-5 fw-bold mb-4">Pencapaian Kami</h2>
                    <p class="lead">Angka-angka yang membanggakan dalam perjalanan kami</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="achievement-item text-center">
                        <div class="achievement-icon mb-3">
                            <i class="fas fa-users fa-3x"></i>
                        </div>
                        <h3 class="display-6 fw-bold mb-2 counter" data-target="5000">0</h3>
                        <p class="h5">Pelanggan Setia</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="achievement-item text-center">
                        <div class="achievement-icon mb-3">
                            <i class="fas fa-shoe-prints fa-3x"></i>
                        </div>
                        <h3 class="display-6 fw-bold mb-2 counter" data-target="50000">0</h3>
                        <p class="h5">Sepatu Terjual</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="achievement-item text-center">
                        <div class="achievement-icon mb-3">
                            <i class="fas fa-award fa-3x"></i>
                        </div>
                        <h3 class="display-6 fw-bold mb-2 counter" data-target="100">0</h3>
                        <p class="h5">Brand Premium</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="achievement-item text-center">
                        <div class="achievement-icon mb-3">
                            <i class="fas fa-star fa-3x"></i>
                        </div>
                        <h3 class="display-6 fw-bold mb-2">4.9</h3>
                        <p class="h5">Rating Pelanggan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center" data-aos="fade-up">
                    <h2 class="display-5 fw-bold mb-4">Siap Menemukan Sepatu Impian?</h2>
                    <p class="lead mb-4">Jelajahi koleksi premium kami dan temukan sepatu yang sempurna untuk gaya hidup Anda.</p>
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        <a href="{{ route('shop') }}" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                        </a>
                        <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-lg px-5">
                            <i class="fas fa-phone me-2"></i>Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .hero-about {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        min-height: 60vh;
    }
    
    .hero-bg {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3') center/cover no-repeat;
        opacity: 0.1;
    }
    
    .min-vh-50 {
        min-height: 50vh;
    }
    
    .hover-lift {
        transition: all 0.3s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,0.175) !important;
    }
    
    .team-card {
        transition: all 0.3s ease;
        padding: 2rem 1rem;
    }
    
    .team-card:hover {
        transform: translateY(-5px);
    }
    
    .achievement-item {
        padding: 2rem 1rem;
    }
    
    .achievement-icon {
        opacity: 0.8;
    }
    
    .counter {
        font-family: 'Poppins', sans-serif;
    }
    
    .social-links a {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .social-links a:hover {
        transform: translateY(-2px);
    }
    
    .breadcrumb-item a {
        text-decoration: none;
        opacity: 0.8;
    }
    
    .breadcrumb-item a:hover {
        opacity: 1;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Counter animation
    function animateCounter() {
        $('.counter').each(function() {
            var $this = $(this);
            var target = parseInt($this.data('target'));
            
            if (target) {
                $({ counter: 0 }).animate({
                    counter: target
                }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function() {
                        $this.text(Math.ceil(this.counter).toLocaleString());
                    },
                    complete: function() {
                        $this.text(target.toLocaleString());
                    }
                });
            }
        });
    }
    
    // Trigger counter animation when achievements section is visible
    $(window).scroll(function() {
        var achievementsTop = $('.achievement-item').first().offset().top;
        var windowBottom = $(window).scrollTop() + $(window).height();
        
        if (achievementsTop < windowBottom && !$('.counter').hasClass('animated')) {
            $('.counter').addClass('animated');
            animateCounter();
        }
    });
    
    // Smooth scrolling for anchor links
    $('a[href^="#"]').on('click', function(event) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 100
            }, 1000);
        }
    });
});
</script>
@endpush