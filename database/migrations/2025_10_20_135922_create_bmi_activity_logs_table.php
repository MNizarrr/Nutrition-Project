<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bmi_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bmi_record_id')->constrained()->onDelete('cascade');
            $table->foreignId('physical_activity_id')->constrained()->onDelete('cascade');
            $table->decimal('duration', 4, 2); // dalam jam
            $table->date('activity_date');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['bmi_record_id', 'activity_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bmi_activity_logs');
    }
};
