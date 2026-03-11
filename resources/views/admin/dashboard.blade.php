{{-- resources/views/admin/dashboard.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Панель управления')
@section('page-title', 'Панель управления')

@section('content')
<!-- Быстрые действия -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex gap-3 flex-wrap">
            <a href="{{ route('admin.reservations') }}" class="btn-exact">
                <i class="bi bi-calendar-check me-2"></i> Бронирования
            </a>
            <a href="{{ route('admin.orders') }}" class="btn-exact">
                <i class="bi bi-cart me-2"></i> Заказы
            </a>
            <a href="{{ route('admin.categories.create') }}" class="btn-exact">
                <i class="bi bi-plus-circle me-2"></i> Новая категория
            </a>
            <a href="{{ route('admin.products.create') }}" class="btn-exact">
                <i class="bi bi-plus-circle me-2"></i> Новое блюдо
            </a>
        </div>
    </div>
</div>

<!-- Статистика -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div class="stat-title">Всего броней</div>
            <div class="stat-value">{{ $stats['total_reservations'] }}</div>
            <div class="stat-change">
                <span class="text-success">
                    <i class="bi bi-arrow-up"></i> {{ $stats['today_reservations'] }} сегодня
                </span>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="stat-icon warning">
                <i class="bi bi-clock-history"></i>
            </div>
            <div class="stat-title">Ожидают подтверждения</div>
            <div class="stat-value">{{ $stats['pending_reservations'] }}</div>
            <div class="stat-change">
                @if($stats['pending_reservations'] > 0)
                <span class="text-warning">Требуют внимания</span>
                @else
                <span class="text-success">Все обработаны</span>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="bi bi-cart-check"></i>
            </div>
            <div class="stat-title">Всего заказов</div>
            <div class="stat-value">{{ $stats['total_orders'] }}</div>
            <div class="stat-change">
                <span class="text-warning">
                    {{ $stats['pending_orders'] }} ожидают обработки
                </span>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="stat-icon info">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-title">Пользователей</div>
            <div class="stat-value">{{ $stats['total_users'] }}</div>
            <div class="stat-change">
                <span class="text-success">Активные клиенты</span>
            </div>
        </div>
    </div>
</div>

<!-- Последние брони -->
<div class="admin-table mb-4">
    <div class="table-header">
        <h2 class="table-title">Последние бронирования</h2>
        <a href="{{ route('admin.reservations') }}" class="btn-outline-exact btn-sm">
            <i class="bi bi-arrow-right"></i> Все брони
        </a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Телефон</th>
                    <th>Дата и время</th>
                    <th>Гости</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $reservation)
                <tr>
                    <td><strong>#{{ $reservation->id }}</strong></td>
                    <td>{{ $reservation->name }}</td>
                    <td>{{ $reservation->phone }}</td>
                    <td>
                        {{ $reservation->date->format('d.m.Y') }}
                        <span class="text-muted">в</span>
                        {{ $reservation->time }}
                    </td>
                    <td>{{ $reservation->guests }}</td>
                    <td>
                        @if($reservation->confirmed)
                        <span class="badge-admin badge-success">Подтверждена</span>
                        @else
                        <span class="badge-admin badge-warning">Ожидает</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="bi bi-calendar-x" style="font-size: 48px;"></i>
                        <p class="mt-2">Нет бронирований</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Быстрые ссылки -->
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="stat-card">
            <h4 class="mb-3"><i class="bi bi-list-ul me-2"></i> Управление меню</h4>
            <div class="d-flex flex-column gap-2">
                <a href="{{ route('admin.categories') }}" class="btn-outline-exact text-start">
                    <i class="bi bi-folder me-2"></i> Все категории
                </a>
                <a href="{{ route('admin.products') }}" class="btn-outline-exact text-start">
                    <i class="bi bi-egg-fried me-2"></i> Все блюда
                </a>
                <a href="{{ route('admin.gallery') }}" class="btn-outline-exact text-start">
                    <i class="bi bi-images me-2"></i> Галерея
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="stat-card">
            <h4 class="mb-3"><i class="bi bi-gear me-2"></i> Быстрые действия</h4>
            <div class="d-flex flex-column gap-2">
                <a href="{{ route('admin.categories.create') }}" class="btn-exact text-start">
                    <i class="bi bi-plus-circle me-2"></i> Добавить категорию
                </a>
                <a href="{{ route('admin.products.create') }}" class="btn-exact text-start">
                    <i class="bi bi-plus-circle me-2"></i> Добавить блюдо
                </a>
                <a href="{{ route('admin.gallery') }}" class="btn-exact text-start">
                    <i class="bi bi-plus-circle me-2"></i> Добавить в галерею
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="stat-card">
            <h4 class="mb-3" style="color: var(--text-light);">
                <i class="bi bi-graph-up me-2"></i> Статистика за месяц
            </h4>
            <div class="text-center py-3">
                <div class="display-4 fw-bold" style="color: #ffffff;">{{ $stats['total_reservations'] }}</div>
                <p class="mb-0" style="color: var(--text-light); font-weight: 500;">Бронирований</p>
            </div>
            <div class="text-center py-3">
                <div class="display-4 fw-bold" style="color:  #ffffff;">{{ $stats['total_orders'] }}</div>
                <p class="mb-0" style="color: var(--text-light); font-weight: 500;">Заказов</p>
            </div>
        </div>
    </div>
</div>

<style>
/* Дополнительные стили для улучшения внешнего вида */
.stat-card .display-4 {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.stat-card p {
    font-size: 1.1rem;
    opacity: 0.9;
}

/* Обеспечим хорошую контрастность */
.text-light {
    color: #ffffff !important;
}

/* Если нужно сделать еще лучше, можно добавить тень тексту */
.stat-card .text-center p {
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Дополнительная подсветка заголовка секции */
.stat-card h4 {
    border-bottom: 2px solid var(--accent);
    padding-bottom: 10px;
    display: inline-block;
}
</style>
@endsection