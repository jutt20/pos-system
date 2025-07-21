<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sim_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('delivery_service_id')->nullable()->constrained()->onDelete('set null');

            $table->string('brand');
            $table->string('sim_type');
            $table->integer('quantity');
            $table->decimal('unit_cost', 10, 2);
            $table->decimal('total_cost', 10, 2);
            $table->string('vendor');
            
            $table->enum('order_type', ['pickup', 'delivery'])->default('pickup');
            $table->decimal('delivery_cost', 10, 2)->default(0);

            $table->string('delivery_address')->nullable();
            $table->string('delivery_city')->nullable();
            $table->string('delivery_state')->nullable();
            $table->string('delivery_zip')->nullable();
            $table->string('delivery_phone')->nullable();

            $table->string('tracking_number')->nullable();
            $table->date('estimated_delivery')->nullable();

            $table->enum('status', ['pending', 'approved', 'delivered', 'cancelled', 'shipped', 'processing'])->default('pending');

            $table->text('notes')->nullable();
            $table->date('order_date')->default(now());
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sim_orders');
    }
};
