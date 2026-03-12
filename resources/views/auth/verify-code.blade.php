@extends('layouts.app')

@section('title', 'Подтверждение кода - Созвездие вкусов')

@section('content')
<div class="auth-page-simple">
    <div class="auth-container-simple">
        <div class="auth-card">
            <div class="auth-header">
                <h2 class="auth-title">Подтверждение кода</h2>
                <p class="auth-subtitle">
                    Мы отправили код подтверждения на email<br>
                    <strong>{{ session('reset_email') }}</strong>
                </p>
            </div>
            
            @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
            @endif
            
            @if($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <form method="POST" action="{{ route('password.verify.submit') }}">
                @csrf
                
                <div class="form-group mb-4">
                    <label for="code" class="form-label">Код подтверждения</label>
                    <div class="code-input-wrapper">
                        <input type="text" 
                               class="form-control form-control-lg text-center code-input @error('code') is-invalid @enderror" 
                               id="code" 
                               name="code" 
                               maxlength="6" 
                               placeholder="000000"
                               autocomplete="off"
                               inputmode="numeric"
                               pattern="[0-9]*"
                               required>
                    </div>
                    @error('code')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                    <div class="form-hint text-center mt-2">
                        Код действителен 15 минут
                    </div>
                </div>
                
                <button type="submit" class="btn-exact w-100">
                    <i class="bi bi-check-circle me-2"></i> Подтвердить код
                </button>
            </form>
            
            <div class="auth-divider">
                <span>или</span>
            </div>
            
            <div class="text-center">
                <form method="POST" action="{{ route('password.send-code') }}" class="d-inline">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('reset_email') }}">
                    <button type="submit" class="btn-link" id="resend-code">
                        Отправить код повторно
                    </button>
                </form>
            </div>
            
            <div class="auth-footer text-center mt-4">
                <p>
                    <a href="{{ route('password.forgot') }}" class="text-link">
                        <i class="bi bi-arrow-left"></i> Вернуться к вводу email
                    </a>
                </p>
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

.auth-subtitle strong {
    color: #AD1C43;
    display: block;
    margin-top: 5px;
    word-break: break-all;
}

.form-group {
    margin-bottom: 25px;
}

.form-label {
    display: block;
    margin-bottom: 10px;
    font-weight: 500;
    color: var(--text-light);
    font-size: 15px;
    text-align: center;
}

.code-input-wrapper {
    max-width: 200px;
    margin: 0 auto;
}

.code-input {
    width: 100%;
    padding: 15px;
    background: var(--bg-light);
    border: 2px solid var(--border);
    border-radius: 12px;
    color: var(--text-light);
    font-size: 32px;
    font-weight: 600;
    text-align: center;
    letter-spacing: 8px;
    transition: all 0.3s ease;
}

.code-input:focus {
    outline: none;
    border-color: #AD1C43;
    box-shadow: 0 0 0 4px rgba(201, 168, 106, 0.15);
    background: var(--bg-card);
}

.code-input.is-invalid {
    border-color: #dc3545;
}

.form-hint {
    color: var(--text-gray);
    font-size: 14px;
}

.alert {
    padding: 14px 18px;
    border-radius: 14px;
    margin-bottom: 25px;
    border: 1px solid transparent;
    font-size: 15px;
}

.alert-success {
    background-color: rgba(40, 167, 69, 0.1);
    border-color: rgba(40, 167, 69, 0.2);
    color: #28a745;
}

.alert-danger {
    background-color: rgba(220, 53, 69, 0.1);
    border-color: rgba(220, 53, 69, 0.2);
    color: #dc3545;
}

.alert ul {
    padding-left: 20px;
    margin-bottom: 0;
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
}

.btn-exact:hover {
    background: var(--accent-light);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(201, 168, 106, 0.3);
}

.btn-link {
    background: none;
    border: none;
    color: #AD1C43;
    font-size: 15px;
    cursor: pointer;
    transition: color 0.3s ease;
    text-decoration: none;
}

.btn-link:hover {
    color: var(--accent-light);
    text-decoration: underline;
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

.text-link {
    color: #AD1C43;
    text-decoration: none;
    transition: color 0.3s ease;
}

.text-link:hover {
    color: var(--accent-light);
    text-decoration: underline;
}

.text-danger {
    color: #dc3545;
    font-size: 13px;
    margin-top: 5px;
}

/* Адаптивность */
@media (max-width: 576px) {
    .auth-card {
        padding: 30px 20px;
    }
    
    .auth-title {
        font-size: 28px;
    }
    
    .code-input {
        font-size: 24px;
        letter-spacing: 4px;
        padding: 12px;
    }
}

/* Убираем стрелки у number input */
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type=number] {
    -moz-appearance: textfield;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const codeInput = document.getElementById('code');
    
    if (codeInput) {
        // Автоматический переход и форматирование
        codeInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '').substring(0, 6);
        });
    }
});
</script>
@endpush
@endsection