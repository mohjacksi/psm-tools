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
            $table->string('spectra');
            $table->longText('peptide_modification')->nullable();
            $table->integer('scan_num')->nullable();
            $table->float('precursor', 15, 5)->nullable();
            $table->integer('isotope_error')->nullable();
            $table->float('precursor_error', 15, 5)->nullable();
            $table->integer('charge')->nullable();
            $table->string('de_novo_score')->nullable();
            $table->integer('msgf_score')->nullable();
            $table->integer('space_evalue')->nullable();
            $table->string('evalue')->nullable();
            $table->string('precursor_svm_score')->nullable();
            $table->float('psm_q_value', 15, 5)->nullable();
            $table->float('peptide_q_value', 15, 5)->nullable();
            $table->integer('missed_clevage')->nullable();
            $table->float('experimental_pl', 15, 5)->nullable();
            $table->float('predicted_pl', 15, 5)->nullable();
            $table->float('delta_pl', 15, 5)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
