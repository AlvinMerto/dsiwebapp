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
        Schema::create('itemtbls', function (Blueprint $table) {
            $table->increments("itemid");
            $table->string("itemname");
            $table->string("itemprice");
            $table->string("supplierid");
            $table->string("mfgid");
            $table->string("description");
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
        Schema::dropIfExists('itemtbls');
    }
};
