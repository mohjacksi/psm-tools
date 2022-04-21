<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPeopleTable extends Migration
{
    public function up()
    {
        Schema::table('people', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id', 'project_fk_6467460')->references('id')->on('projects');
            $table->unsignedBigInteger('projects_id')->nullable();
            $table->foreign('projects_id', 'projects_fk_6468273')->references('id')->on('projects');
        });
    }
}
