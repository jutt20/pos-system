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
            $table->enum('movement_type', ['in', 'out', 'transfer', 'adjustment']);
            $table->integer('quantity');
            $table->integer('previous_stock');
            $table->integer('new_stock');
            $table->string('reason')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('sim_stock_id')->references('id')->on('sim_stocks')->onDelete('cascade');
            $table->index(['sim_stock_id', 'movement_type']);
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sim_stock_movements');
    }
};
