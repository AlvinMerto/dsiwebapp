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
        Schema::create('the_orders', function (Blueprint $table) {
            $table->increments("theorderid");
            $table->string("quoteid")->nullable();
            $table->string("custidfk")->nullable();
            $table->string("contidfk")->nullable();
            $table->datetime("processeddate")->nullable();
            $table->string("bulkorderid")->nullable();
            $table->string("weeknumber")->nullable();
            $table->string("vendor")->nullable();
            $table->string("description")->nullable();
            $table->string("qty")->nullable();
            $table->string("unitcost")->nullable();
            $table->string("extendedcost")->nullable();
            $table->string("estimatedsh")->nullable();
            $table->string("estimatedshtax")->nullable();
            $table->string("tax")->nullable();
            $table->string("totalcost")->nullable();
            $table->string("totalcosttax")->nullable();
            $table->string("inputby")->nullable();
            $table->string("status")->nullable();
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
        Schema::dropIfExists('the_orders');
    }
};
