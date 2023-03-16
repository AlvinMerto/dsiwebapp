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
        Schema::create('viewquoteopts', function (Blueprint $table) {
            $table->increments("vopid");
            $table->string("viewoptionfld");
            $table->string("viewoptiontxt");
            $table->string("quoteidfk");
            $table->string("optiontype");
            $table->string("inputby");
            $table->string("status");
            $table->integer("orderfld");
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
        Schema::dropIfExists('viewquoteopts');
    }
};
