<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSamplesTable extends Migration
{
    public function up()
    {
        Schema::create('samples', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->longText('details')->nullable();
            $table->string('sample_type')->nullable();
            $table->longText('metadata')->nullable();
            $table->string('sample_condition')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
