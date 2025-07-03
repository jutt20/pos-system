<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->text('address')->nullable();
            $table->string('cnic')->nullable(); // Changed from id_number to cnic
            $table->decimal('balance', 10, 2)->default(0);
            $table->enum('prepaid_status', ['prepaid', 'postpaid'])->default('prepaid');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedBigInteger('assigned_employee_id')->nullable();
            $table->timestamps();

            $table->foreign('assigned_employee_id')->references('id')->on('employees')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
