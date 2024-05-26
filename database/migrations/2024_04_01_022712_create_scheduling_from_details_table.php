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
        Schema::create('scheduling_from_details', function (Blueprint $table) {
            $table->primary(['pitch_id','time_id','scheduling_form_id']);
            $table->foreignId('pitch_id')->constrained('pitches');
            $table->foreignId('time_id')->constrained('time_frames');
            $table->foreignId('scheduling_form_id')->constrained('scheduling_froms');
            $table->double('price')->unsigned();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheduling_from_details');
    }
};
