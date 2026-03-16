<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;

class CheckBrokenLinks extends Command
{
    /**
     * Название команды
     */
    protected $signature = 'seo:check-broken-links {--url= : Базовый URL сайта}';

    /**
     * Описание команды
     */
    protected $description = 'Поиск битых ссылок на сайте';

    /**
     * Базовый URL сайта
     */
    protected $baseUrl;

    /**
     * Выполнение команды
     */
    public function handle()
    {
        $this->info('=== ПОИСК БИТЫХ ССЫЛОК НА САЙТЕ "Crimson Flame" ===');
        $this->line('');
        
        // Определяем базовый URL
        $this->baseUrl = $this->option('url') ?? env('APP_URL', 'http://localhost:8000');
        
        // Убираем слеш в конце если есть
        $this->baseUrl = rtrim($this->baseUrl, '/');
        
        $this->info("Базовый URL: {$this->baseUrl}");
        $this->line('');
        
        // Проверяем доступность сайта
        if (!$this->checkSiteAvailable()) {
            $this->error('✗ Сайт недоступен! Проверьте URL и запустите сервер.');
            $this->info('   Запустите сервер: php artisan serve');
            return 1;
        }
        
        $brokenLinks = [];
        $totalChecked = 0;
        
        // Проверяем основные страницы
        $this->info('1. Проверка основных страниц...');
        $result = $this->checkMainPages();
        $brokenLinks = array_merge($brokenLinks, $result['broken']);
        $totalChecked += $result['checked'];
        
        // Проверяем страницы категорий
        $this->info('2. Проверка страниц категорий...');
        $result = $this->checkCategoryPages();
        $brokenLinks = array_merge($brokenLinks, $result['broken']);
        $totalChecked += $result['checked'];
        
        // Проверяем внешние ссылки
        $this->info('3. Проверка внешних ссылок...');
        $result = $this->checkExternalLinks();
        $brokenLinks = array_merge($brokenLinks, $result['broken']);
        $totalChecked += $result['checked'];
        
        $this->line('');
        $this->info("Всего проверено ссылок: {$totalChecked}");
        
        // Выводим результат
        if (count($brokenLinks) > 0) {
            $this->warn('=== НАЙДЕНЫ БИТЫЕ ССЫЛКИ ===');
            foreach ($brokenLinks as $link) {
                $this->warn("✗ {$link['url']}");
                $this->warn("  Локация: {$link['location']}");
                $this->warn("  Код ошибки: {$link['code']}");
                $this->warn("");
            }
            $this->warn("Всего найдено битых ссылок: " . count($brokenLinks));
        } else {
            $this->info('✓ Битых ссылок не обнаружено!');
        }
        
        $this->info('✔ Проверка завершена!');
        
        return 0;
    }

    /**
     * Проверка доступности сайта
     */
    private function checkSiteAvailable()
    {
        try {
            $status = $this->checkUrl($this->baseUrl);
            return $status < 400;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Проверка основных страниц
     */
    private function checkMainPages()
    {
        $broken = [];
        $checked = 0;
        
        $pages = [
            '/' => 'Главная страница',
            '/menu' => 'Меню',
            '/cart' => 'Корзина',
            '/login' => 'Вход',
            '/register' => 'Регистрация',
            '/profile' => 'Профиль',
            '/orders' => 'Заказы',
            '/reservations' => 'Бронирования',
        ];
        
        foreach ($pages as $url => $name) {
            $fullUrl = $this->baseUrl . $url;
            $status = $this->checkUrl($fullUrl);
            $checked++;
            
            if ($status >= 400) {
                $broken[] = [
                    'url' => $fullUrl,
                    'location' => $name,
                    'code' => $status
                ];
                $this->warn("   ✗ {$name} - ошибка {$status}");
            } else {
                $this->line("   ✓ {$name} - OK");
            }
        }
        
        return ['broken' => $broken, 'checked' => $checked];
    }

    /**
     * Проверка страниц категорий
     */
    private function checkCategoryPages()
    {
        $broken = [];
        $checked = 0;
        
        try {
            $categories = Category::all();
            
            if ($categories->isEmpty()) {
                $this->warn("   ! Нет категорий для проверки");
                return ['broken' => [], 'checked' => 0];
            }
            
            foreach ($categories as $category) {
                $url = $this->baseUrl . '/menu/category/' . $category->slug;
                $status = $this->checkUrl($url);
                $checked++;
                
                if ($status >= 400) {
                    $broken[] = [
                        'url' => $url,
                        'location' => 'Категория: ' . $category->name,
                        'code' => $status
                    ];
                    $this->warn("   ✗ Категория: {$category->name} - ошибка {$status}");
                } else {
                    $this->line("   ✓ Категория: {$category->name} - OK");
                }
            }
        } catch (\Exception $e) {
            $this->warn("   ! Ошибка при получении категорий: " . $e->getMessage());
        }
        
        return ['broken' => $broken, 'checked' => $checked];
    }

    /**
     * Проверка внешних ссылок
     */
    private function checkExternalLinks()
    {
        $broken = [];
        $checked = 0;
        
        // Проверка ссылки на Яндекс.Карты
        $yandexUrl = 'https://yandex.ru/maps/?text=г.%20Набережные%20Челны,%20проспект%20Сююмбике,%202';
        $status = $this->checkUrl($yandexUrl, true);
        $checked++;
        
        if ($status >= 400) {
            $broken[] = [
                'url' => $yandexUrl,
                'location' => 'Кнопка "Как добраться"',
                'code' => $status
            ];
            $this->warn("   ✗ Яндекс.Карты (кнопка) - ошибка {$status}");
        } else {
            $this->line("   ✓ Яндекс.Карты (кнопка) - OK");
        }
        
        // Проверка iframe Яндекс.Карт
        $mapUrl = 'https://yandex.ru/map-widget/v1/?ll=52.413870%2C55.724955&z=16&pt=52.413870,55.724955,pm2rdm';
        $status = $this->checkUrl($mapUrl, true);
        $checked++;
        
        if ($status >= 400) {
            $broken[] = [
                'url' => $mapUrl,
                'location' => 'Карта в контактах',
                'code' => $status
            ];
            $this->warn("   ✗ Яндекс.Карта (iframe) - ошибка {$status}");
        } else {
            $this->line("   ✓ Яндекс.Карта (iframe) - OK");
        }
        
        return ['broken' => $broken, 'checked' => $checked];
    }

    /**
     * Проверка URL
     */
    private function checkUrl($url, $external = false)
    {
        try {
            $client = new \GuzzleHttp\Client([
                'timeout' => 5,
                'verify' => false,
                'allow_redirects' => true,
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (compatible; SEO Bot)'
                ]
            ]);
            
            // Сначала пробуем HEAD запрос
            try {
                $response = $client->head($url);
                return $response->getStatusCode();
            } catch (\Exception $e) {
                // Если HEAD не работает, пробуем GET
                $response = $client->get($url);
                return $response->getStatusCode();
            }
            
        } catch (\Exception $e) {
            return 404;
        }
    }
}