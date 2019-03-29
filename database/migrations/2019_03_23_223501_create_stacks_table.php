<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStacksTable extends Migration
{
    public function up()
    {
        Schema::create('stacks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->uuid('parent_uuid')->nullable();
            $table->string('name');
            $table->unsignedInteger('order');
            $table->unsignedInteger('link_count')->default(0);
            $table->uuid('user_uuid')->index();
        });
    }
}
