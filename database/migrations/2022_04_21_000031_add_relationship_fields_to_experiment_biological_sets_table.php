<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToExperimentBiologicalSetsTable extends Migration
{
    public function up()
    {
        Schema::table('experiment_biological_sets', function (Blueprint $table) {
            $table->unsignedBigInteger('experiment_id')->nullable();
            $table->foreign('experiment_id', 'experiment_fk_6467534')->references('id')->on('experiments');
        });
    }
}
