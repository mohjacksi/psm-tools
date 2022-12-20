<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peptides_proteins', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('protein_id')->unsigned();
            $table->foreign('protein_id')
                  ->references('id')
                  ->on('proteins')->onDelete('cascade');
            $table->bigInteger('peptide_id')->unsigned();
            $table->foreign('peptide_id')
                  ->references('id')
                  ->on('peptides')->onDelete('cascade');



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peptides_proteins');
    }
};
