<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->double('amount')->nullable();
            $table->text('notes')->nullable();
            $table->double('sum_debts_us')->nullable();
            $table->double('sum_payment_debts_us')->nullable();
            $table->double('sum_our_debts')->nullable();
            $table->double('sum_payment_our_debts')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('merchants');
    }
}
