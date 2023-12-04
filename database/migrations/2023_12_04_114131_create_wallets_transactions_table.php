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
        Schema::create('wallets_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date');
            $table->string('type', 20);
            $table->unsignedBigInteger('wallet_from');
            $table->foreign('wallet_from')->references('id')->on('wallets');
            $table->decimal('amount_from', 22);
            $table->string('currency_from', 3)->default('usd');
            $table->unsignedBigInteger('wallet_to');
            $table->foreign('wallet_to')->references('id')->on('wallets');
            $table->decimal('amount_to', 22);
            $table->string('currency_to', 3)->default('usd');
            $table->text('description')->nullable();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets_transactions');
    }
};
