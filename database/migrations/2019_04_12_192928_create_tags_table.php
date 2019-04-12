<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->string('name');
            $table->string('slug');
            $table->unsignedInteger('order');
            $table->unsignedInteger('link_count')->default(0);
            $table->uuid('user_uuid')->index();
        });
    }
}
