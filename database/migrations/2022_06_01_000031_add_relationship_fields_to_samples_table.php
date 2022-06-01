<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSamplesTable extends Migration
{
    public function up()
    {
        Schema::table('samples', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id', 'project_fk_6468274')->references('id')->on('projects');
            $table->unsignedBigInteger('species_id')->nullable();
            $table->foreign('species_id', 'species_fk_6614732')->references('id')->on('speciess');
            $table->unsignedBigInteger('tissue_id')->nullable();
            $table->foreign('tissue_id', 'tissue_fk_6468332')->references('id')->on('tissues');
            $table->unsignedBigInteger('sample_condition_id')->nullable();
            $table->foreign('sample_condition_id', 'sample_condition_fk_6614733')->references('id')->on('sample_conditions');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_6614714')->references('id')->on('users');
        });
    }
}
