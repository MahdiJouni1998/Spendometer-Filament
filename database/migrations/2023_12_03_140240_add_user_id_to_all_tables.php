<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
        Schema::table('ious', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
        Schema::table('income_sources', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
        Schema::table('wallets', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->after('description', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->constrained();
            });
        });
        Schema::table('wallets', function (Blueprint $table) {
            $table->after('name', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->constrained();
            });
        });
        Schema::table('income_sources', function (Blueprint $table) {
            $table->after('name', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->constrained();
            });
        });
        Schema::table('incomes', function (Blueprint $table) {
            $table->after('date_received', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->constrained();
            });
        });
        Schema::table('ious', function (Blueprint $table) {
            $table->after('name', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->constrained();
            });
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->after('name', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->constrained();
            });
        });
    }
};
