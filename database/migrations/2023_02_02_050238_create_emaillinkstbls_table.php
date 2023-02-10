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
        Schema::create('emaillinkstbls', function (Blueprint $table) {
            $table->increments("emaillinkid");
            $table->string("thecode");
            $table->string("linktoapprove");
            $table->string("idfk")->nullable();
            $table->string("idfld")->nullable();
            $table->string("thetbl")->nullable();
            $table->string("approver")->nullable();
            $table->string("requestor");
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
        Schema::dropIfExists('emaillinkstbls');
    }
};
