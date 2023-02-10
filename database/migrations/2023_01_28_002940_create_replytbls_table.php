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
        Schema::create('replytbls', function (Blueprint $table) {
            $table->increments("replyid");
            $table->string("taskid");
            $table->string("custid");
            $table->string("groupidfk");
            $table->string("thereply")->nullable();
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
        Schema::dropIfExists('replytbls');
    }
};
