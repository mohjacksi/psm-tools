<?php

namespace App\Http\Controllers\Admin;
use App\Models\Peptide;
use App\Models\Project;
use App\Models\Protein;
use App\Models\Psm;
use App\Models\Sample;

class HomeController
{
    public function index()
    {

        $Psm = Psm::count();

        $Protein = Protein::count();

        $Peptide = Peptide::count();

        $Project = Project::count();

        $Sample = Sample::count();

        return view('home', [  'Psm'=>$Psm,
                                'Protein'=>$Protein,
                                'Peptide'=>$Peptide,
                                'Project'=>$Project,
                                'Sample'=>$Sample]);
    }
}
