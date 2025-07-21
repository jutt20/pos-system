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
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('id_number')->nullable();
            $table->string('id_type')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->decimal('balance', 10, 2)->default(0);
            $table->enum('prepaid_status', ['prepaid', 'postpaid'])->default('postpaid');
            $table->unsignedBigInteger('assigned_employee_id')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('assigned_employee_id')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('employees')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
