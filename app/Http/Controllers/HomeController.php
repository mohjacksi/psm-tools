<?php

namespace App\Http\Controllers;

use App\Models\Peptide;
use App\Models\Project;
use App\Models\Protein;
use App\Models\Psm;
use App\Models\Sample;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $Psm = Psm::count();

        $Protein = Protein::count();

        $Peptide = Peptide::count();

        $Project = Project::count();

        $Sample = Sample::count();

        return view('home', ['Psm'=>$Psm,'Protein'=>$Protein,'Peptide'=>$Peptide,'Project'=>$Project,'Sample'=>$Sample]);
    }
}
