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
        Schema::create('taskstbls', function (Blueprint $table) {
            $table->increments("taskid");
            $table->string("custid");
            $table->string("contactid");
            $table->string("activity");
            $table->string("reference")->nullable();
            $table->string("notes")->nullable();
            $table->string("groupidfk");
            $table->string("taskdatetime");
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
        Schema::dropIfExists('taskstbls');
    }
};
