<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('table_reservations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('table_id')->constrained('tables')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('guest_name');
            $table->string('guest_phone', 32);
            $table->string('guest_email')->nullable();

            $table->unsignedTinyInteger('guests_count');

            $table->dateTime('start_at');
            $table->dateTime('end_at');

            $table->unsignedInteger('deposit_total')->default(0);

            // минимум нужен флаг отмены, иначе "освобождать" только удалением
            $table->boolean('cancelled')->default(false);

            $table->timestamps();

            $table->index(['table_id', 'start_at', 'end_at']);
            $table->index(['user_id', 'start_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('table_reservations');
    }
};