<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPsmsTable extends Migration
{
    public function up()
    {
        Schema::table('psms', function (Blueprint $table) {
            $table->unsignedBigInteger('fraction_id')->nullable();
            $table->foreign('fraction_id', 'fraction_fk_6468521')->references('id')->on('fractions');
            $table->unsignedBigInteger('peptide_with_modification_id')->nullable();
            $table->foreign('peptide_with_modification_id', 'peptide_with_modification_fk_6614768')->references('id')->on('peptide_with_modifications');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_6614761')->references('id')->on('users');
        });
    }
}
