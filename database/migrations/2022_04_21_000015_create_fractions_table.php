<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFractionsTable extends Migration
{
    public function up()
    {
        Schema::create('fractions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('spectra_file_name')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
