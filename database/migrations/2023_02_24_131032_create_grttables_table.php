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
        Schema::create('grttables', function (Blueprint $table) {
            $table->increments("grtid");
            $table->string("custid");
            $table->string("quoteidfk");
            $table->string("grttypeid");
            $table->string("grtvalue");
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
        Schema::dropIfExists('grttables');
    }
};
