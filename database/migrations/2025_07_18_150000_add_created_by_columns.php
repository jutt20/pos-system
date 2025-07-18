<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add created_by to invoices table
        Schema::table('invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->after('employee_id');
            $table->foreign('created_by')->references('id')->on('employees')->onDelete('set null');
        });

        // Add created_by to customers table
        Schema::table('customers', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->after('assigned_employee_id');
            $table->foreign('created_by')->references('id')->on('employees')->onDelete('set null');
        });

        // Add created_by to activations table
        Schema::table('activations', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->after('employee_id');
            $table->foreign('created_by')->references('id')->on('employees')->onDelete('set null');
        });

        // Add created_by to sim_orders table
        Schema::table('sim_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->after('employee_id');
            $table->foreign('created_by')->references('id')->on('employees')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });

        Schema::table('activations', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });

        Schema::table('sim_orders', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });
    }
};
