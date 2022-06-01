<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToProteinsTable extends Migration
{
    public function up()
    {
        Schema::table('proteins', function (Blueprint $table) {
            $table->unsignedBigInteger('peptide_id')->nullable();
            $table->foreign('peptide_id', 'peptide_fk_6614670')->references('id')->on('peptides');
            $table->unsignedBigInteger('type_id')->nullable();
            $table->foreign('type_id', 'type_fk_6614785')->references('id')->on('protein_types');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_6614786')->references('id')->on('users');
        });
    }
}
