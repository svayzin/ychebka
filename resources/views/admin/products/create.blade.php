{{-- resources/views/admin/products/create.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Добавить блюдо')
@section('page-title', 'Добавить блюдо')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="admin-table">
            <div class="table-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="table-title mb-1">Создание нового блюда</h2>
                        <p class="text-muted mb-0">Заполните информацию о новом блюде</p>
                    </div>
                    <a href="{{ route('admin.products') }}" class="btn-outline-exact">
                        <i class="bi bi-arrow-left me-1"></i> Назад к списку
                    </a>
                </div>
            </div>
            
            <div class="p-4">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
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
                                           value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">Описание</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                              rows="4">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Изображение</label>
                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" 
                                           accept="image/*">
                                    <small class="text-muted">JPG, PNG до 2MB</small>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                           value="{{ old('price') }}" step="0.01" min="0" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Вес <span class="text-danger">*</span></label>
                                    <input type="number" name="weight" class="form-control @error('weight') is-invalid @enderror" 
                                           value="{{ old('weight', 300) }}" min="1" required>
                                    @error('weight')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Единица измерения</label>
                                    <select name="weight_unit" class="form-control">
                                        <option value="гр." {{ old('weight_unit') == 'гр.' ? 'selected' : '' }}>гр.</option>
                                        <option value="мл." {{ old('weight_unit') == 'мл.' ? 'selected' : '' }}>мл.</option>
                                        <option value="шт." {{ old('weight_unit') == 'шт.' ? 'selected' : '' }}>шт.</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Категория <span class="text-danger">*</span></label>
                                    <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                        <option value="">-- Выберите категорию --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                    <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}" min="0">
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
                                        <input type="checkbox" name="active" class="form-check-input" id="active" value="1" checked>
                                        <label class="form-check-label" for="active">Активное блюдо</label>
                                    </div>
                                    
                                    <div class="form-check">
                                        <input type="checkbox" name="is_new" class="form-check-input" id="is_new" value="1">
                                        <label class="form-check-label" for="is_new">Новинка</label>
                                    </div>
                                    
                                    <div class="form-check">
                                        <input type="checkbox" name="is_popular" class="form-check-input" id="is_popular" value="1">
                                        <label class="form-check-label" for="is_popular">Популярное</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Кнопки -->
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn-exact">
                            <i class="bi bi-check-circle me-2"></i> Создать блюдо
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
@endsection