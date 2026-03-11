{{-- resources/views/admin/categories/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Управление категориями')
@section('page-title', 'Управление категориями')

@section('content')
<!-- Заголовок и кнопка -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Категории меню</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn-exact">
        <i class="bi bi-plus-circle me-2"></i> Добавить категорию
    </a>
</div>

<!-- Таблица категорий -->
<div class="admin-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Slug</th>
                    <th>Описание</th>
                    <th>Товаров</th>
                    <th>Порядок</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td><strong>#{{ $category->id }}</strong></td>
                    <td>
                        <div class="fw-semibold">{{ $category->name }}</div>
                    </td>
                    <td>
                        <code class="text-muted">{{ $category->slug }}</code>
                    </td>
                    <td>
                        @if($category->description)
                        <small class="text-muted">{{ Str::limit($category->description, 40) }}</small>
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge-admin bg-light text-dark">{{ $category->products->count() }}</span>
                    </td>
                    <td>
                        <span class="text-muted">{{ $category->order }}</span>
                    </td>
                    <td>
                        @if($category->active)
                        <span class="badge-admin badge-success">Активна</span>
                        @else
                        <span class="badge-admin badge-secondary">Неактивна</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-exact me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.categories.delete', $category->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Удалить категорию «{{ $category->name }}»?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-exact text-danger" 
                                    {{ $category->products->count() > 0 ? 'disabled title="Нельзя удалить категорию с товарами"' : '' }}>
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <i class="bi bi-folder-x" style="font-size: 48px; color: var(--text-gray);"></i>
                        <p class="mt-3 text-muted">Категории не найдены</p>
                        <a href="{{ route('admin.categories.create') }}" class="btn-exact mt-2">
                            <i class="bi bi-plus-circle me-2"></i> Создать первую категорию
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($categories->hasPages())
    <div class="table-footer p-3 border-top">
        {{ $categories->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection