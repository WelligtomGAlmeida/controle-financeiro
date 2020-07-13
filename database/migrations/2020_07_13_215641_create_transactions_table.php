<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('person_id')->nullable(false);
            $table->unsignedBigInteger('transaction_type_id')->nullable(false);
            $table->unsignedBigInteger('transaction_movement_id')->nullable(false);
            $table->decimal('value', 12, 2)->nullable(false);
            $table->timestamps();

            $table->foreign('person_id')->references('id')->on('people');
            $table->foreign('transaction_type_id')->references('id')->on('transaction_types');
            $table->foreign('transaction_movement_id')->references('id')->on('transaction_movements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
