@extends('layouts.app')

@section('title', 'Мои бронирования - Созвездие вкусов')

@section('content')
<div class="reservations-page">
    <div class="container-exact">
        <h1 class="page-title">Мои бронирования</h1>
        
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
        
        @if($reservations->count() > 0)
        <div class="reservations-list">
            @foreach($reservations as $reservation)
            <div class="reservation-card">
                <div class="reservation-header">
                    <div class="reservation-id">
                        <strong>Бронь #{{ $reservation->id }}</strong>
                        <span class="badge badge-{{ $reservation->confirmed ? 'success' : 'warning' }}">
                            {{ $reservation->confirmed ? 'Подтверждена' : 'Ожидает подтверждения' }}
                        </span>
                    </div>
                    <div class="reservation-date">
                        Создано: {{ $reservation->created_at->format('d.m.Y H:i') }}
                    </div>
                </div>
                
                <div class="reservation-details">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <strong>Имя:</strong> {{ $reservation->name }}
                            </div>
                            <div class="detail-item">
                                <strong>Телефон:</strong> {{ $reservation->phone }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <strong>Дата:</strong> {{ $reservation->date->format('d.m.Y') }}
                            </div>
                            <div class="detail-item">
                                <strong>Время:</strong> {{ $reservation->time }}
                            </div>
                            <div class="detail-item">
                                <strong>Гостей:</strong> {{ $reservation->guests }}
                            </div>
                        </div>
                    </div>
                    
                    @if($reservation->notes)
                    <div class="detail-item mt-3">
                        <strong>Комментарий:</strong> {{ $reservation->notes }}
                    </div>
                    @endif
                </div>
                
                <div class="reservation-actions">
                    @if(!$reservation->confirmed && $reservation->date > now())
                    <form action="{{ route('reservations.cancel', $reservation->id) }}" 
                          method="POST" 
                          onsubmit="return confirm('Отменить бронирование #{{ $reservation->id }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-exact-outline btn-sm">
                            <i class="bi bi-x-circle"></i> Отменить
                        </button>
                    </form>
                    @endif
                    
                    @if($reservation->confirmed)
                    <span class="text-success">
                        <i class="bi bi-check-circle"></i> Подтверждено администратором
                    </span>
                    @endif
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
            <h3>У вас пока нет бронирований</h3>
            <p class="empty-text">Забронируйте столик, чтобы он появился здесь</p>
            <a href="{{ route('home') }}#reservation" class="btn-exact mt-3">
                 Забронировать столик
            </a>
        </div>
        @endif
    </div>
</div>

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
    font-family: "Yeseva One", serif;
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

.reservation-date {
    color: var(--text-gray);
    font-size: 14px;
}

.reservation-details {
    margin-bottom: 20px;
}

.detail-item {
    margin-bottom: 10px;
    color: var(--text-light);
}

.detail-item strong {
    color: #AD1C43;
    margin-right: 5px;
    min-width: 80px;
    display: inline-block;
}

.reservation-actions {
    padding-top: 15px;
    border-top: 1px solid var(--border);
    display: flex;
    justify-content: space-between;
    align-items: center;
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

@media (max-width: 768px) {
    .reservation-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .reservation-actions {
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
    }
    
    .detail-item strong {
        min-width: 70px;
    }
}
</style>
@endsection