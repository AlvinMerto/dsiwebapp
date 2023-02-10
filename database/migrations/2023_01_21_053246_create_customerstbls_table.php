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
        Schema::create('customerstbls', function (Blueprint $table) {
            $table->id();
            $table->string("companyname")->nullable();
            $table->string("contactperson")->nullable();
            $table->string("contactnumber")->nullable();
            $table->string("email")->nullable();
            $table->string("website")->nullable();
            $table->string("dept")->nullable();
            $table->string("srcidfk")->nullable();
            $table->string("address")->nullable();
            $table->string("city")->nullable();
            $table->string("zip")->nullable();
            $table->string("country")->nullable();
            $table->string("state")->nullable();
            $table->string("industry")->nullable();
            $table->string("interest")->nullable();
            $table->string("siccode")->nullable();
            $table->string("salespersonidfk")->nullable();
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
        Schema::dropIfExists('customerstbls');
    }
};
