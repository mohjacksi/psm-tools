<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelPsmsTable extends Migration
{
    public function up()
    {
        Schema::create('channel_psms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('value')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
