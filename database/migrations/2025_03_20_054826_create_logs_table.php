<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id('log_id');
            $table->string('faculty_id', 100)->nullable();
            $table->timestamp('date_time_borrowed')->nullable();
            $table->timestamp('date_time_returned')->nullable();
            $table->timestamps();
            
            $table->foreign('faculty_id')
                ->references('faculty_id')
                ->on('faculty')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
