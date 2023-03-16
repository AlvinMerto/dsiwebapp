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
        Schema::create('sharewithtbns', function (Blueprint $table) {
            $table->increments("swid");
            $table->string("groupidpk");
            $table->string("tableid")->nullable();
            $table->string("tablefrom")->nullable();
            $table->string("sharedwith");
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
        Schema::dropIfExists('sharewithtbns');
    }
};
