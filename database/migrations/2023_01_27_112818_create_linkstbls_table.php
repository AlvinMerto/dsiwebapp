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
        Schema::create('linkstbls', function (Blueprint $table) {
            $table->increments("sourceid");
            $table->string("custid");
            $table->string("documentname")->nullable();
            $table->string("notes")->nullable();
            $table->string("filename")->nullable();
            $table->string("url")->nullable();
            $table->string("groupidfk")->nullable();
            $table->integer("inputby");
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
        Schema::dropIfExists('linkstbls');
    }
};
