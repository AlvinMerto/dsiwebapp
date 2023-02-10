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
        Schema::create('itemstbls', function (Blueprint $table) {
            $table->increments("itemid");
            $table->string("category");
            $table->string("itemcode")->nullable();
            $table->string("description")->nullable();
            $table->string("itemname")->nullable();
            $table->string("itemprice")->nullable();
            $table->string("markup")->nullable();
            $table->string("sellprice")->nullable();
            $table->string("supplierid")->nullable();
            $table->string("suppliername")->nullable();
            $table->string("mfgid")->nullable();
            $table->string("mfgname")->nullable();
            $table->integer("istaxable")->nullable();
            $table->string("inputby")->nullable();
            $table->integer("status")->nullable();
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
        Schema::dropIfExists('itemstbls');
    }
};
