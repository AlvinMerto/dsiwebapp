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
        Schema::create('quoteitemstbls', function (Blueprint $table) {
            $table->increments("quoteitemid");
            $table->string("quoteidfk");
            $table->integer("tblorder");
            $table->string("subtotalidfk")->nullable();
            $table->string("itemtype")->nullable();
            $table->string("itemdesc")->nullable();
            $table->string("itemcost")->nullable();
            $table->string("suppname")->nullable();
            $table->string("supppart")->nullable();
            $table->string("manuname")->nullable();
            $table->string("manupart")->nullable();
            $table->string("profit")->nullable();
            $table->string("markup")->nullable();
            $table->string("markupvalue")->nullable();
            $table->string("itemidfk")->nullable();
            $table->string("qty")->nullable();
            $table->string("price")->nullable();
            $table->string("extended")->nullable();
            $table->string("taxable")->nullable();
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
        Schema::dropIfExists('quoteitemstbls');
    }
};
