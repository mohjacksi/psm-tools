<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPsmsTable extends Migration
{
    public function up()
    {
        Schema::table('psms', function (Blueprint $table) {
            $table->unsignedBigInteger('peptide_id')->nullable();
            $table->foreign('peptide_id', 'peptide_fk_7714768')->references('id')->on('peptides');
        });
    }
}
