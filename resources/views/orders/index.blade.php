@extends('layouts.app')

@section('title', 'Мои заказы - Созвездие вкусов')

@section('content')
<div class="orders-page">
    <div class="container-exact">
        <h1 class="page-title">Мои заказы</h1>
        
        @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
        @endif
        
        @if($orders->count() > 0)
        <div class="orders-list">
            @foreach($orders as $order)
            <div class="order-card">
                <div class="order-header">
                    <div class="order-id">
                        <strong>Заказ #{{ $order->id }}</strong>
                        <span class="badge badge-{{ $order->status_color }}">
                            {{ $order->status_text }}
                        </span>
                    </div>
                    <div class="order-date">
                        {{ $order->created_at->format('d.m.Y H:i') }}
                    </div>
                </div>
                
                <div class="order-details">
                    <div class="detail-item">
                        <strong>Адрес доставки:</strong> {{ $order->address }}
                    </div>
                    <div class="detail-item">
                        <strong>Сумма:</strong> {{ $order->formatted_total }}
                    </div>
                    @if($order->notes)
                    <div class="detail-item">
                        <strong>Комментарий:</strong> {{ $order->notes }}
                    </div>
                    @endif
                </div>
                
                <div class="order-items">
                    <h5>Состав заказа:</h5>
                    <ul>
                        @foreach($order->items as $item)
                        <li>
                            {{ $item->product->name }} × {{ $item->quantity }}
                            <span class="item-total">{{ $item->formatted_total }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                
                <div class="order-actions">
                    <a href="{{ route('orders.show', $order->id) }}" 
                       class="btn-exact-outline btn-sm">
                        Подробнее
                    </a>
                </div>
            </div>
            @endforeach
            
            {{ $orders->links() }}
        </div>
        @else
        <div class="empty-orders text-center py-5">
            <div class="empty-icon mb-3">
                <i class="bi bi-receipt" style="font-size: 48px; color: #b0b0b0;"></i>
            </div>
            <h3>У вас пока нет заказов</h3>
            <p class="empty-text">Сделайте заказ, чтобы он появился здесь</p>
            <a href="{{ route('menu') }}" class="btn-exact mt-3">
                Перейти в меню
            </a>
        </div>
        @endif
    </div>
</div>

<style>
.orders-page {
    background: var(--bg-dark);
    min-height: 100vh;
    padding: 60px 0;
}

.page-title {
    font-size: 48px;
    font-weight: 700;
    margin-bottom: 40px;
    color: var(--text-light);
    font-family: "Yeseva One", serif;
}

.order-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 20px;
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid var(--border);
}

.order-id {
    font-size: 18px;
    color: var(--text-light);
}

.badge-warning {
    background: #ffc107;
    color: black;
}

.badge-info {
    background: #17a2b8;
    color: white;
}

.badge-success {
    background: #28a745;
    color: white;
}

.badge-danger {
    background: #dc3545;
    color: white;
}

.order-date {
    color: var(--text-gray);
}

.order-details {
    margin-bottom: 20px;
}

.detail-item {
    margin-bottom: 10px;
    color: var(--text-light);
}

.detail-item strong {
    color: #AD1C43;
    margin-right: 5px;
}

.order-items {
    background: var(--bg-light);
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.order-items h5 {
    color: var(--text-light);
    margin-bottom: 10px;
}

.order-items ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.order-items li {
    display: flex;
    justify-content: space-between;
    padding: 5px 0;
    color: var(--text-light);
    border-bottom: 1px solid var(--border);
}

.order-items li:last-child {
    border-bottom: none;
}

.item-total {
    color: #AD1C43;
    font-weight: 600;
}

.order-actions {
    padding-top: 15px;
    border-top: 1px solid var(--border);
}

.empty-orders {
    background: var(--bg-card);
    border-radius: 12px;
    padding: 80px 20px;
    border: 1px solid var(--border);
}

.empty-orders h3 {
    font-size: 28px;
    color: var(--text-light);
    margin-bottom: 15px;
}

/* ИЗМЕНЕНИЕ ЦВЕТА ТЕКСТА */
.empty-text {
    font-size: 18px;
    color: #b0b0b0;
    font-weight: 500;
}

@media (max-width: 768px) {
    .order-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}
</style>
@endsection