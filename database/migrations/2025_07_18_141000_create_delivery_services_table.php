<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('delivery_services', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // UPS, FedEx, DHL, USPS, etc.
            $table->string('code')->unique(); // ups, fedex, dhl, usps
            $table->string('tracking_url'); // URL template with {tracking_number} placeholder
            $table->string('api_endpoint')->nullable(); // For API integration
            $table->string('api_key')->nullable();
            $table->decimal('base_cost', 8, 2)->default(0);
            $table->decimal('per_item_cost', 8, 2)->default(0);
            $table->integer('estimated_days')->default(3);
            $table->boolean('is_active')->default(true);
            $table->json('service_areas')->nullable(); // States/regions served
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('delivery_services');
    }
};
