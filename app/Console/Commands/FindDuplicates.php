<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

class FindDuplicates extends Command
{
    /**
     * Название команды
     */
    protected $signature = 'seo:find-duplicates';

    /**
     * Описание команды
     */
    protected $description = 'Поиск потенциальных дублей страниц и проблем SEO';

    /**
     * Выполнение команды
     */
    public function handle()
    {
        $this->info('=== ПОИСК ПОТЕНЦИАЛЬНЫХ ДУБЛЕЙ В САЙТЕ "СОЗВЕЗДИЕ ВКУСОВ" ===');
        $this->line('');
        
        $this->checkRouteDuplicates();
        $this->line('');
        // ПРОВЕРКА ХАРДКОД ССЫЛОК ВРЕМЕННО ОТКЛЮЧЕНА
        // $this->checkHardcodedUrls();
        $this->info('2. Проверка Blade-шаблонов на хардкод ссылок: ПРОПУЩЕНО');
        $this->line('');
        $this->checkTrailingSlash();
        $this->line('');
        $this->generateRecommendations();
        
        $this->info('✔ Проверка завершена!');
    }

    /**
     * Проверка дублей маршрутов
     */
    private function checkRouteDuplicates()
    {
        $this->info('1. Проверка маршрутов на дубли:');
        
        $routes = Route::getRoutes();
        $routeNames = [];
        $duplicates = [];
        
        foreach ($routes as $route) {
            $name = $route->getName();
            if ($name) {
                if (in_array($name, $routeNames)) {
                    $duplicates[] = $name;
                } else {
                    $routeNames[] = $name;
                }
            }
        }
        
        if (count($duplicates) > 0) {
            $this->warn('   Найдены дублирующиеся имена маршрутов:');
            foreach ($duplicates as $dup) {
                $this->warn("   ✗ {$dup}");
            }
        } else {
            $this->info('   ✓ Дубли имен маршрутов не найдены');
        }
        
        $this->info("   Всего проверено маршрутов: " . count($routes));
    }

    /**
     * Проверка проблем с trailing slash
     */
    private function checkTrailingSlash()
    {
        $this->info('3. Проверка проблем с trailing slash:');
        
        $htaccessPath = public_path('.htaccess');
        
        if (File::exists($htaccessPath)) {
            $content = File::get($htaccessPath);
            if (strpos($content, 'RedirectMatch 302 /(.*)/$ /$1') !== false) {
                $this->info('   ✓ Настроен редирект с / на без /');
            } else {
                $this->warn('   ▲ .htaccess не настроен на удаление trailing slash');
            }
        } else {
            $this->warn('   ▲ Файл .htaccess не найден');
        }
        
        $this->info('   Рекомендация: Всегда использовать URL без / в конце');
    }

    /**
     * Генерация рекомендаций
     */
    private function generateRecommendations()
    {
        $this->info('=== РЕКОМЕНДАЦИИ ДЛЯ УСТРАНЕНИЯ ДУБЛЕЙ ===');
        $this->line('');
        
        $this->info('1. Для маршрутов:');
        $this->line('   - Используйте имена маршрутов (->name()) для всех роутов');
        $this->line('   - Избегайте одинаковых имен для разных маршрутов');
        $this->line('');
        
        $this->info('2. Для trailing slash:');
        $this->line('   - Добавьте в .htaccess редирект:');
        $this->line('     RedirectMatch 301 ^(.*)/$ $1');
        $this->line('');
        
        $this->info('3. Дополнительные меры:');
        $this->line('   - Добавьте canonical теги на все страницы');
        $this->line('   - Настройте robots.txt для исключения параметров');
        $this->line('   - Используйте 301 редиректы для старых URL');
    }
}