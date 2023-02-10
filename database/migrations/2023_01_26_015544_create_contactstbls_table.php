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
        Schema::create('contactstbls', function (Blueprint $table) {
            $table->increments("contid");
            $table->integer("custidfk");
            $table->string("contactname")->nullable();
            $table->string("title")->nullable();
            $table->string("contactnumber")->nullable();
            $table->string("email")->nullable();
            $table->string("address")->nullable();
            $table->string("city")->nullable();
            $table->string("state_country")->nullable();
            $table->string("zip")->nullable();
            $table->string("notes")->nullable();
            $table->string("inputby");
            $table->integer("status")->nullable();
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
        Schema::dropIfExists('contactstbls');
    }
};
