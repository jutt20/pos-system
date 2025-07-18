<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('online_sim_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('brand');
            $table->string('sim_type');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->enum('delivery_method', ['pickup', 'delivery'])->default('delivery');
            $table->foreignId('pickup_retailer_id')->nullable()->constrained('employees')->onDelete('set null');
            
            // Delivery Information
            $table->string('delivery_address')->nullable();
            $table->string('delivery_city')->nullable();
            $table->string('delivery_state')->nullable();
            $table->string('delivery_zip')->nullable();
            $table->string('delivery_phone')->nullable();
            
            // Delivery Service Details
            $table->string('delivery_service')->nullable(); // UPS, FedEx, DHL, etc.
            $table->string('tracking_number')->nullable();
            $table->string('delivery_service_url')->nullable(); // Tracking URL template
            $table->decimal('delivery_cost', 8, 2)->default(0);
            $table->date('estimated_delivery_date')->nullable();
            
            // Order Status
            $table->enum('status', ['pending', 'approved', 'processing', 'shipped', 'delivered', 'cancelled', 'ready_for_pickup'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->text('customer_notes')->nullable();
            
            // Approval
            $table->foreignId('approved_by')->nullable()->constrained('employees')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            
            // Processing
            $table->foreignId('processed_by')->nullable()->constrained('employees')->onDelete('set null');
            $table->timestamp('processed_at')->nullable();
            
            // Shipping
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            
            $table->timestamps();
            
            $table->index(['customer_id', 'status']);
            $table->index(['status', 'created_at']);
            $table->index('tracking_number');
        });
    }

    public function down()
    {
        Schema::dropIfExists('online_sim_orders');
    }
};
