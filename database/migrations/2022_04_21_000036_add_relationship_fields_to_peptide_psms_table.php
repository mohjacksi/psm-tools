<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPeptidePsmsTable extends Migration
{
    public function up()
    {
        Schema::table('peptide_psms', function (Blueprint $table) {
            $table->unsignedBigInteger('peptide_id')->nullable();
            $table->foreign('peptide_id', 'peptide_fk_6467687')->references('id')->on('peptides');
            $table->unsignedBigInteger('psm_id')->nullable();
            $table->foreign('psm_id', 'psm_fk_6467688')->references('id')->on('psms');
        });
    }
}
