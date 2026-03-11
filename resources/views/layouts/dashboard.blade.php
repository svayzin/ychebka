@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Панель управления</h1>
    
    <!-- Статистика -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card primary">
                <h6>Всего броней</h6>
                <h3>{{ $stats['total_reservations'] }}</h3>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card success">
                <h6>Брони на сегодня</h6>
                <h3>{{ $stats['today_reservations'] }}</h3>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card warning">
                <h6>Ожидают подтверждения</h6>
                <h3>{{ $stats['pending_reservations'] }}</h3>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card info">
                <h6>Всего пользователей</h6>
                <h3>{{ $stats['total_users'] }}</h3>
            </div>
        </div>
    </div>
    
    <!-- Последние брони -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Последние брони</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Телефон</th>
                            <th>Дата и время</th>
                            <th>Гости</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->id }}</td>
                            <td>{{ $reservation->name }}</td>
                            <td>{{ $reservation->phone }}</td>
                            <td>{{ $reservation->date->format('d.m.Y') }} {{ $reservation->time }}</td>
                            <td>{{ $reservation->guests }}</td>
                            <td>
                                @if($reservation->confirmed)
                                    <span class="badge bg-success">Подтверждена</span>
                                @else
                                    <span class="badge bg-warning text-dark">Ожидает</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.reservations') }}" class="btn btn-sm btn-primary">Просмотр</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
