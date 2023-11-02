<?php

namespace App\Jobs;

use Exception;
use App\Models\BiologicalSet;
use App\Models\Channel;
use App\Models\ChannelSample;
use App\Models\Fraction;
use App\Models\FragmentMethod;
use App\Models\Peptide;
use App\Models\PeptideWithModification;
use App\Models\Psm;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessPsm implements ShouldQueue
{
    use Batchable ,Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $chunk;
    public $project_id;
    public $fieldsOrder;
    public $user;
    public $experiment;
    public $request;
    public $psm_array;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($chunk,$project_id,$fieldsOrder,$user,$experiment,$request,$psm_array)
    {
        $this->chunk = $chunk;
        $this->project_id = $project_id;
        $this->fieldsOrder = $fieldsOrder;
        $this->user = $user;
        $this->experiment = $experiment;
        $this->request = $request;
        $this->psm_array = $psm_array;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->chunk as   $psm) {

                $FragmentMethod = FragmentMethod::where('name', $psm[$this->fieldsOrder['FragMethod']])->firstOrCreate(
                    [
                        'name' => $psm[$this->fieldsOrder['FragMethod']],
                        'created_by_id' => $this->user
                    ]
                );
                $BiologicalSet = BiologicalSet::where('name', $psm[$this->fieldsOrder['Biological set']])->firstOrCreate(
                    [
                        'name' => $psm[$this->fieldsOrder['Biological set']],
                        'created_by_id' => $this->user,
                        'fragment_method_id' => $FragmentMethod->id,
                        'experiment_id' => $this->experiment->id,
                    ]
                );
                // if (!$BiologicalSet->hasExperiment($experiment)) {
                //     $BiologicalSet->experiments()->attach($experiment);
                // }
                // if (!$experiment->hasBiologicalSet($BiologicalSet)) {
                //     $experiment->experimentBiologicalSets()->attach($BiologicalSet);
                // }
                $Fraction = Fraction::where('name', $psm[$this->fieldsOrder['SpectraFile']])->firstOrCreate(
                    [
                        'name' => $psm[$this->fieldsOrder['SpectraFile']],
                        'spectra_file_name' => $psm[$this->fieldsOrder['SpectraFile']],
                        'biological_set_id' => $BiologicalSet->id,
                    ]
                );
                $PeptideWithModification = PeptideWithModification::where('name', $psm[$this->fieldsOrder['Peptide']])->firstOrCreate(
                    [
                        'name' => $psm[$this->fieldsOrder['Peptide']],
                        'created_by_id' => $this->user
                    ]
                );
                $PeptideAZ = preg_replace("/[^A-Z]+/", "", $psm[$this->fieldsOrder['Peptide']]);
                $Peptide = Peptide::where('sequence', $PeptideAZ)->firstOrCreate(
                    [
                        'sequence' => $PeptideAZ,
                        'created_by_id' =>$this->user
                    ]
                );

                $newPsm = Psm::create([
                    'spectra' => $psm[$this->fieldsOrder['SpectraFile']],
                    'peptide_modification' => $psm[$this->fieldsOrder['Peptide']],
                    'scan_num' => $psm[$this->fieldsOrder['ScanNum']],
                    'precursor' => $psm[$this->fieldsOrder['Precursor']],
                    'isotope_error' => $psm[$this->fieldsOrder['IsotopeError']],
                    'precursor_error' => $psm[$this->fieldsOrder['PrecursorError(ppm)']],
                    'charge' => $psm[$this->fieldsOrder['Charge']],
                    'de_novo_score' => $psm[$this->fieldsOrder['DeNovoScore']],
                    'msgf_score' => $psm[$this->fieldsOrder['MSGFScore']],
                    'space_evalue' => $psm[$this->fieldsOrder['SpecEValue']],
                    'evalue' => $psm[$this->fieldsOrder['EValue']],
                    'precursor_svm_score' => $psm[$this->fieldsOrder['percolator svm-score']],
                    'psm_q_value' => $psm[$this->fieldsOrder['PSM q-value']],
                    'peptide_q_value' => $psm[$this->fieldsOrder['peptide q-value']],
                    'fraction_id' => $Fraction->id,
                    'project_id' => $this->project_id,
                    'experiment_id' => $this->experiment->id,
                    'species_id' => $this->experiment->species_id,
                    'biological_set_id' => $BiologicalSet->id,
                    'peptide_with_modification_id' => $PeptideWithModification->id,
                    'peptide_id' => $Peptide->id,
                    'created_by_id' => $this->user,
                ]);

                if($this->request['sample_number'] > 0){
                    foreach ($this->request['samples'] as $key=>$sample){
                        $channelOdrer=array_search($this->request['chennels'][$key],  $this->psm_array);
                        if($channelOdrer){
                            $newChennel = Channel::where('name', $this->request['chennels'][$key])->firstOrCreate(
                                [
                                    'name' => $this->request['chennels'][$key],
                                    'created_by_id' => $this->user
                                ]
                            );
                            $channelSample = ChannelSample::where('channel_id', $newChennel->id)
                                ->where('psm_id', $newPsm->id)
                                ->where('sample_id', $sample)
                                ->firstOrCreate(
                                    [
                                        'channel_id' => $newChennel->id,
                                        'psm_id' => $newPsm->id,
                                        'sample_id' => $sample,
                                        'channel_value' => $psm[$channelOdrer],
                                    ]
                                );
                        }

                    }
                }
            }

    }
    public function failed(Exception $exception)
    {
        //dd($exception);
    }
}
