<?php
// database/migrations/xxxx_create_reservations_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->date('date');
            $table->time('time');
            $table->integer('guests')->default(2);
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->boolean('confirmed')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Индексы для оптимизации запросов
            $table->index(['date', 'time']);
            $table->index('confirmed');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};