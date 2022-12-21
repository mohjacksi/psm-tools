<?php


namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePeptideRequest;
use App\Http\Requests\UpdatePeptideRequest;
use App\Http\Resources\Admin\PeptideResource;
use App\Models\Channel;
use App\Models\Peptide;
use App\Models\Project;
use App\Models\Protein;
use App\Models\Psm;
use App\Models\Sample;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class NetworkApiController extends Controller
{
    public function index()
    {
        $nodes = [];
        $edges = [];

        $projects = Project::withCount('samples')->get();
        $samples = Sample::withCount('psms')->has('project')->get();
        $psms = Psm::all();
        $peptides = Peptide::all();
        $proteins = Protein::all();


        $x = 2;
        $y = .5;
        $size = 5;


        foreach ($projects as $i => $project) {
            $nodes[] = [
                'key'=> 'project'.$project->id,
                'attributes'=> [
                  'x'=> 1+$i*$x,
                  'y'=> 1+$i*$y,
                  'size'=>
                  strlen((string)$project->samples_count) * $size,
                  'label'=> $project->name,
                  'color'=> '#D8482D'
                ]
            ];
        }



        $x = 0.1;
        $y = 0.01;
        $size = 3;


        foreach ($samples as $i => $sample) {
            $nodes[] = [
                'key'=> 'sample'.$sample->id,
                'attributes'=> [
                  'x'=> 1+$i*$x,
                  'y'=> 1+$i*$y,
                  'size'=> $size,
                  'label'=> $sample->name,
                  'color'=> $sample->sample_condition_id == 1 ? 'red' : 'green'
                ]
            ];


            $edges[] = [
                'key'=> 'S'.$sample->id .'P'.$sample->project_id,
                'source'=> 'sample'.$sample->id,
                'target'=> 'project'.$sample->project_id??1,
                'attributes'=> [
                  'size'=> 1,
                ]
            ];
        }



        $x = 0.01;
        $y = 0.1;
        $size = 3;
        foreach ($peptides as $i => $peptide) {
            $nodes[] = [
                'key'=> 'peptide'.$peptide->id,
                'attributes'=> [
                  'x'=> 1+$i*$x,
                  'y'=> 1+$i*$y,
                  'size'=> $size * $peptide->charge,
                  'label'=> $peptide->sequence,
                  'color'=> $peptide->canonical == 1 ? 'red' : 'green'
                ]
            ];
        }



        $x = 0.01;
        $y = 0.1;
        $size = 0.5;
        foreach ($psms as $i => $psm) {
            $nodes[] = [
                'key'=> 'psm'.$psm->id,
                'attributes'=> [
                  'x'=> 1+$i*$x,
                  'y'=> 1+$i*$y,
                  'size'=> $size * $psm->charge,
                  'label'=> $psm->spectra,
                  'color'=> 'yellow'
                ]
            ];


            $edges[] = [
                'key'=> 'psm'.$psm->id .'peptide'.$psm->peptide_id,
                'source'=> 'psm'.$psm->id,
                'target'=> 'peptide'.$psm->peptide_id,
                'attributes'=> [
                  'size'=> 1,
                ]
            ];
        }


        // This is wrong relationship between protien and peptides, but it's here for example
        $x = 0.01;
        $y = 0.1;
        $size = 1;
        foreach ($proteins as $i => $protein) {
            $nodes[] = [
                'key'=> 'protein'.$protein->id,
                'attributes'=> [
                  'x'=> 1+$i*$x,
                  'y'=> 1+$i*$y,
                  'size'=> $size ,
                  'label'=> $protein->spectra,
                  'color'=> 'blue'
                ]
            ];


            // $edges[] = [
            //     'key'=> 'protein'.$protein->id .'peptide'.$protein->peptide_id,
            //     'source'=> 'protein'.$protein->id,
            //     'target'=> 'peptide'.$protein->peptide_id,
            //     'attributes'=> [
            //       'size'=> 1,
            //     ]
            // ];
        }

        $peptides_proteins = DB::table('peptides_proteins')->get();

        foreach ($peptides_proteins as $key => $row) {
            $edges[] = [
                'key'=> 'protein'.$row->protein_id .'peptide'.$row->peptide_id,
                'source'=> 'protein'.$row->protein_id,
                'target'=> 'peptide'.$row->peptide_id,
                'attributes'=> [
                  'size'=> 1,
                ]
            ];

        }

        $channel_sample = DB::table('channel_sample')->get();

        foreach($channel_sample as $row){

            $edges[] = [
                'key'=> $row->id.'psm'.$protein->id .'sample'.$protein->peptide_id,
                'source'=> 'psm'.$row->psm_id,
                'target'=> 'sample'.$row->sample_id,
                'attributes'=> [
                  'size'=> $row->channel_value,
                ]
            ];

        }

        return
        [
            'nodes'=>$nodes,
            'edges'=>$edges,
        ];



        return new PeptideResource(Peptide::with(['category', 'created_by'])->get());
    }

    public function store(StorePeptideRequest $request)
    {
    }

    public function show(Peptide $peptide)
    {
        return new PeptideResource($peptide->load(['category', 'created_by']));
    }

    public function update(UpdatePeptideRequest $request, Peptide $peptide)
    {
        return (new PeptideResource($peptide))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Peptide $peptide)
    {
        abort_if(Gate::denies('peptide_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptide->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
