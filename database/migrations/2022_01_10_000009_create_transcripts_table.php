<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranscriptsTable extends Migration
{
    public function up()
    {
        Schema::create('transcripts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('transcript')->nullable();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('transcript_sequence')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
