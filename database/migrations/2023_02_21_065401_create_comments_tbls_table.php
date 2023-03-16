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
        Schema::create('comments_tbls', function (Blueprint $table) {
            $table->increments("comid");
            $table->string("quoteidfk");
            $table->string("quoteitemidfk");
            $table->string("thecomment");
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
        Schema::dropIfExists('comments_tbls');
    }
};
