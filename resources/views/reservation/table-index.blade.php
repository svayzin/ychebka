@extends('layouts.app')

@section('title', 'Мои бронирования столиков')

@section('content')
<div class="reservations-page">
    <div class="container-exact">
        <h1 class="page-title">Мои бронирования столиков</h1>

        @if(session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mb-4">{{ session('error') }}</div>
        @endif

        @if($reservations->count() > 0)
            <div class="reservations-list">
                @foreach($reservations as $reservation)
                    <div class="reservation-card">
                        <div class="reservation-header">
                            <div class="reservation-id">
                                <strong>Бронь столика #{{ $reservation->id }}</strong>
                                @if($reservation->cancelled)
                                    <span class="badge badge-warning">Отменена</span>
                                @elseif($reservation->start_at->isPast())
                                    <span class="badge badge-success">Завершена</span>
                                @else
                                    <span class="badge badge-success">Активна</span>
                                @endif
                            </div>
                            <div class="reservation-date">
                                Создано: {{ $reservation->created_at->format('d.m.Y H:i') }}
                            </div>
                        </div>

                        <div class="reservation-details">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <strong>Столик:</strong>
                                        №{{ optional($reservation->table)->number ?? '—' }}
                                    </div>
                                    <div class="detail-item">
                                        <strong>Гостей:</strong>
                                        {{ $reservation->guests_count }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <strong>Дата:</strong>
                                        {{ $reservation->start_at->format('d.m.Y') }}
                                    </div>
                                    <div class="detail-item">
                                        <strong>Время:</strong>
                                        {{ $reservation->start_at->format('H:i') }}
                                        – {{ $reservation->end_at->format('H:i') }}
                                    </div>
                                    <div class="detail-item">
                                        <strong>Депозит:</strong>
                                        {{ number_format($reservation->deposit_total, 0, ',', ' ') }} ₽
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{ $reservations->links() }}
            </div>
        @else
            <div class="empty-reservations text-center py-5">
                <div class="empty-icon mb-3">
                    <i class="bi bi-calendar-x" style="font-size: 48px; color: #b0b0b0;"></i>
                </div>
                <h3>У вас пока нет бронирований столиков</h3>
                <p class="empty-text">Забронируйте столик на странице бронирования.</p>
                <a href="{{ route('booking.index') }}" class="btn-exact mt-3">
                    Перейти к бронированию
                </a>
            </div>
        @endif
    </div>
</div>

{{-- можно переиспользовать стили из reservation/index.blade.php --}}
<style>
.reservations-page {
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
.reservation-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 20px;
}
.reservation-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid var(--border);
}
.reservation-id {
    font-size: 18px;
    color: var(--text-light);
}
.badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    margin-left: 10px;
}
.badge-success {
    background: #28a745;
    color: white;
}
.badge-warning {
    background: #ffc107;
    color: black;
}
.reservation-details {
    margin-bottom: 10px;
}
.detail-item {
    margin-bottom: 8px;
    color: var(--text-light);
}
.detail-item strong {
    color: #AD1C43;
    margin-right: 5px;
    min-width: 90px;
    display: inline-block;
}
.empty-reservations {
    background: var(--bg-card);
    border-radius: 12px;
    padding: 80px 20px;
    border: 1px solid var(--border);
}
.empty-reservations h3 {
    font-size: 28px;
    color: var(--text-light);
    margin-bottom: 15px;
}
.empty-text {
    font-size: 18px;
    color: #b0b0b0;
    font-weight: 500;
}
</style>
@endsection