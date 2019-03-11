<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaturaIslemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fatura_islems', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('faturaId');
            $table->integer('kalemId');
            $table->integer('urunId');
            $table->integer('miktar');
            $table->double('fiyat');
            $table->integer('kdv');
            $table->double('araToplam');
            $table->double('kdvToplam');
            $table->double('genelToplam');
            $table->text('text');
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
        Schema::dropIfExists('fatura_islems');
    }
}
