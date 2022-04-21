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
        });
    }
}
