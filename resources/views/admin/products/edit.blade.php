{{-- resources/views/admin/products/edit.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Редактировать блюдо')
@section('page-title', 'Редактировать блюдо')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="admin-table">
            <div class="table-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="table-title mb-1">Редактирование блюда</h2>
                        <p class="text-muted mb-0">{{ $product->name }}</p>
                    </div>
                    <a href="{{ route('admin.products') }}" class="btn-outline-exact">
                        <i class="bi bi-arrow-left me-1"></i> Назад к списку
                    </a>
                </div>
            </div>
            
            <div class="p-4">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="edit-product-form">
                    @csrf
                    @method('PUT')
                    
                    <!-- Основная информация -->
                    <div class="card-section mb-4">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="bi bi-info-circle"></i>
                            </div>
                            <h4 class="section-title">Основная информация</h4>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label class="form-label">Название блюда <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $product->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">Описание</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                              rows="4">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Изображение</label>
                                    
                                    @if($product->image)
                                        <div class="current-image mb-3 p-3" style="background: var(--bg-light); border-radius: 8px;">
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ asset('storage/' . $product->image) }}" 
                                                     alt="{{ $product->name }}" 
                                                     style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                                                <div class="flex-grow-1">
                                                    <p class="mb-1"><strong>Текущее фото</strong></p>
                                                    <p class="text-muted small mb-2">{{ basename($product->image) }}</p>
                                                    
                                                    <!-- КНОПКА УДАЛЕНИЯ ФОТО -->
                                                    <div class="form-check">
                                                        <input type="checkbox" 
                                                               name="remove_image" 
                                                               class="form-check-input" 
                                                               id="remove_image" 
                                                               value="1">
                                                        <label class="form-check-label text-danger" for="remove_image">
                                                            <i class="bi bi-trash"></i> Удалить текущее фото
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="new-image-upload">
                                        <label class="form-label">Загрузить новое фото</label>
                                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" 
                                               accept="image/*">
                                        <small class="text-muted">JPG, PNG до 2MB. Оставьте пустым, чтобы не менять.</small>
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Характеристики -->
                    <div class="card-section mb-4">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="bi bi-tags"></i>
                            </div>
                            <h4 class="section-title">Характеристики</h4>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Цена (₽) <span class="text-danger">*</span></label>
                                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                                           value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Вес <span class="text-danger">*</span></label>
                                    <input type="number" name="weight" class="form-control @error('weight') is-invalid @enderror" 
                                           value="{{ old('weight', $product->weight) }}" min="1" required>
                                    @error('weight')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Единица измерения</label>
                                    <select name="weight_unit" class="form-control">
                                        <option value="гр." {{ old('weight_unit', $product->weight_unit) == 'гр.' ? 'selected' : '' }}>гр.</option>
                                        <option value="мл." {{ old('weight_unit', $product->weight_unit) == 'мл.' ? 'selected' : '' }}>мл.</option>
                                        <option value="шт." {{ old('weight_unit', $product->weight_unit) == 'шт.' ? 'selected' : '' }}>шт.</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Категория <span class="text-danger">*</span></label>
                                    <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                        <option value="">-- Выберите категорию --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Порядок сортировки</label>
                                    <input type="number" name="order" class="form-control" value="{{ old('order', $product->order ?? 0) }}" min="0">
                                    <small class="text-muted">Чем меньше, тем выше</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Настройки -->
                    <div class="card-section mb-4">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="bi bi-gear"></i>
                            </div>
                            <h4 class="section-title">Настройки</h4>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex gap-4">
                                    <div class="form-check">
                                        <input type="checkbox" name="active" class="form-check-input" id="active" value="1"
                                            {{ old('active', $product->active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="active">Активное блюдо</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Кнопки -->
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn-exact">
                            <i class="bi bi-check-circle me-2"></i> Сохранить изменения
                        </button>
                        <a href="{{ route('admin.products') }}" class="btn-outline-exact">
                            <i class="bi bi-x-circle me-2"></i> Отмена
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Предупреждение при удалении фото
    const removeImageCheckbox = document.getElementById('remove_image');
    const fileInput = document.querySelector('input[name="image"]');
    
    if (removeImageCheckbox && fileInput) {
        removeImageCheckbox.addEventListener('change', function() {
            if (this.checked) {
                fileInput.disabled = true;
                fileInput.value = ''; // Очищаем выбор файла
            } else {
                fileInput.disabled = false;
            }
        });
    }
});
</script>
@endpush
@endsection