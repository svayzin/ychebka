@extends('admin.layouts.app')

@section('title', 'Управление блюдами')
@section('page-title', 'Управление блюдами')

@section('content')
<!-- Заголовок и кнопка -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0">Блюда меню</h2>
        <small class="text-muted">Всего: {{ $products->total() }} блюд</small>
    </div>
    <div class="d-flex gap-3">
        <a href="{{ route('admin.products.create') }}" class="btn-exact">
            <i class="bi bi-plus-circle me-2"></i> Добавить блюдо
        </a>
    </div>
</div>

<!-- Фильтры -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="admin-table">
            <div class="p-3">
                <form action="{{ route('admin.products') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <select name="category" class="form-control-admin">
                            <option value="">Все категории</option>
                            @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-control-admin">
                            <option value="">Все статусы</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Активные</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Неактивные</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control-admin" placeholder="Поиск по названию..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn-exact w-100">Фильтровать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Таблица продуктов -->
<div class="admin-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Изображение</th>
                    <th>Название</th>
                    <th>Категория</th>
                    <th>Цена</th>
                    <th>Вес</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td><strong>#{{ $product->id }}</strong></td>
                    <td>
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                             style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;">
                        @else
                        <div class="text-center" style="width: 60px; height: 60px; background: var(--bg-light); border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-image text-muted"></i>
                        </div>
                        @endif
                    </td>
                    <td>
                        <div class="fw-semibold">{{ $product->name }}</div>
                        <small class="text-muted">{{ Str::limit($product->description, 30) }}</small>
                    </td>
                    <td>
                        <span class="badge-admin bg-light text-dark">{{ $product->category->name }}</span>
                    </td>
                    <td>
                        <div class="fw-semibold">{{ number_format($product->price, 0, '.', ' ') }} ₽</div>
                    </td>
                    <td>
                        <span class="text-muted">{{ $product->weight }} {{ $product->weight_unit }}</span>
                    </td>
                    <td>
                        @if($product->active)
                        <span class="badge-admin badge-success">Активно</span>
                        @else
                        <span class="badge-admin badge-secondary">Неактивно</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-exact me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Удалить блюдо «{{ $product->name }}»?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-exact text-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <i class="bi bi-egg-fried" style="font-size: 48px; color: var(--text-gray);"></i>
                        <p class="mt-3 text-muted">Блюда не найдены</p>
                        <a href="{{ route('admin.products.create') }}" class="btn-exact mt-2">
                            <i class="bi bi-plus-circle me-2"></i> Добавить первое блюдо
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($products->hasPages())
    <div class="table-footer p-3 border-top">
        {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection