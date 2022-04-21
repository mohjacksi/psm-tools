<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperimentBiologicalSetsTable extends Migration
{
    public function up()
    {
        Schema::create('experiment_biological_sets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('set')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
