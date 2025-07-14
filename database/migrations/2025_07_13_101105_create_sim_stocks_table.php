<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sim_stocks', function (Blueprint $table) {
            $table->id();

            // Remove sim_number if it's not in CSV or needed
            $table->string('sim_number')->unique()->nullable(); // ❌ Remove or make nullable if optional

            $table->string('iccid')->unique(); // ✅ ICCID from CSV

            $table->string('sim_type')->nullable();    // e.g., Nano SIM
            $table->string('vendor')->nullable();      // e.g., Jazz Supplier
            $table->string('brand')->nullable();       // e.g., Jazz, Telenor
            $table->decimal('cost', 10, 2)->nullable(); // Cost per SIM
            $table->enum('status', ['available', 'used', 'reserved', 'sold'])->default('available');

            $table->string('pin1')->nullable();
            $table->string('puk1')->nullable();
            $table->string('pin2')->nullable();
            $table->string('puk2')->nullable();
            $table->string('qr_activation_code')->nullable();
            $table->string('batch_id')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sim_stocks');
    }
};
