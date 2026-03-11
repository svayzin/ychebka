{{-- resources/views/admin/reservations/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Управление бронированиями')
@section('page-title', 'Управление бронированиями')

@section('content')
<!-- Фильтры и поиск -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="d-flex gap-3 flex-wrap">
            <a href="{{ route('admin.reservations') }}" class="btn-outline-exact @if(!request('status')) active @endif">
                Все ({{ \App\Models\Reservation::count() }})
            </a>
            <a href="{{ route('admin.reservations', ['status' => 'pending']) }}" class="btn-outline-exact @if(request('status') == 'pending') active @endif">
                Ожидают ({{ \App\Models\Reservation::where('confirmed', false)->count() }})
            </a>
            <a href="{{ route('admin.reservations', ['status' => 'confirmed']) }}" class="btn-outline-exact @if(request('status') == 'confirmed') active @endif">
                Подтверждены ({{ \App\Models\Reservation::where('confirmed', true)->count() }})
            </a>
        </div>
    </div>
    <div class="col-md-4">
        <form action="{{ route('admin.reservations') }}" method="GET">
            <div class="input-group">
                <input type="text" class="form-control-admin" name="search" placeholder="Поиск по имени или телефону..." value="{{ request('search') }}">
                <button class="btn-exact" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Таблица бронирований -->
<div class="admin-table">
    <div class="table-header">
        <h2 class="table-title">Бронирования</h2>
        <div class="text-muted">
            Показано {{ $reservations->count() }} из {{ $reservations->total() }}
        </div>
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
                    <th>Комментарий</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $reservation)
                <tr>
                    <td><strong>#{{ $reservation->id }}</strong></td>
                    <td>
                        <div class="fw-semibold">{{ $reservation->name }}</div>
                        @if($reservation->user)
                        <small class="text-muted">{{ $reservation->user->email }}</small>
                        @endif
                    </td>
                    <td>{{ $reservation->phone }}</td>
                    <td>
                        <div class="fw-semibold">{{ $reservation->date->format('d.m.Y') }}</div>
                        <small class="text-muted">{{ $reservation->time }}</small>
                    </td>
                    <td>
                        <span class="badge-admin bg-light text-dark">{{ $reservation->guests }} чел.</span>
                    </td>
                    <td>
                        <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <select name="confirmed" class="form-control-admin form-select-sm" style="width: auto;" onchange="this.form.submit()">
                                <option value="0" {{ !$reservation->confirmed ? 'selected' : '' }}>Ожидает</option>
                                <option value="1" {{ $reservation->confirmed ? 'selected' : '' }}>Подтверждена</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        @if($reservation->notes)
                        <small class="text-muted" title="{{ $reservation->notes }}">
                            {{ Str::limit($reservation->notes, 30) }}
                        </small>
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-exact" data-bs-toggle="modal" data-bs-target="#editModal{{ $reservation->id }}">
                            <i class="bi bi-pencil"></i>
                        </button>
                    </td>
                </tr>

                <!-- Модальное окно редактирования -->
                <div class="modal fade" id="editModal{{ $reservation->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content" style="background: var(--bg-card); color: var(--text-light);">
                            <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header border-bottom">
                                    <h5 class="modal-title">Редактирование брони #{{ $reservation->id }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть" style="filter: invert(1);"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label-admin">Имя</label>
                                        <input type="text" name="name" class="form-control-admin" value="{{ $reservation->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label-admin">Телефон</label>
                                        <input type="text" name="phone" class="form-control-admin" value="{{ $reservation->phone }}" required>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label-admin">Дата</label>
                                            <input type="date" name="date" class="form-control-admin" value="{{ $reservation->date->format('Y-m-d') }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-admin">Время</label>
                                            <select name="time" class="form-control-admin" required>
                                                @foreach(['19:00', '19:30', '20:00', '20:30', '21:00'] as $time)
                                                <option value="{{ $time }}" {{ $reservation->time == $time ? 'selected' : '' }}>{{ $time }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label-admin">Количество гостей</label>
                                        <input type="number" name="guests" class="form-control-admin" value="{{ $reservation->guests }}" min="1" max="20" required>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" name="confirmed" value="1" 
                                                   class="form-check-input" id="confirmed{{ $reservation->id }}" 
                                                   {{ $reservation->confirmed ? 'checked' : '' }}>
                                            <label class="form-check-label" for="confirmed{{ $reservation->id }}">Подтверждено</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label-admin">Комментарий</label>
                                        <textarea name="notes" class="form-control-admin" rows="3">{{ $reservation->notes }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer border-top">
                                    <button type="button" class="btn btn-outline-exact" data-bs-dismiss="modal">Отмена</button>
                                    <button type="submit" class="btn-exact">Сохранить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
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