<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewRelationshipFieldsToBiologicalSetsTable extends Migration
{
    public function up()
    {
        Schema::table('biological_sets', function (Blueprint $table) {
            $table->unsignedBigInteger('experiment_id')->nullable();
            $table->foreign('experiment_id', 'experiment_fk_6468466')->references('id')->on('experiments');        });
    }
}
