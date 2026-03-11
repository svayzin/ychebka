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
                        <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
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
    scrollbar-color: var(--accent) var(--bg-dark);
}

/* Стилизация скроллбара для Firefox */
.sidebar-categories {
    scrollbar-width: thin;
    scrollbar-color: var(--accent) var(--bg-dark);
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
    background: var(--accent);
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
    border-color: var(--accent);
    color: var(--accent);
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
    border-bottom: 2px solid var(--accent);
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
    border: 1px solid rgba(201, 168, 106, 0.1);
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
    border-color: var(--accent);
    box-shadow: 0 20px 35px rgba(201, 168, 106, 0.2);
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
    color: var(--accent);
    letter-spacing: 0.5px;
    text-shadow: 0 2px 5px rgba(201, 168, 106, 0.3);
}

.btn-exact.add-to-cart {
    width: 100%;
    padding: 14px 15px;
    font-size: 15px;
    cursor: pointer;
    background: transparent;
    color: var(--accent);
    border: 2px solid var(--accent);
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
    background: var(--accent);
    color: var(--bg-dark);
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(201, 168, 106, 0.4);
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
    color: var(--accent);
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
    color: var(--accent);
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
    background: var(--accent);
    color: var(--bg-dark);
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
    background: #dbb168;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(201, 168, 106, 0.4);
}

.btn-modal-add-single i {
    font-size: 20px;
}

.spinner-border.text-gold {
    color: var(--accent) !important;
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
            e.preventDefault();
            const categorySlug = this.dataset.category;
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
                        button.style.color = 'var(--accent)';
                        button.style.borderColor = 'var(--accent)';
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
});
</script>
@endpush
@endsection