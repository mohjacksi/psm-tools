<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperimentsTable extends Migration
{
    public function up()
    {
        Schema::create('experiments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->date('date')->nullable();
            $table->string('method')->nullable();
            $table->boolean('allowed_missed_cleavage')->default(0)->nullable();
            $table->float('expression_threshold', 15, 4)->nullable();
            $table->string('reference_protein_source')->nullable();
            $table->string('other_protein_source')->nullable();
            $table->string('psm_file_name')->nullable();
            $table->longText('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
