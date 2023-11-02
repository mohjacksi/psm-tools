<?php

namespace App\Jobs;

use App\Models\Peptide;
use Exception;
use App\Models\Protein;
use App\Models\ProteinType;
use App\Models\Sample;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessProtein implements ShouldQueue
{
    use Batchable ,Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $chunk;
    public $project_id;
    public $fieldsOrder;
    public $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($chunk,$project_id,$fieldsOrder,$user)
    {
        $this->chunk = $chunk;
        $this->project_id = $project_id;
        $this->fieldsOrder = $fieldsOrder;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $project_id=$this->project_id;
        foreach ($this->chunk as $protein){
            $type_ids = [];
            // edit by mahmoud  alweseemy
            //$types = explode(',', $protein[$this->fieldsOrder['Class_codes']]);
            // foreach ($types as $key => $value) {
            $type = ProteinType::where('name', $protein[$this->fieldsOrder['Class_codes']])->firstOrCreate(
                [
                    'name' => $protein[$this->fieldsOrder['Class_codes']],
                    'created_by_id' => $this->user
                ]
            );
            $type_ids[] = $type->id;
            //}

            $peptide_ids = [];
            // edit by mahmoud  alweseemy
            //$peptides = explode(',', $protein[$this->fieldsOrder['Peptides']]);
            //foreach ($peptides as $key => $value) {
            $peptide = Peptide::where('sequence', $protein[$this->fieldsOrder['Peptides']])->firstOrCreate(
                [
                    'sequence' => $protein[$this->fieldsOrder['Peptides']],
                    'created_by_id' => $this->user
                ]
            );
            $peptide_ids[] = $peptide->id;
            //}

            //ANRU_R2,KADA_R2,ANRU_R1,KADA_R3,BEHA_R1,BEHA_R3,KADA_WGS,KADA_R1,ANRU_R3,BEHA_R2
            $samples = explode(",", $protein[$this->fieldsOrder['Samples']]);

            foreach ($samples as $sampleName) {
                $sample = Sample::where('name', $protein[$this->fieldsOrder['Samples']])->firstOrCreate(
                    [
                        'name' => $protein[$this->fieldsOrder['Samples']],
                        'project_id' => $project_id,
                        'created_by_id' => $this->user
                    ]
                );
            }

            $newProtein = Protein::updateOrCreate(
                [
                    'sequence' => $protein[$this->fieldsOrder['ProteinID']],
                ],
                [
                    'sequence' => $protein[$this->fieldsOrder['ProteinID']],
                    'name' => $protein[$this->fieldsOrder['Name']],
                    'type_id' => $type->id,
                    'created_by_id' => $this->user
                ]
            );

            $newProtein->peptides()->sync($peptide_ids);
            $newProtein->types()->sync($type_ids);
        }

    }


    public function failed(Exception $exception)
    {
        //dd($exception);
    }
}
