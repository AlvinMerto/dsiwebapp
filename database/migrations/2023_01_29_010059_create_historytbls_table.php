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
        Schema::create('historytbls', function (Blueprint $table) {
            $table->increments("historyid");
            $table->string("custidfk");
            $table->string("tableid");
            $table->string("tablefrom");
            $table->string("historyactivity")->nullable();
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
        Schema::dropIfExists('historytbls');
    }
};
