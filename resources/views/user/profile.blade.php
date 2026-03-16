@extends('layouts.app')

@section('title', 'Мой профиль - Crimson Flame')

@section('content')
<div class="profile-page">
    <div class="container-exact">
        <h1 class="page-title">Мой профиль</h1>
        
        @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
        @endif
        
        @if(session('error'))
        <div class="alert alert-danger mb-4">
            {{ session('error') }}
        </div>
        @endif
        
        <div class="row">
            <!-- Левая колонка - Информация о пользователе -->
            <div class="col-lg-4 mb-4">
                <div class="profile-card">
                    <div class="profile-header">
                        <div class="profile-avatar">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <h3 class="profile-name">{{ Auth::user()->full_name }}</h3>
                        <p class="profile-email">{{ Auth::user()->email }}</p>
                    </div>
                    
                    <div class="profile-stats">
                        <div class="stat-item">
                            <span class="stat-label">Заказов:</span>
                            <span class="stat-value">{{ $orders->count() ?? 0 }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Бронирований:</span>
                            <span class="stat-value">{{ $reservations->count() ?? 0 }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">В корзине:</span>
                            <span class="stat-value">{{ $cartCount ?? 0 }}</span>
                        </div>
                    </div>
                    
                    <div class="profile-actions">
                        <a href="{{ route('orders.index') }}" class="btn-exact-outline w-100 mb-2">
                            <i class="bi bi-box"></i> Мои заказы
                        </a>
                        <a href="{{ route('table-reservations.index') }}" class="btn-exact-outline w-100 mb-2">
                            <i class="bi bi-calendar-check me-2"></i> Мои бронирования
                        </a>
                        <a href="{{ route('cart.index') }}" class="btn-exact-outline w-100">
                            <i class="bi bi-cart"></i> Корзина
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Правая колонка - Редактирование профиля и 2FA -->
            <div class="col-lg-8">
                <!-- Форма редактирования профиля -->
                <div class="profile-card mb-4">
                    <h3 class="card-title">Редактировать профиль</h3>
                    
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="full_name" class="form-label">ФИО</label>
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                       id="full_name" name="full_name" value="{{ old('full_name', Auth::user()->full_name) }}" required>
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label for="phone" class="form-label">Телефон</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}" 
                                       placeholder="+7 (999) 123-45-67" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <button type="submit" class="btn-exact">
                            <i class="bi bi-check-circle"></i> Сохранить изменения
                        </button>
                    </form>
                </div>
                
                <!-- Последние заказы -->
                @if(isset($orders) && $orders->count() > 0)
                <div class="profile-card mt-4">
                    <h3 class="card-title">Последние заказы</h3>
                    
                    <div class="recent-orders">
                        @foreach($orders->take(3) as $order)
                        <div class="order-item">
                            <div class="order-info">
                                <span class="order-id">Заказ #{{ $order->id }}</span>
                                <span class="order-date">{{ $order->created_at->format('d.m.Y') }}</span>
                            </div>
                            <div class="order-status status-{{ $order->status }}">
                                {{ $order->status_text }}
                            </div>
                            <div class="order-total">{{ $order->formatted_total }}</div>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn-link">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    
                    <a href="{{ route('orders.index') }}" class="btn-link mt-3">
                        Все заказы <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                @endif
                
                <!-- Последние бронирования -->
                @if(isset($reservations) && $reservations->count() > 0)
                <div class="profile-card mt-4">
                    <h3 class="card-title">Последние бронирования</h3>
                    
                    <div class="recent-reservations">
                        @foreach($reservations->take(3) as $reservation)
                        <div class="reservation-item">
                            <div class="reservation-info">
                                <span class="reservation-date">{{ $reservation->start_at->format('d.m.Y') }}</span>
                                <span class="reservation-time">{{ $reservation->start_at->format('H:i') }} – {{ $reservation->end_at->format('H:i') }}</span>
                                <span class="reservation-guests">{{ $reservation->guests_count }} чел.</span>
                                @if($reservation->table)
                                <span class="reservation-table">Столик №{{ $reservation->table->number }}</span>
                                @endif
                            </div>
                            <div class="reservation-status {{ $reservation->cancelled ? 'cancelled' : ($reservation->end_at->isPast() ? 'past' : 'confirmed') }}">
                                @if($reservation->cancelled) Отменено @elseif($reservation->end_at->isPast()) Завершено @else Подтверждено @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <a href="{{ route('table-reservations.index') }}" class="btn-link mt-3">
                        <i class="bi bi-calendar-check me-1"></i> Перейти к моим бронированиям
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.profile-page {
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

.profile-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 30px;
    transition: all 0.3s ease;
}

.profile-card:hover {
    border-color: #AD1C43;
}

.card-title {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 25px;
    color: var(--text-light);
    padding-bottom: 15px;
    border-bottom: 2px solid #AD1C43;
    display: flex;
    align-items: center;
    gap: 10px;
}

.card-title i {
    color: #AD1C43;
}

/* Левая колонка - профиль */
.profile-header {
    text-align: center;
    margin-bottom: 25px;
}

.profile-avatar {
    font-size: 80px;
    color: #AD1C43;
    margin-bottom: 15px;
}

.profile-name {
    font-size: 24px;
    font-weight: 600;
    color: var(--text-light);
    margin-bottom: 5px;
}

.profile-email {
    color: var(--text-gray);
    font-size: 16px;
}

.profile-stats {
    display: flex;
    justify-content: space-around;
    margin-bottom: 25px;
    padding: 20px 0;
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
}

.stat-item {
    text-align: center;
}

.stat-label {
    display: block;
    color: var(--text-gray);
    font-size: 14px;
    margin-bottom: 5px;
}

.stat-value {
    font-size: 24px;
    font-weight: 700;
    color: #AD1C43;
}

.profile-actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

/* Формы */
.form-label {
    color: var(--text-light);
    font-weight: 500;
    margin-bottom: 8px;
}

.form-control {
    background: var(--bg-light);
    border: 1px solid var(--border);
    color: var(--text-light);
    padding: 12px 15px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.form-control:focus {
    background: var(--bg-card);
    border-color: #AD1C43;
    color: var(--text-light);
    box-shadow: 0 0 0 3px rgba(201, 168, 106, 0.2);
}

.alert {
    padding: 15px 20px;
    border-radius: 8px;
    border: none;
    margin-bottom: 20px;
}

.alert-success {
    background: rgba(40, 167, 69, 0.15);
    color: #28a745;
    border: 1px solid rgba(40, 167, 69, 0.3);
}

.alert-info {
    background: rgba(23, 162, 184, 0.15);
    color: #17a2b8;
    border: 1px solid rgba(23, 162, 184, 0.3);
}

.alert-warning {
    background: rgba(255, 193, 7, 0.15);
    color: #ffc107;
    border: 1px solid rgba(255, 193, 7, 0.3);
}

.alert i {
    margin-right: 8px;
}

/* Кнопки */
.btn-exact {
    background: #AD1C43;
    color: var(--bg-dark);
    border: none;
    padding: 12px 30px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-exact:hover {
    background: var(--accent-light);
    transform: translateY(-2px);
}

.btn-exact-outline {
    background: transparent;
    color: var(--text-light);
    border: 1px solid var(--border);
    padding: 12px 30px;
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-exact-outline:hover {
    border-color: #AD1C43;
    color: #AD1C43;
}

.btn-link {
    color: #AD1C43;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: color 0.3s ease;
}

.btn-link:hover {
    color: var(--accent-light);
}

/* Последние заказы */
.recent-orders {
    margin-bottom: 15px;
}

.order-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 0;
    border-bottom: 1px solid var(--border);
}

.order-item:last-child {
    border-bottom: none;
}

.order-info {
    flex: 2;
}

.order-id {
    display: block;
    font-weight: 600;
    color: var(--text-light);
    margin-bottom: 3px;
}

.order-date {
    color: var(--text-gray);
    font-size: 13px;
}

.order-status {
    flex: 1;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
    text-align: center;
}

.status-pending {
    background: rgba(255, 193, 7, 0.15);
    color: #ffc107;
}

.status-processing {
    background: rgba(23, 162, 184, 0.15);
    color: #17a2b8;
}

.status-completed {
    background: rgba(40, 167, 69, 0.15);
    color: #28a745;
}

.status-cancelled {
    background: rgba(220, 53, 69, 0.15);
    color: #dc3545;
}

.order-total {
    flex: 0.5;
    text-align: right;
    font-weight: 600;
    color: #AD1C43;
    margin-right: 15px;
}

/* Последние бронирования */
.recent-reservations {
    margin-bottom: 15px;
}

.reservation-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 0;
    border-bottom: 1px solid var(--border);
}

.reservation-item:last-child {
    border-bottom: none;
}

.reservation-info {
    display: flex;
    gap: 15px;
    align-items: center;
}

.reservation-date {
    font-weight: 600;
    color: var(--text-light);
}

.reservation-time {
    color: #AD1C43;
    font-weight: 500;
}

.reservation-guests {
    color: var(--text-gray);
    font-size: 14px;
}

.reservation-status {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
}

.reservation-status.confirmed {
    background: rgba(40, 167, 69, 0.15);
    color: #28a745;
}

.reservation-status.pending {
    background: rgba(255, 193, 7, 0.15);
    color: #ffc107;
}

.reservation-status.cancelled {
    background: rgba(220, 53, 69, 0.15);
    color: #dc3545;
}

.reservation-status.past {
    background: rgba(108, 117, 125, 0.15);
    color: #6c757d;
}

.reservation-table {
    color: var(--text-gray);
    font-size: 13px;
}

/* Адаптивность */
@media (max-width: 768px) {
    .profile-page {
        padding: 40px 0;
    }
    
    .page-title {
        font-size: 36px;
    }
    
    .profile-card {
        padding: 20px;
    }
    
    .order-item {
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .order-info {
        flex: 100%;
    }
    
    .order-status,
    .order-total {
        flex: auto;
    }
    
    .reservation-info {
        flex-wrap: wrap;
        gap: 8px;
    }
}
</style>
@endsection