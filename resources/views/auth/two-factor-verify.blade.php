@extends('layouts.app')

@section('title', 'Подтверждение входа - Созвездие вкусов')

@section('content')
<div class="auth-page-simple">
    <div class="auth-container-simple">
        <div class="auth-card">
            <div class="auth-header">
                <h2 class="auth-title">Двухфакторная аутентификация</h2>
                <p class="auth-subtitle">
                    Мы отправили код подтверждения на номер<br>
                    <strong class="text-gold">{{ $maskedPhone }}</strong>
                </p>
            </div>
            
            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle me-2"></i>
                Введите 6-значный код из SMS
            </div>
            
            <div id="error-message" class="alert alert-danger" style="display: none;"></div>
            
            <form id="verify-form" method="POST" action="{{ route('two-factor.verify.submit') }}">
                @csrf
                
                <div class="form-group mb-4">
                    <label for="code" class="form-label">Код подтверждения</label>
                    <div class="code-input-wrapper">
                        <input type="text" 
                               class="form-control form-control-lg text-center code-input" 
                               id="code" 
                               name="code" 
                               maxlength="6" 
                               placeholder="000000"
                               autocomplete="off"
                               inputmode="numeric"
                               pattern="[0-9]*">
                    </div>
                    <div class="form-hint text-center mt-2">
                        Код действителен 10 минут
                    </div>
                </div>
                
                <button type="submit" class="btn-exact w-100" id="submit-btn">
                    <i class="bi bi-check-circle me-2"></i> Подтвердить вход
                </button>
            </form>
            
            <div class="auth-divider">
                <span>или</span>
            </div>
            
            <div class="text-center">
                <button type="button" class="btn-link" id="resend-code" disabled>
                    <span id="resend-text">Отправить код повторно</span>
                    <span id="countdown-text" class="text-muted ms-1"></span>
                </button>
            </div>
            
            <div class="auth-footer text-center mt-4">
                <p>
                    <a href="{{ route('login') }}" class="text-link">
                        <i class="bi bi-arrow-left"></i> Вернуться ко входу
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

.text-gold {
    color: #AD1C43;
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

.alert-info {
    background-color: rgba(23, 162, 184, 0.1);
    border-color: rgba(23, 162, 184, 0.2);
    color: #17a2b8;
    text-align: center;
}

.alert-danger {
    background-color: rgba(220, 53, 69, 0.1);
    border-color: rgba(220, 53, 69, 0.2);
    color: #dc3545;
    text-align: center;
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

.btn-exact:hover:not(:disabled) {
    background: var(--accent-light);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(201, 168, 106, 0.3);
}

.btn-exact:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.btn-link {
    background: none;
    border: none;
    color: #AD1C43;
    font-size: 15px;
    cursor: pointer;
    transition: color 0.3s ease;
}

.btn-link:hover:not(:disabled) {
    color: var(--accent-light);
    text-decoration: underline;
}

.btn-link:disabled {
    color: var(--text-gray);
    cursor: not-allowed;
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
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const codeInput = document.getElementById('code');
    const submitBtn = document.getElementById('submit-btn');
    const resendBtn = document.getElementById('resend-code');
    const resendText = document.getElementById('resend-text');
    const countdownText = document.getElementById('countdown-text');
    const errorMessage = document.getElementById('error-message');
    
    // Таймер для повторной отправки (60 секунд)
    let countdown = 60;
    let timer = null;
    
    function startCountdown() {
        resendBtn.disabled = true;
        countdown = 60;
        
        timer = setInterval(() => {
            countdown--;
            countdownText.textContent = `(${countdown} сек)`;
            
            if (countdown <= 0) {
                clearInterval(timer);
                resendBtn.disabled = false;
                countdownText.textContent = '';
                resendText.textContent = 'Отправить код повторно';
            }
        }, 1000);
    }
    
    startCountdown();
    
    // Автоматический переход к следующему полю (для 6 отдельных полей, но у нас одно поле)
    codeInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').substring(0, 6);
    });
    
    // Отправка формы
    document.getElementById('verify-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const code = codeInput.value;
        
        if (code.length !== 6) {
            showError('Введите 6-значный код');
            return;
        }
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> Проверка...';
        
        fetch(this.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ code: code })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                showError(data.message || 'Неверный код подтверждения');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i> Подтвердить вход';
                codeInput.value = '';
                codeInput.focus();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('Произошла ошибка. Попробуйте позже.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i> Подтвердить вход';
        });
    });
    
    // Повторная отправка кода
    resendBtn.addEventListener('click', function() {
        if (resendBtn.disabled) return;
        
        resendBtn.disabled = true;
        resendText.textContent = 'Отправка...';
        
        fetch('{{ route("two-factor.resend") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                startCountdown();
                hideError();
                showNotification('Новый код отправлен', 'success');
            } else {
                resendBtn.disabled = false;
                resendText.textContent = 'Отправить код повторно';
                showError(data.message || 'Ошибка при отправке кода');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            resendBtn.disabled = false;
            resendText.textContent = 'Отправить код повторно';
            showError('Ошибка при отправке кода');
        });
    });
    
    function showError(message) {
        errorMessage.textContent = message;
        errorMessage.style.display = 'block';
        
        setTimeout(() => {
            errorMessage.style.display = 'none';
        }, 5000);
    }
    
    function hideError() {
        errorMessage.style.display = 'none';
    }
    
    function showNotification(message, type) {
        if (typeof showElegantNotification === 'function') {
            showElegantNotification(message, type);
        }
    }
});
</script>
@endpush
@endsection