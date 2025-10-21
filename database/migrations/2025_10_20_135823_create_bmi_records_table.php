<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bmi_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('height', 5, 2); // dalam cm
            $table->decimal('weight', 5, 2); // dalam kg
            $table->decimal('bmi_value', 4, 2);
            $table->enum('bmi_category', ['Kurus', 'Normal', 'Obesitas']);
            $table->date('record_date');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'record_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bmi_records');
    }
};
