<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToChannelPsmsTable extends Migration
{
    public function up()
    {
        Schema::table('channel_psms', function (Blueprint $table) {
            $table->unsignedBigInteger('channel_id')->nullable();
            $table->foreign('channel_id', 'channel_fk_6467581')->references('id')->on('channels');
            $table->unsignedBigInteger('psm_id')->nullable();
            $table->foreign('psm_id', 'psm_fk_6467582')->references('id')->on('psms');
        });
    }
}
