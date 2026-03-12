@extends('layouts.app')

@section('title', 'Меню - Созвездие вкусов')

@section('content')
<div class="menu-page">
    <!-- Заголовок меню УБРАН -->

    <div class="container-exact">
        <div class="row">
            <!-- Боковая навигация - ФИКСИРОВАННАЯ -->
            <div class="col-lg-3">
                <div class="sidebar-categories sticky-sidebar">
                <div class="categories-list">
                        <a href="{{ route('menu') }}" class="category-sidebar-link category-link-all" data-category="">Все</a>
                        @foreach($categories as $category)
                        <a href="{{ route('menu') }}#category-{{ $category->slug }}"
   class="category-sidebar-link" 
   data-category="{{ $category->slug }}">
    <span class="category-name">{{ $category->name }}</span>
</a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Список блюд -->
            <div class="col-lg-9">
                <!-- Поиск и сортировка -->
                <div class="menu-filters-bar mb-4">
                    <div class="d-flex flex-wrap gap-3 align-items-center">
                    <div class="menu-search-wrap flex-grow-1" style="min-width: 200px;">
                            <input type="text" id="menu-search" class="form-control form-control-exact" placeholder="Поиск блюд..." autocomplete="off">
                        </div>
                        <div class="menu-price-range d-flex align-items-center gap-2 flex-wrap">
                            <label class="text-nowrap text-muted small mb-0">Цена:</label>
                            <input type="number" id="menu-price-from" class="form-control form-control-exact menu-price-input" placeholder="от" min="0" step="10" autocomplete="off">
                            <span class="text-muted">—</span>
                            <input type="number" id="menu-price-to" class="form-control form-control-exact menu-price-input" placeholder="до" min="0" step="10" autocomplete="off">
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-outline-exact dropdown-toggle" type="button" id="menuSortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-sort-down"></i> <span id="menu-sort-label">Сортировка</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="menuSortDropdown">
                                <li><a class="dropdown-item menu-sort-option active" href="#" data-sort="default">По умолчанию</a></li>
                                <li><a class="dropdown-item menu-sort-option" href="#" data-sort="price_asc">По цене (возр.)</a></li>
                                <li><a class="dropdown-item menu-sort-option" href="#" data-sort="price_desc">По цене (убыв.)</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Все категории отображаются сразу при заходе -->
                @foreach($categories as $category)
                <div id="category-{{ $category->slug }}" class="menu-category mb-5 @if($loop->first) active-category @endif">
                    <div class="category-header">
                        <h2 class="category-title">{{ $category->name }}</h2>
                        @if($category->description)
                        <p class="category-description">{{ $category->description }}</p>
                        @endif
                    </div>
                    
                    @if($category->products->count() > 0)
                    <div class="row">
                        @foreach($category->products as $product)
                        <div class="col-xl-4 col-lg-6 col-md-6 mb-4 product-col" data-product-name="{{ Str::lower($product->name) }}" data-product-search="{{ Str::lower($product->name . ' ' . ($product->description ?? '')) }}" data-product-price="{{ $product->price }}" data-category-slug="{{ $category->slug }}">
                            <div class="product-card">
                                <!-- Изображение кликабельное -->
                                <div class="product-image-wrapper" onclick="openProductModal({{ $product->id }})">
                                    <div class="product-image-container">
                                        @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}">
                                        @else
                                        <div class="no-image">
                                            <i class="bi bi-image"></i>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="product-info">
                                    <h3 class="product-name">{{ $product->name }}</h3>
                                    
                                    <div class="product-meta">
                                        <span class="product-weight">{{ $product->weight }} {{ $product->weight_unit }}</span>
                                        <span class="product-price">{{ number_format($product->price, 0, '.', ' ') }} ₽</span>
                                    </div>
                                    
                                    <button class="btn-exact add-to-cart" data-product-id="{{ $product->id }}">
                                        <i class="bi bi-cart-plus"></i> В корзину
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="empty-category text-center py-5">
                        <p class="text-muted">В этой категории пока нет блюд</p>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- МОДАЛЬНОЕ ОКНО ДЛЯ ПРОСМОТРА БЛЮДА -->
<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content product-modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body p-0">
                <div class="product-detail-layout">
                    <!-- Левая часть - большое фото -->
                    <div class="product-detail-image-section">
                        <div class="product-detail-image-container" id="modalImageContainer">
                            <div class="text-center py-5">
                                <div class="spinner-border text-gold" role="status">
                                    <span class="visually-hidden">Загрузка...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Правая часть - информация -->
                    <div class="product-detail-info-section">
                        <div class="product-detail-content" id="modalContent">
                            <div class="text-center py-5">
                                <div class="spinner-border text-gold" role="status">
                                    <span class="visually-hidden">Загрузка...</span>
                                </div>
                                <p class="mt-3 text-muted">Загрузка информации о блюде...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.menu-price-range .form-control.is-invalid {
    border-color: #dc3545;
}

.text-muted {
    color: #ffffff !important;
}

.dropdown-toggle {
    color: #ffffff;
}

.menu-filters-bar {
    background: var(--bg-card);
    border-radius: 12px;
    padding: 16px 20px;
    border: 1px solid var(--border);
}
.form-control-exact {
    border: 1px solid var(--border);
    border-radius: 8px;
}
.form-control-exact:focus {
    border-color: #AD1C43;
    box-shadow: 0 0 0 0.2rem rgba(173, 28, 67, 0.25);
}
.menu-price-range .menu-price-input {
    width: 90px;
}

.menu-page {
    background: var(--bg-dark);
    min-height: 100vh;
    padding-top: 30px; /* Добавлен отступ сверху */
}

/* Удалены стили для hero-title-exact и hero-text-exact так как они больше не используются */

.cart-indicator {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 20px;
}

/* ФИКСИРОВАННАЯ БОКОВАЯ НАВИГАЦИЯ */
.sidebar-categories {
    background: var(--bg-card);
    border-radius: 12px;
    padding: 25px;
    border: 1px solid var(--border);
    margin-bottom: 30px;
    position: sticky;
    top: 100px; /* Фиксируется на расстоянии 100px от верха */
    max-height: calc(100vh - 120px); /* Ограничение высоты */
    overflow-y: auto; /* Прокрутка внутри, если категорий много */
    scrollbar-width: thin;
    scrollbar-color: #AD1C43 var(--bg-dark);
}

/* Стилизация скроллбара для Firefox */
.sidebar-categories {
    scrollbar-width: thin;
    scrollbar-color: #AD1C43 var(--bg-dark);
}

/* Стилизация скроллбара для Chrome/Edge/Safari */
.sidebar-categories::-webkit-scrollbar {
    width: 6px;
}

.sidebar-categories::-webkit-scrollbar-track {
    background: var(--bg-dark);
    border-radius: 10px;
}

.sidebar-categories::-webkit-scrollbar-thumb {
    background: #AD1C43;
    border-radius: 10px;
}

.sidebar-categories::-webkit-scrollbar-thumb:hover {
    background: var(--accent-light);
}

.categories-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.category-sidebar-link {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 15px;
    color: var(--text-light);
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
    border: 1px solid transparent;
    cursor: pointer;
}

.category-sidebar-link:hover,
.category-sidebar-link.active {
    background: var(--bg-light);
    border-color: #AD1C43;
    color: #AD1C43;
}

.category-name {
    font-weight: 500;
    font-size: 16px;
}

.menu-category {
    padding: 30px;
    background: var(--bg-card);
    border-radius: 12px;
    border: 1px solid var(--border);
    display: block;
    margin-bottom: 30px;
}

.menu-category.hidden-category {
    display: none;
}

.menu-category.active-category {
    display: block;
    animation: fadeIn 0.5s ease;
}

.category-header {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid #AD1C43;
}

.category-title {
    font-size: 32px;
    font-weight: 700;
    color: var(--text-light);
    margin-bottom: 10px;
    font-family: "Yeseva One", serif;
}

.category-description {
    color: var(--text-gray);
    font-size: 16px;
    line-height: 1.6;
    margin: 0;
}

.empty-category {
    background: var(--bg-light);
    border-radius: 8px;
    padding: 40px 20px;
    margin-top: 20px;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ДИЗАЙН КАРТОЧЕК */
.product-card {
    background: linear-gradient(145deg, #1e1e1e, #1a1a1a);
    border: 1px solid rgba(126, 48, 69, 0.38);
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    height: 420px;
    display: flex;
    flex-direction: column;
    position: relative;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
}

.product-card:hover {
    transform: translateY(-10px);
    border-color: #AD1C43;
    box-shadow: 0 20px 35px rgba(126, 48, 69, 0.38);
}

.product-image-wrapper {
    position: relative;
    height: 240px;
    overflow: hidden;
    cursor: pointer;
    background: linear-gradient(145deg, #2a2a2a, #1f1f1f);
}

.product-image-container {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.product-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.product-card:hover .product-image-container img {
    transform: scale(1.05);
}

.product-image-wrapper::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent 60%, rgba(0, 0, 0, 0.7));
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.product-card:hover .product-image-wrapper::after {
    opacity: 1;
}

.no-image {
    width: 100%;
    height: 100%;
    background: linear-gradient(145deg, #2a2a2a, #1f1f1f);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-gray);
    font-size: 64px;
}

.product-info {
    padding: 20px 20px 25px 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
    background: linear-gradient(to bottom, #1e1e1e, #181818);
}

.product-name {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 15px;
    color: var(--text-light);
    line-height: 1.3;
    font-family: 'Inter', sans-serif;
    letter-spacing: 0.3px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    min-height: 52px;
}

.product-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid rgba(201, 168, 106, 0.2);
}

.product-weight {
    color: var(--text-gray);
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 5px;
    background: rgba(255, 255, 255, 0.05);
    padding: 4px 10px;
    border-radius: 20px;
}

.product-price {
    font-size: 24px;
    font-weight: 700;
    color: #AD1C43;
    letter-spacing: 0.5px;
    text-shadow: 0 2px 5px rgba(201, 168, 106, 0.3);
}

.btn-exact.add-to-cart {
    width: 100%;
    padding: 14px 15px;
    font-size: 15px;
    cursor: pointer;
    background: transparent;
    color: #AD1C43;
    border: 2px solid #AD1C43;
    border-radius: 40px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-top: auto;
}

.btn-exact.add-to-cart:hover {
    background: #AD1C43;
    color: #ffffff;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(126, 48, 69, 0.38);
}

.btn-exact.add-to-cart i {
    font-size: 18px;
}

/* НОВЫЙ ДИЗАЙН МОДАЛЬНОГО ОКНА */
.product-modal-content {
    background: #1a1a1a;
    border: none;
    border-radius: 24px;
    color: var(--text-light);
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.5);
    overflow: hidden;
}

.modal-header {
    border-bottom: 1px solid rgba(201, 168, 106, 0.2);
    padding: 16px 24px;
    background: rgba(0, 0, 0, 0.3);
    position: absolute;
    top: 0;
    right: 0;
    z-index: 10;
    border: none;
}

.modal-header .btn-close {
    filter: invert(1) grayscale(100%) brightness(200%);
    opacity: 0.8;
    transition: all 0.3s ease;
    background-size: 1.2em;
}

.modal-header .btn-close:hover {
    opacity: 1;
    transform: rotate(90deg) scale(1.1);
}

.modal-body {
    padding: 0;
}

/* Лейаут модального окна */
.product-detail-layout {
    display: flex;
    flex-direction: column;
    min-height: 500px;
}

@media (min-width: 992px) {
    .product-detail-layout {
        flex-direction: row;
    }
}

/* Левая часть - большое фото */
.product-detail-image-section {
    flex: 1.2;
    background: #0f0f0f;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 30px;
    min-height: 400px;
}

@media (min-width: 992px) {
    .product-detail-image-section {
        min-height: 550px;
    }
}

.product-detail-image-container {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-detail-image-container img {
    max-width: 100%;
    max-height: 500px;
    width: auto;
    height: auto;
    object-fit: contain;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
}

/* Правая часть - информация */
.product-detail-info-section {
    flex: 0.8;
    background: #1a1a1a;
    padding: 30px;
    display: flex;
    flex-direction: column;
    border-left: 1px solid rgba(201, 168, 106, 0.2);
}

.product-detail-content {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.product-detail-name {
    font-size: 36px;
    font-weight: 700;
    margin-bottom: 10px;
    color: var(--text-light);
    font-family: "Yeseva One", serif;
    line-height: 1.2;
}

/* Вес под названием */
.product-detail-weight {
    font-size: 16px;
    color: var(--text-gray);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 5px;
    padding-bottom: 15px;
    border-bottom: 1px solid rgba(201, 168, 106, 0.2);
}

.product-detail-weight i {
    color: #AD1C43;
    font-size: 18px;
}

.product-detail-description {
    color: rgba(255, 255, 255, 0.7);
    font-size: 15px;
    line-height: 1.6;
    margin-bottom: 25px;
    flex: 1;
}

/* Блок с ценой и кнопкой */
.product-detail-footer {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-top: auto;
    padding-top: 20px;
    border-top: 1px solid rgba(201, 168, 106, 0.2);
}

/* Цена слева */
.product-detail-price-block {
    flex: 1;
}

.product-detail-price-label {
    font-size: 13px;
    color: var(--text-gray);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 5px;
}

.product-detail-price-value {
    font-size: 32px;
    font-weight: 700;
    color: #AD1C43;
    line-height: 1;
}

.product-detail-price-value small {
    font-size: 16px;
    color: var(--text-gray);
    font-weight: 400;
    margin-left: 2px;
}

/* Кнопка в корзину справа */
.btn-modal-add-single {
    padding: 14px 30px;
    background: #AD1C43;
    color: #ffffff;
    border: none;
    border-radius: 50px;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    white-space: nowrap;
}

.btn-modal-add-single:hover {
    background: #84142A;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(126, 48, 69, 0.38);
}

.btn-modal-add-single i {
    font-size: 20px;
}

.spinner-border.text-gold {
    color: #AD1C43 !important;
    width: 3rem;
    height: 3rem;
    border-width: 0.2rem;
}

/* Адаптивность */
@media (max-width: 992px) {
    .sidebar-categories {
        position: static; /* На мобильных отключаем фиксацию */
        max-height: none;
        overflow-y: visible;
    }
    
    .product-detail-image-section {
        min-height: 350px;
        padding: 20px;
    }
    
    .product-detail-image-container img {
        max-height: 300px;
    }
    
    .product-detail-info-section {
        padding: 25px;
    }
    
    .product-detail-name {
        font-size: 28px;
    }
    
    .product-detail-footer {
        flex-direction: column;
        align-items: stretch;
    }
    
    .btn-modal-add-single {
        width: 100%;
    }
}

@media (max-width: 768px) {
    .menu-page {
        padding-top: 15px;
    }
    
    .category-title {
        font-size: 28px;
    }
    
    .menu-category {
        padding: 20px;
    }
    
    .sidebar-categories {
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .product-card {
        height: 380px;
    }
    
    .product-image-wrapper {
        height: 200px;
    }
    
    .product-name {
        font-size: 18px;
        min-height: 46px;
    }
    
    .modal-header {
        padding: 10px 15px;
    }
    
    .product-detail-image-section {
        min-height: 300px;
        padding: 15px;
    }
    
    .product-detail-image-container img {
        max-height: 250px;
    }
    
    .product-detail-info-section {
        padding: 20px;
    }
    
    .product-detail-name {
        font-size: 24px;
    }
    
    .product-detail-price-value {
        font-size: 28px;
    }
}
</style>

@push('scripts')
<script>
// Глобальная функция для открытия модального окна
window.openProductModal = function(productId) {
    const modal = new bootstrap.Modal(document.getElementById('productModal'));
    
    // Показываем модальное окно
    modal.show();
    
    // Загружаем данные о продукте
    fetch(`/api/product/${productId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(product => {
            renderProductModal(product);
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('modalImageContainer').innerHTML = `
                <div class="text-center py-5 text-danger">
                    <i class="bi bi-exclamation-triangle" style="font-size: 48px;"></i>
                </div>
            `;
            document.getElementById('modalContent').innerHTML = `
                <div class="text-center py-5 text-danger">
                    <p>Ошибка при загрузке информации</p>
                </div>
            `;
        });
}

// Функция для отображения данных в модальном окне
function renderProductModal(product) {
    const imageUrl = product.image ? `/storage/${product.image}` : 'https://via.placeholder.com/600x400/2A2A2A/C9A86A?text=' + encodeURIComponent(product.name);
    
    // Вставляем изображение
    document.getElementById('modalImageContainer').innerHTML = `
        <img src="${imageUrl}" alt="${product.name}" 
             onerror="this.src='https://via.placeholder.com/600x400/2A2A2A/C9A86A?text=${encodeURIComponent(product.name)}'">
    `;
    
    // Вставляем информацию
    document.getElementById('modalContent').innerHTML = `
        <div class="product-detail-content">
            <h3 class="product-detail-name">${product.name}</h3>
            
            <!-- Вес под названием -->
            <div class="product-detail-weight">
                 ${product.weight} ${product.weight_unit}
            </div>
            
            <div class="product-detail-description">
                ${product.description || 'Описание отсутствует'}
            </div>
            
            <!-- Футер с ценой и кнопкой -->
            <div class="product-detail-footer">
                <div class="product-detail-price-block">
                    <div class="product-detail-price-label">Цена</div>
                    <div class="product-detail-price-value">
                        ${new Intl.NumberFormat('ru-RU').format(product.price)} <small>₽</small>
                    </div>
                </div>
                
                <button class="btn-modal-add-single" onclick="addToCartFromModal(${product.id})">
                    <i class="bi bi-cart-plus"></i> В корзину
                </button>
            </div>
        </div>
    `;
}

// Функция для добавления в корзину из модального окна
window.addToCartFromModal = function(productId) {
    @auth
    fetch('/cart/add-item', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const cartCount = document.querySelector('.cart-count');
            if (cartCount) {
                cartCount.textContent = data.cart_count;
            }
            
            if (typeof showElegantNotification === 'function') {
                showElegantNotification('Товар добавлен в корзину!', 'success');
            }
            
            bootstrap.Modal.getInstance(document.getElementById('productModal')).hide();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ошибка при добавлении в корзину');
    });
    @else
    bootstrap.Modal.getInstance(document.getElementById('productModal')).hide();
    if (typeof showElegantNotification === 'function') {
        showElegantNotification('Для добавления в корзину необходимо войти в систему', 'warning');
    }
    @endauth
}

document.addEventListener('DOMContentLoaded', function() {
    // Навигация по категориям
    const categoryLinks = document.querySelectorAll('.category-sidebar-link');
    const categorySections = document.querySelectorAll('.menu-category');
    
    function showAllCategories() {
        categorySections.forEach(section => {
            section.classList.remove('hidden-category');
            section.classList.add('active-category');
        });
        categoryLinks.forEach(link => {
            link.classList.remove('active');
        });
        const allLink = document.querySelector('.category-sidebar-link[data-category=""]');
        if (allLink) allLink.classList.add('active');
    }
    
    function activateCategory(categorySlug) {
        categorySections.forEach(section => {
            section.classList.add('hidden-category');
            section.classList.remove('active-category');
        });
        categoryLinks.forEach(link => {
            link.classList.remove('active');
        });
        
        const activeSection = document.getElementById(`category-${categorySlug}`);
        const activeLink = document.querySelector(`.category-sidebar-link[data-category="${categorySlug}"]`);
        
        if (activeSection) {
            activeSection.classList.remove('hidden-category');
            activeSection.classList.add('active-category');
        }
        if (activeLink) {
            activeLink.classList.add('active');
        }
    }
    
    categoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const categorySlug = this.dataset.category;
            if (categorySlug === '') {
                e.preventDefault();
                showAllCategories();
                const allLink = document.querySelector('.category-sidebar-link[data-category=""]');
                if (allLink) allLink.classList.add('active');
                history.pushState(null, null, window.location.pathname);
                window.scrollTo({ top: 0, behavior: 'smooth' });
                return;
            }
            e.preventDefault();
            history.pushState(null, null, `#category-${categorySlug}`);
            activateCategory(categorySlug);
            
            const targetElement = document.getElementById(`category-${categorySlug}`);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 120,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    function handleHashChange() {
        const hash = window.location.hash.substring(1);
        if (hash && hash.startsWith('category-')) {
            const categorySlug = hash.replace('category-', '');
            activateCategory(categorySlug);
        } else {
            showAllCategories();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    }
    
    window.addEventListener('load', handleHashChange);
    window.addEventListener('hashchange', handleHashChange);
    
    // Обработчик для кнопок добавления в корзину
    document.addEventListener('click', function(e) {
        if (e.target.closest('.add-to-cart') && !e.target.closest('.btn-modal-add-single')) {
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
                    button.style.borderColor = '#4CAF50';
                    
                    setTimeout(() => {
                        button.innerHTML = originalHTML;
                        button.style.background = 'transparent';
                        button.style.color = '#AD1C43';
                        button.style.borderColor = '#AD1C43';
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
        if (typeof showElegantNotification === 'function') {
            showElegantNotification(message, type);
        }
    }
    
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
    
    @auth
    updateCartCounter();
    @endauth

        // Нормализация для поиска (похожие буквы: ё→е, щ→ш и т.д.)
            function normalizeForSearch(s) {
                if (!s) return '';
                const map = { 'ё':'е','й':'и','щ':'ш','ъ':'','ь':'' };
                return s.toLowerCase().replace(/[ёйщъь]/g, c => map[c] || c).trim();
            }
        // Расстояние Левенштейна (одна опечатка = 1)
        function lev(a, b) {
            if (!a.length) return b.length;
            if (!b.length) return a.length;
            const m = a.length, n = b.length;
            let row0 = Array(n + 1).fill(0).map((_, i) => i);
            let row1 = Array(n + 1).fill(0);
            for (let i = 1; i <= m; i++) {
                row1[0] = i;
                for (let j = 1; j <= n; j++) {
                    const cost = a[i - 1] === b[j - 1] ? 0 : 1;
                    row1[j] = Math.min(row1[j - 1] + 1, row0[j] + 1, row0[j - 1] + cost);
                }
                [row0, row1] = [row1, row0];
            }
            return row0[n];
        }
        // Есть ли подстрока в text на расстоянии <= maxDist от query
        function fuzzySubstring(text, query, maxDist) {
            const qLen = query.length;
            for (let i = 0; i <= text.length - qLen + maxDist; i++) {
                for (let len = qLen - maxDist; len <= qLen + maxDist; len++) {
                    if (len < 1) continue;
                    const sub = text.substr(i, len);
                    if (lev(query, sub) <= maxDist) return true;
                }
            }
            return false;
        }
        // Подпоследовательность внутри одного слова
        function isSubsequence(word, query) {
            let j = 0;
            for (let i = 0; i < word.length && j < query.length; i++) {
                if (word[i] === query[j]) j++;
            }
            return j === query.length;
        }
        // Поиск: точное совпадение, без пробелов, одна опечатка (Левенштейн 1), по словам
        function searchMatches(text, query) {
            const q = normalizeForSearch(query);
            if (!q) return true;
            const t = normalizeForSearch(text);
            if (t.indexOf(q) !== -1) return true;
            const tNoSpaces = t.replace(/\s+/g, '');
            const qNoSpaces = q.replace(/\s+/g, '');
            if (tNoSpaces.indexOf(qNoSpaces) !== -1) return true;
            if (q.length >= 3 && (fuzzySubstring(t, q, 1) || fuzzySubstring(tNoSpaces, qNoSpaces, 1))) return true;
            const words = t.split(/\s+/).filter(w => w.length > 0);
            for (const word of words) {
                if (word.indexOf(q) !== -1) return true;
                if (word.length >= 2 && q.length >= 2 && lev(word, q) <= 1) return true;
                if (word.length <= q.length + 3 && isSubsequence(word, q)) return true;
            }
            return false;
        }
        function applyMenuFilters() {
            const q = (document.getElementById('menu-search')?.value || '').trim();
            const fromPrice = parseFloat(document.getElementById('menu-price-from')?.value) || null;
            const toPrice = parseFloat(document.getElementById('menu-price-to')?.value) || null;
            // Неверный диапазон цен: от > до — не применяем фильтр по цене
            const priceRangeValid = (fromPrice == null || toPrice == null) || (fromPrice <= toPrice);
            document.querySelectorAll('.menu-category').forEach(cat => {
                let visibleCount = 0;
                cat.querySelectorAll('.product-col').forEach(col => {
                    const searchText = (col.dataset.productSearch || '').trim();
                    const price = Number(col.dataset.productPrice) || 0;
                    // Поиск только при 2+ символах, иначе показываем все
                    const searchOk = !q || q.length < 2 || searchMatches(searchText, q);
                    const priceOk = !priceRangeValid || (fromPrice == null || price >= fromPrice) && (toPrice == null || price <= toPrice);
                    const show = searchOk && priceOk;
                    col.style.display = show ? '' : 'none';
                    if (show) visibleCount++;
                });
                cat.classList.toggle('hidden-category', visibleCount === 0);
                cat.classList.toggle('active-category', visibleCount > 0);
            });
        }

        // Ограничение: "до" не меньше "от", "от" не больше "до"
        const priceFrom = document.getElementById('menu-price-from');
        const priceTo = document.getElementById('menu-price-to');
        function validatePriceRange() {
            const from = parseFloat(priceFrom?.value) || null;
            const to = parseFloat(priceTo?.value) || null;
            if (priceTo && from != null) priceTo.min = from;
            if (priceFrom && to != null) priceFrom.max = to;
            const invalid = from != null && to != null && from > to;
            if (priceFrom) priceFrom.classList.toggle('is-invalid', invalid);
            if (priceTo) priceTo.classList.toggle('is-invalid', invalid);
        }
        priceFrom?.addEventListener('input', function() {
            validatePriceRange();
            const to = parseFloat(priceTo?.value);
            if (to !== NaN && to < parseFloat(this.value)) priceTo.value = this.value;
        });
        priceTo?.addEventListener('input', validatePriceRange);

        const menuSearchInput = document.getElementById('menu-search');
        if (menuSearchInput) menuSearchInput.addEventListener('input', applyMenuFilters);
        document.getElementById('menu-price-from')?.addEventListener('input', applyMenuFilters);
        document.getElementById('menu-price-to')?.addEventListener('input', applyMenuFilters);
    // Сортировка по цене внутри каждой категории
    let currentMenuSort = 'default';
    document.querySelectorAll('.menu-sort-option').forEach(opt => {
        opt.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.menu-sort-option').forEach(o => o.classList.remove('active'));
            this.classList.add('active');
            currentMenuSort = this.dataset.sort;
            const labels = { default: 'Сортировка', price_asc: 'По цене (возр.)', price_desc: 'По цене (убыв.)' };
            const labelEl = document.getElementById('menu-sort-label');
            if (labelEl) labelEl.textContent = labels[currentMenuSort] || 'Сортировка';
            document.querySelectorAll('.menu-category').forEach(cat => {
                const row = cat.querySelector('.row');
                if (!row) return;
                const cols = Array.from(row.querySelectorAll('.product-col'));
                if (currentMenuSort === 'price_asc') cols.sort((a, b) => Number(a.dataset.productPrice) - Number(b.dataset.productPrice));
                else if (currentMenuSort === 'price_desc') cols.sort((a, b) => Number(b.dataset.productPrice) - Number(a.dataset.productPrice));
                else cols.sort((a, b) => 0);
                cols.forEach(c => row.appendChild(c));
            });
        });
    });
});
</script>
@endpush
@endsection