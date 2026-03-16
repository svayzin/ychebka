@extends('layouts.app')

@section('title', 'Меню - Crimson Flame')

@section('content')
    <!-- Герой секция меню -->
    <section class="hero-elegant-dark" id="menu-hero">
        <div class="container">
            <h1 class="hero-title-dark text-center">Наше меню</h1>
            <p class="hero-subtitle-dark text-center">
                Откройте для себя мир изысканных вкусов и авторских интерпретаций классических блюд
            </p>
        </div>
    </section>

    <div class="container">
        <!-- Навигация по категориям -->
        <div class="section-elegant">
            <div class="text-center mb-5">
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <a href="#soups" class="btn-gold-outline btn-sm">Супы</a>
                    <a href="#rolls" class="btn-gold-outline btn-sm">Роллы</a>
                    <a href="#appetizers" class="btn-gold-outline btn-sm">Закуски</a>
                    <a href="#salads" class="btn-gold-outline btn-sm">Салаты</a>
                    <a href="#pizza" class="btn-gold-outline btn-sm">Пицца</a>
                    <a href="#hot" class="btn-gold-outline btn-sm">Горячее</a>
                    <a href="#desserts" class="btn-gold-outline btn-sm">Десерты</a>
                </div>
            </div>

            <!-- Супы -->
            <div id="soups" class="menu-category-dark mb-5">
                <h3 class="category-title">Супы</h3>
                <div class="row">
                    @foreach($menuItems['soups'] as $item)
                    <div class="col-md-4 mb-4">
                        <div class="dish-card">
                            <div class="dish-content">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="dish-title">{{ $item['name'] }}</h5>
                                    <span class="badge" style="background: #AD1C43; color: var(--bg-dark);">{{ $item['weight'] }}</span>
                                </div>
                                <p class="dish-description">Ароматный бульон с нежными вонтонами и свежей зеленью</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="dish-price">{{ $item['price'] }} ₽</span>
                                    <button class="btn-elegant btn-sm">
                                        <i class="bi bi-cart-plus"></i>
                                        В корзину
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Роллы -->
            <div id="rolls" class="menu-category-dark mb-5">
                <h3 class="category-title">Роллы</h3>
                <div class="row">
                    @foreach($menuItems['rolls'] as $item)
                    <div class="col-md-4 mb-4">
                        <div class="dish-card">
                            <div class="dish-content">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="dish-title">{{ $item['name'] }}</h5>
                                    <span class="badge" style="background: #AD1C43; color: var(--bg-dark);">{{ $item['weight'] }}</span>
                                </div>
                                <p class="dish-description">Свежие роллы с лососем, сливочным сыром и авокадо</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="dish-price">{{ $item['price'] }} ₽</span>
                                    <button class="btn-elegant btn-sm">
                                        <i class="bi bi-cart-plus"></i>
                                        В карточку
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Кнопка бронирования -->
            <div class="text-center mt-5">
                <a href="#reservation" class="btn-elegant">
                    <i class="bi bi-calendar-check"></i>
                    Забронировать столик
                </a>
            </div>
        </div>
    </div>

    <style>
        .menu-category-dark {
            background: var(--bg-card);
            padding: 40px;
            border-radius: 16px;
            border: 1px solid var(--border);
        }
        
        .category-title {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #AD1C43;
        }
        
        .btn-sm {
            padding: 6px 12px;
            font-size: 14px;
        }
    </style>
@endsection