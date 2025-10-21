<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('nutrition_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('target_weight', 5, 2);
            $table->decimal('target_bmi', 4, 2);
            $table->decimal('weekly_physical_activity', 4, 2); // jam per minggu
            $table->date('target_date');
            $table->enum('status', ['Aktif', 'Selesai', 'Dibatalkan'])->default('Aktif');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('nutrition_goals');
    }
};
