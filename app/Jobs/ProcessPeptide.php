<?php

namespace App\Jobs;

use Exception;
use App\Models\PeptidCategory;
use App\Models\Peptide;
use App\Models\Protein;
use App\Models\Sample;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessPeptide implements ShouldQueue
{
    use Batchable,Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        foreach ($this->chunk as $peptide) {


                $category = PeptidCategory::where('name', $peptide[$this->fieldsOrder['Category']])->firstOrCreate(
                    [
                        'name' => $peptide[$this->fieldsOrder['Category']],
                        'created_by_id' => $this->user
                    ]
                );
                //sapmples  ANRU_R2,KADA_R2,ANRU_R1,KADA_R3,BEHA_R1,BEHA_R3,KADA_WGS,KADA_R1,ANRU_R3,BEHA_R2
                $samples = explode(",", $peptide[$this->fieldsOrder['Samples']]);
                if (count($samples) > 0) {
                    foreach ($samples as $sampleName) {
                        $sample = Sample::where('name', $peptide[$this->fieldsOrder['Samples']])->firstOrCreate(
                            [
                                'name' => $peptide[$this->fieldsOrder['Samples']],
                                'project_id' => $this->project_id,
                                'created_by_id' => $this->user
                            ]
                        );
                    }
                }

                if ($peptide[$this->fieldsOrder['is_canonical_frame']] != 'non_canonical') {
                    $canonical = 1;
                    $canonical_frame_value = $peptide[$this->fieldsOrder['is_canonical_frame']];
                } else {
                    $canonical = 0;
                    $canonical_frame_value = null;
                }

                $newPeptide = Peptide::where('sequence', $peptide[$this->fieldsOrder['Peptide']])->firstOrCreate(
                    [
                        'sequence' => $peptide[$this->fieldsOrder['Peptide']],
                        'canonical' => $canonical,
                        'canonical_frame_value' => $canonical_frame_value,
                        'category_id' => $category->id,
                        'created_by_id' => $this->user
                    ]
                );
                $protein_ids = [];
                //edit by alweseemy
                //$proteins = explode(',', $peptide[$fieldsOrder['Transcripts']]);
                //foreach ($proteins as $key => $value) {

                $protein = Protein::where('sequence', $peptide[$this->fieldsOrder['Transcripts']])->firstOrCreate(
                    [
                        'sequence' => $peptide[$this->fieldsOrder['Transcripts']],
                        'created_by_id' => $this->user
                    ]
                );
                $protein_ids[] = $protein->id;
                // }

                $newPeptide->proteins()->sync($protein_ids);

        }
    }

    public function failed(Exception $exception)
    {
        //dd($exception);
    }
}
