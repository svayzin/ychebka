@extends('layouts.app')

@section('title', 'Новый пароль - Созвездие вкусов')

@section('content')
@include('auth.auth-styles')

<div class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-icon">
                    <i class="bi bi-shield-lock"></i>
                </div>
                <h2 class="auth-title">Новый пароль</h2>
                <p class="auth-subtitle">
                    Придумайте надежный пароль для вашего аккаунта
                </p>
            </div>
            
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
            
            <form method="POST" action="{{ route('password.reset.submit') }}" class="auth-form">
                @csrf
                
                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock"></i>
                        Новый пароль
                    </label>
                    <div class="password-wrapper">
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required 
                               placeholder="Минимум 8 символов"
                               autocomplete="new-password">
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="text-danger">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </span>
                    @enderror
                    
                    <div class="password-requirements mt-3">
                        <p class="requirements-title">Требования к паролю:</p>
                        <ul class="requirements-list">
                            <li class="requirement" id="length">
                                <i class="bi bi-circle"></i> Минимум 8 символов
                            </li>
                            <li class="requirement" id="uppercase">
                                <i class="bi bi-circle"></i> Хотя бы одна заглавная буква
                            </li>
                            <li class="requirement" id="lowercase">
                                <i class="bi bi-circle"></i> Хотя бы одна строчная буква
                            </li>
                            <li class="requirement" id="number">
                                <i class="bi bi-circle"></i> Хотя бы одна цифра
                            </li>
                            <li class="requirement" id="special">
                                <i class="bi bi-circle"></i> Хотя бы один спецсимвол (@$!%*?&)
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">
                        <i class="bi bi-lock"></i>
                        Подтвердите пароль
                    </label>
                    <div class="password-wrapper">
                        <input type="password" 
                               class="form-control" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               required 
                               placeholder="Повторите пароль"
                               autocomplete="new-password">
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="password-match-indicator" id="password-match" style="display: none;">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Пароли совпадают</span>
                </div>
                
                <button type="submit" class="btn-exact" id="submit-btn" disabled>
                    <i class="bi bi-check-circle"></i>
                    Сохранить пароль
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
            </div>
        </div>
    </div>
</div>

<style>
/* Дополнительные стили для страницы нового пароля */
.password-wrapper {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--text-muted);
    cursor: pointer;
    padding: 5px;
    transition: color 0.3s ease;
}

.password-toggle:hover {
    color: #AD1C43;
}

.password-requirements {
    background: var(--bg-light);
    border-radius: 12px;
    padding: 15px;
    border: 1px solid var(--border);
}

.requirements-title {
    color: var(--text-light);
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 10px;
}

.requirements-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.requirement {
    color: var(--text-muted);
    font-size: 13px;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.requirement i {
    font-size: 14px;
    color: var(--text-muted);
    transition: all 0.3s ease;
}

.requirement.met {
    color: var(--success);
}

.requirement.met i {
    color: var(--success);
}

.requirement.met i::before {
    content: "\F26E"; /* bi-check-circle-fill */
}

.password-match-indicator {
    background: var(--success-bg);
    color: var(--success);
    padding: 10px 15px;
    border-radius: 10px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

@push('scripts')
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
    field.setAttribute('type', type);
    
    const button = field.nextElementSibling;
    const icon = button.querySelector('i');
    icon.classList.toggle('bi-eye');
    icon.classList.toggle('bi-eye-slash');
}

document.addEventListener('DOMContentLoaded', function() {
    const password = document.getElementById('password');
    const confirm = document.getElementById('password_confirmation');
    const submitBtn = document.getElementById('submit-btn');
    const matchIndicator = document.getElementById('password-match');
    
    const requirements = {
        length: document.getElementById('length'),
        uppercase: document.getElementById('uppercase'),
        lowercase: document.getElementById('lowercase'),
        number: document.getElementById('number'),
        special: document.getElementById('special')
    };
    
    function checkPasswordStrength() {
        const value = password.value;
        
        // Проверка длины
        if (value.length >= 8) {
            requirements.length.classList.add('met');
        } else {
            requirements.length.classList.remove('met');
        }
        
        // Проверка заглавных букв
        if (/[A-Z]/.test(value)) {
            requirements.uppercase.classList.add('met');
        } else {
            requirements.uppercase.classList.remove('met');
        }
        
        // Проверка строчных букв
        if (/[a-z]/.test(value)) {
            requirements.lowercase.classList.add('met');
        } else {
            requirements.lowercase.classList.remove('met');
        }
        
        // Проверка цифр
        if (/\d/.test(value)) {
            requirements.number.classList.add('met');
        } else {
            requirements.number.classList.remove('met');
        }
        
        // Проверка спецсимволов
        if (/[@$!%*?&]/.test(value)) {
            requirements.special.classList.add('met');
        } else {
            requirements.special.classList.remove('met');
        }
        
        checkMatch();
    }
    
    function checkMatch() {
        const allMet = Array.from(document.querySelectorAll('.requirement'))
            .every(req => req.classList.contains('met'));
        
        const passwordsMatch = password.value && confirm.value && password.value === confirm.value;
        
        if (passwordsMatch) {
            matchIndicator.style.display = 'flex';
        } else {
            matchIndicator.style.display = 'none';
        }
        
        submitBtn.disabled = !(allMet && passwordsMatch);
    }
    
    password.addEventListener('input', checkPasswordStrength);
    confirm.addEventListener('input', checkMatch);
    
    // Автофокус
    password.focus();
});
</script>
@endpush
@endsection