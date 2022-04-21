<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPeptideProteinsTable extends Migration
{
    public function up()
    {
        Schema::table('peptide_proteins', function (Blueprint $table) {
            $table->unsignedBigInteger('peptide_id')->nullable();
            $table->foreign('peptide_id', 'peptide_fk_6468572')->references('id')->on('peptides');
            $table->unsignedBigInteger('protein_id')->nullable();
            $table->foreign('protein_id', 'protein_fk_6468573')->references('id')->on('proteins');
        });
    }
}
