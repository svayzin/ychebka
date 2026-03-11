<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_password_reset_tokens_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Проверяем, существует ли таблица
        if (!Schema::hasTable('password_reset_tokens')) {
            // Создаем таблицу с нашей структурой
            Schema::create('password_reset_tokens', function (Blueprint $table) {
                $table->id();
                $table->string('phone')->index();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('expires_at')->nullable();
                $table->boolean('used')->default(false);
                
                $table->index(['phone', 'token']);
            });
        } else {
            // Таблица уже существует - добавляем недостающие колонки
            
            // Добавляем phone если нет
            if (!Schema::hasColumn('password_reset_tokens', 'phone')) {
                Schema::table('password_reset_tokens', function (Blueprint $table) {
                    $table->string('phone')->nullable()->after('id')->index();
                });
            }
            
            // Добавляем expires_at если нет
            if (!Schema::hasColumn('password_reset_tokens', 'expires_at')) {
                Schema::table('password_reset_tokens', function (Blueprint $table) {
                    $table->timestamp('expires_at')->nullable()->after('created_at');
                });
            }
            
            // Добавляем used если нет
            if (!Schema::hasColumn('password_reset_tokens', 'used')) {
                Schema::table('password_reset_tokens', function (Blueprint $table) {
                    $table->boolean('used')->default(false)->after('expires_at');
                });
            }
        }
    }

    public function down(): void
    {
        // Удаляем только наши добавленные колонки
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            if (Schema::hasColumn('password_reset_tokens', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('password_reset_tokens', 'expires_at')) {
                $table->dropColumn('expires_at');
            }
            if (Schema::hasColumn('password_reset_tokens', 'used')) {
                $table->dropColumn('used');
            }
        });
    }
};
