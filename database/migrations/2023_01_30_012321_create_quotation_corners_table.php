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
        Schema::create('quotation_corners', function (Blueprint $table) {
            $table->increments("quoteid");
            $table->string("custidfk");
            $table->datetime("quotedate");
            $table->datetime("quotevalidity")->nullable();
            $table->datetime("orderdate")->nullable();
            $table->string("quoteprice");
            $table->string("quotationsentto")->nullable();
            $table->string("quotationname")->nullable();
            $table->string("taxused")->nullable();
            $table->string("inputby");
            $table->integer("status");
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
        Schema::dropIfExists('quotation_corners');
    }
};
