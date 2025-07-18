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
            $table->string('sim_number')->unique()->nullable();
            $table->string('iccid')->unique();
            
            // SIM Categories: 1. Nexitel Purple (Physical/eSIM), 2. Nexitel Blue (Physical/eSIM), 3. eSIM Only
            $table->enum('category', [
                'nexitel_purple_physical', 
                'nexitel_purple_esim', 
                'nexitel_blue_physical', 
                'nexitel_blue_esim', 
                'esim_only'
            ])->default('nexitel_purple_physical');
            
            $table->enum('sim_type', ['Nano SIM', 'Micro SIM', 'Standard SIM', 'eSIM', 'Triple Cut'])->default('Nano SIM');
            
            $table->string('vendor')->nullable();
            $table->string('brand')->nullable();
            $table->string('network_provider')->nullable();
            $table->string('plan_type')->nullable();
            $table->decimal('cost', 10, 2)->default(0);
            $table->decimal('monthly_cost', 10, 2)->nullable();
            $table->enum('status', ['available', 'used', 'reserved', 'sold', 'damaged', 'expired'])->default('available');
            
            // Stock management
            $table->integer('stock_level')->default(1);
            $table->integer('minimum_stock')->default(10);
            
            // Security codes
            $table->string('pin1')->nullable();
            $table->string('puk1')->nullable();
            $table->string('pin2')->nullable();
            $table->string('puk2')->nullable();
            
            // Activation and batch info
            $table->text('qr_activation_code')->nullable();
            $table->string('batch_id')->nullable();
            $table->date('expiry_date')->nullable();
            
            // Additional fields for tracking
            $table->string('serial_number')->nullable();
            $table->json('activation_data')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->unsignedBigInteger('activated_by')->nullable();
            
            // Location tracking
            $table->string('color_code')->nullable();
            $table->string('warehouse_location')->nullable();
            $table->string('shelf_position')->nullable();
            
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['status', 'category']);
            $table->index(['batch_id']);
            $table->index(['vendor', 'brand']);
            $table->index(['stock_level', 'minimum_stock']);
            
            // Foreign key for activated_by (user who activated)
            $table->foreign('activated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sim_stocks');
    }
};
