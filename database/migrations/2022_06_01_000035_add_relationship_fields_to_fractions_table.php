<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFractionsTable extends Migration
{
    public function up()
    {
        Schema::table('fractions', function (Blueprint $table) {
            $table->unsignedBigInteger('biological_set_id')->nullable();
            $table->foreign('biological_set_id', 'biological_set_fk_6467548')->references('id')->on('biological_sets');
        });
    }
}
