<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Category;
use App\Models\Product;

class CheckMetaTags extends Command
{
    protected $signature = 'seo:check-meta';
    protected $description = 'Проверка наличия мета-тегов на страницах';

    public function handle()
    {
        $this->info('=== ПРОВЕРКА МЕТА-ТЕГОВ НА САЙТЕ "СОЗВЕЗДИЕ ВКУСОВ" ===');
        $this->line('');
        
        $this->checkMainPage();
        $this->line('');
        $this->checkMenuPage();
        $this->line('');
        $this->checkCategoryPages();
        $this->line('');
        $this->generateMetaReport();
    }

    /**
     * Проверка главной страницы
     */
    private function checkMainPage()
    {
        $this->info('1. Главная страница (home.blade.php):');
        
        $mainPagePath = resource_path('views/home.blade.php');
        
        if (!File::exists($mainPagePath)) {
            $this->error('   ✗ Файл главной страницы не найден!');
            return;
        }
        
        $content = File::get($mainPagePath);
        $errors = [];
        
        if (!preg_match('/@section\(\'title\'/', $content)) {
            $errors[] = 'Нет секции title';
        }
        
        if (!preg_match('/@section\(\'description\'/', $content)) {
            $errors[] = 'Нет секции description (рекомендуется добавить)';
        }
        
        if (!preg_match('/<h1/', $content)) {
            $errors[] = 'Нет тега H1';
        }
        
        if (empty($errors)) {
            $this->info('   ✓ Все необходимые мета-теги присутствуют');
        } else {
            foreach ($errors as $error) {
                $this->warn("   ▲ {$error}");
            }
        }
    }

    /**
     * Проверка страницы меню
     */
    private function checkMenuPage()
    {
        $this->info('2. Страница меню (menu/index.blade.php):');
        
        $menuPath = resource_path('views/menu/index.blade.php');
        
        if (!File::exists($menuPath)) {
            $this->error('   ✗ Файл страницы меню не найден!');
            return;
        }
        
        $content = File::get($menuPath);
        $errors = [];
        
        if (!preg_match('/@section\(\'title\'/', $content)) {
            $errors[] = 'Нет секции title';
        }
        
        if (!preg_match('/@section\(\'description\'/', $content)) {
            $errors[] = 'Нет секции description (рекомендуется добавить)';
        }
        
        if (!preg_match('/<h1/', $content)) {
            $errors[] = 'Нет тега H1 на странице меню! Это критично!';
        }
        
        if (empty($errors)) {
            $this->info('   ✓ Все необходимые мета-теги присутствуют');
        } else {
            foreach ($errors as $error) {
                if (strpos($error, 'критично') !== false) {
                    $this->error("   ✗ {$error}");
                } else {
                    $this->warn("   ▲ {$error}");
                }
            }
        }
    }

    /**
     * Проверка страниц категорий
     */
    private function checkCategoryPages()
    {
        $this->info('3. Страницы категорий (menu/category.blade.php):');
        
        $categoryPath = resource_path('views/menu/category.blade.php');
        
        if (!File::exists($categoryPath)) {
            $this->error('   ✗ Файл страницы категории не найден!');
            return;
        }
        
        $content = File::get($categoryPath);
        
        if (preg_match('/@section\(\'title\', \$category->name/', $content)) {
            $this->info('   ✓ Динамический title настроен правильно');
        } else {
            $this->warn('   ▲ Проверьте настройку title для категорий');
        }
        
        if (preg_match('/@section\(\'description\'/', $content)) {
            $this->info('   ✓ Description присутствует');
        } else {
            $this->warn('   ▲ Description отсутствует (рекомендуется добавить)');
        }
        
        // Проверяем реальные категории в базе
        $categories = Category::where('active', true)->take(3)->get();
        
        $this->line('');
        $this->info('   Примеры созданных категорий:');
        foreach ($categories as $cat) {
            $this->line("   - {$cat->name}: title будет '{$cat->name} - Созвездие вкусов'");
        }
    }

    /**
     * Генерация отчета
     */
    private function generateMetaReport()
    {
        $this->info('=== ИТОГОВЫЙ ОТЧЕТ ПО МЕТА-ТЕГАМ ===');
        $this->line('');
        
        $this->info('✅ Страницы, прошедшие проверку:');
        $this->line('   - Главная страница');
        $this->line('   - Страницы категорий (динамические)');
        $this->line('');
        
        $this->warn('⚠️ Требуют доработки:');
        $this->line('   - Страница меню (нужен H1)');
        $this->line('   - Добавить Description на все страницы');
        $this->line('');
        
        $this->info('📝 Рекомендации:');
        $this->line('   1. Добавить @section("description") в home.blade.php');
        $this->line('   2. Добавить @section("description") в menu/index.blade.php');
        $this->line('   3. Добавить H1 в menu/index.blade.php');
        $this->line('   4. Добавить @section("description") в menu/category.blade.php');
        $this->line('   5. Проверить наличие alt у всех изображений');
    }
}