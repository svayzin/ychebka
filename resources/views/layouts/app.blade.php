<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Созвездие вкусов')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <style>
        :root {
            --bg-dark: #171717;
            --bg-card: #1F1F1F;
            --bg-light: #2A2A2A;
            --text-light: #FFFFFF;
            --text-gray: #B0B0B0;
            --text-dark: #E0E0E0;
            --border: #333333;
            --border-light: #404040;
            --accent: #AD1C43;
            --accent-light: #D4B77D;
            --accent-dark: #B89448;
        }

        @font-face {
            font-family: "Adieu-Light";
            src: url("/fonts/Adieu/Adieu-Light.ttf") format("truetype");
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: "Adieu-Regular";
            src: url("/fonts/avian/avian.otf") format("opentype");
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: "Adieu-Bold";
            src: url("/fonts/Adieu/Adieu-Bold.otf") format("truetype");
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: "Adieu-Black";
            src: url("/fonts/Adieu/Adieu-Black.ttf") format("truetype");
            font-style: normal;
            font-display: swap;
        }

        :root{
        --fw-light: 300;
        --fw-regular: 400;
        --fw-bold: 700;
        --fw-black: 900;
        }

        h1,h2,h3 { font-family: "Adieu-Bold"; }
        p     { font-family: "Adieu-Regular"; }
                
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: "Adieu-Regular";
            background-color: var(--bg-dark);
            color: var(--text-gray);
            line-height: 1.6;
        }
        
        /* Элегантная шапка */
        .header-elegant {
            background: var(--bg-dark);
            padding: 20px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
            background: #111111;
        }
        
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        /* Логотип */
        .logo {
            font-size: 24px;
            color: var(--text-light);
            text-decoration: none;
            letter-spacing: -0.5px;
        }
        .logo::before {
            content: url('../images/logo/logotype.svg');
            width: 100%;
            height: 100%;
        }
        
        .logo span {
            color: #AD1C43;
        }
        
        /* Основная навигация */
        .main-nav {
            display: flex;
            gap: 40px;
            align-items: center;
        }
        
        .nav-item {
            color: #ffffff;
            text-decoration: none;
            font-size: 20px;
            position: relative;
            padding: 5px 0;
            transition: all 0.3s ease;
        }
        
        .nav-item:hover {
            color: #AD1C43;
        }
        
        /* Контакты в шапке */
        .header-contacts {
            display: flex;
            align-items: center;
            gap: 30px;
        }
        
        .header-phone {
            color: var(--text-light);
            font-size: 20px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .header-phone:hover {
            color: #AD1C43;
        }
        
        /* Стили для кнопок входа и регистрации */
        .auth-links {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .btn-auth {
            padding: 8px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }
        
        .btn-login {
            background: transparent;
            color: #AD1C43;
            border: 1px solid #AD1C43;
        }
        
        .btn-login:hover {
            background: #AD1C43;
            color: var(--bg-dark);
        }
        
        .btn-register {
            background: #AD1C43;
            color: var(--bg-dark);
            border: none;
        }
        
        .btn-register:hover {
            background: var(--accent-light);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(201, 168, 106, 0.3);
        }
        
        /* Корзина и пользователь */
        .cart-counter {
            position: relative;
            margin-right: 15px;
        }
        .cart-counter::before {
            content: url('../images/nav/cart.svg');
            width: 100%;
            height: 100%;
        }
        
        .user-icon-photo {
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        
        .user-icon-photo:hover {
            transform: scale(1.1);
        }
        
        .user-photo {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
        
        .cart-count-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #AD1C43;
            color: var(--bg-dark);
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }
        
        /* Dropdown меню */
        .dropdown-menu {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 0;
        }
        
        .dropdown-item {
            color: var(--text-light);
            padding: 8px 20px;
            transition: all 0.3s ease;
        }
        
        .dropdown-item:hover {
            background: #AD1C43;
            color: var(--bg-dark);
        }
        
        .dropdown-item-text {
            color: var(--text-gray);
            padding: 8px 20px;
            font-size: 14px;
            display: block;
        }
        
        /* Мобильное меню */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: var(--text-light);
            font-size: 24px;
            cursor: pointer;
            padding: 8px;
        }
        
        /* Герой секция */
        .hero-elegant {
            padding: 120px 0;
            text-align: center;
            background: linear-gradient(135deg, var(--bg-dark) 0%, #1a1a1a 100%);
            position: relative;
            overflow: hidden;
        }
        
        .hero-title {
            font-size: 56px;
            color: var(--text-light);
            margin-bottom: 24px;
            line-height: 1.2;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .hero-subtitle {
            font-size: 20px;
            color: var(--text-gray);
            max-width: 600px;
            margin: 0 auto 40px;
            line-height: 1.6;
        }
        
        /* Кнопки */
        .btn-exact {
            background: #ffffff;
            color: black;
            border: none;
            padding: 14px 32px;
            text-decoration: none;
            font-weight: 600;
            font-size: 20px;
            cursor: pointer;
            transition: background 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-exact:hover {
            background: #f0f0f0;
        }
        
        .btn-exact-outline {
            background: transparent;
            color: #ffffff;
            padding: 12px 32px;
            font-weight: 600;
            text-decoration: none;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.3s;
            border: 2px solid #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-exact-outline:hover {
            background: #ffffff;
            color: black;
        }
        
        /* Разделитель секций */
        .section-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--border), transparent);
            margin: 80px auto;
            max-width: 1200px;
        }
        
        /* Контейнеры */
        .container-exact {
            max-width: 1200px;
            padding-top: 40px;
            margin: 0 auto;
        }
        
        .section-exact {
            margin-bottom: 130px;
        }
        
        /* Адаптивность */
        @media (max-width: 1024px) {
            .header-container {
                padding: 15px;
            }
            
            .main-nav {
                gap: 20px;
            }
        }
        
        @media (max-width: 768px) {
            .main-nav {
                display: none;
            }
            
            .mobile-menu-btn {
                display: block;
            }
            
            .header-contacts {
                gap: 15px;
            }
            
            .auth-links {
                flex-direction: column;
                gap: 8px;
            }
            
            .btn-auth {
                width: 120px;
                justify-content: center;
            }
            
            .hero-title {
                font-size: 40px;
            }
            
            .hero-subtitle {
                font-size: 16px;
            }
        }
        
        @media (max-width: 480px) {
            .header-container {
                flex-direction: column;
                gap: 15px;
            }
            
            .header-contacts {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .user-photo {
                width: 40px;
                height: 40px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Шапка -->
    <header class="header-elegant">
        <div class="header-container">
            <a href="/" class="logo"></a>
            
            <nav class="main-nav">
                <a class="nav-item" href="{{ route('menu') }}">Меню</a>
                <a href="#about" class="nav-item">О нас</a>
                <a href="#gallery" class="nav-item">Галерея</a>
                <a href="#contacts" class="nav-item">Контакты</a>
            </nav>
                
            <div class="header-contacts">
                <a href="tel:88545332222" class="header-phone">
                    8(8545)-33-22-22
                </a>
                
                @auth
                <!-- Иконка корзины для авторизованных -->
                <div class="cart-counter">
                    <a href="{{ route('cart.index') }}" class="user-icon-photo">
                        <span class="cart-count-badge">0</span>
                    </a>
                </div>
                
                <!-- Выпадающее меню пользователя -->
                <div class="dropdown">
                    <div class="user-icon-photo dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="{{ asset('images/nav/user-icon.png') }}" alt="Аккаунт" class="user-photo">
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><span class="dropdown-item-text">{{ Auth::user()->full_name }}</span></li>
                        <li><a class="dropdown-item" href="{{ route('orders.index') }}">Мои заказы</a></li>
                        <li><a class="dropdown-item" href="{{ route('table-reservations.index') }}">Мои бронирования</a></li>
                        @if(Auth::user()->is_admin)
                        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Админ панель</a></li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Выйти</button>
                            </form>
                        </li>
                    </ul>
                </div>
                @else
                <!-- Простые ссылки для входа и регистрации -->
                <div class="auth-single-button">
        <a href="{{ route('login') }}" class="btn-auth-single">
            <img src="{{ asset('images/nav/user-icon.png') }}" alt="Пользователь" class="user-photo">
            <span class="auth-text"></span>
        </a>
    </div>
    @endauth
    
    <button class="mobile-menu-btn" id="mobileMenuBtn">
        <i class="bi bi-list"></i>
    </button>
</div>
                
                <button class="mobile-menu-btn" id="mobileMenuBtn">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Основной контент -->
    <main>
        @yield('content')
    </main>

    <!-- Подвал -->
        
        <div class="footer-bottom">
            <p class="copyright">© 2026, Созвездие вкусов. Все права защищены.</p>
        </div>
    </footer>

    <style>
        .footer-bottom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            text-align: center;
            border: 3px solid var(--border);
            padding-top: 40px;
        }

        .copyright {
            color: #ffffff;
            font-size: 20px;
        }
        
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>



        document.addEventListener('DOMContentLoaded', function() {
            // Мобильное меню
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function() {
                    const mainNav = document.querySelector('.main-nav');
                    if (mainNav) {
                        mainNav.style.display = mainNav.style.display === 'flex' ? 'none' : 'flex';
                        this.innerHTML = mainNav.style.display === 'flex' ? 
                            '<i class="bi bi-x"></i>' : '<i class="bi bi-list"></i>';
                    }
                });
                
                // Закрытие меню при ресайзе окна
                window.addEventListener('resize', function() {
                    if (window.innerWidth > 768) {
                        const mainNav = document.querySelector('.main-nav');
                        if (mainNav) {
                            mainNav.style.display = 'flex';
                            mobileMenuBtn.innerHTML = '<i class="bi bi-list"></i>';
                        }
                    }
                });
            }
            
            // Плавная прокрутка для навигации
            document.querySelectorAll('.nav-item, .footer-link[href^="#"]').forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (!href.startsWith('#')) return;
                    
                    e.preventDefault();
                    const targetId = href.substring(1);
                    const targetElement = document.getElementById(targetId);
                    
                    if (targetElement) {
                        // Закрыть мобильное меню если открыто
                        if (window.innerWidth <= 768) {
                            const mainNav = document.querySelector('.main-nav');
                            if (mainNav) {
                                mainNav.style.display = 'none';
                                mobileMenuBtn.innerHTML = '<i class="bi bi-list"></i>';
                            }
                        }
                        
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });
            
            // Обновление счетчика корзины
            function updateCartCounter() {
                fetch('/cart/count')
                    .then(response => response.json())
                    .then(data => {
                        const badge = document.querySelector('.cart-count-badge');
                        if (badge) {
                            badge.textContent = data.count;
                            badge.style.display = data.count > 0 ? 'flex' : 'none';
                        }
                    })
                    .catch(error => console.error('Error updating cart counter:', error));
            }
            
            // Инициализация счетчика при загрузке
            updateCartCounter();
            
            // Показать сообщения об успехе
            @if(session('success'))
                setTimeout(() => {
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-success position-fixed top-20 start-50 translate-middle-x';
                    alertDiv.style.zIndex = '9999';
                    alertDiv.style.minWidth = '300px';
                    alertDiv.style.backgroundColor = '#AD1C43';
                    alertDiv.style.color = 'var(--bg-dark)';
                    alertDiv.style.border = 'none';
                    alertDiv.style.borderRadius = '8px';
                    alertDiv.style.padding = '15px 20px';
                    alertDiv.style.textAlign = 'center';
                    alertDiv.textContent = '{{ session('success') }}';
                    document.body.appendChild(alertDiv);
                    
                    setTimeout(() => {
                        alertDiv.remove();
                    }, 3000);
                }, 500);
            @endif
            
            @if(session('error'))
                setTimeout(() => {
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-danger position-fixed top-20 start-50 translate-middle-x';
                    alertDiv.style.zIndex = '9999';
                    alertDiv.style.minWidth = '300px';
                    alertDiv.style.backgroundColor = '#dc3545';
                    alertDiv.style.color = 'white';
                    alertDiv.style.border = 'none';
                    alertDiv.style.borderRadius = '8px';
                    alertDiv.style.padding = '15px 20px';
                    alertDiv.style.textAlign = 'center';
                    alertDiv.textContent = '{{ session('error') }}';
                    document.body.appendChild(alertDiv);
                    
                    setTimeout(() => {
                        alertDiv.remove();
                    }, 3000);
                }, 500);
            @endif
        });
    </script>
    @stack('scripts')
</body>
</html>