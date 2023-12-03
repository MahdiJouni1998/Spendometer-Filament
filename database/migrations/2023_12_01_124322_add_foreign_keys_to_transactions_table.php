<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->after('description', function (Blueprint $table) {
                $table->foreignId('wallet_id')->constrained();
                $table->foreignId('iou_id')->constrained();
                $table->foreignId('category_id')->constrained();
                $table->foreignId('user_id')->constrained();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['wallet_id']);
            $table->dropForeign(['iou_id']);
            $table->dropForeign(['category_id']);
        });
    }
};
