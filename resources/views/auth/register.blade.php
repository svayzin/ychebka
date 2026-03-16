@extends('layouts.app')

@section('title', 'Регистрация - Созвездие вкусов')

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <div class="auth-grid">
            <!-- Левая часть с фото -->
            <div class="auth-image-side">
                <div class="auth-image-content">
                    <img src="{{ asset('images/auth/register-photo.jpg') }}" alt="Интерьер ресторана Созвездие вкусов" class="auth-image">
                    <div class="auth-image-overlay">
                    </div>
                </div>
            </div>
            
            <!-- Правая часть с формой -->
            <div class="auth-form-side">
                <div class="auth-form-wrapper">
                    <div class="auth-header">
                        <h2 class="auth-title">Регистрация</h2>
                        <p class="auth-subtitle">Создайте аккаунт для оформления заказов</p>
                    </div>
                    
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    
                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label for="full_name" class="form-label">ФИО</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" 
                                   value="{{ old('full_name') }}" required 
                                   placeholder="Введите ваше полное имя">
                            @error('full_name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="phone" class="form-label">Телефон</label>
                            <input type="tel" class="form-control" id="phone" name="phone" 
                                   value="{{ old('phone') }}" required 
                                   placeholder="+7 (999) 123-45-67">
                            @error('phone')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="{{ old('email') }}" required 
                                   placeholder="example@mail.ru">
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="password" class="form-label">Пароль</label>
                            <input type="password" class="form-control" id="password" name="password" required 
                                   placeholder="Минимум 8 символов">
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Повторите пароль</label>
                            <input type="password" class="form-control" id="password_confirmation" 
                                   name="password_confirmation" required 
                                   placeholder="Повторите пароль">
                            @error('password_confirmation')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <input type="hidden" name="privacy_policy" value="0">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="privacy_policy" 
                                       id="privacy_policy" value="1" {{ old('privacy_policy') ? 'checked' : '' }}>
                                <label class="form-check-label" for="privacy_policy">
                                    Я согласен с правилами обработки персональных данных
                                </label>
                            </div>
                            @error('privacy_policy')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn-exact w-100">
                            <i class="bi bi-person-plus"></i> Зарегистрироваться
                        </button>
                        
                        <div class="auth-footer text-center mt-4">
                            <p>Уже есть аккаунт? <a href="{{ route('login') }}" class="text-link">Войти</a></p>
                        </div>
                    </form>
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
    height: 820px;
}

/* Левая часть с фото */
.auth-image-side {
    position: relative;
    height: 820px;
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

.auth-image-title {
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 10px;
    font-family: "Yeseva One", serif;
    color: #AD1C43;
}

.auth-image-text {
    font-size: 16px;
    line-height: 1.6;
    opacity: 0.9;
    max-width: 450px;
}

/* Правая часть с формой */
.auth-form-side {
    height: 820px;
    padding: 0 50px;
    background: var(--bg-card);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow-y: auto;
}

.auth-form-wrapper {
    width: 100%;
    max-width: 480px;
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
    padding: 14px 18.5px;
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
    color: var(--text-light);
    border-color: #AD1C43;
    box-shadow: 0 0 0 4px rgba(201, 168, 106, 0.15);
    background: var(--bg-card);
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

/* ЖЕЛТАЯ ГАЛОЧКА - стили для чекбокса */
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
        height: 760px;
    }
    
    .auth-image-side,
    .auth-form-side {
        height: 760px;
    }
}

@media (max-width: 1200px) {
    .auth-container {
        max-width: 1300px;
    }
    
    .auth-grid {
        height: 720px;
    }
    
    .auth-image-side,
    .auth-form-side {
        height: 720px;
    }
    
    .auth-form-wrapper {
        max-width: 460px;
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
    
    .auth-image-side {
        height: 280px;
    }
    
    .form-control {
        padding: 12px 16px;
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
    
    .form-control {
        padding: 11px 14px;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Маска для телефона
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length > 0) {
                if (!value.startsWith('7') && !value.startsWith('8')) {
                    value = '7' + value;
                }
                
                let formatted = '+7';
                
                if (value.length > 1) {
                    formatted += ' (' + value.substring(1, 4);
                }
                if (value.length > 4) {
                    formatted += ') ' + value.substring(4, 7);
                }
                if (value.length > 7) {
                    formatted += '-' + value.substring(7, 9);
                }
                if (value.length > 9) {
                    formatted += '-' + value.substring(9, 11);
                }
                
                e.target.value = formatted;
            }
        });
    }
});
</script>
@endpush
@endsection