<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->string('url');
            $table->string('title');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('stack_id');
            $table->string('stack_uuid')->index();
            $table->timestamp('added_at');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('stack_id')->references('id')->on('stacks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('link');
    }
}
