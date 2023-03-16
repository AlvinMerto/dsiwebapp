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
        Schema::create('contactfluidtbls', function (Blueprint $table) {
            $table->increments("cffid");
            $table->integer("contidfk");
            $table->string("thefield");
            $table->string("thevalue");
            $table->integer("status");
            $table->integer("inputby");
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
        Schema::dropIfExists('contactfluidtbls');
    }
};
