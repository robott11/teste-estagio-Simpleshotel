<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('transaction_id', false, true);
            $table->enum('payment_method', ['dinheiro', 'debito', 'credito', 'pix']);
            $table->integer('amount_to_pay', false, true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers_payments');
    }
};
