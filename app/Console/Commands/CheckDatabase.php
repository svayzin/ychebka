<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CheckDatabase extends Command
{
    protected $signature = 'db:check-simple';
    protected $description = 'Проверка работоспособности базы данных';

    public function handle()
    {
        $this->info('ПРОВЕРКА БАЗЫ ДАННЫХ');
        $this->line('');

        // 1. Проверка подключения
        $this->checkConnection();

        // 2. Список таблиц
        $this->showTables();

        // 3. Детальная проверка таблицы products
        $this->checkProductsTable();

        // 4. Проверка остальных таблиц
        $this->checkOtherTables();

        // 5. Проверка миграций
        $this->checkMigrations();

        $this->info('');
        $this->info('Проверка завершена!');
    }

    /**
     * Проверка подключения к БД
     */
    private function checkConnection()
    {
        $this->line('Проверка подключения...');

        try {
            DB::connection()->getPdo();
            $this->info('✔ Подключение к БД успешно');
            $this->line('✔ База данных: ' . DB::connection()->getDatabaseName());
        } catch (\Exception $e) {
            $this->error('❌ Ошибка подключения: ' . $e->getMessage());
        }
    }

    /**
     * Показать список таблиц
     */
    private function showTables()
    {
        $this->line('');
        $this->line('Список таблиц:');

        try {
            $tables = DB::select('SHOW TABLES');
            $tableCount = 0;
            $userTables = [];

            foreach ($tables as $table) {
                $tableName = array_values((array)$table)[0];
                
                // Пропускаем служебные таблицы Laravel
                if (in_array($tableName, [
                    'migrations', 
                    'failed_jobs', 
                    'password_reset_tokens', 
                    'password_reset_codes',
                    'personal_access_tokens', 
                    'sessions',
                    'cache',
                    'jobs'
                ])) {
                    continue;
                }

                try {
                    $count = DB::table($tableName)->count();
                    $this->line("   - {$tableName}: {$count} записей");
                    $tableCount++;
                    $userTables[] = $tableName;
                } catch (\Exception $e) {
                    $this->line("   - {$tableName}: Ошибка подсчета");
                }
            }

            $this->info('✔ Найдено пользовательских таблиц: ' . $tableCount . ' (' . implode(', ', $userTables) . ')');
        } catch (\Exception $e) {
            $this->error('❌ Ошибка получения таблиц: ' . $e->getMessage());
        }
    }

    /**
     * Детальная проверка таблицы products
     */
    private function checkProductsTable()
    {
        $this->line('');
        $this->line('Проверка таблицы products...');

        if (!Schema::hasTable('products')) {
            $this->error('❌ Таблица products не найдена!');
            return;
        }

        // Проверка полей
        $columns = Schema::getColumnListing('products');
        $requiredColumns = [
            'id', 'name', 'description', 'weight', 'weight_unit', 
            'price', 'image', 'category_id', 'is_new', 'is_popular', 
            'order', 'active', 'created_at', 'updated_at'
        ];

        $this->line('   Поля в таблице products:');
        foreach ($requiredColumns as $column) {
            if (in_array($column, $columns)) {
                $this->line("   ✔ {$column}");
            } else {
                $this->error("   ✖ {$column} (отсутствует)");
            }
        }

        // Статистика по товарам
        $totalProducts = DB::table('products')->count();
        $activeProducts = DB::table('products')->where('active', true)->count();
        $newProducts = DB::table('products')->where('is_new', true)->count();
        $popularProducts = DB::table('products')->where('is_popular', true)->count();
        
        // Товары с изображениями
        $withImage = DB::table('products')->whereNotNull('image')->count();
        $withoutImage = DB::table('products')->whereNull('image')->count();

        // Цены
        $minPrice = DB::table('products')->min('price');
        $maxPrice = DB::table('products')->max('price');
        $avgPrice = DB::table('products')->avg('price');

        $this->line('');
        $this->line("   Всего товаров: {$totalProducts}");
        $this->line("   Активных товаров: {$activeProducts}");
        $this->line("   Новинок: {$newProducts}");
        $this->line("   Популярных: {$popularProducts}");
        $this->line("   Цены: от {$minPrice} до {$maxPrice} руб. (средняя: " . round($avgPrice, 0) . " руб.)");
        
        if ($totalProducts > 0) {
            $withImagePercent = round(($withImage / $totalProducts) * 100);
            $this->line("   С изображениями: {$withImage} товаров ({$withImagePercent}%)");
            $this->line("   Без изображения: {$withoutImage} товаров");
        }

        // Проверка по категориям
        $this->line('');
        $this->line('   Товары по категориям:');
        
        $categories = DB::table('categories')->get();
        foreach ($categories as $category) {
            $count = DB::table('products')->where('category_id', $category->id)->count();
            $activeCount = DB::table('products')->where('category_id', $category->id)->where('active', true)->count();
            $this->line("   - {$category->name}: {$count} товаров (активных: {$activeCount})");
        }
    }

    /**
     * Проверка остальных таблиц
     */
    private function checkOtherTables()
    {
        $this->line('');
        $this->line('Проверка остальных таблиц...');

        // Пользователи
        if (Schema::hasTable('users')) {
            $users = DB::table('users')->count();
            $admins = DB::table('users')->where('is_admin', true)->count();
            $this->line("   ✔ Пользователей: {$users} (админов: {$admins})");
        }

        // Категории
        if (Schema::hasTable('categories')) {
            $categories = DB::table('categories')->where('active', true)->count();
            $totalCategories = DB::table('categories')->count();
            $this->line("   ✔ Категорий: всего {$totalCategories}, активных: {$categories}");
        }

        // Заказы
        if (Schema::hasTable('orders')) {
            $orders = DB::table('orders')->count();
            $pendingOrders = DB::table('orders')->where('status', 'pending')->count();
            $completedOrders = DB::table('orders')->where('status', 'completed')->count();
            $this->line("   ✔ Заказов: всего {$orders}, в обработке: {$pendingOrders}, завершено: {$completedOrders}");
            
            if ($orders > 0) {
                $totalSum = DB::table('orders')->sum('total');
                $this->line("   ✔ Общая сумма заказов: " . number_format($totalSum, 0, '.', ' ') . " ₽");
            }
        }

        // Бронирования
        if (Schema::hasTable('reservations')) {
            $reservations = DB::table('reservations')->count();
            $todayReservations = DB::table('reservations')->whereDate('date', today())->count();
            $confirmedReservations = DB::table('reservations')->where('confirmed', true)->count();
            $this->line("   ✔ Бронирований: всего {$reservations}, на сегодня: {$todayReservations}, подтверждено: {$confirmedReservations}");
        }

        // Корзина
        if (Schema::hasTable('cart_items')) {
            $cartItems = DB::table('cart_items')->count();
            $usersWithCart = DB::table('cart_items')->distinct('user_id')->count('user_id');
            $this->line("   ✔ Корзина: {$cartItems} товаров в корзинах {$usersWithCart} пользователей");
        }

        // Галерея
        if (Schema::hasTable('gallery')) {
            $galleryImages = DB::table('gallery')->count();
            $activeGallery = DB::table('gallery')->where('active', true)->count();
            $this->line("   ✔ Галерея: {$galleryImages} изображений (активных: {$activeGallery})");
        }
    }

    /**
     * Проверка миграций
     */
    private function checkMigrations()
    {
        $this->line('');
        $this->line('Проверка миграций...');

        if (!Schema::hasTable('migrations')) {
            $this->error('❌ Таблица миграций не найдена!');
            return;
        }

        $migrations = DB::table('migrations')->get();
        $batches = $migrations->groupBy('batch');

        $this->line("   ✔ Выполнено миграций: " . $migrations->count() . " из " . $migrations->count());
        $this->line('');
        $this->line('   Последние миграции:');

        $lastMigrations = $migrations->sortByDesc('id')->take(5);
        foreach ($lastMigrations as $migration) {
            $this->line("   - {$migration->migration} (batch {$migration->batch})");
        }
    }
}
