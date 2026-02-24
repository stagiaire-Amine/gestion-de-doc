<!-- resources/views/auth/login.blade.php -->
@extends('layouts.guest')

@section('content')
    <div class="login-container">
        <div class="login-card">
            <!-- Left Section - Branding -->
            <div class="login-brand">
                <div class="brand-content">
                    <div class="logo-wrapper">
                        <svg class="logo-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="16" y1="13" x2="8" y2="13" />
                            <line x1="16" y1="17" x2="8" y2="17" />
                            <polyline points="10 9 9 9 8 9" />
                        </svg>
                    </div>
                    <h1>DocuManage</h1>
                    <p class="brand-tagline">Document Management System</p>
                </div>
            </div>

            <!-- Right Section - Login Form -->
            <div class="login-form-section">
                <div class="form-wrapper">
                    <h2>Welcome to DocuManage</h2>
                    <p class="form-subtitle">Please create an account to access your documents</p>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name Field -->
                        <div class="form-group">
                            <label for="name">
                                <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                Full Name
                            </label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}"
                                placeholder="Enter your full name" class="@error('name') is-invalid @enderror" required
                                autofocus>
                            @error('name')
                                <div class="error-message">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" y1="8" x2="12" y2="12" />
                                        <line x1="12" y1="16" x2="12.01" y2="16" />
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="form-group">
                            <label for="email">
                                <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                    <polyline points="22,6 12,13 2,6" />
                                </svg>
                                Email Address
                            </label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                placeholder="Enter your email" class="@error('email') is-invalid @enderror" required>
                            @error('email')
                                <div class="error-message">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" y1="8" x2="12" y2="12" />
                                        <line x1="12" y1="16" x2="12.01" y2="16" />
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="form-group">
                            <label for="password">
                                <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                                Password
                            </label>
                            <div class="password-wrapper">
                                <input id="password" type="password" name="password" placeholder="Enter your password"
                                    class="@error('password') is-invalid @enderror" required>
                                <button type="button" class="toggle-password" onclick="togglePassword()">
                                    <svg class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <div class="error-message">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" y1="8" x2="12" y2="12" />
                                        <line x1="12" y1="16" x2="12.01" y2="16" />
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="form-group">
                            <label for="password_confirmation">
                                <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                                Confirm Password
                            </label>
                            <div class="password-wrapper">
                                <input id="password_confirmation" type="password" name="password_confirmation"
                                    placeholder="Confirm your password" required>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="login-button">
                            <span>Create Account</span>
                            <svg class="button-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                                <polyline points="10 17 15 12 10 7" />
                                <line x1="15" y1="12" x2="3" y2="12" />
                            </svg>
                        </button>

                        <!-- Additional Links -->
                        <div class="additional-links">
                            <p>Already have an account?
                                <a href="{{ route('login') }}" class="register-link">Log in instead</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Modern Login Page Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .login-card {
            display: flex;
            max-width: 1000px;
            width: 100%;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Left Brand Section */
        .login-brand {
            flex: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
        }

        .brand-content {
            text-align: center;
        }

        .logo-wrapper {
            margin-bottom: 2rem;
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            stroke: white;
            stroke-width: 1.5;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .brand-content h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }

        .brand-tagline {
            font-size: 1rem;
            opacity: 0.9;
            line-height: 1.6;
        }

        /* Right Form Section */
        .login-form-section {
            flex: 1;
            background: white;
            padding: 3rem 2rem;
        }

        .form-wrapper {
            max-width: 360px;
            margin: 0 auto;
        }

        .form-wrapper h2 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .form-subtitle {
            color: #666;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            font-weight: 500;
            color: #555;
            margin-bottom: 0.5rem;
        }

        .field-icon {
            width: 18px;
            height: 18px;
            stroke: #667eea;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e1e1e1;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group input.is-invalid {
            border-color: #f56565;
        }

        /* Password Toggle */
        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #999;
            transition: color 0.3s ease;
        }

        .toggle-password:hover {
            color: #667eea;
        }

        .eye-icon {
            width: 20px;
            height: 20px;
        }

        /* Error Message */
        .error-message {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
            color: #f56565;
            font-size: 0.85rem;
        }

        .error-message svg {
            width: 16px;
            height: 16px;
        }

        /* Form Options */
        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        /* Custom Checkbox */
        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            font-size: 0.9rem;
            color: #666;
            user-select: none;
        }

        .checkbox-container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .checkmark {
            position: relative;
            display: inline-block;
            width: 18px;
            height: 18px;
            background: #fff;
            border: 2px solid #e1e1e1;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .checkbox-container:hover .checkmark {
            border-color: #667eea;
        }

        .checkbox-container input:checked~.checkmark {
            background: #667eea;
            border-color: #667eea;
        }

        .checkbox-container input:checked~.checkmark:after {
            content: '';
            position: absolute;
            left: 5px;
            top: 1px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        /* Forgot Password Button */
        .forgot-password-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 25px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(245, 87, 108, 0.3);
        }

        .forgot-password-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245, 87, 108, 0.4);
            background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
        }

        .forgot-password-btn:active {
            transform: translateY(0);
        }

        .forgot-icon {
            width: 16px;
            height: 16px;
        }

        /* Login Button */
        .login-button {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .button-icon {
            width: 20px;
            height: 20px;
            transition: transform 0.3s ease;
        }

        .login-button:hover .button-icon {
            transform: translateX(5px);
        }

        /* Additional Links */
        .additional-links {
            text-align: center;
            border-top: 1px solid #e1e1e1;
            padding-top: 1.5rem;
        }

        .additional-links p {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .text-muted {
            color: #999;
            font-style: italic;
        }

        /* Help Link */
        .help-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: #f8f9fa;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .help-link:hover {
            background: #e9ecef;
        }

        .help-link svg {
            width: 16px;
            height: 16px;
            color: #667eea;
        }

        .help-link a {
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .help-link a:hover {
            text-decoration: underline;
        }

        .register-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            margin-left: 0.25rem;
            transition: color 0.3s ease;
        }

        .register-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
            }

            .login-brand {
                padding: 2rem;
            }

            .logo-icon {
                width: 60px;
                height: 60px;
            }

            .brand-content h1 {
                font-size: 2rem;
            }

            .login-form-section {
                padding: 2rem 1.5rem;
            }

            .form-options {
                flex-direction: column;
                align-items: flex-start;
            }

            .forgot-password-btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* Animation for forgot password button */
        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-2px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(2px);
            }
        }

        .forgot-password-btn:hover .forgot-icon {
            animation: shake 0.5s ease-in-out;
        }
    </style>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle eye icon
            const eyeIcon = document.querySelector('.eye-icon');
            if (type === 'text') {
                eyeIcon.style.stroke = '#667eea';
                eyeIcon.style.fill = '#667eea20';
            } else {
                eyeIcon.style.stroke = 'currentColor';
                eyeIcon.style.fill = 'none';
            }
        }

        // Add keyboard shortcut for forgot password (optional)
        document.addEventListener('keydown', function (e) {
            // Press Ctrl+Alt+F to open forgot password
            if (e.ctrlKey && e.altKey && e.key === 'f') {
                e.preventDefault();
                window.location.href = "{{ route('password.request') }}";
            }
        });
    </script>
@endsection