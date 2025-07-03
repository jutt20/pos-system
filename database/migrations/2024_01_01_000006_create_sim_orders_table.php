<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sim_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('vendor');
            $table->string('brand');
            $table->string('sim_type');
            $table->integer('quantity');
            $table->date('order_date');
            $table->decimal('cost_per_sim', 8, 2);
            $table->decimal('total_cost', 10, 2);
            $table->enum('status', ['pending', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->string('tracking_number')->nullable();
            $table->string('invoice_file')->nullable();
            $table->foreignId('employee_id')->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sim_orders');
    }
};
