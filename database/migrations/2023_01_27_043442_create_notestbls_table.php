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
        Schema::create('notestbls', function (Blueprint $table) {
            $table->increments("noteid");
            $table->string("custid");
            $table->string("reference");
            $table->string("label");
            $table->longText("thenote");
            $table->string("groupidfk");
            $table->integer("status");
            $table->string("inputby");
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
        Schema::dropIfExists('notestbls');
    }
};
