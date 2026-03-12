@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="order-details-card">
        <div class="order-header">
            <h1 class="section-title-exact">Заказ #{{ $order->id }}</h1>
            <div class="order-status status-{{ $order->status }}">
                @switch($order->status)
                    @case('new')
                        Новый
                        @break
                    @case('cancelled')
                        Отменен
                        @break
                    @default
                        {{ $order->status }}
                @endswitch
            </div>
        </div>
        
        <div class="order-info-grid">
            <div class="info-section">
                <h3 class="info-title">Информация о заказе</h3>
                <div class="info-row">
                    <span class="info-label">Дата:</span>
                    <span class="info-value">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Сумма:</span>
                    <span class="info-value price">{{ number_format($order->total) }} ₽</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Способ оплаты:</span>
                    <span class="info-value">
                        @switch($order->payment_method)
                            @case('cash')
                                Наличными
                                @break
                            @case('card')
                                Картой
                                @break
                            @case('online')
                                Онлайн
                                @break
                            @default
                                {{ $order->payment_method }}
                        @endswitch
                    </span>
                </div>
            </div>
            
            <div class="info-section">
                <h3 class="info-title">Доставка</h3>
                <div class="info-row">
                    <span class="info-label">Адрес:</span>
                    <span class="info-value">{{ $order->delivery_address }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Получатель:</span>
                    <span class="info-value">{{ $order->customer_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Телефон:</span>
                    <span class="info-value">{{ $order->customer_phone }}</span>
                </div>
                @if($order->customer_email)
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $order->customer_email }}</span>
                </div>
                @endif
            </div>
        </div>
        
        @if($order->comment)
        <div class="comment-section">
            <h3 class="info-title">Комментарий к заказу</h3>
            <p class="comment-text">{{ $order->comment }}</p>
        </div>
        @endif
        
        <div class="order-items-section">
            <h3 class="info-title">Состав заказа</h3>
            <div class="order-items-list">
                @foreach($order->items as $item)
                <div class="order-item">
                    <div class="item-info">
                        <span class="item-name">{{ $item->product_name }}</span>
                        @if($item->weight)
                        <span class="item-weight">{{ $item->weight }}</span>
                        @endif
                    </div>
                    <div class="item-quantity">{{ $item->quantity }} ×</div>
                    <div class="item-price">{{ number_format($item->price) }} ₽</div>
                    <div class="item-total">{{ number_format($item->price * $item->quantity) }} ₽</div>
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="order-actions">
            @if($order->status === 'new')
            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-cancel-order" onclick="return confirm('Отменить заказ?')">
                    Отменить заказ
                </button>
            </form>
            @endif
            
            <a href="{{ route('orders.index') }}" class="btn-back">
                ← Назад к списку заказов
            </a>
        </div>
    </div>
</div>

<style>
.order-details-card {
    background: #1a1a1a;
    border-radius: 16px;
    padding: 40px;
    margin-bottom: 40px;
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
    padding-bottom: 20px;
    border-bottom: 1px solid #333;
}

.order-status {
    padding: 8px 20px;
    border-radius: 30px;
    font-size: 16px;
    font-weight: 600;
}

.status-new {
    background: rgba(76, 175, 80, 0.15);
    color: #4CAF50;
    border: 1px solid rgba(76, 175, 80, 0.3);
}

.status-cancelled {
    background: rgba(244, 67, 54, 0.15);
    color: #F44336;
    border: 1px solid rgba(244, 67, 54, 0.3);
}

.order-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    margin-bottom: 40px;
}

.info-section {
    background: #242424;
    border-radius: 12px;
    padding: 25px;
}

.info-title {
    color: #AD1C43;
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #333;
}

.info-row {
    display: flex;
    margin-bottom: 12px;
}

.info-label {
    width: 120px;
    color: #999;
    font-size: 15px;
}

.info-value {
    color: #fff;
    font-size: 15px;
    flex: 1;
}

.info-value.price {
    color: #AD1C43;
    font-weight: 700;
    font-size: 18px;
}

.comment-section {
    background: #242424;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 40px;
}

.comment-text {
    color: #fff;
    font-size: 16px;
    line-height: 1.6;
    margin: 0;
}

.order-items-section {
    background: #242424;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 40px;
}

.order-items-list {
    margin-top: 20px;
}

.order-item {
    display: grid;
    grid-template-columns: 2fr 0.5fr 0.8fr 0.8fr;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #333;
}

.order-item:last-child {
    border-bottom: none;
}

.item-name {
    color: #fff;
    font-size: 16px;
    font-weight: 500;
    display: block;
    margin-bottom: 4px;
}

.item-weight {
    color: #999;
    font-size: 13px;
}

.item-quantity {
    color: #AD1C43;
    font-size: 15px;
}

.item-price {
    color: #999;
    font-size: 15px;
}

.item-total {
    color: #fff;
    font-size: 16px;
    font-weight: 600;
}

.order-actions {
    display: flex;
    gap: 20px;
    justify-content: flex-end;
}

.btn-cancel-order {
    padding: 12px 30px;
    background: transparent;
    color: #F44336;
    border: 2px solid #F44336;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-cancel-order:hover {
    background: #F44336;
    color: #fff;
}

.btn-back {
    padding: 12px 30px;
    background: transparent;
    color: #fff;
    border: 2px solid #666;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-back:hover {
    border-color: #AD1C43;
    color: #AD1C43;
}

@media (max-width: 768px) {
    .order-details-card {
        padding: 25px;
    }
    
    .order-info-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .order-item {
        grid-template-columns: 1fr;
        gap: 10px;
    }
    
    .order-actions {
        flex-direction: column;
    }
}
</style>
@endsection