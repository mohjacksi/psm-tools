<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSamplesTable extends Migration
{
    public function up()
    {
        Schema::table('samples', function (Blueprint $table) {
            $table->unsignedBigInteger('person_id')->nullable();
            $table->foreign('person_id', 'person_fk_6467489')->references('id')->on('people');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id', 'project_fk_6468274')->references('id')->on('projects');
            $table->unsignedBigInteger('channel_id')->nullable();
            $table->foreign('channel_id', 'channel_fk_6468275')->references('id')->on('channels');
            $table->unsignedBigInteger('tissue_id')->nullable();
            $table->foreign('tissue_id', 'tissue_fk_6468332')->references('id')->on('tissues');
        });
    }
}
