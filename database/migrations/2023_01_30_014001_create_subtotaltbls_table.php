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
        Schema::create('subtotaltbls', function (Blueprint $table) {
            $table->increments("subtotalid");
            $table->string("quoteidfk");
            $table->string("subtotalname");
            $table->string("subtotalqty");
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
        Schema::dropIfExists('subtotaltbls');
    }
};
