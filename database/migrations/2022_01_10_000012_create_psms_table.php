<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePsmsTable extends Migration
{
    public function up()
    {
        Schema::create('psms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('psm_info')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
