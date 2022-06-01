<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiologicalSetExperimentPivotTable extends Migration
{
    public function up()
    {
        Schema::create('biological_set_experiment', function (Blueprint $table) {
            $table->unsignedBigInteger('biological_set_id');
            $table->foreign('biological_set_id', 'biological_set_id_fk_6614659')->references('id')->on('biological_sets')->onDelete('cascade');
            $table->unsignedBigInteger('experiment_id');
            $table->foreign('experiment_id', 'experiment_id_fk_6614659')->references('id')->on('experiments')->onDelete('cascade');
        });
    }
}
