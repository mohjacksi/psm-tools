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


        $psm = DB::table('channel_sample')
        // ->distinct('sample_id','psm_id','channel_id')->get();
        ->get()->groupBy('sample_id');

        // dd($psm->first()->toArray());
        foreach($psm as $rows){
            foreach($rows as $row){
            $edges[] = [
                'key'=> $row->id.'psm'.$row->psm_id .'sample'.$row->sample_id,
                'source'=> 'psm'.$row->psm_id,
                'target'=> 'sample'.$row->sample_id,
                'attributes'=> [
                  'size'=> is_numeric($row->channel_value) ? $row->channel_value/20: 0.1,
                ]
            ];
            }
        }
        // dd($edges);


        $projects = Project::withCount('samples')->get();
        $samples = Sample::withCount('psms')->has('project')->get();
        $psms = Psm::all();
        $peptides = Peptide::all();
        $proteins = Protein::all();


        $x = 2;
        $y = .5;
        $size = 10;


        foreach ($projects as $i => $project) {
            $nodes[] = [
                'key'=> 'project'.$project->id,
                'type'=> 'project',
                'attributes'=> [
                  'x'=> rand(1,25),
                  'y'=> rand(1,25),
                  'size'=>
                  strlen((string)$project->samples_count) * $size,
                  'label'=> 'Project:'.$project->name,
                  'color'=> 'blue'
                ]
            ];
        }



        $x = 0.1;
        $y = 0.01;
        $size = 7;


        foreach ($samples as $i => $sample) {
            $type = $sample->sample_condition_id == 1 ? '-cancer' : '';
            $nodes[] = [
                'key'=> 'sample'.$sample->id,
                'type'=> 'sample' . $type,
                'attributes'=> [
                  'x'=> rand(1,25),
                  'y'=> rand(1,25),
                  'size'=> $size,
                  'label'=> 'Sample:'.$sample->name,
                  'color'=> $sample->sample_condition_id == 1 ? 'green' : 'red'
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
        $size = 4;
        foreach ($peptides as $i => $peptide) {
            $type = $peptide->canonical == 1 ? '-canonical' : '';
            $nodes[] = [
                'key'=> 'peptide'.$peptide->id,
                'type'=> 'peptide'.$type,
                'attributes'=> [
                  'x'=> rand(1,25),
                  'y'=> rand(1,25),
                  'size'=> $size * $peptide->charge,
                  'label'=> 'Pep:'.$peptide->sequence,
                  'color'=> $peptide->canonical == 1 ? 'purple' : 'mediumpurple'
                ]
            ];
        }



        $x = 0.01;
        $y = 0.1;
        $size = 0.8;
        foreach ($psms as $i => $psm) {
            $nodes[] = [
                'key'=> 'psm'.$psm->id,
                'type'=> 'psm',
                'attributes'=> [
                  'x'=> rand(1,25),
                  'y'=> rand(1,25),
                  'size'=> $size * $psm->charge,
                  'label'=>'Psm:'.$psm->spectra,
                  'color'=> 'orange'
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
        $size = 3;
        foreach ($proteins as $i => $protein) {
            $nodes[] = [
                'key'=> 'protein'.$protein->id,
                'type'=> 'protein',
                'attributes'=> [
                  'x'=> rand(1,25),
                  'y'=> rand(1,25),
                  'size'=> $size ,
                  'label'=> 'Protien:'.$protein->sequence,
                  'color'=> 'grey'
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
        /* Puse it  for now!
        $channel_sample = DB::table('channel_sample')
        ->distinct('sample_id','psm_id','channel_id')
        ->get();
        dd($channel_sample->count());
        foreach($channel_sample as $row){

            $edges[] = [
                'key'=> $row->id.'psm'.$row->psm_id .'sample'.$row->sample_id,
                'source'=> 'psm'.$row->psm_id,
                'target'=> 'sample'.$row->sample_id,
                'attributes'=> [
                  'size'=> $row->channel_value,
                ]
            ];

        }
        */


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
