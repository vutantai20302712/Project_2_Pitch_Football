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
        Schema::create('scheduling_froms', function (Blueprint $table) {
            $table->id();
            $table->string('scheduling_form_status');
            $table->date('scheduling_form_date');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('admin_id')->constrained('admins');
            $table->foreignId('payment_method')->constrained('payments');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheduling_forms');
    }
};
