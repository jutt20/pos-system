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
            $table->string('sim_number')->unique();
            $table->string('phone_number')->unique();
            $table->string('package_type');
            $table->decimal('activation_fee', 8, 2);
            $table->decimal('monthly_fee', 8, 2)->default(0);
            $table->enum('status', ['pending', 'active', 'suspended', 'terminated'])->default('pending');
            $table->date('activation_date');
            $table->date('expiry_date')->nullable();
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
