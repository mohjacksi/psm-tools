<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToExperimentsTable extends Migration
{
    public function up()
    {
        Schema::table('experiments', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id', 'project_fk_6468385')->references('id')->on('projects');
            $table->unsignedBigInteger('species_id')->nullable();
            $table->foreign('species_id', 'species_fk_6614759')->references('id')->on('speciess');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_6614760')->references('id')->on('users');
        });
    }
}
