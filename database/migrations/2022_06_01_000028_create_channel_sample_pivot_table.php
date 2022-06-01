<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelSamplePivotTable extends Migration
{
    public function up()
    {
        Schema::create('channel_sample', function (Blueprint $table) {
            $table->unsignedBigInteger('sample_id');
            $table->foreign('sample_id', 'sample_id_fk_6713817')->references('id')->on('samples')->onDelete('cascade');
            $table->unsignedBigInteger('channel_id');
            $table->foreign('channel_id', 'channel_id_fk_6713817')->references('id')->on('channels')->onDelete('cascade');
        });
    }
}
