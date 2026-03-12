@extends('layouts.app')

@section('title', 'Новый пароль - Созвездие вкусов')

@section('content')
<div class="auth-page-simple">
    <div class="auth-container-simple">
        <div class="auth-card">
            <div class="auth-header">
                <h2 class="auth-title">Новый пароль</h2>
                <p class="auth-subtitle">Придумайте надежный пароль для вашего аккаунта</p>
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
            
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" 
                           required placeholder="example@mail.ru">
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Новый пароль</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password" required 
                           placeholder="Минимум 8 символов">
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Подтвердите пароль</label>
                    <input type="password" class="form-control" 
                           id="password_confirmation" name="password_confirmation" required 
                           placeholder="Повторите пароль">
                </div>
                
                <button type="submit" class="btn-exact w-100">
                    <i class="bi bi-check-circle"></i> Сохранить пароль
                </button>
            </form>
            
            <div class="auth-divider">
                <span>или</span>
            </div>
            
            <div class="auth-footer text-center">
                <p>Вспомнили пароль? <a href="{{ route('login') }}" class="text-link">Войти</a></p>
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
    margin: 0;
    padding: 0;
    background: var(--bg-dark);
}

.auth-page-simple {
    background: var(--bg-dark);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.auth-container-simple {
    max-width: 500px;
    width: 100%;
    margin: 0 auto;
}

.auth-card {
    background: var(--bg-card);
    border-radius: 24px;
    padding: 40px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    border: 1px solid var(--border);
}

.auth-header {
    text-align: center;
    margin-bottom: 30px;
}

.auth-title {
    font-size: 32px;
    font-weight: 700;
    color: var(--text-light);
    margin-bottom: 10px;
    font-family: "Yeseva One", serif;
}

.auth-subtitle {
    color: var(--text-gray);
    font-size: 16px;
    margin: 0;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: var(--text-light);
    font-size: 15px;
}

.form-control {
    width: 100%;
    padding: 14px 18px;
    background: var(--bg-light);
    border: 1px solid var(--border);
    border-radius: 14px;
    color: var(--text-light);
    font-size: 15px;
    transition: all 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: #AD1C43;
    box-shadow: 0 0 0 4px rgba(201, 168, 106, 0.15);
    background: var(--bg-card);
}

.form-control::placeholder {
    color: var(--text-gray);
    opacity: 0.7;
}

.form-control.is-invalid {
    border-color: #dc3545;
}

.alert {
    padding: 14px 18px;
    border-radius: 14px;
    margin-bottom: 25px;
    border: 1px solid transparent;
    font-size: 15px;
}

.alert-danger {
    background-color: rgba(220, 53, 69, 0.1);
    border-color: rgba(220, 53, 69, 0.2);
    color: #dc3545;
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
    padding: 14px;
    background: #AD1C43;
    color: var(--bg-dark);
    border: none;
    border-radius: 14px;
    font-size: 17px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
    margin-top: 10px;
}

.btn-exact:hover {
    background: var(--accent-light);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(201, 168, 106, 0.3);
}

.btn-exact i {
    margin-right: 8px;
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

.auth-footer p {
    color: var(--text-gray);
    font-size: 15px;
    margin: 5px 0;
}

/* Адаптивность */
@media (max-width: 576px) {
    .auth-card {
        padding: 30px 20px;
    }
    
    .auth-title {
        font-size: 28px;
    }
}
</style>
@endsection