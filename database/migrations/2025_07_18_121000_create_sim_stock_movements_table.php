<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sim_stock_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sim_stock_id');
            $table->enum('movement_type', ['in', 'out', 'transfer', 'adjustment', 'damaged', 'expired']);
            $table->integer('quantity')->default(1);
            $table->string('reference_number')->nullable(); // Invoice, PO, etc.
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('location_from')->nullable();
            $table->string('location_to')->nullable();
            $table->timestamps();
            
            $table->foreign('sim_stock_id')->references('id')->on('sim_stocks')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            
            $table->index(['sim_stock_id', 'movement_type']);
            $table->index(['created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('sim_stock_movements');
    }
};
