<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register Admin - ShoeMart</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #8b5cf6;
            --accent-color: #06b6d4;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #1f2937;
            --light-color: #f8fafc;
            --border-radius: 12px;
            --box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --box-shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .register-container {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow-lg);
            overflow: hidden;
            width: 100%;
            max-width: 500px;
        }

        .register-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .register-header h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            margin: 0;
            font-size: 1.75rem;
        }

        .register-header p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
        }

        .register-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: var(--border-radius);
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
        }

        .input-group {
            position: relative;
        }

        .input-group-text {
            background: var(--light-color);
            border: 2px solid #e5e7eb;
            border-right: none;
            border-radius: var(--border-radius) 0 0 var(--border-radius);
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 var(--border-radius) var(--border-radius) 0;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: var(--border-radius);
            padding: 0.75rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--box-shadow-lg);
        }

        .register-footer {
            text-align: center;
            padding: 1.5rem 2rem 2rem;
            background: var(--light-color);
            border-top: 1px solid #e5e7eb;
        }

        .register-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .register-footer a:hover {
            text-decoration: underline;
        }

        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875rem;
            color: var(--danger-color);
        }

        .is-invalid {
            border-color: var(--danger-color);
        }

        .alert {
            border: none;
            border-radius: var(--border-radius);
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
        }

        .password-toggle {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            z-index: 10;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <div class="mb-3">
                <i class="fas fa-user-plus fa-3x"></i>
            </div>
            <h1>Register Admin</h1>
            <p>Buat akun admin baru untuk ShoeMart</p>
        </div>
        
        <div class="register-body">
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.register.process') }}">
                @csrf
                
                <div class="form-group">
                    <label for="nama_lengkap" class="form-label">
                        <i class="fas fa-user me-1"></i> Nama Lengkap
                    </label>
                    <input type="text" 
                           class="form-control @error('nama_lengkap') is-invalid @enderror" 
                           id="nama_lengkap" 
                           name="nama_lengkap" 
                           value="{{ old('nama_lengkap') }}" 
                           required 
                           placeholder="Masukkan nama lengkap">
                    @error('nama_lengkap')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope me-1"></i> Email
                    </label>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           placeholder="admin@shoemart.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="telepon" class="form-label">
                        <i class="fas fa-phone me-1"></i> Nomor Telepon (Opsional)
                    </label>
                    <input type="text" 
                           class="form-control @error('telepon') is-invalid @enderror" 
                           id="telepon" 
                           name="telepon" 
                           value="{{ old('telepon') }}" 
                           placeholder="08123456789">
                    @error('telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock me-1"></i> Password
                    </label>
                    <div class="position-relative">
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required 
                               minlength="6"
                               placeholder="Minimal 6 karakter">
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <i class="fas fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">
                        <i class="fas fa-lock me-1"></i> Konfirmasi Password
                    </label>
                    <div class="position-relative">
                        <input type="password" 
                               class="form-control" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               required 
                               placeholder="Ulangi password">
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <i class="fas fa-eye" id="password_confirmation-icon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-user-plus me-2"></i>
                    Daftar Admin
                </button>
            </form>
        </div>
        
        <div class="register-footer">
            <p class="mb-0">
                Sudah punya akun admin? 
                <a href="{{ route('admin.login') }}">Login di sini</a>
            </p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(inputId + '-icon');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Phone number formatting
        document.getElementById('telepon').addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            
            if (value.length > 0 && !value.startsWith('08')) {
                if (value.startsWith('8')) {
                    value = '0' + value;
                } else if (value.startsWith('62')) {
                    value = '0' + value.substring(2);
                }
            }
            
            if (value.length > 15) {
                value = value.substring(0, 15);
            }
            
            this.value = value;
        });

        // Real-time password confirmation check
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmation = this.value;
            
            if (password !== confirmation && confirmation.length > 0) {
                this.classList.add('is-invalid');
                if (!this.nextElementSibling || !this.nextElementSibling.classList.contains('invalid-feedback')) {
                    const feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    feedback.textContent = 'Password tidak cocok';
                    this.parentNode.appendChild(feedback);
                }
            } else {
                this.classList.remove('is-invalid');
                const feedback = this.parentNode.querySelector('.invalid-feedback');
                if (feedback) {
                    feedback.remove();
                }
            }
        });
    </script>
</body>
</html>
