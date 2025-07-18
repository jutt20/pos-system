<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sim_stocks', function (Blueprint $table) {
            // Add foreign key constraint to employees table instead of users
            $table->foreign('activated_by')->references('id')->on('employees')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('sim_stocks', function (Blueprint $table) {
            $table->dropForeign(['activated_by']);
        });
    }
};
