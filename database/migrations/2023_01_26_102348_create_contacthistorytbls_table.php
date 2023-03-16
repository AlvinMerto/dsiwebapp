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
        Schema::create('contacthistorytbls', function (Blueprint $table) {
            $table->increments("conthisid");
            $table->integer("contidfk");
            $table->string("thefield");
            $table->string("thevalue");
            $table->string("thevaluename")->nullable();
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
        Schema::dropIfExists('contacthistorytbls');
    }
};
