{{-- resources/views/admin/table-reservations/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Бронирования столиков')
@section('page-title', 'Бронирования столиков')

@section('content')
@if(session('success'))
    <div class="alert alert-success mb-3">{{ session('success') }}</div>
@endif

<div class="row mb-4">
    <div class="col-md-8">
        <form action="{{ route('admin.table-reservations') }}" method="GET" class="d-flex align-items-center gap-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox"
                       name="only_active" id="only_active"
                       value="1" {{ request('only_active') ? 'checked' : '' }}>
                <label class="form-check-label" for="only_active">
                    Только активные
                </label>
            </div>
            <button class="btn-exact btn-sm" type="submit">Фильтровать</button>
        </form>
    </div>
</div>

<div class="admin-table">
    <div class="table-header">
        <h2 class="table-title">Бронирования столиков</h2>
        <div class="text-muted">
            Показано {{ $reservations->count() }} из {{ $reservations->total() }}
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
            <tr>
                <th>ID</th>
                <th>Столик</th>
                <th>Гость</th>
                <th>Контакты</th>
                <th>Дата и время</th>
                <th>Гостей</th>
                <th>Депозит</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @forelse($reservations as $reservation)
                <tr>
                    <td><strong>#{{ $reservation->id }}</strong></td>
                    <td>
                        №{{ optional($reservation->table)->number ?? '—' }}
                    </td>
                    <td>
                        <div class="fw-semibold">{{ $reservation->guest_name }}</div>
                        @if($reservation->user)
                            <small class="text-muted">Пользователь: {{ $reservation->user->email }}</small>
                        @endif
                    </td>
                    <td>
                        <div>{{ $reservation->guest_phone }}</div>
                        @if($reservation->guest_email)
                            <small class="text-muted">{{ $reservation->guest_email }}</small>
                        @endif
                    </td>
                    <td>
                        <div class="fw-semibold">{{ $reservation->start_at->format('d.m.Y') }}</div>
                        <small class="text-muted">
                            {{ $reservation->start_at->format('H:i') }} – {{ $reservation->end_at->format('H:i') }}
                        </small>
                    </td>
                    <td>{{ $reservation->guests_count }}</td>
                    <td>{{ number_format($reservation->deposit_total, 0, ',', ' ') }} ₽</td>
                    <td>
                        @if($reservation->cancelled)
                            <span class="badge-admin bg-warning text-dark">Отменена</span>
                        @elseif($reservation->end_at->isPast())
                            <span class="badge-admin bg-secondary">Завершена</span>
                        @else
                            <span class="badge-admin bg-success">Активна</span>
                        @endif
                    </td>
                    <td>
                        @if(!$reservation->cancelled && $reservation->end_at->isFuture())
                            <form action="{{ route('admin.table-reservations.cancel', $reservation->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Отменить бронь столика #{{ $reservation->id }}?')">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-outline-exact">
                                    Отменить
                                </button>
                            </form>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center py-5">
                        <i class="bi bi-calendar-x" style="font-size: 48px; color: var(--text-gray);"></i>
                        <p class="mt-3 text-muted">Бронирования не найдены</p>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if($reservations->hasPages())
        <div class="table-footer p-3 border-top">
            {{ $reservations->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection