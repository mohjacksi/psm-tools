<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProteinsTable extends Migration
{
    public function up()
    {
        Schema::create('proteins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('protein')->nullable();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('protein_sequence')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
