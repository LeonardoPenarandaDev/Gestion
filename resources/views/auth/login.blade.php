<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif !important;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 1rem;
        }
        
        .login-container {
            width: 100%;
            max-width: 450px;
            background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.85) 100%);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 32px 64px rgba(0,0,0,0.15);
            border: 1px solid rgba(255,255,255,0.2);
            overflow: hidden;
            animation: fadeIn 0.8s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .login-header {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            padding: 3rem 2rem 2rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .login-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
        }
        
        .login-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 0.5rem 0;
        }
        
        .login-subtitle {
            color: #6b7280;
            font-size: 0.95rem;
            margin: 0;
            line-height: 1.5;
        }
        
        .login-form {
            padding: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.75rem;
            font-size: 0.925rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
            z-index: 2;
        }
        
        .form-input {
            width: 100%;
            padding: 1rem 1rem 1rem 2.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.925rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(5px);
            color: #374151;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-1px);
        }
        
        .form-input:focus + .input-icon {
            color: #667eea;
        }
        
        .error-message {
            color: #ef4444;
            font-size: 0.825rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-weight: 500;
        }
        
        .success-message {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            padding: 1rem;
            border-radius: 12px;
            border: 1px solid #86efac;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 1.5rem 0;
        }
        
        .custom-checkbox {
            width: 20px;
            height: 20px;
            border: 2px solid #d1d5db;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.8);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .custom-checkbox input {
            opacity: 0;
            position: absolute;
            width: 100%;
            height: 100%;
            cursor: pointer;
            margin: 0;
        }
        
        .custom-checkbox input:checked + .checkmark {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
        }
        
        .custom-checkbox input:checked + .checkmark::after {
            opacity: 1;
            transform: scale(1);
        }
        
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .checkmark::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            color: white;
            font-size: 12px;
            font-weight: bold;
            opacity: 0;
            transition: all 0.2s ease;
        }
        
        .checkbox-label {
            color: #6b7280;
            font-size: 0.875rem;
            cursor: pointer;
        }
        
        .btn-primary {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.925rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .forgot-password {
            color: #667eea;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .forgot-password:hover {
            color: #5a67d8;
            text-decoration: underline;
        }
        
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }
        
        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }
        
        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 10%;
            left: 10%;
            animation-delay: -1s;
        }
        
        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 70%;
            right: 10%;
            animation-delay: -2s;
        }
        
        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 15%;
            animation-delay: -3s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        @media (max-width: 480px) {
            .login-container {
                margin: 0.5rem;
                border-radius: 20px;
            }
            
            .login-header {
                padding: 2rem 1.5rem 1.5rem;
            }
            
            .login-form {
                padding: 1.5rem;
            }
            
            .login-title {
                font-size: 1.75rem;
            }
        }
    </style>

    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="login-container">
        <!-- Header -->
        <div class="login-header">
            <div class="login-logo">
                <svg width="40" height="40" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="login-title">Bienvenido</h1>
            <p class="login-subtitle">Ingresa tus credenciales para acceder al sistema electoral</p>
        </div>

        <!-- Form -->
        <div class="login-form">
            <!-- Session Status -->
            @if (session('status'))
                <div class="success-message">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                        </svg>
                        {{ __('Email') }}
                    </label>
                    <div class="input-wrapper">
                        <div class="input-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                        <input id="email" 
                               class="form-input" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               placeholder="tu@email.com"
                               required 
                               autofocus 
                               autocomplete="username">
                    </div>
                    @if ($errors->get('email'))
                        <div class="error-message">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ implode(', ', $errors->get('email')) }}
                        </div>
                    @endif
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        {{ __('Password') }}
                    </label>
                    <div class="input-wrapper">
                        <div class="input-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input id="password" 
                               class="form-input"
                               type="password"
                               name="password"
                               placeholder="Ingresa tu contraseña"
                               required 
                               autocomplete="current-password">
                    </div>
                    @if ($errors->get('password'))
                        <div class="error-message">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ implode(', ', $errors->get('password')) }}
                        </div>
                    @endif
                </div>

                <!-- Remember Me -->
                <div class="checkbox-wrapper">
                    <div class="custom-checkbox">
                        <input id="remember_me" type="checkbox" name="remember">
                        <div class="checkmark"></div>
                    </div>
                    <label for="remember_me" class="checkbox-label">{{ __('Recordar Contraseña') }}</label>
                </div>

                <!-- Submit Button and Forgot Password -->
                <button type="submit" class="btn-primary">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    {{ __('Log in') }}
                </button>

                @if (Route::has('password.request'))
                    <div class="form-footer">
                        <a class="forgot-password" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-focus en el email si está vacío
            const emailInput = document.getElementById('email');
            if (!emailInput.value) {
                emailInput.focus();
            }

            // Efecto de escritura en el placeholder del email
            const emailPlaceholder = 'tu@email.com';
            let placeholderIndex = 0;
            let isDeleting = false;
            
            function typePlaceholder() {
                if (!isDeleting) {
                    emailInput.placeholder = emailPlaceholder.slice(0, placeholderIndex);
                    placeholderIndex++;
                    
                    if (placeholderIndex > emailPlaceholder.length) {
                        isDeleting = true;
                        setTimeout(typePlaceholder, 2000);
                        return;
                    }
                } else {
                    emailInput.placeholder = emailPlaceholder.slice(0, placeholderIndex);
                    placeholderIndex--;
                    
                    if (placeholderIndex < 0) {
                        isDeleting = false;
                        setTimeout(typePlaceholder, 500);
                        return;
                    }
                }
                
                setTimeout(typePlaceholder, isDeleting ? 50 : 100);
            }
            
            // Solo iniciar la animación si el campo está vacío y no está enfocado
            if (!emailInput.value) {
                setTimeout(typePlaceholder, 1000);
            }

            // Detener animación cuando el usuario comience a escribir
            emailInput.addEventListener('focus', function() {
                this.placeholder = 'tu@email.com';
            });

            // Validación visual en tiempo real
            emailInput.addEventListener('blur', function() {
                if (this.value && !this.checkValidity()) {
                    this.style.borderColor = '#ef4444';
                } else if (this.value) {
                    this.style.borderColor = '#10b981';
                }
            });

            // Efecto de shake en caso de error
            const errorMessages = document.querySelectorAll('.error-message');
            if (errorMessages.length > 0) {
                const container = document.querySelector('.login-container');
                container.style.animation = 'shake 0.5s ease-in-out';
            }
        });

        // Animación de shake
        const shakeKeyframes = `
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-5px); }
                75% { transform: translateX(5px); }
            }
        `;
        
        const styleSheet = document.createElement('style');
        styleSheet.textContent = shakeKeyframes;
        document.head.appendChild(styleSheet);
    </script>
</x-guest-layout>