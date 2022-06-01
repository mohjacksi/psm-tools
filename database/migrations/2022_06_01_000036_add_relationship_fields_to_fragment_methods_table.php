<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFragmentMethodsTable extends Migration
{
    public function up()
    {
        Schema::table('fragment_methods', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_6614804')->references('id')->on('users');
        });
    }
}
