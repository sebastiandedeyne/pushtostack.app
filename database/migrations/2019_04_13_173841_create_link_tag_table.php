<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkTagTable extends Migration
{
    public function up()
    {
        Schema::create('link_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('link_id');
            $table->foreign('link_id')->references('id')->on('links')->onDelete('cascade');

            $table->unsignedBigInteger('tag_id');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');

            $table->unique(['link_id', 'tag_id']);
        });
    }
}
