<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sim_stocks', function (Blueprint $table) {
            // Only add columns that don't exist
            if (!Schema::hasColumn('sim_stocks', 'color_code')) {
                $table->string('color_code', 7)->nullable()->after('category');
            }
        });
    }

    public function down()
    {
        Schema::table('sim_stocks', function (Blueprint $table) {
            if (Schema::hasColumn('sim_stocks', 'color_code')) {
                $table->dropColumn('color_code');
            }
        });
    }
};
