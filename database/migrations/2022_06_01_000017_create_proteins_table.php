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
            $table->longText('sequence')->nullable();
            $table->string('name')->nullable();
            $table->longText('source')->nullable();
            $table->longText('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
