<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTranscriptsTable extends Migration
{
    public function up()
    {
        Schema::table('transcripts', function (Blueprint $table) {
            $table->unsignedBigInteger('dna_location_id')->nullable();
            $table->foreign('dna_location_id', 'dna_location_fk_5772217')->references('id')->on('dna_regions');
        });
    }
}
