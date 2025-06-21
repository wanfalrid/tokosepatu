@extends('layouts.app')

@section('title', 'Profil Saya - ShoeMart')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
<style>
  :root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    --shadow-soft: 0 10px 25px rgba(0,0,0,0.1);
    --shadow-medium: 0 15px 35px rgba(0,0,0,0.15);
    --glass-bg: rgba(255,255,255,0.9);
    --glass-border: rgba(255,255,255,0.3);
  }

  body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--primary-gradient);
    min-height: 100vh;
  }

  .profile-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 1rem;
  }

  .profile-card {
    background: var(--glass-bg);
    backdrop-filter: blur(10px);
    border: 1px solid var(--glass-border);
    border-radius: 20px;
    box-shadow: var(--shadow-medium);
    padding: 2rem;
    margin-bottom: 2rem;
  }

  .profile-header {
    text-align: center;
    margin-bottom: 3rem;
    color: white;
  }

  .profile-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
  }

  .profile-subtitle {
    font-size: 1.125rem;
    opacity: 0.9;
  }  .profile-avatar {
    width: 120px;
    height: 120px;
    background: var(--primary-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    position: relative;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .profile-avatar::before {
    content: '';
    position: absolute;
    inset: -3px;
    background: var(--secondary-gradient);
    border-radius: 50%;
    z-index: -1;
    opacity: 0.7;
  }

  .profile-avatar:hover {
    transform: scale(1.05);
    box-shadow: 0 12px 35px rgba(102, 126, 234, 0.6);
  }

  .profile-avatar .upload-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.7);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    color: white;
    font-size: 1.5rem;
  }

  .profile-avatar:hover .upload-overlay {
    opacity: 1;
  }

  .edit-photo-btn {
    position: absolute;
    bottom: 0;
    right: 0;
    background: var(--primary-gradient);
    border: 3px solid white;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
  }

  .edit-photo-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
  }

  /* Modal Styles */
  .modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.8);
    backdrop-filter: blur(10px);
  }

  .modal.show {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .modal-content {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    max-width: 600px;
    width: 90%;
    max-height: 80vh;
    overflow-y: auto;
    box-shadow: 0 25px 50px rgba(0,0,0,0.3);
    animation: modalSlideIn 0.3s ease-out;
  }

  @keyframes modalSlideIn {
    from {
      transform: translateY(-50px);
      opacity: 0;
    }
    to {
      transform: translateY(0);
      opacity: 1;
    }
  }

  .modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e5e7eb;
  }

  .modal-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .close-btn {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #6b7280;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 8px;
    transition: all 0.3s ease;
  }

  .close-btn:hover {
    background: #f3f4f6;
    color: #374151;
  }

  .crop-container {
    max-height: 400px;
    margin: 1rem 0;
    border-radius: 12px;
    overflow: hidden;
    border: 2px solid #e5e7eb;
  }

  .modal-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 1.5rem;
    padding-top: 1rem;
    border-top: 2px solid #e5e7eb;
  }

  .upload-area {
    border: 2px dashed #e5e7eb;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .upload-area:hover {
    border-color: #667eea;
    background: rgba(102, 126, 234, 0.05);
  }

  .upload-area.dragover {
    border-color: #667eea;
    background: rgba(102, 126, 234, 0.1);
    transform: scale(1.02);
  }

  #photo-file-input {
    display: none;
  }

  .photo-upload-section {
    background: rgba(255,255,255,0.1);
    padding: 1.5rem;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.2);
    margin-bottom: 1.5rem;
  }

  .photo-upload-area {
    border: 2px dashed #e5e7eb;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }

  .photo-upload-area:hover {
    border-color: #667eea;
    background: rgba(102, 126, 234, 0.05);
  }

  .photo-upload-area.dragover {
    border-color: #667eea;
    background: rgba(102, 126, 234, 0.1);
    transform: scale(1.02);
  }

  .file-input {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
  }

  .photo-preview {
    max-width: 200px;
    max-height: 200px;
    border-radius: 12px;
    margin: 1rem auto;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  }

  .btn-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
  }

  .btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(239, 68, 68, 0.5);
  }

  .btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
  }

  .status-badge {
    background: rgba(34, 197, 94, 0.1);
    border: 1px solid rgba(34, 197, 94, 0.3);
    color: #16a34a;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }

  .status-dot {
    width: 8px;
    height: 8px;
    background: #16a34a;
    border-radius: 50%;
    animation: pulse 2s infinite;
  }

  .info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
  }

  .info-item {
    background: rgba(255,255,255,0.1);
    padding: 1rem;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .info-icon {
    width: 40px;
    height: 40px;
    background: var(--primary-gradient);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
  }

  .form-section {
    margin-bottom: 2rem;
  }

  .section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
  }

  .form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  .form-label {
    font-weight: 600;
    color: #374151;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .form-input {
    padding: 0.875rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
  }

  .form-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    transform: translateY(-1px);
  }

  .form-textarea {
    resize: vertical;
    min-height: 100px;
  }
  .password-section {
    background: linear-gradient(135deg, #667eea, #764ba2);
    padding: 2rem;
    border-radius: 20px;
    margin: 2rem 0;
    position: relative;
    overflow: hidden;
  }

  .password-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    z-index: -1;
  }

  .password-section .section-title {
    color: white;
    margin-bottom: 2rem;
  }

  .password-section .form-label {
    color: rgba(255,255,255,0.95);
    font-weight: 600;
  }

  .password-section .form-input {
    background: rgba(255,255,255,0.95);
    border: 2px solid rgba(255,255,255,0.3);
    color: #374151;
  }

  .password-section .form-input:focus {
    background: white;
    border-color: rgba(255,255,255,0.8);
    box-shadow: 0 0 0 3px rgba(255,255,255,0.2);
  }

  .password-section .error-message {
    color: #fecaca;
    background: rgba(239, 68, 68, 0.1);
    padding: 0.5rem;
    border-radius: 8px;
    border: 1px solid rgba(239, 68, 68, 0.3);
  }

  .password-toggle {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #6b7280;
    cursor: pointer;
    padding: 0.25rem;
  }

  .button-group {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
  }

  .btn {
    padding: 0.875rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 1rem;
  }

  .btn-primary {
    background: var(--primary-gradient);
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
  }

  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
  }

  .btn-secondary {
    background: white;
    color: #374151;
    border: 2px solid #e5e7eb;
  }

  .btn-secondary:hover {
    background: #f9fafb;
    border-color: #d1d5db;
    transform: translateY(-1px);
  }
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
  }

  .quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
  }
  .stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: 16px;
    box-shadow: var(--shadow-soft);
    text-align: center;
    border: 1px solid #f3f4f6;
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
    display: block;
  }

  .stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-medium);
    text-decoration: none;
    color: inherit;
  }

  .stat-card.hover\:bg-blue-50:hover {
    background: #eff6ff;
  }

  .stat-card.hover\:bg-green-50:hover {
    background: #f0fdf4;
  }

  .stat-card.hover\:bg-purple-50:hover {
    background: #faf5ff;
  }

  .stat-card.hover\:bg-orange-50:hover {
    background: #fff7ed;
  }
  .stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 1.25rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  }

  .stat-value {
    font-size: 1.875rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.25rem;
    line-height: 1.2;
  }

  .stat-label {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 600;
    line-height: 1.4;
  }

  .alert {
    background: rgba(34, 197, 94, 0.1);
    border: 1px solid rgba(34, 197, 94, 0.3);
    color: #16a34a;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .alert-icon {
    width: 20px;
    height: 20px;
    background: #16a34a;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.75rem;
  }

  .error-message {
    color: #dc2626;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  @keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
  }
  @media (max-width: 768px) {
    .profile-container {
      padding: 1rem 0.5rem;
    }
    
    .profile-title {
      font-size: 2rem;
    }
    
    .profile-card {
      padding: 1.5rem;
    }
    
    .button-group {
      flex-direction: column;
    }
    
    .form-grid {
      grid-template-columns: 1fr;
    }

    .stats-grid {
      grid-template-columns: 1fr;
      gap: 1rem;
    }

    .quick-actions-grid {
      grid-template-columns: 1fr;
      gap: 1rem;
    }

    .password-section {
      padding: 1.5rem;
      margin: 1.5rem 0;
    }

    .info-grid {
      grid-template-columns: 1fr;
      gap: 1rem;
    }
  }
</style>
@endpush 

@section('content')
<div class="profile-container">
  {{-- Header --}}
  <div class="profile-header">
    <h1 class="profile-title">Profil Saya</h1>
    <p class="profile-subtitle">Kelola informasi pribadi Anda dengan mudah dan aman</p>
  </div>  {{-- Profile Info Card --}}
  <div class="profile-card">
    <div class="text-center">
      <div class="profile-avatar" onclick="openPhotoModal()">
        @if($customer->hasFoto())
          <img src="{{ $customer->foto_url }}" alt="Profile Photo" class="w-full h-full object-cover rounded-full">
        @else
          <i class="fas fa-user text-white text-4xl"></i>
        @endif
        <div class="upload-overlay">
          <i class="fas fa-camera"></i>
        </div>
        <div class="edit-photo-btn">
          <i class="fas fa-pencil-alt text-sm"></i>
        </div>
      </div>
      
      <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $customer->nama }}</h2>
      <p class="text-gray-600 mb-4">{{ $customer->email }}</p>
      
      <div class="status-badge">
        <div class="status-dot"></div>
        <span>{{ ucfirst($customer->status_akun) }}</span>
      </div>

      <div class="info-grid">
        <div class="info-item">
          <div class="info-icon">
            <i class="fas fa-calendar"></i>
          </div>
          <div>
            <div class="font-semibold text-gray-800">Bergabung</div>
            <div class="text-sm text-gray-600">
              {{ $customer->created_at ? $customer->created_at->format('d M Y') : '–' }}
            </div>
          </div>
        </div>
        
        <div class="info-item">
          <div class="info-icon">
            <i class="fas fa-shield-alt"></i>
          </div>
          <div>
            <div class="font-semibold text-gray-800">Status</div>
            <div class="text-sm text-gray-600">Akun Terverifikasi</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- Form Section --}}
    <div class="lg:col-span-2">
      <div class="profile-card">
        @if(session('success'))
          <div class="alert">
            <div class="alert-icon">
              <i class="fas fa-check"></i>
            </div>
            <div>
              <div class="font-semibold">Berhasil!</div>
              <div class="text-sm">{{ session('success') }}</div>
            </div>
          </div>
        @endif        <form action="{{ route('auth.profile.update') }}" method="POST" enctype="multipart/form-data" id="profile-form">
          @csrf
          @method('PUT')
          
          {{-- Hidden field for cropped photo --}}
          <input type="hidden" id="cropped-photo" name="foto_base64">
          
          {{-- Personal Information --}}
          <div class="form-section">
            <h3 class="section-title">
              <i class="fas fa-user text-blue-500"></i>
              Informasi Pribadi
            </h3>
            
            <div class="form-grid">
              <div class="form-group">
                <label for="nama" class="form-label">
                  <i class="fas fa-id-card text-blue-500"></i>
                  Nama Lengkap
                </label>
                <input 
                  type="text" 
                  id="nama" 
                  name="nama" 
                  value="{{ old('nama', $customer->nama) }}"
                  class="form-input @error('nama') border-red-500 @enderror" 
                  required>
                @error('nama')
                  <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                  </div>
                @enderror
              </div>

              <div class="form-group">
                <label for="email" class="form-label">
                  <i class="fas fa-envelope text-blue-500"></i>
                  Email Address
                </label>
                <input 
                  type="email" 
                  id="email" 
                  name="email" 
                  value="{{ old('email', $customer->email) }}"
                  class="form-input @error('email') border-red-500 @enderror" 
                  required>
                @error('email')
                  <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                  </div>
                @enderror
              </div>

              <div class="form-group">
                <label for="telepon" class="form-label">
                  <i class="fas fa-phone text-blue-500"></i>
                  Nomor Telepon
                </label>
                <input 
                  type="tel" 
                  id="telepon" 
                  name="telepon" 
                  value="{{ old('telepon', $customer->telepon) }}"
                  class="form-input @error('telepon') border-red-500 @enderror" 
                  required>
                @error('telepon')
                  <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                  </div>
                @enderror
              </div>

              <div class="form-group">
                <label for="tanggal_lahir" class="form-label">
                  <i class="fas fa-birthday-cake text-blue-500"></i>
                  Tanggal Lahir
                </label>
                <input 
                  type="date" 
                  id="tanggal_lahir" 
                  name="tanggal_lahir" 
                  value="{{ old('tanggal_lahir', $customer->tanggal_lahir) }}"
                  class="form-input @error('tanggal_lahir') border-red-500 @enderror">
                @error('tanggal_lahir')
                  <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>

            <div class="form-group mt-6">
              <label for="alamat" class="form-label">
                <i class="fas fa-map-marker-alt text-blue-500"></i>
                Alamat Lengkap
              </label>
              <textarea 
                id="alamat" 
                name="alamat" 
                rows="4"
                class="form-input form-textarea @error('alamat') border-red-500 @enderror"
                required>{{ old('alamat', $customer->alamat) }}</textarea>              @error('alamat')
                <div class="error-message">
                  <i class="fas fa-exclamation-circle"></i>
                  {{ $message }}
                </div>
              @enderror
            </div>
          </div>

          {{-- Password Section --}}
          <div class="password-section">
            <h3 class="section-title">
              <i class="fas fa-lock text-white"></i>
              Keamanan Akun
            </h3>
            
            <div class="form-grid">
              <div class="form-group">
                <label for="password" class="form-label">
                  <i class="fas fa-key text-purple-300"></i>
                  Password Baru
                </label>
                <div class="relative">
                  <input 
                    type="password" 
                    id="password" 
                    name="password"
                    class="form-input pr-12 @error('password') border-red-500 @enderror"
                    minlength="6">
                  <button type="button" onclick="togglePassword('password')" class="password-toggle">
                    <i class="fas fa-eye" id="password-eye"></i>
                  </button>
                </div>
                @error('password')
                  <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                  </div>
                @enderror
              </div>

              <div class="form-group">
                <label for="password_confirmation" class="form-label">
                  <i class="fas fa-key text-purple-300"></i>
                  Konfirmasi Password
                </label>
                <div class="relative">
                  <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation"
                    class="form-input pr-12 @error('password_confirmation') border-red-500 @enderror"
                    minlength="6">
                  <button type="button" onclick="togglePassword('password_confirmation')" class="password-toggle">
                    <i class="fas fa-eye" id="password_confirmation-eye"></i>
                  </button>
                </div>
                @error('password_confirmation')
                  <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
          </div>

          {{-- Action Buttons --}}
          <div class="button-group">
            <a href="{{ route('home') }}" class="btn btn-secondary">
              <i class="fas fa-arrow-left"></i>
              Kembali
            </a>
            <button type="submit" class="btn btn-primary flex-1">
              <i class="fas fa-save"></i>
              Simpan Perubahan
            </button>
          </div>
        </form>
      </div>
    </div>    {{-- Sidebar Stats --}}
    <div class="space-y-8">
      <div class="profile-card">
        <h3 class="section-title">
          <i class="fas fa-chart-bar text-blue-500"></i>
          Statistik
        </h3>
        
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-icon" style="background: var(--success-gradient);">
              <i class="fas fa-shopping-bag"></i>
            </div>
            <div class="stat-value">0</div>
            <div class="stat-label">Total Pesanan</div>
          </div>
          
          <div class="stat-card">
            <div class="stat-icon" style="background: var(--warning-gradient);">
              <i class="fas fa-star"></i>
            </div>
            <div class="stat-value">0</div>
            <div class="stat-label">Poin Reward</div>
          </div>
        </div>
      </div><div class="profile-card">
        <h3 class="section-title">
          <i class="fas fa-bolt text-yellow-500"></i>
          Aksi Cepat
        </h3>
        
        <div class="quick-actions-grid">
          <a href="{{ route('auth.orders') }}" class="stat-card hover:bg-blue-50">
            <div class="stat-icon" style="background: var(--primary-gradient);">
              <i class="fas fa-history"></i>
            </div>
            <div class="stat-label">Riwayat Pesanan</div>
          </a>
          
          <a href="{{ route('shop') }}" class="stat-card hover:bg-green-50">
            <div class="stat-icon" style="background: var(--success-gradient);">
              <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-label">Belanja</div>
          </a>
          
          <a href="{{ route('cart.index') }}" class="stat-card hover:bg-purple-50">
            <div class="stat-icon" style="background: var(--secondary-gradient);">
              <i class="fas fa-shopping-bag"></i>
            </div>
            <div class="stat-label">Keranjang</div>
          </a>
          
          <a href="{{ route('contact') }}" class="stat-card hover:bg-orange-50">
            <div class="stat-icon" style="background: var(--warning-gradient);">
              <i class="fas fa-headset"></i>
            </div>
            <div class="stat-label">Bantuan</div>
          </a>        
        </div>
      </div>    </div>
  </div>
</div>

{{-- Photo Crop Modal --}}
<div id="photo-modal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title">
        <i class="fas fa-crop text-blue-500"></i>
        Edit Foto Profil
      </h3>
      <button type="button" class="close-btn" onclick="closePhotoModal()">
        <i class="fas fa-times"></i>
      </button>
    </div>
    
    <div id="upload-step">
      <div class="upload-area" onclick="document.getElementById('photo-file-input').click()">
        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
        <h4 class="text-lg font-semibold text-gray-700 mb-2">Pilih Foto Profil</h4>
        <p class="text-gray-500 mb-4">Klik atau drag & drop foto Anda di sini</p>
        <p class="text-sm text-gray-400">Format: JPG, PNG, GIF (Max: 2MB)</p>
      </div>
      <input type="file" id="photo-file-input" accept="image/*" onchange="loadImage(this)">
    </div>
    
    <div id="crop-step" style="display: none;">
      <div class="crop-container">
        <img id="crop-image" style="max-width: 100%;">
      </div>
      
      <div class="modal-actions">
        <button type="button" class="btn btn-secondary" onclick="backToUpload()">
          <i class="fas fa-arrow-left"></i>
          Pilih Foto Lain
        </button>
        <button type="button" class="btn btn-primary" onclick="cropAndSave()">
          <i class="fas fa-check"></i>
          Gunakan Foto Ini
        </button>
      </div>
    </div>
    
    @if($customer->hasFoto())
    <div class="modal-actions" id="existing-photo-actions">
      <button type="button" class="btn btn-danger" onclick="deletePhoto()">
        <i class="fas fa-trash"></i>
        Hapus Foto
      </button>
    </div>
    @endif
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script>
  let cropper = null;
  let currentImageFile = null;

  function togglePassword(fieldId) {
    const passwordField = document.getElementById(fieldId);
    const eyeIcon = document.getElementById(fieldId + '-eye');
    
    if (passwordField.type === 'password') {
      passwordField.type = 'text';
      eyeIcon.classList.remove('fa-eye');
      eyeIcon.classList.add('fa-eye-slash');
    } else {
      passwordField.type = 'password';
      eyeIcon.classList.remove('fa-eye-slash');
      eyeIcon.classList.add('fa-eye');
    }
  }

  // Photo modal functions
  function openPhotoModal() {
    document.getElementById('photo-modal').classList.add('show');
    document.body.style.overflow = 'hidden';
  }

  function closePhotoModal() {
    document.getElementById('photo-modal').classList.remove('show');
    document.body.style.overflow = 'auto';
    
    // Clean up
    if (cropper) {
      cropper.destroy();
      cropper = null;
    }
    
    document.getElementById('upload-step').style.display = 'block';
    document.getElementById('crop-step').style.display = 'none';
    document.getElementById('photo-file-input').value = '';
  }

  function loadImage(input) {
    if (input.files && input.files[0]) {
      const file = input.files[0];
      
      // Validate file size (2MB)
      if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran file terlalu besar. Maksimal 2MB.');
        input.value = '';
        return;
      }
      
      // Validate file type
      const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
      if (!allowedTypes.includes(file.type)) {
        alert('Format file tidak didukung. Gunakan JPG, PNG, atau GIF.');
        input.value = '';
        return;
      }
      
      currentImageFile = file;
      const reader = new FileReader();
      reader.onload = function(e) {
        const image = document.getElementById('crop-image');
        image.src = e.target.result;
        
        // Show crop step
        document.getElementById('upload-step').style.display = 'none';
        document.getElementById('crop-step').style.display = 'block';
        
        // Initialize cropper
        if (cropper) {
          cropper.destroy();
        }
        
        cropper = new Cropper(image, {
          aspectRatio: 1,
          viewMode: 2,
          guides: false,
          center: false,
          highlight: false,
          cropBoxMovable: true,
          cropBoxResizable: true,
          toggleDragModeOnDblclick: false,
          responsive: true,
          restore: false,
          modal: true,
          minCropBoxWidth: 100,
          minCropBoxHeight: 100,
          ready: function() {
            // Auto fit crop box to image
            this.cropper.crop();
          }
        });
      };
      reader.readAsDataURL(file);
    }
  }

  function backToUpload() {
    document.getElementById('upload-step').style.display = 'block';
    document.getElementById('crop-step').style.display = 'none';
    
    if (cropper) {
      cropper.destroy();
      cropper = null;
    }
    
    document.getElementById('photo-file-input').value = '';
  }

  function cropAndSave() {
    if (!cropper) return;
    
    // Get cropped canvas
    const canvas = cropper.getCroppedCanvas({
      width: 300,
      height: 300,
      imageSmoothingEnabled: true,
      imageSmoothingQuality: 'high'
    });
    
    // Convert to blob and then to base64
    canvas.toBlob(function(blob) {
      const reader = new FileReader();
      reader.onload = function() {
        // Set the base64 data to hidden input
        document.getElementById('cropped-photo').value = reader.result;
        
        // Update profile avatar preview
        const profileAvatar = document.querySelector('.profile-avatar');
        profileAvatar.innerHTML = `
          <img src="${reader.result}" alt="Profile Photo" class="w-full h-full object-cover rounded-full">
          <div class="upload-overlay">
            <i class="fas fa-camera"></i>
          </div>
          <div class="edit-photo-btn">
            <i class="fas fa-pencil-alt text-sm"></i>
          </div>
        `;
        
        // Close modal
        closePhotoModal();
        
        // Show success message
        showNotification('Foto berhasil dipilih! Klik "Simpan Perubahan" untuk menyimpan.', 'success');
      };
      reader.readAsDataURL(blob);
    }, 'image/jpeg', 0.9);
  }

  function deletePhoto() {
    if (confirm('Yakin ingin menghapus foto profil?')) {
      fetch('{{ route("auth.profile.photo.delete") }}', {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Content-Type': 'application/json',
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Update profile avatar to default
          const profileAvatar = document.querySelector('.profile-avatar');
          profileAvatar.innerHTML = `
            <i class="fas fa-user text-white text-4xl"></i>
            <div class="upload-overlay">
              <i class="fas fa-camera"></i>
            </div>
            <div class="edit-photo-btn">
              <i class="fas fa-pencil-alt text-sm"></i>
            </div>
          `;
          
          closePhotoModal();
          showNotification('Foto profil berhasil dihapus!', 'success');
          
          // Reload page to update UI
          setTimeout(() => location.reload(), 1000);
        } else {
          showNotification('Gagal menghapus foto profil!', 'error');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan!', 'error');
      });
    }
  }

  function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;
    
    if (type === 'success') {
      notification.classList.add('bg-green-500', 'text-white');
      notification.innerHTML = `<i class="fas fa-check-circle mr-2"></i>${message}`;
    } else if (type === 'error') {
      notification.classList.add('bg-red-500', 'text-white');
      notification.innerHTML = `<i class="fas fa-times-circle mr-2"></i>${message}`;
    } else {
      notification.classList.add('bg-blue-500', 'text-white');
      notification.innerHTML = `<i class="fas fa-info-circle mr-2"></i>${message}`;
    }
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
      notification.classList.remove('translate-x-full');
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
      notification.classList.add('translate-x-full');
      setTimeout(() => {
        document.body.removeChild(notification);
      }, 300);
    }, 3000);
  }

  // Drag and drop functionality for upload area
  document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.querySelector('.upload-area');
    const fileInput = document.getElementById('photo-file-input');

    if (uploadArea && fileInput) {
      // Prevent default drag behaviors
      ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
      });

      // Highlight drop area when item is dragged over it
      ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, highlight, false);
      });

      ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, unhighlight, false);
      });

      // Handle dropped files
      uploadArea.addEventListener('drop', handleDrop, false);

      function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
      }

      function highlight(e) {
        uploadArea.classList.add('dragover');
      }

      function unhighlight(e) {
        uploadArea.classList.remove('dragover');
      }

      function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;

        if (files.length > 0) {
          fileInput.files = files;
          loadImage(fileInput);
        }
      }
    }

    // Close modal when clicking outside
    document.getElementById('photo-modal').addEventListener('click', function(e) {
      if (e.target === this) {
        closePhotoModal();
      }
    });

    // Add smooth scrolling to form validation errors
    const errorElements = document.querySelectorAll('.error-message');
    if (errorElements.length > 0) {
      errorElements[0].scrollIntoView({ 
        behavior: 'smooth', 
        block: 'center' 
      });
    }
  });
</script>
@endpush