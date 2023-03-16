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
        Schema::create('totalpricetbls', function (Blueprint $table) {
            $table->increments("tptblid");
            $table->string("custidfk");
            $table->string("quoteidfk");
            $table->string("profit")->nullable();
            $table->string("gp")->nullable();
            $table->string("cost")->nullable();
            $table->string("subtotal")->nullable();
            $table->string("tax")->nullable();
            $table->string("taxpercentage")->nullable();
            $table->string('total')->nullable();
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
        Schema::dropIfExists('totalpricetbls');
    }
};
