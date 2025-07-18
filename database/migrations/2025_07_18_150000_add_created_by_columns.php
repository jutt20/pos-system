<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add created_by to invoices table if it doesn't exist
        if (!Schema::hasColumn('invoices', 'created_by')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->unsignedBigInteger('created_by')->nullable()->after('id');
                $table->foreign('created_by')->references('id')->on('employees')->onDelete('set null');
            });
        }

        // Add created_by to customers table if it doesn't exist
        if (!Schema::hasColumn('customers', 'created_by')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->unsignedBigInteger('created_by')->nullable()->after('id');
                $table->foreign('created_by')->references('id')->on('employees')->onDelete('set null');
            });
        }

        // Add created_by to activations table if it doesn't exist
        if (!Schema::hasColumn('activations', 'created_by')) {
            Schema::table('activations', function (Blueprint $table) {
                $table->unsignedBigInteger('created_by')->nullable()->after('id');
                $table->foreign('created_by')->references('id')->on('employees')->onDelete('set null');
            });
        }

        // Add created_by to sim_orders table if it doesn't exist
        if (!Schema::hasColumn('sim_orders', 'created_by')) {
            Schema::table('sim_orders', function (Blueprint $table) {
                $table->unsignedBigInteger('created_by')->nullable()->after('id');
                $table->foreign('created_by')->references('id')->on('employees')->onDelete('set null');
            });
        }

        // Add status column to employees table if it doesn't exist
        if (!Schema::hasColumn('employees', 'status')) {
            Schema::table('employees', function (Blueprint $table) {
                $table->enum('status', ['active', 'inactive'])->default('active')->after('is_active');
            });
        }
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

        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
