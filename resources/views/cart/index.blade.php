@extends('layouts.app')

@section('title', 'Корзина - Созвездие вкусов')

@section('content')
<div class="cart-page">
    <div class="container-exact">
        <h1 class="page-title">Корзина</h1>
        
        @if(!auth()->check())
            {{-- Блок для неавторизованных пользователей --}}
            <div class="auth-required text-center py-5">
                <div class="empty-cart-icon">
                    <i class="bi bi-person-x"></i>
                </div>
                <h2>Требуется авторизация</h2>
                <p>Для просмотра корзины необходимо войти в систему</p>
                <div class="mt-4">
                    <a href="{{ route('login') }}" class="btn-exact me-3">
                        Войти
                    </a>
                    <a href="{{ route('register') }}" class="btn-exact-outline">
                        Зарегистрироваться
                    </a>
                </div>
            </div>
        @elseif(isset($cartItems) && $cartItems->count() > 0)
            {{-- Блок для авторизованных пользователей с товарами в корзине --}}
            <div class="row">
                <!-- Товары в корзине -->
                <div class="col-lg-7">
                    <div class="cart-items">
                        @foreach($cartItems as $item)
                        <div class="cart-item" data-item-id="{{ $item->id }}">
                            <div class="cart-item-image">
                                @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                                @else
                                <div class="no-image">
                                    <i class="bi bi-image"></i>
                                </div>
                                @endif
                            </div>
                            
                            <div class="cart-item-info">
                                <h4>{{ $item->product->name }}</h4>
                                <p class="cart-item-weight">{{ $item->product->weight }} {{ $item->product->weight_unit }}</p>
                                <p class="cart-item-price-single">{{ number_format($item->product->price, 0, '.', ' ') }} ₽</p>
                            </div>
                            
                            <div class="cart-item-quantity">
                                <button class="quantity-btn minus" data-action="decrease" data-item-id="{{ $item->id }}">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input type="number" class="quantity-input" value="{{ $item->quantity }}" min="1" max="10"
                                       data-item-id="{{ $item->id }}">
                                <button class="quantity-btn plus" data-action="increase" data-item-id="{{ $item->id }}">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                            
                            <div class="cart-item-total">
                                <span class="item-total-price">
                                    {{ number_format($item->quantity * $item->product->price, 0, '.', ' ') }} ₽
                                </span>
                            </div>
                            
                            <button class="cart-item-remove" data-item-id="{{ $item->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Итоговая информация и оформление -->
                <div class="col-lg-5">
                    <div class="order-summary">
                        <h3 class="summary-title">Оформление заказа</h3>
                        
                        <form action="{{ route('cart.checkout') }}" method="POST" id="checkout-form">
                            @csrf
                            
                            <!-- Способ получения -->
                            <div class="delivery-section">
                                <h4 class="section-title">Способ получения</h4>
                                
                                <div class="delivery-options">
                                    <div class="delivery-option">
                                        <input type="radio" name="delivery_type" id="delivery" value="delivery" class="delivery-radio" checked>
                                        <label for="delivery" class="delivery-label">
                                            <i class="bi bi-truck"></i>
                                            <span>Доставка</span>
                                        </label>
                                    </div>
                                    
                                    <div class="delivery-option">
                                        <input type="radio" name="delivery_type" id="pickup" value="pickup" class="delivery-radio">
                                        <label for="pickup" class="delivery-label">
                                            <i class="bi bi-shop"></i>
                                            <span>Самовывоз</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Блок для доставки -->
                                <div class="delivery-address-block" id="delivery-block">
                                    <div class="form-group">
                                        <label for="city" class="form-label">Город</label>
                                        <input type="text" class="form-control" id="city" name="city" 
                                               value="{{ old('city', 'Набережные Челны') }}" placeholder="Город">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="street" class="form-label">Улица</label>
                                        <input type="text" class="form-control" id="street" name="street" 
                                               value="{{ old('street') }}" placeholder="Улица" required>
                                    </div>
                                    
                                    <div class="address-row">
                                        <div class="form-group half">
                                            <label for="house" class="form-label">Дом</label>
                                            <input type="text" class="form-control" id="house" name="house" 
                                                   value="{{ old('house') }}" placeholder="№" required>
                                        </div>
                                        
                                        <div class="form-group half">
                                            <label for="apartment" class="form-label">Квартира/офис</label>
                                            <input type="text" class="form-control" id="apartment" name="apartment" 
                                                   value="{{ old('apartment') }}" placeholder="№">
                                        </div>
                                    </div>
                                    
                                    <div class="address-row">
                                        <div class="form-group half">
                                            <label for="entrance" class="form-label">Подъезд</label>
                                            <input type="text" class="form-control" id="entrance" name="entrance" 
                                                   value="{{ old('entrance') }}" placeholder="№">
                                        </div>
                                        
                                        <div class="form-group half">
                                            <label for="floor" class="form-label">Этаж</label>
                                            <input type="text" class="form-control" id="floor" name="floor" 
                                                   value="{{ old('floor') }}" placeholder="№">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="intercom" class="form-label">Домофон (код)</label>
                                        <input type="text" class="form-control" id="intercom" name="intercom" 
                                               value="{{ old('intercom') }}" placeholder="Код домофона">
                                    </div>
                                </div>
                                
                                <!-- Блок для самовывоза -->
                                <div class="pickup-address-block" id="pickup-block" style="display: none;">
                                    <div class="pickup-info">
                                        <div class="pickup-icon">
                                            <i class="bi bi-shop"></i>
                                        </div>
                                        <div class="pickup-details">
                                            <h5>Адрес самовывоза</h5>
                                            <p>г. Набережные Челны, проспект Сююмбике, 2</p>
                                            <p class="pickup-hours">
                                                <i class="bi bi-clock"></i>
                                                Ежедневно с 10:00 до 23:00
                                            </p>
                                            <p class="pickup-phone">
                                                <i class="bi bi-telephone"></i>
                                                8(8545)-33-22-22
                                            </p>
                                        </div>
                                    </div>
                                    <input type="hidden" name="pickup_address" value="г. Набережные Челны, проспект Сююмбике, 2">
                                </div>
                            </div>
                            
                            <!-- Комментарий к заказу -->
                            <div class="comment-section">
                                <h4 class="section-title">Комментарий к заказу</h4>
                                <div class="form-group">
                                    <textarea class="form-control" id="notes" name="notes" rows="3"
                                              placeholder="Ваши пожелания ">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                            
                            <!-- Способ оплаты -->
                            <div class="payment-section">
                                <h4 class="section-title">Способ оплаты</h4>
                                
                                <div class="payment-options">
                                    <div class="payment-option">
                                        <input type="radio" name="payment_method" id="card" value="card" class="payment-radio" checked>
                                        <label for="card" class="payment-label">
                                            <i class="bi bi-credit-card"></i>
                                            <div class="payment-info">
                                                <span class="payment-title">Банковской картой</span>
                                                <span class="payment-desc">Visa, Mastercard, МИР</span>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    <div class="payment-option">
                                        <input type="radio" name="payment_method" id="online" value="online" class="payment-radio">
                                        <label for="online" class="payment-label">
                                            <i class="bi bi-wifi"></i>
                                            <div class="payment-info">
                                                <span class="payment-title">Онлайн-оплата</span>
                                                <span class="payment-desc">Через платежную систему</span>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    <div class="payment-option">
                                        <input type="radio" name="payment_method" id="cash" value="cash" class="payment-radio">
                                        <label for="cash" class="payment-label">
                                            <i class="bi bi-cash"></i>
                                            <div class="payment-info">
                                                <span class="payment-title">Наличными</span>
                                                <span class="payment-desc">При получении</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Итоговая сумма -->
                            <div class="summary-details">
                                <div class="summary-row">
                                    <span>Товары ({{ $cartItems->sum('quantity') }})</span>
                                    <span>{{ number_format($total, 0, '.', ' ') }} ₽</span>
                                </div>
                                
                                <div class="summary-row" id="delivery-cost-row" style="display: none;">
                                    <span>Доставка</span>
                                    <span class="delivery-cost">0 ₽</span>
                                </div>
                                
                                <div class="summary-divider"></div>
                                
                                <div class="summary-row total-row">
                                    <span>К оплате</span>
                                    <span class="total-amount">{{ number_format($total, 0, '.', ' ') }} ₽</span>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn-checkout btn-exact w-100">
                                Оформить заказ
                            </button>
                        </form>
                        
                        <div class="continue-shopping mt-3">
                            <a href="{{ route('menu') }}" class="btn-link">
                                <i class="bi bi-arrow-left"></i> Продолжить покупки
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- Блок для авторизованных пользователей с пустой корзиной --}}
            <div class="empty-cart">
                <div class="empty-cart-icon">
                    <i class="bi bi-cart-x"></i>
                </div>
                <h2>Корзина пуста</h2>
                <p>Добавьте товары из меню, чтобы оформить заказ</p>
                <a href="{{ route('menu') }}" class="btn-exact">
                    Перейти в меню
                </a>
            </div>
        @endif
    </div>
</div>

<style>
.cart-page {
    background: var(--bg-dark);
    min-height: 100vh;
    padding: 60px 0;
}

.page-title {
    font-size: 48px;
    font-weight: 700;
    margin-bottom: 40px;
    color: var(--text-light);
}

.cart-items {
    background: var(--bg-card);
    border-radius: 16px;
    padding: 20px;
    border: 1px solid var(--border);
}

.cart-item {
    display: flex;
    align-items: center;
    padding: 20px 0;
    border-bottom: 1px solid var(--border);
}

.cart-item:last-child {
    border-bottom: none;
}

.cart-item-image {
    width: 80px;
    height: 80px;
    border-radius: 8px;
    overflow: hidden;
    margin-right: 20px;
    flex-shrink: 0;
}

.cart-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cart-item-image .no-image {
    width: 100%;
    height: 100%;
    background: var(--bg-light);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-gray);
    font-size: 24px;
}

.cart-item-info {
    flex: 1;
    min-width: 0;
}

.cart-item-info h4 {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 5px;
    color: var(--text-light);
}

.cart-item-weight {
    color: var(--text-gray);
    font-size: 14px;
    margin: 0;
}

.cart-item-price-single {
    color: #AD1C43;
    font-size: 14px;
    margin: 5px 0 0 0;
    font-weight: 600;
}

.cart-item-quantity {
    display: flex;
    align-items: center;
    margin: 0 30px;
}

.quantity-btn {
    width: 32px;
    height: 32px;
    border: 1px solid var(--border);
    background: var(--bg-dark);
    color: var(--text-light);
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.quantity-btn:hover {
    border-color: #AD1C43;
    color: #AD1C43;
}

.quantity-input {
    width: 50px;
    height: 32px;
    text-align: center;
    border: 1px solid var(--border);
    background: var(--bg-dark);
    color: var(--text-light);
    border-radius: 4px;
    margin: 0 5px;
    -moz-appearance: textfield;
}

.quantity-input::-webkit-outer-spin-button,
.quantity-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.cart-item-total {
    text-align: right;
    min-width: 100px;
    margin: 0 30px;
}

.cart-item-total .item-total-price {
    display: block;
    font-size: 18px;
    font-weight: 700;
    color: #AD1C43;
}

.cart-item-remove {
    background: none;
    border: none;
    color: var(--text-gray);
    font-size: 18px;
    cursor: pointer;
    padding: 5px;
    transition: color 0.3s ease;
}

.cart-item-remove:hover {
    color: #ff4444;
}

.order-summary {
    background: var(--bg-card);
    border-radius: 16px;
    padding: 30px;
    border: 1px solid var(--border);
    position: sticky;
    top: 100px;
}

.summary-title {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 25px;
    color: var(--text-light);
    border-bottom: 2px solid #AD1C43;
    padding-bottom: 15px;
}

.section-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 15px;
    color: var(--text-light);
}

/* Стили для способов получения */
.delivery-section {
    margin-bottom: 25px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--border);
}

.delivery-options {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
}

.delivery-option {
    flex: 1;
}

.delivery-radio {
    display: none;
}

.delivery-label {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 12px;
    background: var(--bg-light);
    border: 1px solid var(--border);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    color: var(--text-light);
}

.delivery-radio:checked + .delivery-label {
    background: #AD1C43;
    border-color: #AD1C43;
    color: var(--bg-dark);
}

.delivery-label i {
    font-size: 20px;
}

.address-row {
    display: flex;
    gap: 15px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group.half {
    flex: 1;
}

.form-label {
    display: block;
    margin-bottom: 6px;
    font-weight: 500;
    color: var(--text-light);
    font-size: 14px;
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    background: var(--bg-light);
    border: 1px solid var(--border);
    border-radius: 8px;
    color: var(--text-light);
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: #AD1C43;
    box-shadow: 0 0 0 2px rgba(201, 168, 106, 0.2);
}

.form-control::placeholder {
    color: var(--text-gray);
    opacity: 0.7;
}

textarea.form-control {
    resize: vertical;
    min-height: 80px;
}

/* Стили для самовывоза */
.pickup-info {
    display: flex;
    gap: 20px;
    padding: 20px;
    background: var(--bg-light);
    border-radius: 8px;
    border: 1px solid var(--border);
}

.pickup-icon {
    font-size: 32px;
    color: #AD1C43;
}

.pickup-details h5 {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 8px;
    color: var(--text-light);
}

.pickup-details p {
    color: var(--text-gray);
    margin-bottom: 5px;
    font-size: 14px;
}

.pickup-hours i,
.pickup-phone i {
    margin-right: 5px;
    color: #AD1C43;
}

/* Стили для способов оплаты */
.payment-section {
    margin-bottom: 25px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--border);
}

.payment-options {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.payment-option {
    width: 100%;
}

.payment-radio {
    display: none;
}

.payment-label {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: var(--bg-light);
    border: 1px solid var(--border);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.payment-radio:checked + .payment-label {
    background: rgba(126, 48, 69, 0.38);
    border-color: #AD1C43;
}

.payment-label i {
    font-size: 24px;
    color: #AD1C43;
}

.payment-info {
    display: flex;
    flex-direction: column;
}

.payment-title {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-light);
}

.payment-desc {
    font-size: 13px;
    color: var(--text-gray);
}

/* Итоговая сумма */
.summary-details {
    margin-bottom: 20px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
    font-size: 16px;
    color: var(--text-light);
}

.summary-divider {
    height: 1px;
    background: var(--border);
    margin: 15px 0;
}

.summary-row.total-row {
    font-size: 20px;
    font-weight: 700;
}

.summary-row.total-row .total-amount {
    color: #AD1C43;
    font-size: 24px;
}

.btn-checkout {
    display: block;
    width: 100%;
    padding: 16px;
    text-align: center;
    font-size: 18px;
    font-weight: 600;
    margin-top: 10px;
}

.continue-shopping {
    text-align: center;
    padding-top: 20px;
    border-top: 1px solid var(--border);
}

.btn-link {
    color: #AD1C43;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    transition: color 0.3s ease;
}

.btn-link:hover {
    color: var(--accent-light);
}

.empty-cart,
.auth-required {
    text-align: center;
    padding: 80px 20px;
    background: var(--bg-card);
    border-radius: 16px;
    border: 1px solid var(--border);
}

.empty-cart-icon {
    font-size: 80px;
    color: var(--text-gray);
    margin-bottom: 30px;
}

.empty-cart h2,
.auth-required h2 {
    font-size: 32px;
    margin-bottom: 15px;
    color: var(--text-light);
}

.empty-cart p,
.auth-required p {
    color: var(--text-gray);
    margin-bottom: 30px;
    font-size: 18px;
}

/* Адаптивность */
@media (max-width: 992px) {
    .cart-item {
        flex-wrap: wrap;
        position: relative;
        padding: 15px 0;
    }
    
    .cart-item-image {
        width: 60px;
        height: 60px;
        margin-right: 15px;
    }
    
    .cart-item-quantity {
        order: 3;
        margin: 15px 0 0 0;
        width: 100%;
        justify-content: center;
    }
    
    .cart-item-total {
        order: 2;
        margin-left: auto;
        min-width: auto;
    }
    
    .cart-item-remove {
        position: absolute;
        top: 15px;
        right: 0;
    }
    
    .order-summary {
        margin-top: 30px;
    }
}

@media (max-width: 576px) {
    .page-title {
        font-size: 36px;
    }
    
    .delivery-options {
        flex-direction: column;
        gap: 10px;
    }
    
    .address-row {
        flex-direction: column;
        gap: 0;
    }
    
    .pickup-info {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .empty-cart h2 {
        font-size: 24px;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Переключение между доставкой и самовывозом
    const deliveryRadio = document.getElementById('delivery');
    const pickupRadio = document.getElementById('pickup');
    const deliveryBlock = document.getElementById('delivery-block');
    const pickupBlock = document.getElementById('pickup-block');
    
    if (deliveryRadio && pickupRadio) {
        deliveryRadio.addEventListener('change', function() {
            if (this.checked) {
                deliveryBlock.style.display = 'block';
                pickupBlock.style.display = 'none';
                
                // Делаем поля доставки обязательными
                document.getElementById('street').required = true;
                document.getElementById('house').required = true;
            }
        });
        
        pickupRadio.addEventListener('change', function() {
            if (this.checked) {
                deliveryBlock.style.display = 'none';
                pickupBlock.style.display = 'block';
                
                // Убираем обязательность полей доставки
                document.getElementById('street').required = false;
                document.getElementById('house').required = false;
            }
        });
    }
    
    // Обработчики для кнопок изменения количества
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const action = this.dataset.action;
            const itemId = this.dataset.itemId;
            const input = document.querySelector(`.quantity-input[data-item-id="${itemId}"]`);
            let quantity = parseInt(input.value);
            
            if (action === 'increase' && quantity < 10) {
                quantity++;
            } else if (action === 'decrease' && quantity > 1) {
                quantity--;
            }
            
            input.value = quantity;
            updateCartItem(itemId, quantity);
        });
    });
    
    // Обработчик изменения значения в поле ввода
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const itemId = this.dataset.itemId;
            const quantity = this.value;
            updateCartItem(itemId, quantity);
        });
    });
    
    // Обработчики для кнопок удаления
    document.querySelectorAll('.cart-item-remove').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            removeCartItem(itemId);
        });
    });
    
    // Функция обновления количества товара
    function updateCartItem(itemId, quantity) {
        fetch(`/cart/update/${itemId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = document.querySelector(`[data-item-id="${itemId}"]`);
                if (item) {
                    const itemTotal = item.querySelector('.item-total-price');
                    if (itemTotal) {
                        itemTotal.textContent = data.item_total.toLocaleString('ru-RU') + ' ₽';
                    }
                }
                
                const totalAmount = document.querySelector('.total-amount');
                if (totalAmount) {
                    totalAmount.textContent = data.total.toLocaleString('ru-RU') + ' ₽';
                }
                
                updateCartCounter();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Ошибка при обновлении корзины', 'error');
        });
    }
    
    // Функция удаления товара
    function removeCartItem(itemId) {
        if (!confirm('Удалить товар из корзины?')) return;
        
        fetch(`/cart/remove/${itemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = document.querySelector(`[data-item-id="${itemId}"]`);
                if (item) {
                    item.remove();
                }
                
                const totalAmount = document.querySelector('.total-amount');
                if (totalAmount) {
                    totalAmount.textContent = data.total.toLocaleString('ru-RU') + ' ₽';
                }
                
                const cartItems = document.querySelectorAll('.cart-item');
                if (cartItems.length === 0) {
                    location.reload();
                }
                
                updateCartCounter();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Ошибка при удалении товара', 'error');
        });
    }
    
    // Функция обновления счетчика корзины
    function updateCartCounter() {
        fetch('/cart/count')
            .then(response => response.json())
            .then(data => {
                let badge = document.querySelector('.cart-count-badge');
                const cartCounter = document.querySelector('.cart-counter');
                
                if (!badge && cartCounter) {
                    badge = document.createElement('span');
                    badge.className = 'cart-count-badge';
                    cartCounter.appendChild(badge);
                }
                
                if (badge) {
                    badge.textContent = data.count;
                    badge.style.display = data.count > 0 ? 'flex' : 'none';
                }
            })
            .catch(error => console.error('Error updating cart counter:', error));
    }
    
    // Функция для показа уведомлений
    function showNotification(message, type = 'success') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} position-fixed top-20 start-50 translate-middle-x`;
        alertDiv.style.zIndex = '9999';
        alertDiv.style.minWidth = '300px';
        alertDiv.style.padding = '15px 20px';
        alertDiv.style.borderRadius = '8px';
        alertDiv.style.textAlign = 'center';
        alertDiv.style.backgroundColor = type === 'success' ? '#4CAF50' : type === 'error' ? '#dc3545' : '#ffc107';
        alertDiv.style.color = type === 'warning' ? 'black' : 'white';
        alertDiv.style.border = 'none';
        alertDiv.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
        alertDiv.textContent = message;
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 3000);
    }
    
    // Обработка формы оформления заказа
    const checkoutForm = document.getElementById('checkout-form');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            const deliveryType = document.querySelector('input[name="delivery_type"]:checked').value;
            
            if (deliveryType === 'delivery') {
                const street = document.getElementById('street');
                const house = document.getElementById('house');
                
                if (!street.value.trim()) {
                    e.preventDefault();
                    street.focus();
                    showNotification('Пожалуйста, введите улицу', 'error');
                    return;
                }
                
                if (!house.value.trim()) {
                    e.preventDefault();
                    house.focus();
                    showNotification('Пожалуйста, введите номер дома', 'error');
                    return;
                }
            }
        });
    }
    
    // Инициализация счетчика при загрузке страницы
    updateCartCounter();
});
</script>
@endpush
@endsection