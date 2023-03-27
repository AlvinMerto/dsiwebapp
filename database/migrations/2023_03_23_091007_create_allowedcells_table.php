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
        Schema::create('allowedcells', function (Blueprint $table) {
            $table->increments("acid");
            $table->string("quoteid");
            $table->string("quoteitemid");
            $table->string("requestinguserid");
            $table->string("cellid");
            $table->string("auidfk");       
            $table->string("status");
            $table->string("inputby");
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
        Schema::dropIfExists('allowedcells');
    }
};
