<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Кто сделал заказ
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            // Контактные данные
            $table->string('full_name');
            $table->string('phone');
            $table->string('email')->nullable();

            // Основной адрес (если хочешь — можешь убрать)
            $table->string('address')->nullable();

            // Тип доставки и оплаты
            $table->string('delivery_type')->default('delivery'); // delivery / pickup и т.п.
            $table->string('payment_method')->default('card');    // card / cash и т.п.

            // Детализация адреса (всё опционально)
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->string('house')->nullable();
            $table->string('apartment')->nullable();
            $table->string('entrance')->nullable();
            $table->string('floor')->nullable();
            $table->string('intercom')->nullable();

            // Сумма и статус заказа
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('status')->default('new'); // new, paid, shipped, cancelled и т.п.

            $table->text('comment')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};