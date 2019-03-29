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
            $table->string('url', 1000);
            $table->string('host');
            $table->string('title', 1000);
            $table->string('favicon_url')->nullable();
            $table->dateTime('added_at');

            $table->uuid('user_uuid')->index();
            $table->uuid('stack_uuid')->index();
            $table->unsignedBigInteger('stack_id');
            $table->foreign('stack_id')->references('id')->on('stacks')->onDelete('cascade');
        });
    }
}
