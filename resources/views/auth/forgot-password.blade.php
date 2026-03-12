@extends('layouts.app')

@section('title', 'Восстановление пароля - Созвездие вкусов')

@section('content')
<style>
:root {
    --bg-dark: #0a0a0a;
    --bg-card: #141414;
    --bg-light: #1e1e1e;
    --text-light: #ffffff;
    --text-gray: #b0b0b0;
    --text-muted: #808080;
    --border: #2a2a2a;
    --border-light: #333333;
    --accent: #AD1C43;
    --accent-light: #d4b77d;
    --accent-dark: #b89448;
    --accent-gradient: linear-gradient(135deg, #AD1C43 0%, #b89448 100%);
    --error: #ff4444;
    --error-bg: rgba(255, 68, 68, 0.1);
    --success: #4CAF50;
    --success-bg: rgba(76, 175, 80, 0.1);
}

/* Скрываем шапку и подвал */
header.header-elegant,
footer {
    display: none !important;
}

body {
    margin: 0;
    padding: 0;
    background: var(--bg-dark);
    font-family: 'Inter', sans-serif;
    min-height: 100vh;
    position: relative;
}

body::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 10% 20%, rgba(201, 168, 106, 0.03) 0%, transparent 30%),
        radial-gradient(circle at 90% 80%, rgba(201, 168, 106, 0.03) 0%, transparent 30%);
    pointer-events: none;
}

.auth-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    position: relative;
    z-index: 1;
}

.auth-container {
    max-width: 460px;
    width: 100%;
    margin: 0 auto;
}

.auth-card {
    background: rgba(20, 20, 20, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 32px;
    padding: 48px 40px;
    box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.7);
    border: 1px solid rgba(201, 168, 106, 0.15);
    position: relative;
    overflow: hidden;
}

.auth-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--accent-gradient);
}

.auth-card-glow {
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(201, 168, 106, 0.05) 0%, transparent 70%);
    opacity: 0.5;
    pointer-events: none;
}

.auth-header {
    text-align: center;
    margin-bottom: 40px;
}

.auth-icon {
    width: 70px;
    height: 70px;
    background: rgba(126, 48, 69, 0.38);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 32px;
    color: #AD1C43;
    border: 1px solid rgba(201, 168, 106, 0.3);
}

.auth-title {
    font-size: 36px;
    font-weight: 700;
    color: var(--text-light);
    margin-bottom: 12px;
    font-family: "Yeseva One", serif;
    background: linear-gradient(135deg, #ffffff 0%, #e0e0e0 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.auth-subtitle {
    color: var(--text-gray);
    font-size: 16px;
    line-height: 1.6;
}

.form-group {
    margin-bottom: 24px;
}

.form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: var(--text-light);
    font-size: 15px;
}

.form-label i {
    color: #AD1C43;
    margin-right: 6px;
}

.form-control {
    width: 100%;
    padding: 16px 20px;
    background: var(--bg-light);
    border: 1.5px solid var(--border);
    border-radius: 16px;
    color: var(--text-light);
    font-size: 16px;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.form-control:focus {
    outline: none;
    border-color: #AD1C43;
    box-shadow: 0 0 0 4px rgba(201, 168, 106, 0.15);
    background: var(--bg-card);
}

.form-control::placeholder {
    color: var(--text-muted);
    opacity: 0.7;
}

.form-control.is-invalid {
    border-color: var(--error);
    background: var(--error-bg);
}

.btn-exact {
    display: block;
    width: 100%;
    padding: 16px 28px;
    background: var(--accent-gradient);
    color: var(--bg-dark);
    border: none;
    border-radius: 16px;
    font-size: 17px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.btn-exact::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn-exact:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px -5px rgba(201, 168, 106, 0.4);
}

.btn-exact:hover::before {
    width: 300px;
    height: 300px;
}

.btn-exact i {
    margin-right: 8px;
}

.alert {
    padding: 16px 20px;
    border-radius: 16px;
    margin-bottom: 30px;
    border: 1px solid transparent;
    font-size: 15px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.alert-success {
    background: var(--success-bg);
    border-color: rgba(76, 175, 80, 0.3);
    color: var(--success);
}

.alert-danger {
    background: var(--error-bg);
    border-color: rgba(255, 68, 68, 0.3);
    color: var(--error);
}

.alert ul {
    margin: 0;
    padding-left: 20px;
}

.text-danger {
    color: var(--error);
    font-size: 13px;
    margin-top: 6px;
    display: block;
}

.auth-divider {
    position: relative;
    text-align: center;
    margin: 30px 0 20px;
    color: var(--text-muted);
}

.auth-divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--border), transparent);
}

.auth-divider span {
    position: relative;
    background: var(--bg-card);
    padding: 0 18px;
    font-size: 14px;
}

.auth-footer p {
    color: var(--text-muted);
    font-size: 15px;
    margin: 8px 0;
}

.text-link {
    color: #AD1C43;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 15px;
    font-weight: 500;
    position: relative;
    padding-bottom: 2px;
}

.text-link::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 1px;
    background: #AD1C43;
    transition: width 0.3s ease;
}

.text-link:hover {
    color: var(--accent-light);
}

.text-link:hover::after {
    width: 100%;
}

.text-link i {
    font-size: 14px;
    transition: transform 0.3s ease;
}

.text-link:hover i:first-child {
    transform: translateX(-3px);
}

.text-link:hover i:last-child {
    transform: translateX(3px);
}

@media (max-width: 576px) {
    .auth-card {
        padding: 35px 25px;
    }
    
    .auth-title {
        font-size: 32px;
    }
    
    .form-control {
        padding: 14px 18px;
    }
}
</style>

<div class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <!-- Декоративный элемент -->
            <div class="auth-card-glow"></div>
            
            <div class="auth-header">
                <div class="auth-icon">
                    <i class="bi bi-key"></i>
                </div>
                <h2 class="auth-title">Забыли пароль?</h2>
                <p class="auth-subtitle">
                    Введите email, указанный при регистрации,<br>
                    и мы отправим код подтверждения
                </p>
            </div>
            
            @if(session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif
            
            @if($errors->any())
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <div>
                    <strong>Пожалуйста, исправьте ошибки:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            
            <form method="POST" action="{{ route('password.send-code') }}" class="auth-form">
                @csrf
                
                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="bi bi-envelope"></i>
                        Email
                    </label>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus 
                           placeholder="example@mail.ru"
                           autocomplete="off">
                    @error('email')
                        <span class="text-danger">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                
                <button type="submit" class="btn-exact">
                    <i class="bi bi-send"></i>
                    Отправить код подтверждения
                </button>
            </form>
            
            <div class="auth-divider">
                <span>или</span>
            </div>
            
            <div class="auth-footer">
                <p class="text-center">
                    <a href="{{ route('login') }}" class="text-link">
                        <i class="bi bi-arrow-left"></i>
                        Вернуться ко входу
                    </a>
                </p>
                <p class="text-center mt-3">
                    Нет аккаунта? 
                    <a href="{{ route('register') }}" class="text-link">
                        Зарегистрироваться
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.focus();
    }
});
</script>
@endpush
@endsection