@extends('layouts.app')

@section('content')
   <!-- Герой секция с полями -->
<section class="hero-exact" id="home">
    <div class="hero-exact-background-photo">
        <div class="container-exact">
        <div class="row align-items-center">
            <!-- Текст слева - ДОБАВЛЯЕМ ОТСТУП СВЕРХУ -->
            <div class="col-lg-6">
                <div class="hero-text-wrapper-exact" style="margin-top: 60px;"> <!-- ДОБАВЬТЕ ЭТОТ DIV -->
                    <h1 class="hero-title-exact">Crimson Flame</h1>
                    <p class="hero-text-exact">
                        Попробуйте любое блюдо из нашего широкого ассортимента — и вас затянет его вкус уже с первой ложки, не отпуская до последнего кусочка.
                    </p>
                    <div class="hero-buttons-exact">
                        <a href="{{ route('menu') }}" class="btn-menu-primary">
                            Посмотреть меню
                        </a>
                        <a href="{{ route('home') }}#reservation" class="btn-reservation-outline hero-reservation-btn">
                            Забронировать стол
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Картинка справа -->
            <div class="col-lg-6">
                <div class="hero-image-exact">
                    <img src="{{ asset('images/hero/') }}" 
                         alt="Интерьер ресторана Созвездие вкусов" 
                         class="hero-img-exact">
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<!-- Стили для героя -->
<style>
     
    .hero-exact {
        background: #000000;
    }
    .hero-exact-background-photo {
        background-image:
        linear-gradient(rgba(0,0,0,.75), rgba(0,0,0,.45)),
        url("../images/hero/black-stone-background-photo.webp");
        background-size: cover;
        background-position: center;
    }
    
    .hero-title-exact {
        font-size: 90px;
        font-family: "Adieu-Bold";
        font-weight: 900;
        color: var(--text-light);
        margin-bottom: 26px;
        line-height: 1.1;
    }
    
    .hero-text-exact {
        font-family: "Adieu-Regular";
        font-size: 25px;
        color: #ffffff;
        line-height: 1.4;
    }
    
    .hero-buttons-exact {
        display: flex;
        margin-top: 35px;
        gap: 25px;
        align-items: center;
    }
    
    /* Стиль ДЛЯ КНОПКИ "ПОСМОТРЕТЬ МЕНЮ" - УВЕЛИЧЕННАЯ */
    .btn-menu-primary {
        padding: 15px 35px;
        border-radius: 24px;
        background-color: #AD1C43;
        color:rgb(255, 255, 255);
        border: none;
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 110px;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    
    /* ОБЩИЕ СТИЛИ ДЛЯ ОБЕИХ КНОПОК */
    .btn-reservation-outline {
        padding: 15px 35px;
        border-radius: 24px;
        background-color: #AD1C43;
        color:rgb(255, 255, 255);
        border: none;
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 110px;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    
    /* Стрелка для обеих кнопок */
    .arrow-tip {
        display: block;
        position: absolute;
        left: calc(50% + 48px);
        top: calc(50% + 25px);
        transform: translateY(-50%);
        width: 0;
        height: 0;
        border-top: 6px solid transparent;
        border-bottom: 6px solid transparent;
        border-left: 10px solid #ffffff;
    }
    
    /* УНИКАЛЬНЫЕ СТИЛИ ДЛЯ КНОПКИ В "О РЕСТОРАНЕ" */
    .about-reservation-btn {
        margin-left: 290px;
        left: 0;
        width: 150px;
        height: 150px;
    }
    
    .about-reservation-btn::after {
        left: -75px;
        width: 170px;
        content: 'Забронировать стол';
    }
    
    .about-reservation-btn::before {
        left: 65px;
    }
    
    .about-reservation-btn .arrow-tip {
        left: calc(50% + 40px);
        top: calc(50% + 20px);
    }
    
    .hero-img-exact {
        width: 620px;
        height: 620px;
        object-fit: cover;
    }
    
    /* Адаптивность для кнопки в герое */
    @media (max-width: 768px) {
        .hero-exact {
            padding: 60px 0;
        }
        
        .hero-title-exact {
            font-size: 36px;
        }
        
        .hero-text-exact {
            font-size: 18px;
        }
        
        .hero-image-exact {
            height: 300px;
            margin-top: 40px;
        }
        
        .hero-buttons-exact {
            flex-direction: column;
        }
        

        
        .btn-menu-primary {
            padding: 16px 40px;
            font-size: 18px;
            width: 100%;
            max-width: 300px;
        }
        
        .hero-img-exact {
            width: 100%;
            height: 300px;
            margin-left: 0;
        }
    }
    
    /* Адаптивность для кнопки в "О ресторане" */
    @media (max-width: 768px) {
        .about-reservation-btn {
            padding: 10px 25px;
            width: 100%;
            max-width: 280px;
            border: none;
            width: auto;
            height: auto;
            background: transparent;
            color: #ffffff !important;
            font-size: 16px;
            padding: 8px 18px;
            border: 1px solid #ffffff;
            border-radius: 4px;
            margin-top: 15px;
            margin-left: 0;
        }
        
        .about-reservation-btn::before,
        .about-reservation-btn::after,
        .about-reservation-btn .arrow-tip {
            display: none;
        }
        
        .about-reservation-btn::after {
            position: static;
            left: auto;
            text-align: center;
            width: auto;
            white-space: normal;
            font-size: 16px;
            color: #ffffff;
            display: block;
            padding: 5px;
        }
    }
    
</style>

<!-- Популярные блюда -->
<section class="section-exact" id="menu">
    <div class="container-exact">
        <h2 class="section-title-exact">Популярные блюда</h2>
        
        <div class="bordered-exact">
            <!-- Кнопки-вкладки для категорий -->
            <div class="category-tabs-exact">
                <button class="category-tab-exact active" data-category="soups">Супы</button>
                <button class="category-tab-exact" data-category="rolls">Роллы</button>
                <button class="category-tab-exact" data-category="appetizers">Закуски</button>
                <button class="category-tab-exact" data-category="salads">Салаты</button>
                <button class="category-tab-exact" data-category="pizza">Пицца</button>
                <button class="category-tab-exact" data-category="hot">Горячее</button>
                <button class="category-tab-exact" data-category="desserts">Десерты</button>
            </div>
            
            <!-- Слайдер для каждой категории -->
            <div class="dishes-slider-container-exact">
                <!-- Супы (активная по умолчанию) -->
                <div class="category-slider-exact active" id="soups-slider">
                    <div class="swiper dishes-swiper-exact">
                        <div class="swiper-wrapper">
                            <!-- 3 блюда для супов -->
                            <div class="swiper-slide">
                                <div class="dish-item-exact">
                                    <div class="dish-image-exact">
                                        <img src="{{ asset('images/dishes/soup1.jpg') }}" alt="Бульон с вонтонами">
                                    </div>
                                    <div class="dish-name-exact">Бульон с вонтонами</div>
                                    <div class="dish-weight-exact">270 гр.</div>
                                    <div class="dish-price-exact">590 ₽</div>
                                    <button class="btn-exact btn-sm-exact">В корзину</button>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="dish-item-exact">
                                    <div class="dish-image-exact">
                                        <img src="{{ asset('images/dishes/soup2.jpg') }}" alt="Том Ям Красный">
                                    </div>
                                    <div class="dish-name-exact">Том Ям Красный</div>
                                    <div class="dish-weight-exact">400 гр.</div>
                                    <div class="dish-price-exact">750 ₽</div>
                                    <button class="btn-exact btn-sm-exact">В корзину</button>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="dish-item-exact">
                                    <div class="dish-image-exact">
                                        <img src="{{ asset('images/dishes/soup3.jpg') }}" alt="Том Ям Кокос">
                                    </div>
                                    <div class="dish-name-exact">Том Ям Кокос</div>
                                    <div class="dish-weight-exact">400 гр.</div>
                                    <div class="dish-price-exact">890 ₽</div>
                                    <button class="btn-exact btn-sm-exact">В корзину</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Роллы -->
                <div class="category-slider-exact" id="rolls-slider">
                    <div class="swiper dishes-swiper-exact">
                        <div class="swiper-wrapper">
                            <!-- 3 блюда для роллов -->
                            <div class="swiper-slide">
                                <div class="dish-item-exact">
                                    <div class="dish-image-exact">
                                        <img src="{{ asset('images/dishes/roll1.jpg') }}" alt="Ролл Филадельфия">
                                    </div>
                                    <div class="dish-name-exact">Ролл Филадельфия</div>
                                    <div class="dish-weight-exact">250 гр.</div>
                                    <div class="dish-price-exact">650 ₽</div>
                                    <button class="btn-exact btn-sm-exact">В корзину</button>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="dish-item-exact">
                                    <div class="dish-image-exact">
                                        <img src="{{ asset('images/dishes/roll2.jpg') }}" alt="Ролл Калифорния">
                                    </div>
                                    <div class="dish-name-exact">Ролл Калифорния</div>
                                    <div class="dish-weight-exact">230 гр.</div>
                                    <div class="dish-price-exact">550 ₽</div>
                                    <button class="btn-exact btn-sm-exact">В корзину</button>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="dish-item-exact">
                                    <div class="dish-image-exact">
                                        <img src="{{ asset('images/dishes/roll3.jpg') }}" alt="Запеченный ролл">
                                    </div>
                                    <div class="dish-name-exact">Запеченный ролл</div>
                                    <div class="dish-weight-exact">280 гр.</div>
                                    <div class="dish-price-exact">720 ₽</div>
                                    <button class="btn-exact btn-sm-exact">В корзину</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Закуски -->
                <div class="category-slider-exact" id="appetizers-slider">
                    <div class="swiper dishes-swiper-exact">
                        <div class="swiper-wrapper">
                            <!-- 3 блюда для закусок -->
                            <div class="swiper-slide">
                                <div class="dish-item-exact">
                                    <div class="dish-image-exact">
                                        <img src="{{ asset('images/dishes/app1.jpg') }}" alt="Брускетта">
                                    </div>
                                    <div class="dish-name-exact">Брускетта</div>
                                    <div class="dish-weight-exact">180 гр.</div>
                                    <div class="dish-price-exact">320 ₽</div>
                                    <button class="btn-exact btn-sm-exact">В корзину</button>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="dish-item-exact">
                                    <div class="dish-image-exact">
                                        <img src="{{ asset('images/dishes/app2.jpg') }}" alt="Тар-тар из говядины">
                                    </div>
                                    <div class="dish-name-exact">Тар-тар из говядины</div>
                                    <div class="dish-weight-exact">200 гр.</div>
                                    <div class="dish-price-exact">580 ₽</div>
                                    <button class="btn-exact btn-sm-exact">В корзину</button>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="dish-item-exact">
                                    <div class="dish-image-exact">
                                        <img src="{{ asset('images/dishes/app3.jpg') }}" alt="Сырное плато">
                                    </div>
                                    <div class="dish-name-exact">Сырное плато</div>
                                    <div class="dish-weight-exact">350 гр.</div>
                                    <div class="dish-price-exact">890 ₽</div>
                                    <button class="btn-exact btn-sm-exact">В корзину</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Салаты -->
                <div class="category-slider-exact" id="salads-slider">
                    <div class="swiper dishes-swiper-exact">
                        <div class="swiper-wrapper">
                            <!-- 3 блюда для салатов -->
                            <div class="swiper-slide">
                                <div class="dish-item-exact">
                                    <div class="dish-image-exact">
                                        <img src="{{ asset('images/dishes/salad1.jpg') }}" alt="Цезарь с креветками">
                                    </div>
                                    <div class="dish-name-exact">Цезарь с креветками</div>
                                    <div class="dish-weight-exact">300 гр.</div>
                                    <div class="dish-price-exact">650 ₽</div>
                                    <button class="btn-exact btn-sm-exact">В корзину</button>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="dish-item-exact">
                                    <div class="dish-image-exact">
                                        <img src="{{ asset('images/dishes/salad2.jpg') }}" alt="Греческий салат">
                                    </div>
                                    <div class="dish-name-exact">Греческий салат</div>
                                    <div class="dish-weight-exact">350 гр.</div>
                                    <div class="dish-price-exact">420 ₽</div>
                                    <button class="btn-exact btn-sm-exact">В корзину</button>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="dish-item-exact">
                                    <div class="dish-image-exact">
                                        <img src="{{ asset('images/dishes/salad3.jpg') }}" alt="Салат с тунцом">
                                    </div>
                                    <div class="dish-name-exact">Салат с тунцом</div>
                                    <div class="dish-weight-exact">280 гр.</div>
                                    <div class="dish-price-exact">520 ₽</div>
                                    <button class="btn-exact btn-sm-exact">В корзину</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Пицца -->
                <div class="category-slider-exact" id="pizza-slider">
                    <div class="swiper dishes-swiper-exact">
                        <div class="swiper-wrapper">
                            <!-- 3 блюда для пиццы -->
                            <div class="swiper-slide">
                                <div class="dish-item-exact">
                                    <div class="dish-image-exact">
                                        <img src="{{ asset('images/dishes/pizza1.jpg') }}" alt="Маргарита">
                                    </div>
                                    <div class="dish-name-exact">Маргарита</div>
                                    <div class="dish-weight-exact">500 гр.</div>
                                    <div class="dish-price-exact">550 ₽</div>
                                    <button class="btn-exact btn-sm-exact">В корзину</button>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="dish-item-exact">
                                    <div class="dish-image-exact">
                                        <img src="{{ asset('images/dishes/pizza2.jpg') }}" alt="Пепперони">
                                    </div>
                                    <div class="dish-name-exact">Пепперони</div>
                                    <div class="dish-weight-exact">550 гр.</div>
                                    <div class="dish-price-exact">680 ₽</div>
                                    <button class="btn-exact btn-sm-exact">В корзину</button>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="dish-item-exact">
                                    <div class="dish-image-exact">
                                        <img src="{{ asset('images/dishes/pizza3.jpg') }}" alt="Четыре сыра">
                                    </div>
                                    <div class="dish-name-exact">Четыре сыра</div>
                                    <div class="dish-weight-exact">480 гр.</div>
                                    <div class="dish-price-exact">620 ₽</div>
                                    <button class="btn-exact btn-sm-exact">В корзину</button>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
                
                <!-- Горячее -->
                <div class="category-slider-exact" id="hot-slider">
                    <div class="swiper dishes-swiper-exact">
                        <div class="swiper-wrapper">
                            <!-- 3 блюда для горячего -->
                            <div class="swiper-slide">
                                <div class="dish-item-exact">
                                    <div class="dish-image-exact">
                                        <img src="{{ asset('images/dishes/hot1.jpg') }}" alt="Стейк Рибай">
                                    </div>
                                    <div class="dish-name-exact">Стейк Рибай</div>
                                    <div class="dish-weight-exact">350 гр.</div>
                                    <div class="dish-price-exact">1200 ₽</div>
                                    <button class="btn-exact btn-sm-exact">В корзину</button>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="dish-item-exact">
                                    <div class="dish-image-exact">
                                        <img src="{{ asset('images/dishes/hot2.jpg') }}" alt="Лосось на гриле">
                                    </div>
                                    <div class="dish-name-exact">Лосось на гриле</div>
                                    <div class="dish-weight-exact">300 гр.</div>
                                    <div class="dish-price-exact">850 ₽</div>
                                    <button class="btn-exact btn-sm-exact">В корзину</button>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="dish-item-exact">
                                    <div class="dish-image-exact">
                                        <img src="{{ asset('images/dishes/hot3.jpg') }}" alt="Утиная грудка">
                                    </div>
                                    <div class="dish-name-exact">Утиная грудка</div>
                                    <div class="dish-weight-exact">280 гр.</div>
                                    <div class="dish-price-exact">780 ₽</div>
                                    <button class="btn-exact btn-sm-exact">В корзину</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Десерты -->
                <div class="category-slider-exact" id="desserts-slider">
                    <div class="swiper dishes-swiper-exact">
                        <div class="swiper-wrapper">
                            <!-- 3 блюда для десертов -->
                            <div class="swiper-slide">
                                <div class="dish-item-exact">
                                    <div class="dish-image-exact">
                                        <img src="{{ asset('images/dishes/dessert1.jpg') }}" alt="Тирамису">
                                    </div>
                                    <div class="dish-name-exact">Тирамису</div>
                                    <div class="dish-weight-exact">150 гр.</div>
                                    <div class="dish-price-exact">450 ₽</div>
                                    <button class="btn-exact btn-sm-exact">В корзину</button>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="dish-item-exact">
                                    <div class="dish-image-exact">
                                        <img src="{{ asset('images/dishes/dessert2.jpg') }}" alt="Чизкейк">
                                    </div>
                                    <div class="dish-name-exact">Чизкейк</div>
                                    <div class="dish-weight-exact">180 гр.</div>
                                    <div class="dish-price-exact">380 ₽</div>
                                    <button class="btn-exact btn-sm-exact">В корзину</button>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="dish-item-exact">
                                    <div class="dish-image-exact">
                                        <img src="{{ asset('images/dishes/dessert3.jpg') }}" alt="Шоколадный фондан">
                                    </div>
                                    <div class="dish-name-exact">Шоколадный фондан</div>
                                    <div class="dish-weight-exact">160 гр.</div>
                                    <div class="dish-price-exact">420 ₽</div>
                                    <button class="btn-exact btn-sm-exact">В корзину</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="{{ route('menu') }}" class="btn-exact-outline">
                    Открыть полное меню
                </a>
            </div>
        </div>
    </div>
</section>

<style>

    
    .text-center.mt-4 {
    margin-top: 0px !important;  /* ИЛИ 10px, ИЛИ -20px */
}
    /* Стили для категорий-вкладок */
    .category-tabs-exact {
        display: flex;
        gap: 15px;
        margin-bottom: 40px;
        flex-wrap: wrap;
    }
    
    .category-tab-exact {
        padding: 6px 35px;
        background: transparent;
        border: 2px solid #ffffff;
        color: #ffffff;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        border-radius: 4px;
        white-space: nowrap;
    }
    
    .category-tab-exact:hover {
        background: rgba(55, 55, 55, 0.92);
    }
    
    .category-tab-exact.active {
        background: #ffffff;
        color: #000000;
        border-color: #ffffff;
    }
    
    /* Контейнер для слайдеров */
    .dishes-slider-container-exact {
        position: relative;
        min-height: 0px;
    }
    
    /* Категорийные слайдеры */
    .category-slider-exact {
        display: none;
        opacity: 0;
        transition: opacity 0.5s ease;
    }
    
    .category-slider-exact.active {
        display: block;
        opacity: 1;
    }
    
    /* Стили для слайдера блюд */
    .dishes-swiper-exact {
        width: 100%;
        height: 520px;
        padding: 20px 0 50px 0;
        position: relative;
    }
    
    .dishes-swiper-exact .swiper-wrapper {
        align-items: stretch;
    }
    
    /* Карточка блюда - более компактная */
    .dish-item-exact {
      background: #1a1a1a;
    border-radius: 12px;
    padding: 15px;
    height: 350px;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
    text-align: center;
    }
    
    
    .dish-image-exact {
        width: 180px;
        height: 180px;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 12px;
    }
    
    
    .dish-name-exact {
        font-weight: 600;
        color: var(--text-light);
        margin-bottom: 5px;
        font-size: 18px;
        line-height: 1.2;
        min-height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .dish-weight-exact {
        color: var(--text-gray);
        font-size: 14px;
        margin-bottom: 8px;
    }
    
    .dish-price-exact {
        color: var(--accent);
        font-weight: 700;
        font-size: 22px;
        margin-bottom: 12px;
    }
    
    /* Кнопки в слайдере - растянутые на весь блок */
    .btn-sm-exact {
        padding: 10px 20px !important;
        font-size: 16px;
        width: 100%;
        display: block;
        margin-top: auto;
        min-height: 40px;
        border-radius: 6px;
        border: none;
        background: #ffffff;
        color: #000000;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-sm-exact:hover {
        background: #f0f0f0;
        transform: translateY(-2px);
    }
    
    /* Кнопки навигации слайдера */
    .dishes-swiper-exact .dishes-slider-prev,
    .dishes-swiper-exact .dishes-slider-next {
        width: 45px;
        height: 45px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, 0.3);
        top: 40%;
        transform: translateY(-50%);
        transition: all 0.3s ease;
    }
    
    .dishes-swiper-exact .dishes-slider-prev:hover,
    .dishes-swiper-exact .dishes-slider-next:hover {
        background: rgba(255, 255, 255, 0.25);
        border-color: #ffffff;
        transform: translateY(-50%) scale(1.1);
    }
    
    .dishes-swiper-exact .dishes-slider-prev:after,
    .dishes-swiper-exact .dishes-slider-next:after {
        font-size: 18px;
        color: #ffffff;
        font-weight: bold;
    }
    
    .dishes-swiper-exact .dishes-slider-prev {
        left: -20px;
    }
    
    .dishes-swiper-exact .dishes-slider-next {
        right: -20px;
    }
    
    .dishes-swiper-exact .dishes-pagination .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
        background: rgba(255, 255, 255, 0.5);
        opacity: 1;
        margin: 0 5px !important;
    }
    
    .dishes-swiper-exact .dishes-pagination .swiper-pagination-bullet-active {
        background: #ffffff;
        transform: scale(1.2);
    }
    
    /* Уменьшаем расстояние между слайдами */
    .dishes-swiper-exact .swiper-wrapper {
        gap: 105px;
    }
    
    .dishes-swiper-exact .swiper-slide {
        width: 320px !important;
        padding: 5px;
    }
    
    /* Адаптивность */
    @media (max-width: 1400px) {
        .dish-item-exact {
            height: 340px;
            padding: 15px;
        }
        
        .dish-image-exact {
            width: 160px;
            height: 160px;
        }
        
        .dishes-swiper-exact .swiper-slide {
            width: 300px !important;
        }
        
        .dishes-swiper-exact .dishes-slider-prev {
            left: -15px;
        }
        
        .dishes-swiper-exact .dishes-slider-next {
            right: -15px;
        }
    }
    
    @media (max-width: 1200px) {
        .dish-item-exact {
            height: 330px;
            width: 280px;
        }
        
        .dish-image-exact {
            width: 150px;
            height: 150px;
        }
        
        .dishes-swiper-exact .swiper-slide {
            width: 280px !important;
        }
        
        .category-tabs-exact {
            gap: 10px;
            margin-bottom: 30px;
        }
        
        .category-tab-exact {
            padding: 10px 18px;
            font-size: 16px;
        }
        
        .dish-name-exact {
            font-size: 16px;
        }
        
        .dishes-swiper-exact .dishes-slider-prev,
        .dishes-swiper-exact .dishes-slider-next {
            width: 40px;
            height: 40px;
        }
        
        .dishes-swiper-exact .dishes-slider-prev:after,
        .dishes-swiper-exact .dishes-slider-next:after {
            font-size: 16px;
        }
        
        .btn-sm-exact {
            padding: 8px 16px !important;
            font-size: 15px;
        }
    }
    
    @media (max-width: 992px) {
        .dish-item-exact {
            height: 320px;
            width: 260px;
        }
        
        .dish-image-exact {
            width: 140px;
            height: 140px;
        }
        
        .dishes-swiper-exact .swiper-slide {
            width: 260px !important;
        }
        
        .dish-name-exact {
            min-height: 36px;
            font-size: 15px;
        }
        
        .dish-price-exact {
            font-size: 20px;
        }
        
        .btn-sm-exact {
            padding: 8px 14px !important;
            font-size: 14px;
        }
    }
    
    @media (max-width: 768px) {
        .category-tabs-exact {
            overflow-x: auto;
            justify-content: flex-start;
            padding-bottom: 10px;
            margin-bottom: 25px;
            scrollbar-width: thin;
            scrollbar-color: #555 #333;
        }
        
        .category-tabs-exact::-webkit-scrollbar {
            height: 4px;
        }
        
        .category-tabs-exact::-webkit-scrollbar-track {
            background: #333;
        }
        
        .category-tabs-exact::-webkit-scrollbar-thumb {
            background: #555;
        }
        
        .category-tab-exact {
            padding: 8px 16px;
            font-size: 15px;
        }
        
        .dish-item-exact {
            height: 300px;
            width: 240px;
            padding: 12px;
        }
        
        .dish-image-exact {
            width: 130px;
            height: 130px;
            margin-bottom: 10px;
        }
        
        .dishes-swiper-exact .swiper-slide {
            width: 240px !important;
        }
        
        .dish-name-exact {
            font-size: 14px;
            min-height: 32px;
        }
        
        .dish-weight-exact {
            font-size: 13px;
        }
        
        .dish-price-exact {
            font-size: 18px;
        }
        
        .dishes-swiper-exact .dishes-slider-prev,
        .dishes-swiper-exact .dishes-slider-next {
            display: none;
        }
    }
    
    @media (max-width: 576px) {
        .dish-item-exact {
            height: 280px;
            width: 220px;
            padding: 10px;
        }
        
        .dish-image-exact {
            width: 120px;
            height: 120px;
        }
        
        .dishes-swiper-exact .swiper-slide {
            width: 220px !important;
        }
        
        .dish-name-exact {
            font-size: 13px;
        }
        
        .btn-sm-exact {
            padding: 6px 12px !important;
            font-size: 13px;
        }
    }
    
    @media (max-width: 480px) {
        .dish-item-exact {
            height: 260px;
            width: 200px;
            padding: 8px;
        }
        
        .dish-image-exact {
            width: 110px;
            height: 110px;
        }
        
        .dishes-swiper-exact .swiper-slide {
            width: 200px !important;
        }
        
        .btn-sm-exact {
            padding: 5px 10px !important;
            font-size: 12px;
        }
    }
        .section-title-exact {
            font-size: 65px;
            font-family: "Yeseva One";
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 45px;
        }
        
        .dish-item-exact {
            padding: 10px;
            height: 450px;
            width: 800px;
        }
        
        .dish-name-exact {
            font-weight: 600;
            color: var(--text-light);
            margin-bottom: 5px;
        }
        
        .dish-weight-exact {
            color: var(--text-gray);
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .dish-price-exact {
            color: var(--accent);
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 15px;
        }
        
        .btn-sm-exact {
            padding: 8px 16px;
            font-size: 14px;
        }
    </style>

<!-- О ресторане -->
<section class="section-exact" id="about">
    <div class="container-exact">
        <div class="about-content-exact">
            <!-- Левая часть: Заголовок и текст -->
            <div class="about-left-exact">
                <h2 class="about-title-exact">О ресторане</h2>
                
                <div class="about-text-content-exact">
                    <p>
                       Созвездие вкусов — это больше, чем просто ресторан. Это место, где рождаются кулинарные истории. 
                    <p>
                        Наш шеф-повар и его команда вдохновляются лучшими локальными продуктами, превращая их в современные и изысканные блюда. В меню вы найдете как смелые авторские интерпретации, так и любимые классические вкусы, исполненные с безупречной техникой.
                    </p>
                    <p>
                        Мы тщательно продумали каждую деталь: уютный интерьер с теплым светом, тщательно подобранное меню и безупречный сервис, который чувствует ваши пожелания. Здесь время замедляется, чтобы вы могли насладиться главным — вкусной едой, хорошей компанией и моментами настоящего удовольствия.
                    </p>
                    <div class="text-left mt-4">
                        <a href="{{ route('home') }}#reservation" class="btn-reservation-outline about-reservation-btn">
                            <span class="arrow-simple"></span>
                            Забронировать стол
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Правая часть: Фото -->
            <div class="about-right-exact">
                <div class="photos-grid-exact">
                    <!-- Большая фото слева -->
                    <div class="photo-large-wrapper-exact">
                        <img src="{{ asset('images/about/restaurant-1.png') }}" 
                             alt="Интерьер ресторана" 
                             class="about-img-large-exact">
                    </div>
                    
                    <!-- 2 маленькие квадратные фото справа -->
                    <div class="photos-small-wrapper-exact">
                        <div class="about-photo-small-exact">
                            <img src="{{ asset('images/about/restaurant-2.png') }}" 
                                 alt="Кухня ресторана" 
                                 class="about-img-small-exact">
                        </div>
                        <div class="about-photo-small-exact">
                            <img src="{{ asset('images/about/restaurant-3.png') }}" 
                                 alt="Зал ресторана" 
                                 class="about-img-small-exact">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>

    .text-left.mt-4 {
    margin-top: -15px !important; /* Поднимаем кнопку выше */
    position: relative;
    z-index: 2;
}

.about-reservation-btn {
    margin-left: 290px;
    left: 0;
    width: 150px;
    height: 150px;
    position: relative;
    top: -5px; /* Дополнительно поднимаем саму кнопку */
}
    /* Новая структура для секции "О ресторане" */
    .about-content-exact {
        display: grid;
        grid-template-columns: 1.2fr 1.8fr; /* Фото занимают больше места */
        gap: 60px;
        align-items: start;
    }
    
    .about-left-exact {
        display: flex;
        flex-direction: column;
        height: 100%;
        padding-right: 30px; /* Отступ от фото */
    }
    
    .about-title-exact {
        font-size: 70px;
        font-family: "Yeseva One";
        font-weight: 700;
        color: var(--text-light);
        margin-bottom: 20px; /* Уменьшен отступ */
        line-height: 1.1;
    }
    
    .about-text-content-exact {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        max-width: 500px; /* Ограничиваем ширину текста */
    }
    
    .about-text-content-exact p {
        margin-bottom: 20px; /* Уменьшен отступ между параграфами */
        font-size: 18px; /* Немного уменьшен шрифт */
        line-height: 1.5;
        color: #ffffff;
    }
    
    /* Правая часть с фотографиями */
    .about-right-exact {
        height: 100%;
        width: 100%;
    }
    
    /* Стили для фото справа */
    .photos-grid-exact {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 15px;
        width: 100%;
        height: 600px;
    }
    
    .photo-large-wrapper-exact {
        grid-column: 1;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }
    
    .about-img-large-exact {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .about-img-large-exact:hover {
        transform: scale(1.05);
    }
    
    .photos-small-wrapper-exact {
        grid-column: 2;
        display: flex;
        flex-direction: column;
        gap: 15px;
        width: 100%;
        height: 100%;
    }
    
    .about-photo-small-exact {
        width: 100%;
        height: calc(50% - 7.5px);
        overflow: hidden;
        aspect-ratio: 1/1; /* Делаем квадратными */
    }
    
    .about-img-small-exact {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .about-img-small-exact:hover {
        transform: scale(1.05);
    }
    
    /* Кнопка */
    .btn-exact-outline {
        display: inline-block;
        padding: 10px 25px;
        background: #ffffff;
        color: #000000;
        text-decoration: none;
        font-weight: 500;
        font-size: 20px;
        transition: all 0.3s ease;
        margin-top: 10px;
    }
    
    
    /* Адаптивность */
    @media (max-width: 1200px) {
        .about-title-exact {
            font-size: 60px;
        }
        
        .photos-grid-exact {
            height: 550px;
        }
        
        .about-text-content-exact {
            max-width: 450px;
        }
    }
    
    @media (max-width: 1024px) {
        .about-content-exact {
            grid-template-columns: 1fr;
            gap: 40px;
        }
        
        .about-left-exact {
            padding-right: 0;
            max-width: 100%;
        }
        
        .about-title-exact {
            font-size: 50px;
            margin-bottom: 20px;
        }
        
        .about-text-content-exact {
            max-width: 100%;
        }
        
        .photos-grid-exact {
            height: 400px;
            grid-template-columns: 1.5fr 1fr;
        }
    }
    
    @media (max-width: 768px) {
        .about-title-exact {
            font-size: 40px;
        }
        
        .about-text-content-exact p {
            font-size: 15px;
        }
        
        .photos-grid-exact {
            grid-template-columns: 1fr;
            grid-template-rows: 250px auto;
            height: auto;
            gap: 20px;
        }
        
        .photo-large-wrapper-exact {
            grid-column: 1;
            grid-row: 1;
            height: 250px;
        }
        
        .photos-small-wrapper-exact {
            grid-column: 1;
            grid-row: 2;
            flex-direction: row;
            gap: 15px;
            height: 150px;
        }
        
        .about-photo-small-exact {
            height: 150px;
            flex: 1;
            aspect-ratio: 1/1; /* Сохраняем квадратные на мобильных */
        }
        
        .about-img-small-exact {
            width: 100%;
            height: 100%;
        }
    }
    
    @media (max-width: 480px) {
        .about-title-exact {
            font-size: 32px;
        }
        
        .photos-small-wrapper-exact {
            flex-direction: column;
            height: auto;
        }
        
        .about-photo-small-exact {
            height: 150px;
            width: 100%;
            aspect-ratio: 1/1;
        }
        
        .btn-exact-outline {
            padding: 8px 20px;
            font-size: 13px;
        }
    }
</style>

<!-- Фотогалерея -->
<section class="section-exact" id="gallery">
    <div class="container-exact">
        <h2 class="section-title-exact">Фотогалерея ресторана</h2>
        
        <div class="gallery-wrapper-exact">
            <div class="gallery-container-exact">
                <div class="swiper gallery-swiper-exact">
                    <div class="swiper-wrapper">
                        <!-- 6 слайдов с фотографиями -->
                        <div class="swiper-slide">
                            <div class="slide-image-wrapper-exact">
                                <img src="{{ asset('images/gallery/photo1.png') }}" 
                                     alt="Интерьер ресторана" 
                                     class="gallery-img-exact">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slide-image-wrapper-exact">
                                <img src="{{ asset('images/gallery/photo2.png') }}" 
                                     alt="Кухня ресторана" 
                                     class="gallery-img-exact">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slide-image-wrapper-exact">
                                <img src="{{ asset('images/gallery/photo3.png') }}" 
                                     alt="Зал ресторана" 
                                     class="gallery-img-exact">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slide-image-wrapper-exact">
                                <img src="{{ asset('images/gallery/photo4.png') }}" 
                                     alt="Блюда ресторана" 
                                     class="gallery-img-exact">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slide-image-wrapper-exact">
                                <img src="{{ asset('images/gallery/photo5.png') }}" 
                                     alt="Барная стойка" 
                                     class="gallery-img-exact">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slide-image-wrapper-exact">
                                <img src="{{ asset('images/gallery/photo6.png') }}" 
                                     alt="Веранда ресторана" 
                                     class="gallery-img-exact">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Пагинация (кружочки отдельно под фотографиями) -->
            <div class="gallery-pagination-wrapper-exact">
                <div class="swiper-pagination-gallery-exact"></div>
            </div>
        </div>
    </div>
</section>

<style>
    .gallery-wrapper-exact {
        position: relative;
        width: 100%;
    }
    
    .gallery-container-exact {
        width: 100%;
        height: 500px;
        margin-bottom: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    
    .gallery-swiper-exact {
        width: 100%;
        height: 100%;
        position: relative;
    }
    
    .swiper-wrapper {
        display: flex;
        align-items: center;
        height: 100%;
    }
    
    .swiper-slide {
        width: 450px;
        height: 450px;
        flex-shrink: 0;
        display: flex !important;
        justify-content: center;
        align-items: center;
        opacity: 1 !important;
        visibility: visible !important;
    }
    
    .slide-image-wrapper-exact {
        width: 100%;
        height: 100%;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .slide-image-wrapper-exact:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.25);
    }
    
    .gallery-img-exact {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .gallery-img-exact:hover {
        transform: scale(1.03);
    }
    
    .gallery-pagination-wrapper-exact {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 25px 0; /* Увеличил padding */
    }
    
    .swiper-pagination-gallery-exact {
        position: relative !important;
        width: auto !important;
        height: auto !important;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px; /* Увеличил gap между кружочками */
        margin-top: 0;
        bottom: auto !important;
        left: auto !important;
    }
    
    .swiper-pagination-gallery-exact .swiper-pagination-bullet {
        width: 16px; /* УВЕЛИЧИЛ с 12px до 16px */
        height: 16px; /* УВЕЛИЧИЛ с 12px до 16px */
        background: transparent;
        opacity: 0.7;
        border: 2px solid #ffffff; /* Увеличил толщину границы */
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
        margin: 0 !important;
    }
    
    .swiper-pagination-gallery-exact .swiper-pagination-bullet-active {
        background: #ffffff;
        opacity: 1;
        transform: scale(1.3); /* УВЕЛИЧИЛ с 1.2 до 1.3 */
        box-shadow: 0 0 12px rgba(255, 255, 255, 0.5); /* Усилил тень */
    }
    
    .swiper-pagination-gallery-exact .swiper-pagination-bullet:hover {
        opacity: 0.9;
        transform: scale(1.2); /* Увеличил эффект при наведении */
        border-color: #ffffff;
    }
    
    /* Адаптивность - обновленные значения для больших фото */
    @media (max-width: 1400px) {
        .gallery-container-exact {
            height: 450px;
        }
        
        .swiper-slide {
            width: 400px;
            height: 400px;
        }
    }
    
    @media (max-width: 1200px) {
        .gallery-container-exact {
            height: 420px;
        }
        
        .swiper-slide {
            width: 380px;
            height: 380px;
        }
    }
    
    @media (max-width: 992px) {
        .gallery-container-exact {
            height: 380px;
        }
        
        .swiper-slide {
            width: 350px;
            height: 350px;
        }
        
        .swiper-pagination-gallery-exact .swiper-pagination-bullet {
            width: 14px; /* Немного меньше на планшетах */
            height: 14px;
        }
        
        .swiper-pagination-gallery-exact .swiper-pagination-bullet-active {
            transform: scale(1.25);
        }
    }
    
    @media (max-width: 768px) {
        .gallery-container-exact {
            height: 350px;
            margin-bottom: 30px;
        }
        
        .swiper-slide {
            width: 320px;
            height: 320px;
        }
        
        .gallery-pagination-wrapper-exact {
            padding: 20px 0; /* Меньше padding на мобильных */
        }
        
        .swiper-pagination-gallery-exact {
            gap: 15px;
        }
        
        .swiper-pagination-gallery-exact .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            border-width: 1.5px;
        }
        
        .swiper-pagination-gallery-exact .swiper-pagination-bullet-active {
            transform: scale(1.2);
        }
    }
    
    @media (max-width: 576px) {
        .gallery-container-exact {
            height: 320px;
        }
        
        .swiper-slide {
            width: 300px;
            height: 300px;
        }
        
        .gallery-pagination-wrapper-exact {
            padding: 15px 0;
        }
        
        .swiper-pagination-gallery-exact {
            gap: 12px;
        }
        
        .swiper-pagination-gallery-exact .swiper-pagination-bullet {
            width: 10px;
            height: 10px;
            border-width: 1.5px;
        }
        
        .swiper-pagination-gallery-exact .swiper-pagination-bullet-active {
            transform: scale(1.2);
        }
    }
    
    @media (max-width: 480px) {
        .gallery-container-exact {
            height: 280px;
        }
        
        .swiper-slide {
            width: 260px;
            height: 260px;
        }
        
        .swiper-pagination-gallery-exact {
            gap: 10px;
        }
        
        .swiper-pagination-gallery-exact .swiper-pagination-bullet {
            width: 8px;
            height: 8px;
        }
    }
</style>
    
<section class="section-exact" id="reservation">
    <div class="container-exact">
        <!-- Заголовок перенесен внутрь формы -->
        <div class="reservation-simple-exact">
            <!-- Левая часть: Картинка на фоне с формой поверх -->
            <div class="reservation-background-exact">
                <div class="reservation-bg-image-exact" 
                     style="background-image: url('{{ asset('images/reservation/photo2.png') }}');">
                </div>
                
                <!-- Форма поверх картинки -->
                <div class="reservation-form-overlay-exact">
                    <div class="form-container-exact">
                        
                        <form action="{{ route('reservation.store') }}" method="POST">
                            @csrf
                            
                            <!-- Заголовок внутри формы -->
                            <h2 class="section-title-exact" style="color: var(--text-light);margin-bottom: 20px;">
                                Столик для вас
                            </h2>
                            
                            <div class="form-grid-exact">
                                <!-- ПЕРВЫЙ РЯД: Имя и Телефон - ОДИНАКОВЫЕ И ДЛИННЫЕ -->
                                <div class="form-group-exact name-field">
                                    <label class="form-label-exact">Имя</label>
                                    <input type="text" class="form-control-exact" name="name" 
                                           value="{{ old('name', Auth::check() ? Auth::user()->full_name : '') }}" required>
                                    @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group-exact phone-field">
                                    <label class="form-label-exact">Телефон</label>
                                    <input type="tel" class="form-control-exact" name="phone" 
                                           value="{{ old('phone', Auth::check() ? Auth::user()->phone : '') }}" required>
                                    @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- ВТОРОЙ РЯД: Дата, Время, Гости - все на одном уровне -->
                                <!-- Для этого используем отдельный контейнер для второго ряда -->
                                <div class="second-row-container">
                                    <div class="form-group-exact date-field">
                                        <label class="form-label-exact">Дата</label>
                                        <input type="date" class="form-control-exact" name="date" 
                                               value="{{ old('date', date('Y-m-d')) }}" required
                                               min="{{ date('Y-m-d') }}">
                                        @error('date')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group-exact time-field">
                                        <label class="form-label-exact">Время</label>
                                        <select class="form-control-exact" name="time" required>
                                            <option value="19:00" {{ old('time') == '19:00' ? 'selected' : '' }}>19:00</option>
                                            <option value="19:30" {{ old('time') == '19:30' ? 'selected' : '' }}>19:30</option>
                                            <option value="20:00" {{ old('time') == '20:00' ? 'selected' : '' }}>20:00</option>
                                            <option value="20:30" {{ old('time') == '20:30' ? 'selected' : '' }}>20:30</option>
                                            <option value="21:00" {{ old('time') == '21:00' ? 'selected' : '' }}>21:00</option>
                                        </select>
                                        @error('time')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group-exact guests-field">
                                        <label class="form-label-exact">Гости</label>
                                        <select class="form-control-exact" name="guests" required>
                                            @for($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}" {{ old('guests', 2) == $i ? 'selected' : '' }}>
                                                {{ $i }} {{ trans_choice('гость|гостя|гостей', $i) }}
                                            </option>
                                            @endfor
                                        </select>
                                        @error('guests')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-check-exact">
                                    <input type="checkbox" class="form-check-input-exact" 
                                           id="privacy" name="privacy" value="1" 
                                           {{ old('privacy') ? 'checked' : '' }} required>
                                    <label class="form-check-label-exact" for="privacy">
                                        Я даю согласие на обработку персональных данных
                                    </label>
                                    @error('privacy')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <button type="submit" class="btn-exact">
                                    Забронировать
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Правая часть: Картинка -->
            <div class="reservation-side-image-exact">
                <img src="{{ asset('images/reservation/photo.png') }}" 
                     alt="Столик в ресторане Созвездие вкусов" 
                     class="side-image-exact">
            </div>
        </div>
    </div>
</section>

<style>
    /* Основной контейнер */
    .reservation-simple-exact {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 0;
        height: 600px;
        overflow: hidden;
    }
    
    /* Левая часть: фоновая картинка с формой поверх */
    .reservation-background-exact {
        position: relative;
        height: 500px;
        margin-top: 50px;
        overflow: hidden;
    }
    
    .reservation-bg-image-exact {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        z-index: 1;
    }
    
    /* Форма поверх картинки */
    .reservation-form-overlay-exact {
        position: relative;
        z-index: 2;
        height: 100%;
        display: flex;
        align-items: center;
        padding: 40px;
        padding-left: 60px;
    }
    
    .form-container-exact {
        width: 100%;
        max-width: 800px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }
    
    /* Правая часть: Картинка */
    .reservation-side-image-exact {
        height: 100%;
        overflow: hidden;
    }
    
    .side-image-exact {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.7s ease;
    }
    
    .reservation-side-image-exact:hover .side-image-exact {
        transform: scale(1.05);
    }
    
    /* СТИЛИ ФОРМЫ: ПРОСТАЯ И ЧЕТКАЯ СЕТКА */
    .form-grid-exact {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
    }
    
    /* ПЕРВЫЙ РЯД: Имя и Телефон - ОДИНАКОВЫЕ И ДЛИННЫЕ */
    .form-grid-exact .name-field {
        grid-column: 1;
        grid-row: 1;
    }
    
    .form-grid-exact .phone-field {
        grid-column: 2;
        grid-row: 1;
    }
    
    /* ВТОРОЙ РЯД: Контейнер для полей даты, времени и гостей */
    .second-row-container {
        grid-column: 1 / span 2; /* Занимает обе колонки */
        grid-row: 2;
        display: grid;
        grid-template-columns: 1fr 1fr 1fr; /* 3 равные колонки */
        gap: 25px;
        margin-top: 0;
    }
    
    /* Поля внутри второго ряда */
    .second-row-container .date-field {
        grid-column: 1;
    }
    
    .second-row-container .time-field {
        grid-column: 2;
    }
    
    .second-row-container .guests-field {
        grid-column: 3;
    }
    
    /* Чекбокс и кнопка */
    .form-check-exact {
        grid-column: 1 / span 2;
        grid-row: 3;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .btn-exact {
        grid-column: 1 / span 2;
        grid-row: 4;
        padding: 8px 30px;
        font-size: 17px;
        height: 45px;
        width: 200px;
    }
    
    /* ДЕЛАЕМ ИМЯ И ТЕЛЕФОН ОДИНАКОВЫМИ И ДЛИННЫМИ */
    .form-group-exact {
        width: 100%;
    }
    
    .form-control-exact {
        width: 100%;
        padding: 15px 20px;
        background: var(--bg-dark);
        border: 1px solid var(--border);
        color: var(--text-light);
        font-size: 17px;
        transition: all 0.3s ease;
        min-height: 55px;
        box-sizing: border-box;
    }
    
    /* ОДИНАКОВЫЙ РАЗМЕР ДЛЯ ИМЕНИ И ТЕЛЕФОНА */
    .name-field .form-control-exact,
    .phone-field .form-control-exact {
        min-width: 100%;
    }
    
    /* ОДИНАКОВЫЙ РАЗМЕР ДЛЯ ДАТЫ, ВРЕМЕНИ И ГОСТЕЙ */
    .date-field .form-control-exact,
    .time-field .form-control-exact,
    .guests-field .form-control-exact {
        min-width: 100%;
    }
    
    select.form-control-exact {
        height: 62px;
        line-height: 55px;
    }
    
    /* Сделал метки больше */
    .form-label-exact {
        display: block;
        font-weight: 500;
        color: var(--text-light);
        font-size: 16px;
    }
    
    .form-control-exact:focus {
        outline: none;
        border-color: var(--accent);
        background: var(--bg-light);
        box-shadow: 0 0 0 3px rgba(201, 168, 106, 0.3);
    }
    
    .form-check-input-exact {
        width: 20px;
        height: 20px;
        accent-color: var(--accent);
        flex-shrink: 0;
    }
    
    .form-check-label-exact {
        color: var(--text-gray);
        font-size: 15px;
        line-height: 1.5;
    }
    
    /* Сообщения */
    .alert {
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 25px;
        border: 1px solid transparent;
    }
    
    .alert-success {
        background-color: rgba(25, 135, 84, 0.1);
        border-color: rgba(25, 135, 84, 0.2);
        color: #198754;
    }
    
    .alert-danger {
        background-color: rgba(220, 53, 69, 0.1);
        border-color: rgba(220, 53, 69, 0.2);
        color: #dc3545;
    }
    
    /* Адаптивность */
    @media (max-width: 1400px) {
        .form-container-exact {
            max-width: 750px;
        }
        
        .reservation-form-overlay-exact {
            padding-left: 50px;
        }
    }
    
    @media (max-width: 1200px) {
        .reservation-simple-exact {
            height: 550px;
        }
        
        .form-container-exact {
            padding: 35px;
            max-width: 700px;
        }
        
        .reservation-form-overlay-exact {
            padding: 30px;
            padding-left: 40px;
        }
        
        .form-control-exact {
            padding: 14px 18px;
            font-size: 16px;
        }
        
        /* На средних экранах второй ряд тоже в 3 колонки */
        .second-row-container {
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
        }
    }
    
    @media (max-width: 1100px) {
        .form-container-exact {
            max-width: 650px;
        }
        
        .reservation-form-overlay-exact {
            padding-left: 30px;
        }
        
        .form-grid-exact {
            gap: 20px;
        }
        
        .second-row-container {
            gap: 15px;
        }
    }
    
    @media (max-width: 992px) {
        .reservation-simple-exact {
            grid-template-columns: 1fr;
            height: auto;
        }
        
        .reservation-background-exact {
            height: 750px; /* Увеличил высоту для планшета */
        }
        
        .reservation-side-image-exact {
            height: 400px;
        }
        
        .form-container-exact {
            max-width: 90%;
            margin: 0 auto;
        }
        
        .reservation-form-overlay-exact {
            align-items: flex-start;
            padding-top: 30px;
            padding-left: 0;
            justify-content: center;
        }
        
        /* На планшетах: все поля в 2 колонки */
        .form-grid-exact {
            grid-template-columns: 1fr 1fr;
        }
        
        .form-grid-exact .name-field {
            grid-column: 1;
            grid-row: 1;
        }
        
        .form-grid-exact .phone-field {
            grid-column: 2;
            grid-row: 1;
        }
        
        /* Второй ряд на планшете: 3 поля в 2 колонках (дата и время в первой, гости во второй) */
        .second-row-container {
            grid-column: 1 / span 2;
            grid-row: 2;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .second-row-container .date-field {
            grid-column: 1;
            grid-row: 1;
        }
        
        .second-row-container .time-field {
            grid-column: 2;
            grid-row: 1;
        }
        
        .second-row-container .guests-field {
            grid-column: 1 / span 2; /* Гости занимают всю ширину на следующей строке */
            grid-row: 2;
            width: 50%;
            margin-left: 25%;
        }
        
        .form-check-exact {
            grid-column: 1 / span 2;
            grid-row: 3;
        }
        
        .btn-exact {
            grid-column: 1 / span 2;
            grid-row: 4;
        }
    }
    
    @media (max-width: 768px) {
        .reservation-background-exact {
            height: 850px; /* Еще увеличил для мобильных */
        }
        
        .reservation-side-image-exact {
            height: 350px;
        }
        
        .reservation-form-overlay-exact {
            padding: 20px;
        }
        
        .form-container-exact {
            padding: 30px;
            max-width: 95%;
        }
        
        /* На мобильных - одна колонка */
        .form-grid-exact {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        /* Сбрасываем позиционирование для мобильных */
        .form-grid-exact .name-field,
        .form-grid-exact .phone-field {
            grid-column: 1;
            grid-row: auto;
        }
        
        /* Второй ряд на мобильных: все поля в один столбец */
        .second-row-container {
            grid-column: 1;
            grid-row: auto;
            grid-template-columns: 1fr;
            gap: 20px;
            margin-top: 0;
        }
        
        .second-row-container .date-field,
        .second-row-container .time-field,
        .second-row-container .guests-field {
            grid-column: 1;
            grid-row: auto;
            width: 100%;
            margin-left: 0;
        }
        
        .form-check-exact {
            grid-column: 1;
            grid-row: auto;
        }
        
        .btn-exact {
            grid-column: 1;
            grid-row: auto;
        }
        
        .form-control-exact {
            padding: 14px 16px;
            min-height: 52px;
            font-size: 16px;
        }
        
        .btn-exact {
            height: 54px;
            font-size: 16px;
        }

        
    }
    
    @media (max-width: 576px) {
        .reservation-background-exact {
            height: 950px; /* Максимальная высота для самых маленьких экранов */
        }
        
        .reservation-side-image-exact {
            height: 300px;
        }
        
        .reservation-form-overlay-exact {
            padding: 15px;
        }
        
        .form-container-exact {
            padding: 25px;
        }
        
        .form-check-exact {
            align-items: flex-start;
        }
        
        .section-title-exact {
            font-size: 26px;
            margin-bottom: 25px;
        }
        
    }
    
    @media (max-width: 400px) {
        .reservation-background-exact {
            height: 1000px; /* На очень маленьких экранах */
        }
        
        .form-container-exact {
            padding: 20px;
        }
        
        .form-grid-exact {
            gap: 15px;
        }
        
        .second-row-container {
            gap: 15px;
        }
        
        .btn-exact {
            height: 52px;
            font-size: 15px;
        }
    }
</style>

<!-- Контакты -->
<section class="section-exact" id="contacts">
    <div class="container-exact">
        <h2 class="section-title-exact">Контакты</h2>
        
        <div class="contacts-grid-exact">
            <!-- Левая часть: информация -->
            <div class="contacts-info-exact">
                <div class="contact-item-exact">
                    <strong>Телефон</strong>
                    <p>8(8545)-33-22-22</p>
                </div>
                
                <div class="contact-item-exact">
                    <strong>Адрес</strong>
                    <p>г. Набережные Челны, проспект Сююмбике, 2</p>
                </div>
                
                <div class="contact-item-exact">
                    <strong>Время работы</strong>
                    <p>
                        Пн-пт: 10:00-23:00<br>
                        Сб-вс: 9:00-23:00
                    </p>
                </div>
                
                <!-- Кнопка в стиле главной -->
                 <a href="https://yandex.ru/maps/?text=г.%20Набережные%20Челны,%20проспект%20Сююмбике,%202" 
                   target="_blank" 
                    class="btn-exact how-to-get-btn">
                   Как добраться
                </a>
            </div>
            
            <!-- Правая часть: Яндекс Карта -->
            <div class="contacts-map-exact">
                <iframe 
                    src="https://yandex.ru/map-widget/v1/?ll=52.413870%2C55.724955&z=16&pt=52.413870,55.724955,pm2rdm" 
                    width="700" 
                    height="570" 
                    frameborder="0" 
                    allowfullscreen="true" 
                    style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); margin-top: -80px;">
                </iframe>
            </div>
        </div>
    </div>
</section>

<style>
    /* Стили ТОЛЬКО для блока контактов */
    .contacts-grid-exact {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 50px;
        align-items: start;
        margin-top: -20px;
    }
    
    .contacts-info-exact {
        display: flex;
        flex-direction: column;
        height: 100%;
        padding-top: 20px;
    }
    
    /* Стили для кнопки "Как добраться" как главная кнопка */
    .how-to-get-btn {
        display: inline-block;
        padding: 14px 32px;
        background: #ffffff;
        color: black;
        border: none;
        height: 60px;
        text-decoration: none;
        font-weight: 600;
        font-size: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        margin-top: 20px;
        max-width: 250px;
    }
    
    .how-to-get-btn:hover {
        background: #f0f0f0;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .contact-item-exact {
        margin-bottom: 15px;
    }
    
    .contact-item-exact:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    
    .contact-item-exact strong {
        display: block;
        color: var(--text-light);
        font-weight: 700;
        margin-bottom: 8px;
        font-size: 24px;
    }
    
    .contact-item-exact p {
        color: #ffffff;
        font-size: 22px;
        font-weight: 400;
        line-height: 1.4;
    }
    
    .contacts-map-exact {
        display: flex;
        align-items: flex-start;
        height: 100%;
    }
    
    /* Адаптивность для карты */
    @media (max-width: 1200px) {
        .contacts-grid-exact {
            gap: 40px;
        }
        
        .contacts-map-exact iframe {
            height: 500px;
            width: 100%;
        }
        
        .contact-item-exact strong {
            font-size: 18px;
        }
        
        .contact-item-exact p {
            font-size: 16px;
        }
        
        .how-to-get-btn {
            padding: 12px 28px;
            font-size: 18px;
        }
    }
    
    @media (max-width: 992px) {
        .contacts-grid-exact {
            grid-template-columns: 1fr;
            gap: 40px;
            margin-top: 0;
        }
        
        .contacts-info-exact {
            order: 2;
            padding-top: 0;
        }
        
        .contacts-map-exact {
            order: 1;
        }
        
        .contacts-map-exact iframe {
            height: 400px;
            margin-top: 0;
            width: 100%;
        }
        
        .how-to-get-btn {
            max-width: 220px;
        }
    }
    
    @media (max-width: 768px) {
        .contacts-grid-exact {
            gap: 30px;
        }
        
        .contacts-map-exact iframe {
            height: 350px;
        }
        
        .contact-item-exact {
            margin-bottom: 20px;
            padding-bottom: 20px;
        }
        
        .contact-item-exact strong {
            font-size: 17px;
        }
        
        .contact-item-exact p {
            font-size: 15px;
        }
        
        .how-to-get-btn {
            padding: 10px 24px;
            font-size: 16px;
            max-width: 200px;
        }
    }
    
    @media (max-width: 480px) {
        .contacts-map-exact iframe {
            height: 280px;
        }
        
        .contact-item-exact {
            margin-bottom: 15px;
            padding-bottom: 15px;
        }
        
        .contact-item-exact strong {
            font-size: 16px;
        }
        
        .contact-item-exact p {
            font-size: 14px;
        }
        
        .how-to-get-btn {
            padding: 8px 20px;
            font-size: 14px;
            max-width: 180px;
        }
    }
</style>
@endsection


@push('scripts')
<script>

 // Слайдер для популярных блюд
document.addEventListener('DOMContentLoaded', function() {
    // Инициализация всех слайдеров
    const dishSliders = document.querySelectorAll('.dishes-swiper-exact');
    const swiperInstances = {};
    
    dishSliders.forEach((slider, index) => {
        const sliderId = slider.closest('.category-slider-exact').id;
        swiperInstances[sliderId] = new Swiper(slider, {
            loop: false,
            slidesPerView: 3,
            spaceBetween: 10,
            speed: 500,
            grabCursor: true,
            
            // Навигация
            navigation: {
                nextEl: slider.querySelector('.dishes-slider-next'),
                prevEl: slider.querySelector('.dishes-slider-prev'),
            },
            
            // Пагинация
            pagination: {
                el: slider.querySelector('.dishes-pagination'),
                clickable: true,
            },
            
            // Адаптивность с более плотным расположением
            breakpoints: {
                1400: {
                    slidesPerView: 3,
                    spaceBetween: 10
                },
                1200: {
                    slidesPerView: 2.8,
                    spaceBetween: 8
                },
                992: {
                    slidesPerView: 2.5,
                    spaceBetween: 8
                },
                768: {
                    slidesPerView: 2.2,
                    spaceBetween: 6
                },
                576: {
                    slidesPerView: 1.8,
                    spaceBetween: 5
                },
                480: {
                    slidesPerView: 1.5,
                    spaceBetween: 5
                },
                320: {
                    slidesPerView: 1.2,
                    spaceBetween: 5
                }
            }
        });
    });
    
    // Переключение категорий
    const categoryTabs = document.querySelectorAll('.category-tab-exact');
    const categorySliders = document.querySelectorAll('.category-slider-exact');
    
    categoryTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const category = this.dataset.category;
            
            // Удаляем активный класс у всех вкладок
            categoryTabs.forEach(t => t.classList.remove('active'));
            // Добавляем активный класс текущей вкладке
            this.classList.add('active');
            
            // Скрываем все слайдеры
            categorySliders.forEach(slider => {
                slider.classList.remove('active');
                slider.style.display = 'none';
                slider.style.opacity = '0';
            });
            
            // Показываем выбранный слайдер
            const targetSlider = document.getElementById(`${category}-slider`);
            if (targetSlider) {
                targetSlider.style.display = 'block';
                setTimeout(() => {
                    targetSlider.style.opacity = '1';
                    targetSlider.classList.add('active');
                    
                    // Обновляем слайдер
                    const sliderId = targetSlider.id;
                    if (swiperInstances[sliderId]) {
                        swiperInstances[sliderId].update();
                        swiperInstances[sliderId].updateSlides();
                    }
                }, 10);
            }
        });
    });
    
    // Обновление при изменении размера окна
    window.addEventListener('resize', function() {
        const activeSlider = document.querySelector('.category-slider-exact.active');
        if (activeSlider) {
            const sliderId = activeSlider.id;
            if (swiperInstances[sliderId]) {
                swiperInstances[sliderId].update();
                swiperInstances[sliderId].updateSlides();
            }
        }
    });
});
    
    document.addEventListener('DOMContentLoaded', function() {
        // Инициализация галереи с 3 фото одновременно
        const gallerySwiper = new Swiper('.gallery-swiper-exact', {
            loop: true,
            slidesPerView: 3,
            spaceBetween: 30,
            speed: 600,
            grabCursor: true,
            
            // Навигация
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            
            // Пагинация
            pagination: {
                el: '.swiper-pagination-gallery-exact',
                clickable: true,
                bulletClass: 'swiper-pagination-bullet',
                bulletActiveClass: 'swiper-pagination-bullet-active',
            },
            
            // Автопрокрутка
             autoplay: { delay: 4000, disableOnInteraction: false, pauseOnMouseEnter: true, },
          
            
            // Адаптивность
            breakpoints: {
                1200: {
                    slidesPerView: 3,
                    spaceBetween: 30
                },
                992: {
                    slidesPerView: 2.5,
                    spaceBetween: 25
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                576: {
                    slidesPerView: 1.5,
                    spaceBetween: 15
                },
                320: {
                    slidesPerView: 1,
                    spaceBetween: 10
                }
            },
            
            // События
            on: {
                init: function () {
                    console.log('Swiper инициализирован');
                }
            }
        });
        
        // Установка минимальной даты для формы бронирования
        const today = new Date().toISOString().split('T')[0];
        const dateInput = document.querySelector('input[name="date"]');
        if (dateInput) {
            dateInput.min = today;
        }
        
        // Стили для кнопок навигации
        const style = document.createElement('style');
        style.textContent = `
            .swiper-button-prev,
            .swiper-button-next {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                width: 40px;
                height: 40px;
                background: rgba(0, 0, 0, 0.5);
                border-radius: 50%;
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 10;
                cursor: pointer;
                transition: background 0.3s ease;
            }
            
            .swiper-button-prev:hover,
            .swiper-button-next:hover {
                background: rgba(0, 0, 0, 0.8);
            }
            
            .swiper-button-prev {
                left: 10px;
            }
            
            .swiper-button-next {
                right: 10px;
            }
            
            .swiper-button-prev i,
            .swiper-button-next i {
                font-size: 20px;
            }
            
            @media (max-width: 768px) {
                .swiper-button-prev,
                .swiper-button-next {
                    width: 35px;
                    height: 35px;
                }
                
                .swiper-button-prev i,
                .swiper-button-next i {
                    font-size: 18px;
                }
            }
        `;
        document.head.appendChild(style);
    });
</script>
@endpush

<!-- ===== КРАСИВЫЕ УВЕДОМЛЕНИЯ ТОЛЬКО В ПРАВОМ ВЕРХНЕМ УГЛУ ===== -->
<style>
/* Контейнер для уведомлений - ТОЛЬКО СПРАВА */
.notification-elegant-container {
    position: fixed;
    top: 100px;
    right: 30px;
    z-index: 99999;
    display: flex;
    flex-direction: column;
    gap: 15px;
    max-width: 380px;
    width: 100%;
    pointer-events: none;
}

/* Стиль уведомления */
.notification-elegant {
    background: rgba(31, 31, 31, 0.95);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(201, 168, 106, 0.3);
    border-radius: 16px;
    padding: 18px 22px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
    display: flex;
    align-items: center;
    gap: 16px;
    transform: translateX(120%);
    animation: slideIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    pointer-events: auto;
    position: relative;
    overflow: hidden;
    border-left: 6px solid var(--accent);
}

/* Иконка уведомления */
.notification-elegant-icon {
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, rgba(201, 168, 106, 0.15), rgba(201, 168, 106, 0.05));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: var(--accent);
    border: 1px solid rgba(201, 168, 106, 0.3);
    flex-shrink: 0;
}

/* Контент уведомления */
.notification-elegant-content {
    flex: 1;
}

.notification-elegant-title {
    font-weight: 700;
    font-size: 16px;
    color: #fff;
    margin-bottom: 4px;
    letter-spacing: 0.3px;
}

.notification-elegant-message {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.4;
}

/* Кнопка закрытия */
.notification-elegant-close {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.notification-elegant-close:hover {
    background: rgba(201, 168, 106, 0.2);
    color: var(--accent);
    border-color: var(--accent);
}

/* Прогресс-бар */
.notification-elegant-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--accent), #e6c38a);
    animation: progress 4s linear forwards;
    border-radius: 0 0 0 3px;
}

/* Анимации */
@keyframes slideIn {
    0% { transform: translateX(120%); opacity: 0; }
    100% { transform: translateX(0); opacity: 1; }
}

@keyframes slideOut {
    0% { transform: translateX(0); opacity: 1; }
    100% { transform: translateX(120%); opacity: 0; }
}

@keyframes progress {
    0% { width: 100%; }
    100% { width: 0%; }
}

/* Типы уведомлений */
.notification-elegant.success {
    border-left-color: #4CAF50;
}
.notification-elegant.success .notification-elegant-icon {
    color: #4CAF50;
    border-color: rgba(76, 175, 80, 0.3);
    background: linear-gradient(135deg, rgba(76, 175, 80, 0.15), rgba(76, 175, 80, 0.05));
}

.notification-elegant.warning {
    border-left-color: #FFC107;
}
.notification-elegant.warning .notification-elegant-icon {
    color: #FFC107;
    border-color: rgba(255, 193, 7, 0.3);
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.15), rgba(255, 193, 7, 0.05));
}

.notification-elegant.error {
    border-left-color: #F44336;
}
.notification-elegant.error .notification-elegant-icon {
    color: #F44336;
    border-color: rgba(244, 67, 54, 0.3);
    background: linear-gradient(135deg, rgba(244, 67, 54, 0.15), rgba(244, 67, 54, 0.05));
}

.notification-elegant.info {
    border-left-color: #29B6F6;
}
.notification-elegant.info .notification-elegant-icon {
    color: #29B6F6;
    border-color: rgba(41, 182, 246, 0.3);
    background: linear-gradient(135deg, rgba(41, 182, 246, 0.15), rgba(41, 182, 246, 0.05));
}

/* Адаптивность */
@media (max-width: 768px) {
    .notification-elegant-container {
        top: 20px;
        right: 20px;
        left: auto;
        max-width: 300px;
    }
}
</style>

<!-- Контейнер для уведомлений ТОЛЬКО СПРАВА -->
<div class="notification-elegant-container" id="notificationContainer"></div>

<script>
// Функция показа красивых уведомлений ТОЛЬКО В ПРАВОМ УГЛУ
function showElegantNotification(message, type = 'success', title = '') {
    const container = document.getElementById('notificationContainer');
    if (!container) return;
    
    // Определяем заголовок и иконку
    let notificationTitle = '';
    let iconClass = '';
    
    switch(type) {
        case 'success':
            notificationTitle = title || 'Успешно!';
            iconClass = 'bi-check-circle-fill';
            break;
        case 'warning':
            notificationTitle = title || 'Внимание!';
            iconClass = 'bi-exclamation-triangle-fill';
            break;
        case 'error':
            notificationTitle = title || 'Ошибка!';
            iconClass = 'bi-x-circle-fill';
            break;
        case 'info':
            notificationTitle = title || 'Информация';
            iconClass = 'bi-info-circle-fill';
            break;
        default:
            notificationTitle = title || 'Уведомление';
            iconClass = 'bi-bell-fill';
    }
    
    // Создаем уведомление
    const notification = document.createElement('div');
    notification.className = `notification-elegant ${type}`;
    notification.innerHTML = `
        <div class="notification-elegant-icon">
            <i class="bi ${iconClass}"></i>
        </div>
        <div class="notification-elegant-content">
            <div class="notification-elegant-title">${notificationTitle}</div>
            <div class="notification-elegant-message">${message}</div>
        </div>
        <div class="notification-elegant-close">
            <i class="bi bi-x"></i>
        </div>
        <div class="notification-elegant-progress"></div>
    `;
    
    container.appendChild(notification);
    
    // Кнопка закрытия
    const closeBtn = notification.querySelector('.notification-elegant-close');
    closeBtn.addEventListener('click', function() {
        notification.style.animation = 'slideOut 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards';
        setTimeout(() => notification.remove(), 500);
    });
    
    // Авто-закрытие через 4 секунды
    setTimeout(() => {
        if (notification.parentNode) {
            notification.style.animation = 'slideOut 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards';
            setTimeout(() => notification.remove(), 500);
        }
    }, 4000);
}

// Показываем ТОЛЬКО уведомления из сессии - НИКАКИХ ПРИВЕТСТВИЙ
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        showElegantNotification('{{ session('success') }}', 'success', 'Успешно!');
    @endif
    
    @if(session('error'))
        showElegantNotification('{{ session('error') }}', 'error', 'Ошибка!');
    @endif
    
    @if(session('warning'))
        showElegantNotification('{{ session('warning') }}', 'warning', 'Внимание!');
    @endif
    
    @if(session('info'))
        showElegantNotification('{{ session('info') }}', 'info', 'Информация');
    @endif
});
</script>
