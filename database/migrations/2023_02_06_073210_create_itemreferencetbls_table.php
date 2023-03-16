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
        Schema::create('itemreferencetbls', function (Blueprint $table) {
            $table->increments("itemrefid");
            $table->string("quoteidfk");
            $table->string("itemgrpid");
            $table->string("theitemid")->nullable();
            $table->string("criteria");
            $table->string("reference");
            $table->string("thevalue");
            $table->string("inputby");
            $table->string("status");
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
        Schema::dropIfExists('itemreferencetbls');
    }
};
