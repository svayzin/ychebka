@extends('layouts.app')

@section('title', $category->name . ' - Созвездие вкусов')

@section('content')
<div class="category-page">
    <!-- Заголовок категории -->
    <section class="hero-exact category-hero">
        <div class="container-exact">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('menu') }}">Меню</a></li>
                            <li class="breadcrumb-item active">{{ $category->name }}</li>
                        </ol>
                    </nav>
                    <h1 class="hero-title-exact">{{ $category->name }}</h1>
                    @if($category->description)
                    <p class="hero-text-exact">{{ $category->description }}</p>
                    @endif
                </div>
                <div class="col-lg-4 text-end">
                    @auth
                    <div class="cart-indicator">
                        <a href="{{ route('cart.index') }}" class="btn-exact-outline">
                            <i class="bi bi-cart"></i> Корзина (<span class="cart-count">0</span>)
                        </a>
                    </div>
                    @endauth
                    <a href="{{ route('menu') }}" class="btn-exact-outline mt-3 mt-lg-0">
                        <i class="bi bi-arrow-left"></i> Вернуться к меню
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="container-exact">
        <div class="row">
            <!-- Боковая навигация -->
            <div class="col-lg-3">
                <div class="sidebar-categories sticky-top" style="top: 100px;">
                    <h3 class="sidebar-title">Все категории</h3>
                    <div class="categories-list">
                        @foreach($categories as $cat)
                        <a href="{{ route('menu.category', $cat->slug) }}" 
                           class="category-sidebar-link @if($cat->id === $category->id) active @endif">
                            <span class="category-name">{{ $cat->name }}</span>
                            <span class="category-count">{{ $cat->products->count() }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Блюда категории -->
            <div class="col-lg-9">
                <!-- Фильтры сортировки -->
                <div class="sorting-filters mb-4">
                    <div class="d-flex justify-content-end align-items-center">
                        <div class="dropdown">
                            <button class="btn btn-outline-exact dropdown-toggle" type="button" 
                                    id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-sort-down"></i> 
                                @php
                                    $sortLabels = [
                                        'default' => 'Сортировать',
                                        'price_asc' => 'По цене (возр.)',
                                        'price_desc' => 'По цене (убыв.)'
                                    ];
                                    $currentSort = request('sort', 'default');
                                @endphp
                                {{ $sortLabels[$currentSort] ?? 'Сортировать' }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="sortDropdown">
                                <li>
                                    <a class="dropdown-item {{ $currentSort == 'default' ? 'active' : '' }}" 
                                       href="{{ route('menu.category', $category->slug) }}?sort=default">
                                        <i class="bi bi-list-ol"></i> По умолчанию
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ $currentSort == 'price_asc' ? 'active' : '' }}" 
                                       href="{{ route('menu.category', $category->slug) }}?sort=price_asc">
                                        <i class="bi bi-sort-numeric-up"></i> По цене (возрастание)
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ $currentSort == 'price_desc' ? 'active' : '' }}" 
                                       href="{{ route('menu.category', $category->slug) }}?sort=price_desc">
                                        <i class="bi bi-sort-numeric-down"></i> По цене (убывание)
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Индикатор активной сортировки -->
                        @if(request('sort') && request('sort') != 'default')
                            <div class="ms-3">
                                @php
                                    $sortLabelsFull = [
                                        'default' => 'По умолчанию',
                                        'price_asc' => 'По возрастанию цены',
                                        'price_desc' => 'По убыванию цены'
                                    ];
                                @endphp
                                <span class="badge-admin" style="background: #AD1C43; color: var(--bg-dark);">
                                    <i class="bi bi-funnel-fill"></i>
                                    {{ $sortLabelsFull[$currentSort] ?? 'По умолчанию' }}
                                    <a href="{{ route('menu.category', $category->slug) }}" class="text-dark ms-1" title="Сбросить">
                                        <i class="bi bi-x"></i>
                                    </a>
                                </span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Информация о количестве блюд -->
                    <div class="mt-2 text-end">
                        <span class="text-muted">
                            Найдено блюд: <strong style="color: #AD1C43;">{{ $category->products->count() }}</strong>
                        </span>
                    </div>
                </div>

                @if($category->products->count() > 0)
                <div class="row g-4">
                    @foreach($category->products as $product)
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        @include('partials.product-card', ['product' => $product])
                    </div>
                    @endforeach
                </div>
                @else
                <div class="empty-category text-center py-5">
                    <div class="empty-icon mb-3">
                        <i class="bi bi-emoji-frown" style="font-size: 64px; color: var(--text-gray);"></i>
                    </div>
                    <h3 style="color: var(--text-light);">В этой категории пока нет блюд</h3>
                    <p class="text-muted mb-4">Возвращайтесь позже, мы обязательно добавим новые блюда</p>
                    <a href="{{ route('menu') }}" class="btn-exact">
                        <i class="bi bi-grid"></i> Перейти в меню
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* ===== ОСНОВНЫЕ СТИЛИ СТРАНИЦЫ ===== */
.category-page {
    background: var(--bg-dark);
    min-height: 100vh;
}

.category-hero {
    background: linear-gradient(135deg, var(--bg-dark) 0%, #2a2a2a 100%);
    padding: 60px 0 30px;
    margin-bottom: 40px;
}

.breadcrumb {
    background: transparent;
    padding: 0;
    margin-bottom: 20px;
}

.breadcrumb-item a {
    color: #AD1C43;
    text-decoration: none;
    transition: color 0.3s ease;
}

.breadcrumb-item a:hover {
    color: var(--accent-light);
    text-decoration: underline;
}

.breadcrumb-item.active {
    color: var(--text-light);
}

.breadcrumb-item + .breadcrumb-item::before {
    color: var(--text-gray);
}

.hero-title-exact {
    font-family: "Yeseva One", serif;
    font-size: 48px;
    font-weight: 700;
    color: var(--text-light);
    margin-bottom: 15px;
}

.hero-text-exact {
    font-size: 18px;
    color: var(--text-gray);
    line-height: 1.6;
    max-width: 600px;
}

.cart-indicator {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 10px;
}

.btn-exact-outline {
    background: transparent;
    color: var(--text-light);
    border: 1px solid var(--border);
    padding: 10px 20px;
    font-weight: 500;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-exact-outline:hover {
    border-color: #AD1C43;
    color: #AD1C43;
    background: rgba(201, 168, 106, 0.05);
}

/* ===== СТИЛИ БОКОВОЙ НАВИГАЦИИ ===== */
.sidebar-categories {
    background: var(--bg-card);
    border-radius: 16px;
    padding: 25px;
    border: 1px solid var(--border);
    margin-bottom: 30px;
    transition: all 0.3s ease;
}

.sidebar-categories:hover {
    border-color: rgba(201, 168, 106, 0.3);
}

.sidebar-title {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 20px;
    color: var(--text-light);
    padding-bottom: 15px;
    border-bottom: 2px solid #AD1C43;
    font-family: "Yeseva One", serif;
}

.categories-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.category-sidebar-link {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    color: var(--text-light);
    text-decoration: none;
    border-radius: 10px;
    transition: all 0.3s ease;
    border: 1px solid transparent;
    cursor: pointer;
}

.category-sidebar-link:hover {
    background: var(--bg-light);
    border-color: #AD1C43;
    color: #AD1C43;
    transform: translateX(5px);
}

.category-sidebar-link.active {
    background: rgba(201, 168, 106, 0.15);
    border-color: #AD1C43;
    color: #AD1C43;
    font-weight: 600;
}

.category-name {
    font-weight: 500;
    font-size: 16px;
}

.category-count {
    background: var(--bg-dark);
    color: var(--text-gray);
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    min-width: 32px;
    text-align: center;
    transition: all 0.3s ease;
}

.category-sidebar-link:hover .category-count,
.category-sidebar-link.active .category-count {
    background: #AD1C43;
    color: var(--bg-dark);
}

/* ===== СТИЛИ ДЛЯ ФИЛЬТРОВ СОРТИРОВКИ ===== */
.sorting-filters {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 18px 25px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.sorting-filters:hover {
    border-color: rgba(201, 168, 106, 0.3);
}

.btn-outline-exact {
    background: transparent;
    color: var(--text-light);
    border: 1px solid var(--border);
    padding: 10px 20px;
    font-weight: 500;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 15px;
}

.btn-outline-exact:hover,
.btn-outline-exact:focus {
    border-color: #AD1C43;
    color: #AD1C43;
    background: rgba(201, 168, 106, 0.05);
}

.btn-outline-exact.active {
    background: #AD1C43;
    color: var(--bg-dark);
    border-color: #AD1C43;
}

.dropdown-menu {
    background: var(--bg-card);
    border: 1px solid var(--border);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    border-radius: 12px;
    padding: 8px 0;
    margin-top: 5px;
    min-width: 240px;
}

.dropdown-item {
    color: var(--text-light);
    padding: 12px 20px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 15px;
    cursor: pointer;
}

.dropdown-item:hover,
.dropdown-item:focus,
.dropdown-item.active {
    background: #AD1C43;
    color: var(--bg-dark);
}

.dropdown-item i {
    font-size: 16px;
    width: 20px;
    text-align: center;
}

.dropdown-divider {
    border-top-color: var(--border);
    margin: 6px 0;
}

.badge-admin {
    padding: 8px 16px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: #AD1C43;
    color: var(--bg-dark);
    box-shadow: 0 2px 10px rgba(201, 168, 106, 0.3);
    letter-spacing: 0.3px;
}

.badge-admin a {
    color: inherit;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
}

.badge-admin a:hover {
    background: rgba(0, 0, 0, 0.2);
    transform: scale(1.15);
}

/* ===== СТИЛИ ДЛЯ ПУСТОЙ КАТЕГОРИИ ===== */
.empty-category {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 80px 20px;
    transition: all 0.3s ease;
}

.empty-category:hover {
    border-color: rgba(201, 168, 106, 0.3);
}

.empty-icon {
    color: var(--text-gray);
    opacity: 0.6;
}

/* ===== АНИМАЦИИ ===== */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.category-page .row > * {
    animation: fadeInUp 0.5s ease-out;
}

/* ===== АДАПТИВНОСТЬ ===== */
@media (max-width: 1200px) {
    .hero-title-exact {
        font-size: 42px;
    }
    
    .hero-text-exact {
        font-size: 17px;
    }
}

@media (max-width: 992px) {
    .category-hero {
        padding: 40px 0 20px;
    }
    
    .hero-title-exact {
        font-size: 36px;
    }
    
    .hero-text-exact {
        font-size: 16px;
    }
    
    .sidebar-categories {
        margin-bottom: 30px;
        position: static;
    }
    
    .sorting-filters {
        padding: 15px 20px;
    }
}

@media (max-width: 768px) {
    .category-hero {
        padding: 30px 0 15px;
    }
    
    .hero-title-exact {
        font-size: 32px;
    }
    
    .hero-text-exact {
        font-size: 15px;
    }
    
    .row.align-items-center {
        flex-direction: column;
        text-align: center;
    }
    
    .col-lg-4.text-end {
        text-align: center !important;
        margin-top: 20px;
    }
    
    .cart-indicator {
        justify-content: center;
    }
    
    .sidebar-categories {
        padding: 20px;
    }
    
    .sorting-filters .d-flex {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start !important;
        width: 100%;
    }
    
    .sorting-filters .dropdown {
        width: 100%;
    }
    
    .btn-outline-exact {
        width: 100%;
        justify-content: space-between;
    }
    
    .ms-3 {
        margin-left: 0 !important;
        width: 100%;
    }
    
    .badge-admin {
        width: 100%;
        justify-content: space-between;
    }
    
    .empty-category {
        padding: 60px 20px;
    }
    
    .empty-category h3 {
        font-size: 24px;
    }
}

@media (max-width: 576px) {
    .hero-title-exact {
        font-size: 28px;
    }
    
    .hero-text-exact {
        font-size: 14px;
    }
    
    .breadcrumb {
        font-size: 14px;
    }
    
    .sidebar-title {
        font-size: 18px;
    }
    
    .category-sidebar-link {
        padding: 10px 14px;
        font-size: 14px;
    }
    
    .category-count {
        font-size: 12px;
        padding: 3px 8px;
    }
    
    .sorting-filters {
        padding: 12px 16px;
    }
    
    .btn-outline-exact {
        padding: 8px 16px;
        font-size: 14px;
    }
    
    .dropdown-menu {
        min-width: 200px;
    }
    
    .dropdown-item {
        padding: 10px 16px;
        font-size: 14px;
    }
    
    .empty-category {
        padding: 40px 15px;
    }
    
    .empty-category h3 {
        font-size: 20px;
    }
    
    .empty-category p {
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .hero-title-exact {
        font-size: 24px;
    }
    
    .btn-exact-outline {
        padding: 8px 16px;
        font-size: 13px;
    }
    
    .sidebar-categories {
        padding: 15px;
    }
    
    .category-sidebar-link {
        padding: 8px 12px;
    }
    
    .empty-category {
        padding: 30px 15px;
    }
    
    .empty-category h3 {
        font-size: 18px;
    }
}

/* ===== ДОПОЛНИТЕЛЬНЫЕ УЛУЧШЕНИЯ ===== */
/* Стилизация скроллбара */
.sidebar-categories::-webkit-scrollbar {
    width: 6px;
}

.sidebar-categories::-webkit-scrollbar-track {
    background: var(--bg-dark);
    border-radius: 10px;
}

.sidebar-categories::-webkit-scrollbar-thumb {
    background: var(--border);
    border-radius: 10px;
}

.sidebar-categories::-webkit-scrollbar-thumb:hover {
    background: #AD1C43;
}

/* Фокус для доступности */
.category-sidebar-link:focus-visible,
.btn-outline-exact:focus-visible,
.dropdown-item:focus-visible {
    outline: 2px solid #AD1C43;
    outline-offset: 2px;
}

/* Плавная прокрутка */
html {
    scroll-behavior: smooth;
}

/* Кастомный стиль для текста */
.text-muted {
    color: var(--text-gray) !important;
}

/* Стиль для ссылки сброса фильтра */
.badge-admin a i {
    font-size: 14px;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // === СОРТИРОВКА И СОХРАНЕНИЕ ВЫБОРА ===
    const sortDropdown = document.getElementById('sortDropdown');
    const dropdownItems = document.querySelectorAll('.dropdown-item');
    
    // Обновляем текст кнопки в зависимости от выбранной сортировки
    const currentSort = new URLSearchParams(window.location.search).get('sort') || 'default';
    const sortLabels = {
        'default': 'Сортировать',
        'price_asc': 'По цене (возр.)',
        'price_desc': 'По цене (убыв.)'
    };
    
    if (sortDropdown && sortLabels[currentSort]) {
        sortDropdown.innerHTML = `<i class="bi bi-sort-down"></i> ${sortLabels[currentSort]}`;
    }
    
    // Сохраняем выбор в localStorage при клике на пункт меню
    dropdownItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // Получаем параметр sort из href
            const href = this.getAttribute('href');
            const urlParams = new URLSearchParams(href.split('?')[1]);
            const sortType = urlParams.get('sort') || 'default';
            
            // Сохраняем в localStorage
            localStorage.setItem('menu_sort_preference', sortType);
            
            // Добавляем анимацию загрузки
            showNotification('Применяем сортировку...', 'info');
        });
    });
    
    // Восстанавливаем выбор при загрузке страницы
    const savedSort = localStorage.getItem('menu_sort_preference');
    if (savedSort && savedSort !== currentSort && !window.location.search.includes('sort=')) {
        // Показываем уведомление о применении сохраненной сортировки
        showNotification('Применена сохраненная сортировка', 'info');
        
        // Раскомментируйте следующую строку, если хотите автоматически применять сохраненную сортировку
        // window.location.href = window.location.pathname + '?sort=' + savedSort + window.location.hash;
    }

    // === ФУНКЦИОНАЛ КОРЗИНЫ ===
    function updateCartCounter() {
        @auth
        fetch('/cart/count')
            .then(response => response.json())
            .then(data => {
                const cartCount = document.querySelector('.cart-count');
                if (cartCount) {
                    cartCount.textContent = data.count;
                }
            })
            .catch(error => console.error('Error updating cart counter:', error));
        @endauth
    }
    
    updateCartCounter();
    
    // Обработчик для кнопок добавления в корзину
    document.addEventListener('click', function(e) {
        if (e.target.closest('.add-to-cart')) {
            const button = e.target.closest('.add-to-cart');
            const productId = button.dataset.productId;
            
            if (!productId) return;
            
            @auth
            addToCart(productId, 1);
            @else
            showNotification('Для добавления в корзину необходимо войти в систему', 'warning');
            @endauth
        }
    });
    
    function addToCart(productId, quantity) {
        fetch('/cart/add-item', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const cartCount = document.querySelector('.cart-count');
                if (cartCount) {
                    cartCount.textContent = data.cart_count;
                }
                
                showNotification('Товар добавлен в корзину!', 'success');
                
                const button = document.querySelector(`.add-to-cart[data-product-id="${productId}"]`);
                if (button) {
                    const originalHTML = button.innerHTML;
                    button.innerHTML = '<i class="bi bi-check"></i> Добавлено';
                    button.style.background = '#4CAF50';
                    button.style.color = 'white';
                    
                    setTimeout(() => {
                        button.innerHTML = originalHTML;
                        button.style.background = 'white';
                        button.style.color = 'black';
                    }, 2000);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Ошибка при добавлении в корзину', 'error');
        });
    }
    
    function showNotification(message, type = 'success') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} position-fixed top-20 start-50 translate-middle-x`;
        alertDiv.style.zIndex = '9999';
        alertDiv.style.minWidth = '300px';
        alertDiv.style.padding = '15px 20px';
        alertDiv.style.borderRadius = '8px';
        alertDiv.style.textAlign = 'center';
        
        // Цвета для разных типов уведомлений
        const colors = {
            'success': '#4CAF50',
            'warning': '#ffc107',
            'error': '#dc3545',
            'info': '#17a2b8'
        };
        
        alertDiv.style.backgroundColor = colors[type] || colors.info;
        alertDiv.style.color = type === 'warning' ? 'black' : 'white';
        alertDiv.style.border = 'none';
        alertDiv.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
        alertDiv.style.fontWeight = '500';
        alertDiv.textContent = message;
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 3000);
    }
    
    // Добавляем поддержку клавиш для доступности
    function handleKeyPress(e) {
        if (e.key === 'Escape' && document.querySelector('.dropdown-menu.show')) {
            const dropdown = bootstrap.Dropdown.getInstance(document.querySelector('[data-bs-toggle="dropdown"]'));
            if (dropdown) dropdown.hide();
        }
    }
    
    document.addEventListener('keydown', handleKeyPress);
});
</script>
@endpush