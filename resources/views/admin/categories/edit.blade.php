{{-- resources/views/admin/categories/edit.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Редактировать категорию')
@section('page-title', 'Редактировать категорию')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="admin-table">
            <div class="table-header">
                <h2 class="table-title">Редактирование категории</h2>
                <a href="{{ route('admin.categories') }}" class="btn-outline-exact">
                    <i class="bi bi-arrow-left me-1"></i> Назад к списку
                </a>
            </div>
            
            <div class="p-4">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="form-label-admin">Название категории *</label>
                        <input type="text" name="name" class="form-control-admin" value="{{ old('name', $category->name) }}" required>
                        @error('name')
                        <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label-admin">Slug (URL) *</label>
                        <input type="text" name="slug" class="form-control-admin" value="{{ old('slug', $category->slug) }}" required>
                        <small class="text-muted">Только латинские буквы, цифры и дефисы</small>
                        @error('slug')
                        <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label-admin">Описание</label>
                        <textarea name="description" class="form-control-admin" rows="3">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                        <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label-admin">Порядок сортировки</label>
                            <input type="number" name="order" class="form-control-admin" value="{{ old('order', $category->order) }}">
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4 pt-2">
                                <div class="form-check">
                                    <input type="checkbox" name="active" class="form-check-input" id="active" 
                                           value="1" {{ old('active', $category->active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="active">Активная категория</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn-exact">
                            <i class="bi bi-check-circle me-2"></i> Сохранить изменения
                        </button>
                        <a href="{{ route('admin.categories') }}" class="btn-outline-exact">
                            Отмена
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="stat-card">
            <h4 class="mb-3"><i class="bi bi-box me-2"></i> Товары в категории</h4>
            @if($category->products->count() > 0)
            <div class="list-group">
                @foreach($category->products->take(5) as $product)
                <a href="{{ route('admin.products.edit', $product->id) }}" class="list-group-item list-group-item-action bg-transparent text-light border-secondary">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>{{ $product->name }}</span>
                        <span class="badge-admin">{{ number_format($product->price, 0, '.', ' ') }} ₽</span>
                    </div>
                </a>
                @endforeach
            </div>
            @if($category->products->count() > 5)
            <div class="text-center mt-3">
                <a href="{{ route('admin.products') }}?category={{ $category->id }}" class="btn-outline-exact btn-sm">
                    Все {{ $category->products->count() }} товаров
                </a>
            </div>
            @endif
            @else
            <p class="text-muted text-center py-3">В этой категории нет товаров</p>
            <a href="{{ route('admin.products.create') }}?category_id={{ $category->id }}" class="btn-exact w-100">
                <i class="bi bi-plus-circle me-2"></i> Добавить товар
            </a>
            @endif
        </div>
        
        <div class="stat-card mt-4">
            <h4 class="mb-3"><i class="bi bi-exclamation-triangle me-2"></i> Осторожно</h4>
            <div class="text-muted">
                <p>Изменение slug может сломать ссылки на категорию на сайте.</p>
                <p>Деактивация категории скроет её и все товары в ней.</p>
                @if($category->products->count() > 0)
                <p class="text-warning">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    В категории {{ $category->products->count() }} товаров
                </p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection