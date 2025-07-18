<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // This migration adds additional fields and updates for SIM stock categories
        Schema::table('sim_stocks', function (Blueprint $table) {
            // Add color coding for visual identification
            $table->string('color_code', 7)->nullable()->after('category'); // Hex color code
            
            // Add network provider information
            $table->string('network_provider')->nullable()->after('brand');
            
            // Add plan information
            $table->string('plan_type')->nullable()->after('network_provider');
            $table->decimal('monthly_cost', 8, 2)->nullable()->after('plan_type');
            
            // Add inventory tracking
            $table->integer('stock_level')->default(1)->after('status');
            $table->integer('minimum_stock')->default(10)->after('stock_level');
            
            // Add location tracking
            $table->string('warehouse_location')->nullable()->after('batch_id');
            $table->string('shelf_position')->nullable()->after('warehouse_location');
        });
    }

    public function down()
    {
        Schema::table('sim_stocks', function (Blueprint $table) {
            $table->dropColumn([
                'color_code',
                'network_provider',
                'plan_type',
                'monthly_cost',
                'stock_level',
                'minimum_stock',
                'warehouse_location',
                'shelf_position'
            ]);
        });
    }
};
