<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sim_stocks', function (Blueprint $table) {
            // First add the columns if they don't exist
            if (!Schema::hasColumn('sim_stocks', 'created_by')) {
                $table->foreignId('created_by')->nullable()->after('id');
            }
            if (!Schema::hasColumn('sim_stocks', 'updated_by')) {
                $table->foreignId('updated_by')->nullable()->after('created_by');
            }
            if (!Schema::hasColumn('sim_stocks', 'activated_by')) {
                $table->foreignId('activated_by')->nullable()->after('updated_by');
            }
            if (!Schema::hasColumn('sim_stocks', 'activated_at')) {
                $table->timestamp('activated_at')->nullable()->after('activated_by');
            }
        });

        // Add foreign key constraints in a separate schema call
        Schema::table('sim_stocks', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('activated_by')->references('id')->on('employees')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('sim_stocks', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['activated_by']);
            $table->dropColumn(['created_by', 'updated_by', 'activated_by', 'activated_at']);
        });
    }
};
