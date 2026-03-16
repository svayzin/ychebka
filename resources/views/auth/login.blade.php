@extends('layouts.app')

@section('title', 'Вход - Crimson Flame')

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <div class="auth-grid">
            <div class="auth-image-side">
                <div class="auth-image-content">
                    <img src="{{ asset('images/auth/login-photo.jpg') }}" alt="Ресторан Crimson Flame" class="auth-image">
                    <div class="auth-image-overlay">
                    </div>
                </div>
            </div>
            
            <div class="auth-form-side">
                <div class="auth-form-wrapper">
                    <div class="auth-header">
                        <h2 class="auth-title">Вход в аккаунт</h2>
                        <p class="auth-subtitle">Войдите для оформления заказов</p>
                    </div>
                    
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    
                    <form method="POST" action="{{ route('login') }}" id="login-form" autocomplete="on">
                        @csrf
                        
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="{{ old('email') }}" required autofocus 
                                   placeholder="example@mail.ru" autocomplete="email">
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="password" class="form-label">Пароль</label>
                            <input type="password" class="form-control" id="password" name="password" required 
                                   placeholder="Введите пароль" autocomplete="current-password">
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">
                                    Запомнить меня
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn-exact w-100">
                            <i class="bi bi-box-arrow-in-right"></i> Войти
                        </button>
                    </form>
                    
                    <div class="auth-divider">
                        <span>или</span>
                    </div>
                    
                    <div class="auth-footer text-center mt-4">
                        <p>Нет аккаунта? <a href="{{ route('register') }}" class="text-link">Зарегистрироваться</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Скрываем шапку и подвал */
header.header-elegant,
footer {
    display: none !important;
}

body {
    overflow: hidden;
    margin: 0;
    padding: 0;
}

.auth-page {
    background: var(--bg-dark);
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    margin: 0;
}

.auth-container {
    max-width: 1500px;
    width: 100%;
    margin: 0 auto;
    padding: 20px;
}

.auth-grid {
    display: grid;
    grid-template-columns: 1.1fr 0.9fr;
    background: var(--bg-card);
    border-radius: 32px;
    overflow: hidden;
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.5);
    border: 1px solid var(--border);
    height: 780px;
}

/* Левая часть с фото */
.auth-image-side {
    position: relative;
    height: 780px;
    overflow: hidden;
}

.auth-image-content {
    position: relative;
    width: 100%;
    height: 100%;
}

.auth-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.auth-image-side:hover .auth-image {
    transform: scale(1.05);
}

.auth-image-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 40px;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.9), transparent);
    color: white;
}

/* Правая часть с формой */
.auth-form-side {
    height: 780px;
    padding: 0 60px;
    background: var(--bg-card);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow-y: auto;
}

.auth-form-wrapper {
    width: 100%;
    max-width: 500px;
    margin: 0 auto;
}

.auth-header {
    text-align: center;
    margin-bottom: 25px;
}

.auth-title {
    font-size: 36px;
    font-weight: 700;
    color: var(--text-light);
    margin-bottom: 8px;
    font-family: "Yeseva One", serif;
}

.auth-subtitle {
    color: var(--text-gray);
    font-size: 17px;
    margin: 0;
}

.form-group {
    margin-bottom: 20px;
    width: 100%;
}

.form-label {
    display: block;
    margin-bottom: 6px;
    font-weight: 500;
    color: var(--text-light);
    font-size: 15px;
}

.form-control {
    width: 100%;
    padding: 14px 18px;
    background: var(--bg-light);
    border: 1px solid var(--border);
    border-radius: 16px;
    color: var(--text-light);
    font-size: 15px;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.form-control:focus {
    outline: none;
    border-color: #AD1C43;
    box-shadow: 0 0 0 4px rgba(201, 168, 106, 0.15);
}

.form-control::placeholder {
    color: var(--text-gray);
    opacity: 0.7;
}

.alert {
    padding: 14px 18px;
    border-radius: 16px;
    margin-bottom: 22px;
    border: 1px solid transparent;
    font-size: 15px;
}

.alert ul {
    padding-left: 20px;
    margin-bottom: 0;
}

.form-check {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 15px;
}

.form-check-input {
    width: 20px;
    height: 20px;
    margin-top: 0;
    accent-color: #AD1C43;
    flex-shrink: 0;
    cursor: pointer;
    background-color: var(--bg-light);
    border: 2px solid var(--border);
    border-radius: 4px;
    transition: all 0.2s ease;
}

.form-check-input:checked {
    background-color: #AD1C43;
    border-color: #AD1C43;
}

.form-check-input:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(201, 168, 106, 0.3);
}

.form-check-label {
    color: var(--text-gray);
    font-size: 15px;
    line-height: 1.4;
    cursor: pointer;
}

.text-link {
    color: #AD1C43;
    text-decoration: none;
    transition: color 0.3s ease;
    font-size: 15px;
}

.text-link:hover {
    color: var(--accent-light);
    text-decoration: underline;
}

.btn-exact {
    display: block;
    width: 100%;
    padding: 16px;
    background: #AD1C43;
    color: var(--bg-dark);
    border: none;
    border-radius: 16px;
    font-size: 18px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
    margin-top: 12px;
}

.btn-exact:hover {
    background: var(--accent-light);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(201, 168, 106, 0.3);
}

.btn-exact i {
    margin-right: 10px;
}

.auth-divider {
    position: relative;
    text-align: center;
    margin: 25px 0;
    color: var(--text-gray);
}

.auth-divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: var(--border);
}

.auth-divider span {
    position: relative;
    background: var(--bg-card);
    padding: 0 18px;
    font-size: 14px;
}

.social-auth {
    margin-bottom: 20px;
}

.social-auth p {
    color: var(--text-gray);
    font-size: 14px;
    margin-bottom: 15px;
}

.social-buttons {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
}

.btn-social {
    padding: 12px;
    border: 1px solid var(--border);
    background: var(--bg-light);
    color: var(--text-light);
    border-radius: 16px;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-social:hover {
    background: var(--bg-card);
    border-color: #AD1C43;
    transform: translateY(-2px);
}

.btn-social.google:hover {
    color: #DB4437;
    border-color: #DB4437;
}

.btn-social.vk:hover {
    color: #4C75A3;
    border-color: #4C75A3;
}

.btn-social.yandex:hover {
    color: #FFCC00;
    border-color: #FFCC00;
}

.auth-footer p {
    color: var(--text-gray);
    font-size: 15px;
    margin-top: 8px;
}

.text-danger {
    color: #dc3545;
    font-size: 13px;
}

/* Адаптивность */
@media (max-width: 1400px) {
    .auth-grid {
        height: 720px;
    }
    
    .auth-image-side,
    .auth-form-side {
        height: 720px;
    }
}

@media (max-width: 1200px) {
    .auth-container {
        max-width: 1300px;
    }
    
    .auth-grid {
        height: 680px;
    }
    
    .auth-image-side,
    .auth-form-side {
        height: 680px;
    }
}

@media (max-width: 992px) {
    .auth-grid {
        grid-template-columns: 1fr;
        height: auto;
        max-height: 95vh;
    }
    
    .auth-image-side {
        height: 350px;
    }
    
    .auth-form-side {
        height: auto;
        padding: 50px 40px;
        min-height: 600px;
    }
    
    .auth-form-wrapper {
        max-width: 500px;
    }
}

@media (max-width: 768px) {
    .auth-container {
        padding: 10px;
    }
    
    .auth-form-side {
        padding: 40px 25px;
        min-height: 550px;
    }
    
    .auth-title {
        font-size: 34px;
    }
    
    .social-buttons {
        grid-template-columns: 1fr;
    }
    
    .auth-image-side {
        height: 280px;
    }
}

@media (max-width: 480px) {
    .auth-form-side {
        padding: 30px 20px;
        min-height: 500px;
    }
    
    .auth-image-side {
        height: 220px;
    }
}
</style>
@endsection