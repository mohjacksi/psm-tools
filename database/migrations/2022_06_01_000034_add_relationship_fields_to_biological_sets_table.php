<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBiologicalSetsTable extends Migration
{
    public function up()
    {
        Schema::table('biological_sets', function (Blueprint $table) {
            $table->unsignedBigInteger('stripe_id')->nullable();
            $table->foreign('stripe_id', 'stripe_fk_6468466')->references('id')->on('stripes');
            $table->unsignedBigInteger('fragment_method_id')->nullable();
            $table->foreign('fragment_method_id', 'fragment_method_fk_6468467')->references('id')->on('fragment_methods');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_6614758')->references('id')->on('users');
        });
    }
}
