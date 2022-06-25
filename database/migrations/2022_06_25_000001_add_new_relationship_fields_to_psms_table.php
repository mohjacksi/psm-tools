<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewRelationshipFieldsToPsmsTable extends Migration
{
    public function up()
    {
        Schema::table('psms', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id', 'project_fk_6614768')->references('id')->on('projects');
            $table->unsignedBigInteger('experiment_id')->nullable();
            $table->foreign('experiment_id', 'experiment_fk_6614768')->references('id')->on('experiments');
            $table->unsignedBigInteger('biological_set_id')->nullable();
            $table->foreign('biological_set_id', 'biological_set_fk_6614768')->references('id')->on('biological_sets');
        });
    }
}
