<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMusterilersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('musterilers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('musteriTipi')->default(0);
            $table->string('photo')->nullable();

            $table->string('ad')->nullable();
            $table->string('soyad')->nullable();
            $table->date('dogumTarih')->nullable();
            $table->string('tc')->nullable();

            $table->string('firmaAdi')->nullable();
            $table->string('vergiNumarasi')->nullable();
            $table->string('vergiDairesi')->nullable();

            $table->string('adres')->nullable();
            $table->string('telefon')->nullable();
            $table->string('email')->nullable();

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
        Schema::dropIfExists('musterilers');
    }
}
