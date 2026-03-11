{{-- resources/views/admin/orders/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Управление заказами')
@section('page-title', 'Управление заказами')

@section('content')
<!-- Фильтры -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="d-flex gap-3 flex-wrap">
            <a href="{{ route('admin.orders') }}" class="btn-outline-exact @if(!request('status')) active @endif">
                Все ({{ \App\Models\Order::count() }})
            </a>
            <a href="{{ route('admin.orders', ['status' => 'pending']) }}" class="btn-outline-exact @if(request('status') == 'pending') active @endif">
                Ожидают ({{ \App\Models\Order::where('status', 'pending')->count() }})
            </a>
            <a href="{{ route('admin.orders', ['status' => 'processing']) }}" class="btn-outline-exact @if(request('status') == 'processing') active @endif">
                В обработке ({{ \App\Models\Order::where('status', 'processing')->count() }})
            </a>
            <a href="{{ route('admin.orders', ['status' => 'completed']) }}" class="btn-outline-exact @if(request('status') == 'completed') active @endif">
                Завершены ({{ \App\Models\Order::where('status', 'completed')->count() }})
            </a>
            <a href="{{ route('admin.orders', ['status' => 'cancelled']) }}" class="btn-outline-exact @if(request('status') == 'cancelled') active @endif">
                Отменены ({{ \App\Models\Order::where('status', 'cancelled')->count() }})
            </a>
        </div>
    </div>
</div>

<!-- Таблица заказов -->
<div class="admin-table">
    <div class="table-header">
        <h2 class="table-title">Заказы</h2>
        <div class="text-muted">
            Показано {{ $orders->count() }} из {{ $orders->total() }}
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Клиент</th>
                    <th>Сумма</th>
                    <th>Адрес</th>
                    <th>Статус</th>
                    <th>Дата</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><strong>#{{ $order->id }}</strong></td>
                    <td>
                        <div class="fw-semibold">{{ $order->user->full_name }}</div>
                        <small class="text-muted">{{ $order->user->email }}</small>
                    </td>
                    <td>
                        <div class="fw-semibold">{{ number_format($order->total, 0, '.', ' ') }} ₽</div>
                        <small class="text-muted">{{ $order->items->count() }} товаров</small>
                    </td>
                    <td>
                        <small class="text-muted" title="{{ $order->address }}">
                            {{ Str::limit($order->address, 30) }}
                        </small>
                    </td>
                    <td>
                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-control-admin form-select-sm" style="width: auto;" onchange="this.form.submit()">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Ожидает</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>В обработке</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Завершен</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Отменен</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <div class="fw-semibold">{{ $order->created_at->format('d.m.Y') }}</div>
                        <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-exact" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">
                            <i class="bi bi-eye"></i>
                        </button>
                    </td>
                </tr>

                <!-- Модальное окно с деталями заказа -->
                <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content" style="background: var(--bg-card); color: var(--text-light);">
                            <div class="modal-header border-bottom">
                                <h5 class="modal-title">Детали заказа #{{ $order->id }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть" style="filter: invert(1);"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h6 class="mb-3"><i class="bi bi-person me-2"></i> Информация о клиенте</h6>
                                        <p><strong>ФИО:</strong> {{ $order->user->full_name }}</p>
                                        <p><strong>Email:</strong> {{ $order->user->email }}</p>
                                        <p><strong>Телефон:</strong> {{ $order->user->phone ?? 'Не указан' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-3"><i class="bi bi-truck me-2"></i> Информация о доставке</h6>
                                        <p><strong>Статус:</strong> 
                                            <span class="badge-admin 
                                                @if($order->status == 'pending') badge-warning
                                                @elseif($order->status == 'processing') badge-info
                                                @elseif($order->status == 'completed') badge-success
                                                @else badge-danger @endif">
                                                {{ $order->status_text }}
                                            </span>
                                        </p>
                                        <p><strong>Адрес:</strong> {{ $order->address }}</p>
                                        @if($order->notes)
                                        <p><strong>Комментарий:</strong> {{ $order->notes }}</p>
                                        @endif
                                    </div>
                                </div>
                                
                                <h6 class="mb-3"><i class="bi bi-cart me-2"></i> Состав заказа</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Блюдо</th>
                                                <th>Количество</th>
                                                <th>Цена</th>
                                                <th>Сумма</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->items as $item)
                                            <tr>
                                                <td>{{ $item->product->name }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ number_format($item->price, 0, '.', ' ') }} ₽</td>
                                                <td>{{ number_format($item->total, 0, '.', ' ') }} ₽</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3" class="text-end">Итого:</th>
                                                <th>{{ $order->formatted_total }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer border-top">
                                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="w-100">
                                    @csrf
                                    @method('PUT')
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <select name="status" class="form-control-admin">
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Ожидает обработки</option>
                                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>В обработке</option>
                                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Завершен</option>
                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Отменен</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" class="btn-exact w-100">Обновить статус</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="bi bi-cart-x" style="font-size: 48px; color: var(--text-gray);"></i>
                        <p class="mt-3 text-muted">Заказы не найдены</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($orders->hasPages())
    <div class="table-footer p-3 border-top">
        {{ $orders->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection