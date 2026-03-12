<!DOCTYPE html>
<!-- resources/views/admin/layouts/app.blade.php -->
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Админ панель') - Crimson Flame</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Yeseva+One&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-dark: #171717;
            --bg-card: #1F1F1F;
            --bg-light: #2A2A2A;
            --text-light: #FFFFFF;
            --text-gray: #B0B0B0;
            --accent: #AD1C43;
            --accent-light: #D4B77D;
            --border: #333333;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-light);
            min-height: 100vh;
        }
        
        /* Основной контейнер */
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Боковое меню */
        .admin-sidebar {
            width: 250px;
            background: var(--bg-card);
            border-right: 1px solid var(--border);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }
        
        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid var(--border);
        }
        
        .sidebar-logo {
            font-family: 'Yeseva One', serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--text-light);
            text-decoration: none;
        }
        
        .sidebar-logo span {
            color: #AD1C43;
        }
        
        .sidebar-subtitle {
            color: var(--text-gray);
            font-size: 14px;
            margin-top: 5px;
        }
        
        /* Навигация */
        .sidebar-nav {
            padding: 20px 0;
        }
        
        .nav-section-title {
            color: var(--text-gray);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 15px 20px 8px;
            font-weight: 600;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--text-gray);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        
        .nav-link:hover {
            background: rgba(144, 88, 103, 0.38);
            color: #AD1C43;
        }
        
        .nav-link.active {
            background: rgba(126, 48, 69, 0.38);
            color: #AD1C43;
            border-left-color: #AD1C43;
        }
        
        .nav-link i {
            margin-right: 12px;
            font-size: 18px;
            width: 24px;
            text-align: center;
        }
        
        /* Основной контент */
        .admin-content {
            flex: 1;
            margin-left: 250px;
            min-height: 100vh;
        }
        
        /* Верхняя панель */
        .admin-header {
            background: var(--bg-card);
            border-bottom: 1px solid var(--border);
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-title {
            font-size: 24px;
            font-weight: 600;
            color: var(--text-light);
            margin: 0;
        }
        
        .header-user {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-info {
            text-align: right;
        }
        
        .user-name {
            font-weight: 600;
            color: var(--text-light);
            font-size: 16px;
        }
        
        .user-role {
            color: #AD1C43;
            font-size: 14px;
            font-weight: 500;
        }
        
        .btn-exact {
            background: #AD1C43;
            color: #ffffff;
            border: none;
            padding: 8px 20px;
            font-weight: 600;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .btn-exact:hover {
            background: #430011;
            transform: translateY(-2px);
        }
        
        .btn-outline-exact {
            background: transparent;
            color: var(--text-light);
            border: 1px solid var(--border);
            padding: 8px 20px;
            font-weight: 500;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .btn-outline-exact:hover {
            border-color: #AD1C43;
            color: #AD1C43;
        }
        
        /* Основной блок контента */
        .main-content {
            padding: 30px;
        }
        
        /* Карточки */
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 25px;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .stat-card:hover {
            border-color: #AD1C43;
            transform: translateY(-5px);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        
        .stat-icon.primary { background: rgba(52, 152, 219, 0.1); color: #3498db; }
        .stat-icon.success { background: rgba(46, 204, 113, 0.1); color: #2ecc71; }
        .stat-icon.warning { background: rgba(241, 196, 15, 0.1); color: #f1c40f; }
        .stat-icon.danger { background: rgba(231, 76, 60, 0.1); color: #e74c3c; }
        
        .stat-title {
            font-size: 14px;
            color: var(--text-gray);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }
        
        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 5px;
        }
        
        .stat-change {
            font-size: 14px;
            color: var(--text-gray);
        }
        
        /* Таблицы */
        .admin-table {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }
        
        .table-header {
            padding: 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .table-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-light);
            margin: 0;
        }
        
        .table {
            margin: 0;
            color: var(--text-light);
        }
        
        .table thead th {
            background: var(--bg-light);
            border-bottom: 2px solid var(--border);
            color: var(--text-gray);
            font-weight: 600;
            padding: 15px;
            border-top: none;
        }
        
        .table tbody td {
            padding: 15px;
            border-color: var(--border);
            vertical-align: middle;
        }
        
        .table tbody tr:hover {
            background: rgba(255, 255, 255, 0.03);
        }
        
        /* Формы */
        .form-control-admin {
            background: var(--bg-light);
            border: 1px solid var(--border);
            color: var(--text-light);
            padding: 12px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .form-control-admin:focus {
            background: var(--bg-card);
            border-color: #AD1C43;
            color: var(--text-light);
            box-shadow: 0 0 0 3px rgba(201, 168, 106, 0.2);
        }
        
        .form-label-admin {
            color: var(--text-light);
            font-weight: 500;
            margin-bottom: 8px;
        }
        
        /* Бейджи */
        .badge-admin {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .badge-success { background: rgba(46, 204, 113, 0.2); color: #2ecc71; }
        .badge-warning { background: rgba(241, 196, 15, 0.2); color: #f1c40f; }
        .badge-info { background: rgba(52, 152, 219, 0.2); color: #3498db; }
        .badge-danger { background: rgba(231, 76, 60, 0.2); color: #e74c3c; }
        .badge-secondary { background: rgba(189, 195, 199, 0.2); color: #bdc3c7; }
        
        /* Уведомления */
        .alert-admin {
            border-radius: 8px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
        }
        
        .alert-success-admin { background: rgba(46, 204, 113, 0.1); color: #2ecc71; }
        .alert-danger-admin { background: rgba(231, 76, 60, 0.1); color: #e74c3c; }
        .alert-warning-admin { background: rgba(241, 196, 15, 0.1); color: #f1c40f; }
        
        /* Адаптивность */
        @media (max-width: 992px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .admin-sidebar.active {
                transform: translateX(0);
            }
            
            .admin-content {
                margin-left: 0;
            }
            
            .mobile-menu-btn {
                display: block;
            }
        }
        
        @media (max-width: 768px) {
            .admin-header {
                padding: 15px 20px;
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .header-user {
                width: 100%;
                justify-content: space-between;
            }
            
            .main-content {
                padding: 20px;
            }
        }
        
        /* Кнопка мобильного меню */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: var(--text-light);
            font-size: 24px;
            cursor: pointer;
            padding: 5px;
        }
        
        /* Пагинация */
        .pagination-admin .page-link {
            background: var(--bg-light);
            border-color: var(--border);
            color: var(--text-light);
        }
        
        .pagination-admin .page-link:hover {
            background: #AD1C43;
            border-color: #AD1C43;
            color: var(--bg-dark);
        }
        
        .pagination-admin .page-item.active .page-link {
            background: #AD1C43;
            border-color: #AD1C43;
            color: var(--bg-dark);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="admin-container">
        <!-- Боковое меню -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                    Crimson Flame
                </a>
                <div class="sidebar-subtitle">Административная панель</div>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-section-title">Основное</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif">
                    <i class="bi bi-speedometer2"></i>
                    <span>Панель управления</span>
                </a>
                
                <div class="nav-section-title">Управление</div>
                <a href="{{ route('admin.table-reservations') }}" class="nav-link @if(request()->routeIs('admin.table-reservations*')) active @endif">
                    <i class="bi bi-calendar-check"></i>
                    <span>Бронирования столиков</span>
                </a>
                <a href="{{ route('admin.orders') }}" class="nav-link @if(request()->routeIs('admin.orders*')) active @endif">
                    <i class="bi bi-cart"></i>
                    <span>Заказы</span>
                </a>
                
                <div class="nav-section-title">Меню</div>
                <a href="{{ route('admin.categories') }}" class="nav-link @if(request()->routeIs('admin.categories*')) active @endif">
                    <i class="bi bi-list-ul"></i>
                    <span>Категории</span>
                </a>
                <a href="{{ route('admin.products') }}" class="nav-link @if(request()->routeIs('admin.products*')) active @endif">
                    <i class="bi bi-egg-fried"></i>
                    <span>Блюда</span>
                </a>
                
                <div class="nav-section-title">Навигация</div>
                <a href="{{ route('home') }}" class="nav-link" target="_blank">
                    <i class="bi bi-house"></i>
                    <span>На сайт</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" class="nav-link-form">
                    @csrf
                    <button type="submit" class="nav-link" style="width: 100%; text-align: left; background: none; border: none;">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Выйти</span>
                    </button>
                </form>
            </nav>
        </aside>
        
        <!-- Основной контент -->
        <main class="admin-content">
            <!-- Верхняя панель -->
            <header class="admin-header">
                <div class="d-flex align-items-center gap-3">
                    <button class="mobile-menu-btn" id="mobileMenuBtn">
                        <i class="bi bi-list"></i>
                    </button>
                    <h1 class="header-title">@yield('page-title', 'Панель управления')</h1>
                </div>
                
                <div class="header-user">
                    <div class="user-info">
                        <div class="user-name">{{ Auth::user()->full_name }}</div>
                        <div class="user-role">
                            <i class="bi bi-shield-check"></i> Администратор
                        </div>
                    </div>
                    <a href="{{ route('home') }}" class="btn-outline-exact">
                        <i class="bi bi-globe"></i> На сайт
                    </a>
                </div>
            </header>
            
            <!-- Основной контент -->
            <div class="main-content">
                @if(session('success'))
                <div class="alert alert-success-admin alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть" style="filter: invert(1);"></button>
                </div>
                @endif
                
                @if(session('error'))
                <div class="alert alert-danger-admin alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть" style="filter: invert(1);"></button>
                </div>
                @endif
                
                @yield('content')
            </div>
        </main>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Мобильное меню
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const adminSidebar = document.getElementById('adminSidebar');
            
            if (mobileMenuBtn && adminSidebar) {
                mobileMenuBtn.addEventListener('click', function() {
                    adminSidebar.classList.toggle('active');
                    this.innerHTML = adminSidebar.classList.contains('active') 
                        ? '<i class="bi bi-x"></i>' 
                        : '<i class="bi bi-list"></i>';
                });
            }
            
            // Закрытие меню при клике вне его на мобильных
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 992) {
                    if (!adminSidebar.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
                        adminSidebar.classList.remove('active');
                        mobileMenuBtn.innerHTML = '<i class="bi bi-list"></i>';
                    }
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>