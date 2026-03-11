{{-- resources/views/admin/categories/create.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Добавить категорию')
@section('page-title', 'Добавить категорию')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="admin-table">
            <div class="table-header">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div>
                        <h2 class="table-title mb-1">Создание новой категории</h2>
                        <p class="text-white mb-0">Заполните информацию о новой категории блюд</p>
                    </div>
                    <a href="{{ route('admin.categories') }}" class="btn-outline-exact ms-auto">
                        <i class="bi bi-arrow-left me-1"></i> Назад к списку
                    </a>
                </div>
            </div>
            
            <div class="p-4">
                <form action="{{ route('admin.categories.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    
                    <!-- Блок основной информации -->
                    <div class="card-section mb-5">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="bi bi-folder"></i>
                            </div>
                            <h4 class="section-title">Основная информация</h4>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Название категории -->
                                <div class="form-group-animated mb-4">
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           class="form-control-admin animated @error('name') is-invalid @enderror" 
                                           value="{{ old('name') }}" 
                                           placeholder=" "
                                           required>
                                    <label for="name" class="animated-label">
                                        Название категории <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-hint">Например: Супы, Роллы, Десерты</div>
                                    @error('name')
                                    <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Slug (URL) -->
                                <div class="form-group-animated mb-4">
                                    <input type="text" 
                                           name="slug" 
                                           id="slug" 
                                           class="form-control-admin animated @error('slug') is-invalid @enderror" 
                                           value="{{ old('slug') }}" 
                                           placeholder=" "
                                           required>
                                    <label for="slug" class="animated-label">
                                        Slug (URL) <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-hint">Только латинские буквы, цифры и дефисы. Например: soups, rolls, desserts</div>
                                    @error('slug')
                                    <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Описание -->
                                <div class="form-group-animated mb-4">
                                    <textarea name="description" 
                                              id="description" 
                                              class="form-control-admin animated textarea @error('description') is-invalid @enderror" 
                                              rows="4"
                                              placeholder=" ">{{ old('description') }}</textarea>
                                    <label for="description" class="animated-label">
                                        Описание категории
                                    </label>
                                    <div class="form-hint">Краткое описание будет отображаться под названием категории</div>
                                    @error('description')
                                    <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Блок настроек -->
                    <div class="card-section mb-5">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="bi bi-gear"></i>
                            </div>
                            <h4 class="section-title">Настройки категории</h4>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex flex-wrap gap-4">
                                    <!-- Порядок сортировки -->
                                    <div class="setting-card">
                                        <div class="setting-icon">
                                            <i class="bi bi-sort-numeric-up"></i>
                                        </div>
                                        <div class="setting-content">
                                            <label class="setting-title">Порядок сортировки</label>
                                            <span class="setting-desc">Чем меньше число, тем выше в списке</span>
                                            <div class="number-input-wrapper mt-3">
                                                <button type="button" class="number-btn minus" onclick="decrementOrder()">
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                                <input type="number" 
                                                       name="order" 
                                                       id="order" 
                                                       class="form-control-number" 
                                                       value="{{ old('order', 0) }}" 
                                                       min="0"
                                                       step="1">
                                                <button type="button" class="number-btn plus" onclick="incrementOrder()">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Статус активности -->
                                    <div class="setting-card">
                                        <div class="setting-icon" style="color: #4CAF50;">
                                            <i class="bi bi-eye"></i>
                                        </div>
                                        <div class="setting-content">
                                            <div class="form-check form-switch">
                                                <input type="checkbox" 
                                                       name="active" 
                                                       class="form-check-input" 
                                                       id="active" 
                                                       value="1" 
                                                       {{ old('active', true) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="active">
                                                    <span class="setting-title">Активная категория</span>
                                                    <span class="setting-desc">Отображается в меню на сайте</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Кнопки действий -->
                    <div class="action-buttons">
                        <button type="submit" class="btn-exact btn-create">
                            <i class="bi bi-check-circle me-2"></i> Создать категорию
                        </button>
                        <a href="{{ route('admin.categories') }}" class="btn-outline-exact">
                            <i class="bi bi-x-circle me-2"></i> Отмена
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* ===== СТИЛИ ДЛЯ ШАПКИ ===== */
.table-header .d-flex {
    width: 100%;
}

.ms-auto {
    margin-left: auto !important;
}

.text-white {
    color: #8d8d8d !important;
}

/* ===== АНИМИРОВАННЫЕ ПОЛЯ ФОРМЫ (как в create блюда) ===== */
.form-group-animated {
    position: relative;
    margin-bottom: 1.5rem;
}

.form-control-admin.animated {
    background: var(--bg-light);
    border: 2px solid var(--border);
    border-radius: 10px;
    padding: 25px 20px 10px;
    color: var(--text-light);
    font-size: 16px;
    transition: all 0.3s ease;
    height: auto;
    min-height: 60px;
    width: 100%;
}

.form-control-admin.animated:focus {
    background: var(--bg-card);
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(201, 168, 106, 0.15);
}

.form-control-admin.animated:focus + .animated-label,
.form-control-admin.animated:not(:placeholder-shown) + .animated-label {
    transform: translateY(-8px);
    font-size: 12px;
    color: var(--accent);
}

.form-control-admin.animated.textarea {
    padding: 25px 20px 15px;
    min-height: 120px;
    resize: vertical;
}

.animated-label {
    position: absolute;
    top: 20px;
    left: 20px;
    color: var(--text-gray);
    font-size: 16px;
    transition: all 0.3s ease;
    pointer-events: none;
    background: transparent;
    padding: 0 5px;
    z-index: 2;
}

.form-hint {
    font-size: 13px;
    color: var(--text-gray);
    margin-top: 5px;
    opacity: 0.7;
}

.form-error {
    color: #ff6b6b;
    font-size: 13px;
    margin-top: 5px;
}

/* ===== СЕКЦИИ (как в create блюда) ===== */
.card-section {
    background: var(--bg-light);
    border-radius: 12px;
    padding: 30px;
    border: 1px solid var(--border);
    transition: transform 0.3s ease, border-color 0.3s ease;
}

.card-section:hover {
    transform: translateY(-2px);
    border-color: var(--accent-light);
}

.section-header {
    display: flex;
    align-items: center;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid var(--border);
}

.section-icon {
    width: 40px;
    height: 40px;
    background: rgba(201, 168, 106, 0.1);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    color: var(--accent);
    font-size: 18px;
}

.section-title {
    font-size: 20px;
    font-weight: 600;
    color: var(--text-light);
    margin: 0;
}

/* ===== НАСТРОЙКИ (КАРТОЧКИ) ===== */
.setting-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 20px;
    flex: 1;
    min-width: 280px;
    transition: all 0.3s ease;
}

.setting-card:hover {
    border-color: var(--accent-light);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.setting-icon {
    font-size: 24px;
    margin-bottom: 15px;
    color: var(--accent);
}

.setting-content {
    display: flex;
    flex-direction: column;
}

.setting-title {
    font-weight: 600;
    color: var(--text-light);
    font-size: 16px;
    display: block;
}

.setting-desc {
    color: var(--text-gray);
    font-size: 13px;
    margin-top: 2px;
}

/* ===== ЧИСЛОВОЙ ВВОД ===== */
.number-input-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
    max-width: 180px;
}

.form-control-number {
    width: 80px;
    padding: 10px;
    background: var(--bg-dark);
    border: 1px solid var(--border);
    border-radius: 8px;
    color: var(--text-light);
    font-size: 16px;
    font-weight: 600;
    text-align: center;
    transition: all 0.3s ease;
}

.form-control-number:focus {
    outline: none;
    border-color: var(--accent);
    box-shadow: 0 0 0 2px rgba(201, 168, 106, 0.2);
}

.number-btn {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bg-dark);
    border: 1px solid var(--border);
    border-radius: 8px;
    color: var(--text-light);
    transition: all 0.3s ease;
    cursor: pointer;
}

.number-btn:hover {
    background: var(--accent);
    border-color: var(--accent);
    color: var(--bg-dark);
}

/* ===== TOGGLE ПЕРЕКЛЮЧАТЕЛЬ ===== */
.form-check.form-switch {
    padding-left: 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.form-check-input {
    width: 48px;
    height: 24px;
    float: none;
    margin-left: 0;
    background-color: var(--bg-dark);
    border: 1px solid var(--border);
    cursor: pointer;
}

.form-check-input:checked {
    background-color: var(--accent);
    border-color: var(--accent);
}

.form-check-label {
    cursor: pointer;
    display: flex;
    flex-direction: column;
}

/* ===== КНОПКИ ДЕЙСТВИЙ ===== */
.action-buttons {
    display: flex;
    gap: 15px;
    padding-top: 30px;
    border-top: 1px solid var(--border);
    margin-top: 20px;
}

.btn-create {
    background: linear-gradient(135deg, var(--accent) 0%, var(--accent-dark) 100%);
    color: var(--bg-dark);
    font-weight: 600;
    padding: 15px 40px;
    border: none;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-create:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(201, 168, 106, 0.4);
    background: linear-gradient(135deg, var(--accent-light) 0%, var(--accent) 100%);
}

/* ===== АНИМАЦИИ ===== */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.card-section {
    animation: fadeIn 0.3s ease-out;
}

/* ===== АДАПТИВНОСТЬ ===== */
@media (max-width: 768px) {
    .card-section {
        padding: 20px;
    }
    
    .setting-card {
        min-width: 100%;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .btn-create,
    .btn-outline-exact {
        width: 100%;
        text-align: center;
    }
}

/* ===== ДОПОЛНИТЕЛЬНЫЕ СТИЛИ ===== */
.text-danger {
    color: #ff6b6b !important;
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

/* Плейсхолдер */
.form-control-admin.animated::placeholder {
    color: transparent;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Функции для кнопок +/–
    window.incrementOrder = function() {
        const orderInput = document.getElementById('order');
        const currentValue = parseInt(orderInput.value) || 0;
        orderInput.value = currentValue + 1;
    }

    window.decrementOrder = function() {
        const orderInput = document.getElementById('order');
        const currentValue = parseInt(orderInput.value) || 0;
        if (currentValue > 0) {
            orderInput.value = currentValue - 1;
        }
    }
    
    // Автоматическая генерация slug из названия
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    
    if (nameInput && slugInput) {
        nameInput.addEventListener('blur', function() {
            if (!slugInput.value.trim() && this.value.trim()) {
                const generatedSlug = this.value
                    .toLowerCase()
                    .replace(/[^\w\sа-яё]/gi, '')
                    .replace(/[а-яё]/g, function(char) {
                        const translit = {
                            'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'e',
                            'ж': 'zh', 'з': 'z', 'и': 'i', 'й': 'y', 'к': 'k', 'л': 'l', 'м': 'm',
                            'н': 'n', 'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u',
                            'ф': 'f', 'х': 'kh', 'ц': 'ts', 'ч': 'ch', 'ш': 'sh', 'щ': 'shch',
                            'ы': 'y', 'э': 'e', 'ю': 'yu', 'я': 'ya'
                        };
                        return translit[char] || char;
                    })
                    .replace(/\s+/g, '-')
                    .replace(/[^a-z0-9-]/g, '')
                    .replace(/-+/g, '-')
                    .replace(/^-|-$/g, '');
                
                slugInput.value = generatedSlug;
            }
        });
    }
    
    // Валидация формы
    (function() {
        'use strict';
        
        const form = document.querySelector('form.needs-validation');
        if (form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        }
    })();
});
</script>
@endpush
@endsection