<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('activations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('employee_id');
            $table->string('brand');
            $table->string('plan');
            $table->string('sku');
            $table->integer('quantity');
            $table->decimal('price', 10, 2); // Selling price
            $table->decimal('cost', 10, 2);  // Cost price
            $table->decimal('profit', 10, 2); // Calculated profit
            $table->date('activation_date');
            $table->enum('status', ['pending', 'active', 'suspended', 'terminated'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('activations');
    }
};
