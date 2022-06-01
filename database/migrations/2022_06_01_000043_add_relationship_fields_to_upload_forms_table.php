<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUploadFormsTable extends Migration
{
    public function up()
    {
        Schema::table('upload_forms', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id', 'project_fk_6713810')->references('id')->on('projects');
            $table->unsignedBigInteger('experiment_id')->nullable();
            $table->foreign('experiment_id', 'experiment_fk_6713811')->references('id')->on('experiments');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_6713816')->references('id')->on('users');
        });
    }
}
