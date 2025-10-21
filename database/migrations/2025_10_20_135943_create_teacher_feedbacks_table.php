<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('teacher_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('bmi_record_id')->constrained()->onDelete('cascade');
            $table->text('feedback');
            $table->text('recommendation')->nullable();
            $table->tinyInteger('rating')->unsigned()->nullable(); // 1-5
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['teacher_id', 'bmi_record_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('teacher_feedbacks');
    }
};
