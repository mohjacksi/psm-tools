<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPeptideWithModificationsTable extends Migration
{
    public function up()
    {
        Schema::table('peptide_with_modifications', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_6614767')->references('id')->on('users');
        });
    }
}
