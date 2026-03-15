@extends('layouts.app')

@section('content')
   <!-- Герой секция с полями -->
<section class="hero-exact" id="home">
    <div class="hero-exact-background-photo">
        <div class="container-exact hero-container-exact">
            <div class="row align-items-center hero-row-exact">
                <!-- Текст слева -->
                <div class="col-12 col-lg-6 order-2 order-lg-1">
                    <div class="hero-text-wrapper-exact">
                        <h1 class="hero-title-exact">Crimson Flame</h1>
                        <p class="hero-text-exact">
                            Широкий выбор блюд, в которых каждая ложка — это путешествие вкуса: от первого укуса до последнего мы создаём моменты, которые хочется повторять.
                        </p>
                        <div class="hero-buttons-exact">
                            <a href="{{ route('menu') }}" class="btn-menu-primary">
                                Посмотреть меню
                            </a>
                            <a href="{{ route('home') }}#reservation" class="btn-reservation-outline hero-reservation-btn btn-menu-primary">
                                Забронировать стол
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Картинка справа (скрывается при ≤990px) -->
                <div class="col-12 col-lg-6 order-1 order-lg-2 hero-image-col">
                    <div class="hero-image-exact">
                        <img src="{{ asset('images/hero/hero-photo.png') }}" 
                             alt="Интерьер ресторана Crimson Flame" 
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
        overflow-x: hidden;
    }

    .hero-exact-background-photo {
        background-image:
            linear-gradient(rgba(0,0,0,.75), rgba(0,0,0,.45)),
            url("../images/hero/black-stone-background-photo.webp");
        background-size: cover;
        background-position: center;
        padding: 40px 0 60px;
    }

    .hero-container-exact {
        padding-left: 20px;
        padding-right: 20px;
    }

    .hero-row-exact {
        --hero-gap: 40px;
    }

    .hero-text-wrapper-exact {
        margin-top: 20px;
    }

    .hero-title-exact {
        font-size: clamp(36px, 8vw, 90px);
        font-family: "Adieu-Bold";
        font-weight: 900;
        color: var(--text-light);
        margin-bottom: 20px;
        line-height: 1.1;
    }

    .hero-text-exact {
        font-family: "Adieu-Regular";
        font-size: clamp(16px, 2.2vw, 25px);
        color: #ffffff;
        line-height: 1.45;
        max-width: 540px;
    }

    .hero-buttons-exact {
        display: flex;
        margin-top: 28px;
        margin-bottom: 0;
        gap: 20px;
        align-items: center;
        flex-wrap: wrap;
    }

    .btn-menu-primary {
        padding: 14px 28px;
        border-radius: 24px;
        background-color: #AD1C43;
        color: rgb(255, 255, 255);
        border: none;
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 0;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .btn-menu-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(173, 28, 67, 0.4);
    }

    .btn-reservation-outline {
        padding: 14px 28px;
        border-radius: 24px;
        background-color: #AD1C43;
        color: rgb(255, 255, 255);
        border: none;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

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

    .hero-image-exact {
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: visible;
    }

    .hero-img-exact {
        width: 100%;
        max-width: 420px;
        height: auto;
        aspect-ratio: 1;
        object-fit: cover;
        border-radius: 12px;
        transform: rotate(-6deg);
    }

    /* От 990px: фото скрыто, весь контент ровно по центру блока */
    @media (max-width: 990px) {
        .hero-image-col {
            display: none !important;
        }

        .hero-row-exact {
            justify-content: center;
            text-align: center;
        }

        .hero-row-exact .col-12.col-lg-6.order-2.order-lg-1 {
            max-width: 100%;
            flex: 0 0 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-text-wrapper-exact {
            margin-top: 0;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
            max-width: 560px;
            width: 100%;
        }

        .hero-title-exact {
            text-align: center;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 20px;
        }

        .hero-text-exact {
            text-align: center;
            max-width: 100%;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-buttons-exact {
            justify-content: center;
            margin-top: 28px;
        }
    }

    /* Планшет: отступы (фото уже скрыто выше 990px) */
    @media (max-width: 991px) {
        .hero-exact-background-photo {
            padding: 32px 0 48px;
        }
    }

    /* Мобильный */
    @media (max-width: 768px) {
        .hero-exact-background-photo {
            padding: 24px 0 40px;
        }

        .hero-container-exact {
            padding-left: 16px;
            padding-right: 16px;
        }

        .hero-title-exact {
            text-align: center;
            margin-bottom: 14px;
        }

        .hero-text-exact {
            text-align: center;
            font-size: 16px;
        }

        .hero-text-wrapper-exact {
            padding-bottom: 8px;
        }

        .hero-buttons-exact {
            flex-direction: column;
            margin-top: 20px;
            gap: 12px;
            align-items: stretch;
        }

        .hero-buttons-exact .btn-menu-primary {
            width: 100%;
            max-width: 280px;
            margin-left: auto;
            margin-right: auto;
            padding: 14px 24px;
            font-size: 15px;
        }

        .hero-img-exact {
            max-width: 280px;
        }
    }

    /* Маленькие телефоны (≤480px) — уменьшаем всё, чтобы влезало */
    @media (max-width: 480px) {
        .hero-exact-background-photo {
            padding: 16px 0 24px;
        }

        .hero-container-exact {
            padding-left: 10px;
            padding-right: 10px;
        }

        .hero-text-wrapper-exact {
            max-width: 100%;
        }

        .hero-title-exact {
            font-size: 24px;
            margin-bottom: 10px;
            line-height: 1.15;
        }

        .hero-text-exact {
            font-size: 14px;
            line-height: 1.4;
        }

        .hero-buttons-exact {
            margin-top: 16px;
            gap: 10px;
        }

        .hero-buttons-exact .btn-menu-primary {
            max-width: 100%;
            padding: 12px 20px;
            font-size: 14px;
        }

        .hero-img-exact {
            max-width: 200px;
        }
    }

    /* Очень узкие экраны (≤380px) */
    @media (max-width: 380px) {
        .hero-exact-background-photo {
            padding: 12px 0 20px;
        }

        .hero-container-exact {
            padding-left: 8px;
            padding-right: 8px;
        }

        .hero-title-exact {
            font-size: 22px;
        }

        .hero-text-exact {
            font-size: 13px;
        }

        .hero-buttons-exact .btn-menu-primary {
            padding: 11px 16px;
            font-size: 13px;
        }
    }
    
</style>

<!-- О ресторане -->
<section class="section-exact" id="about">
    <div class="container-exact">
        <div class="about-content-exact">
            <!-- Левая часть: Заголовок и текст -->
            <div class="about-left-exact">
                <h2 class="section-title-exact">О ресторане</h2>
                
                <div class="about-text-content-exact">
                    <p>
                       Crimson Flame — не просто ресторан, а место, где рождаются кулинарные истории.
                    </p>
                    <p>
                        Шеф-повар и команда берут за основу лучшие локальные продукты и превращают их в современные, изысканные блюда. В меню — смелые авторские решения и классика, исполненная с безупречной техникой.
                    </p>
                    <p>
                        Каждая деталь продумана: уютный интерьер с тёплым светом, выверенное меню и сервис, который чувствует ваши пожелания. Здесь время замедляется — для вкусной еды, хорошей компании и настоящего удовольствия.
                    </p>
                    <div class="about-btn-wrap">
                        <a href="{{ route('home') }}#reservation" class="about-reservation-btn">Забронировать стол</a>
                    </div>
                </div>
            </div>
            
            <!-- Правая часть: Фото -->
            <div class="about-right-exact">
                <div class="photos-grid-exact">
                    <!-- Большая фото слева -->
                    <div class="photo-large-wrapper-exact">
                        <img src="{{ asset('images/about/restaurant-1.jpg') }}" 
                             alt="Интерьер ресторана" 
                             class="about-img-large-exact">
                    </div>
                    
                    <!-- 2 маленькие квадратные фото справа -->
                    <div class="photos-small-wrapper-exact">
                        <div class="about-photo-small-exact">
                            <img src="{{ asset('images/about/restaurant-2.jpg') }}" 
                                 alt="Кухня ресторана" 
                                 class="about-img-small-exact">
                        </div>
                        <div class="about-photo-small-exact">
                            <img src="{{ asset('images/about/restaurant-3.jpg') }}" 
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

    .about-btn-wrap {
        margin-top: 24px;
    }

    .about-reservation-btn {
        display: inline-block;
        padding: 14px 28px;
        border-radius: 24px;
        background-color: var(--accent, #AD1C43);
        color: #fff;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .about-reservation-btn:hover {
        background-color: #c92355;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(173, 28, 67, 0.4);
    }

    /* Структура секции "О ресторане" */
    .about-content-exact {
        display: grid;
        grid-template-columns: 1.2fr 1.8fr; /* Фото занимают больше места */
        gap: 60px;
        align-items: start;
        margin-top: 60px;
    }
    
    .about-left-exact {
        display: flex;
        flex-direction: column;
        height: 100%;
        padding-right: 30px; /* Отступ от фото */
    }
    
    #about .section-title-exact {
        margin-bottom: 20px;
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
    
    
    /* Секция "О ресторане": контент не выходит за пределы, фото не залезают на следующий блок */
    #about.section-exact {
        overflow: hidden;
    }

    /* Адаптивность блока "О ресторане" */
    @media (max-width: 1200px) {
        .about-content-exact {
            gap: 50px;
            margin-top: 40px;
        }

        .photos-grid-exact {
            height: 520px;
        }

        .about-text-content-exact {
            max-width: 480px;
        }
    }

    /* С ~1000px: контент по центру; фото в одну сетку без обрезки */
    @media (max-width: 1024px) {
        #about.section-exact {
            margin-bottom: 80px;
            padding-bottom: 48px;
        }

        .about-content-exact {
            grid-template-columns: 1fr;
            gap: 36px;
            margin-top: 32px;
            justify-items: center;
            text-align: center;
        }

        .about-left-exact {
            padding-right: 0;
            max-width: 100%;
            align-items: center;
        }

        #about .section-title-exact {
            margin-bottom: 16px;
        }

        .about-text-content-exact {
            max-width: 100%;
            margin-left: auto;
            margin-right: auto;
        }

        .about-text-content-exact p {
            margin-bottom: 16px;
        }

        .about-btn-wrap {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        /* Сетка: большое + два маленьких без обрезки последнего */
        .photos-grid-exact {
            height: 340px;
            grid-template-columns: 2fr 1fr;
            grid-template-rows: 1fr;
            gap: 12px;
            max-width: 100%;
            margin: 0 auto;
        }

        .photos-small-wrapper-exact {
            display: flex;
            flex-direction: column;
            gap: 12px;
            min-height: 0;
        }

        .about-photo-small-exact {
            flex: 1;
            min-height: 0;
            aspect-ratio: unset;
            height: auto;
        }

        .about-img-small-exact {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    }

    /* Ниже 770px: три фото в один ряд одинакового размера, без смены кадра */
    @media (max-width: 768px) {
        #about.section-exact {
            margin-bottom: 60px;
            padding-bottom: 32px;
        }

        #about .container-exact {
            padding-left: 16px;
            padding-right: 16px;
        }

        .about-content-exact {
            gap: 28px;
            margin-top: 24px;
        }

        #about .section-title-exact {
            margin-bottom: 14px;
        }

        .about-text-content-exact p {
            font-size: 16px;
            margin-bottom: 14px;
        }

        .about-reservation-btn {
            padding: 12px 24px;
            font-size: 15px;
        }

        /* Один ряд, три равных колонки — все фото видны и полезны */
        .photos-grid-exact {
            grid-template-columns: 1fr 1fr 1fr;
            grid-template-rows: 1fr;
            height: 200px;
            gap: 10px;
            max-width: 100%;
        }

        .photo-large-wrapper-exact {
            grid-column: 1;
        }

        .photos-small-wrapper-exact {
            display: contents;
        }

        .about-photo-small-exact {
            min-height: 0;
            height: 100%;
            aspect-ratio: unset;
        }

        .photos-small-wrapper-exact .about-photo-small-exact:first-child {
            grid-column: 2;
        }

        .photos-small-wrapper-exact .about-photo-small-exact:last-child {
            grid-column: 3;
        }

        .about-img-small-exact,
        .about-img-large-exact {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    }

    @media (max-width: 480px) {
        #about.section-exact {
            margin-bottom: 48px;
        }

        #about .container-exact {
            padding-left: 12px;
            padding-right: 12px;
        }

        .about-content-exact {
            gap: 20px;
            margin-top: 16px;
        }

        #about .section-title-exact {
            margin-bottom: 12px;
        }

        .about-text-content-exact p {
            font-size: 14px;
            margin-bottom: 12px;
        }

        .about-btn-wrap {
            margin-top: 16px;
            text-align: center;
        }

        .about-reservation-btn {
            display: block;
            width: 100%;
            max-width: 280px;
            margin: 0 auto;
            padding: 12px 20px;
            font-size: 14px;
        }

        .photos-grid-exact {
            height: 160px;
            gap: 8px;
        }
    }
</style>

<!-- Фотогалерея -->
<section class="section-exact" id="gallery">
    <div class="container-exact">
        <h2 class="section-title-exact">Crimson Flame в кадре</h2>
        
        <div class="gallery-wrapper-exact">
            <div class="gallery-container-exact">
                <div class="swiper gallery-swiper-exact">
                    <div class="swiper-wrapper">
                        <!-- 6 слайдов с фотографиями -->
                        <div class="swiper-slide">
                            <div class="slide-image-wrapper-exact">
                                <img src="{{ asset('images/gallery/photo1.jpg') }}" 
                                     alt="Интерьер ресторана" 
                                     class="gallery-img-exact">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slide-image-wrapper-exact">
                                <img src="{{ asset('images/gallery/photo2.jpg') }}" 
                                     alt="Кухня ресторана" 
                                     class="gallery-img-exact">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slide-image-wrapper-exact">
                                <img src="{{ asset('images/gallery/photo3.jpg') }}" 
                                     alt="Зал ресторана" 
                                     class="gallery-img-exact">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slide-image-wrapper-exact">
                                <img src="{{ asset('images/gallery/photo4.jpg') }}" 
                                     alt="Блюда ресторана" 
                                     class="gallery-img-exact">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slide-image-wrapper-exact">
                                <img src="{{ asset('images/gallery/photo5.jpg') }}" 
                                     alt="Барная стойка" 
                                     class="gallery-img-exact">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slide-image-wrapper-exact">
                                <img src="{{ asset('images/gallery/photo6.jpg') }}" 
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
    
<!-- Бронирование -->
<section class="section-exact" id="reservation">
    <div class="container-exact">
        @include('booking._content')
    </div>
</section>
<style>
    #reservation .booking-page { min-height: auto; }
</style>

<!-- Контакты -->


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
                
                <a href="https://yandex.ru/maps/?text=г.%20Набережные%20Челны,%20проспект%20Сююмбике,%202" 
                   target="_blank" 
                   class="how-to-get-btn">
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
    
    /* Кнопка "Как добраться" в стиле остальных (как "Забронировать стол") */
    .how-to-get-btn {
        display: inline-block;
        padding: 14px 28px;
        border-radius: 24px;
        background-color: var(--accent, #AD1C43);
        color: #fff;
        border: none;
        text-decoration: none;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        margin-top: 20px;
        max-width: 250px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    
    .how-to-get-btn:hover {
        background-color: #c92355;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(173, 28, 67, 0.4);
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
            order: 1;
            padding-top: 0;
            text-align: center;
            align-items: center;
        }
        
        .contacts-map-exact {
            order: 2;
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
        
        .contacts-info-exact {
            text-align: center;
            align-items: center;
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
            padding: 12px 24px;
            font-size: 15px;
            max-width: 200px;
        }
    }
    
    @media (max-width: 480px) {
        .contacts-map-exact iframe {
            height: 280px;
        }
        
        .contacts-info-exact {
            text-align: center;
            align-items: center;
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
            padding: 12px 20px;
            font-size: 14px;
            max-width: 280px;
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
        border-left: 6px solid #AD1C43;
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
        color: #AD1C43;
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
        color: #AD1C43;
        border-color: #AD1C43;
    }

    /* Прогресс-бар */
    .notification-elegant-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        background: linear-gradient(90deg, #AD1C43, #e6c38a);
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