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
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->text('address')->nullable();
            $table->decimal('balance', 10, 2)->default(0);
            $table->enum('prepaid_status', ['prepaid', 'postpaid'])->default('postpaid');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreignId('assigned_employee_id')->nullable()->constrained('employees');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
