<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Psm extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use Auditable;
    use HasFactory;

    public $table = 'psms';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'spectra',
        'fraction_id',
        'peptide_modification',
        'scan_num',
        'precursor',
        'isotope_error',
        'precursor_error',
        'charge',
        'de_novo_score',
        'msgf_score',
        'space_evalue',
        'evalue',
        'precursor_svm_score',
        'psm_q_value',
        'peptide_q_value',
        'missed_clevage',
        'experimental_pl',
        'predicted_pl',
        'delta_pl',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function psmChannelPsms()
    {
        return $this->hasMany(ChannelPsm::class, 'psm_id', 'id');
    }

    public function psmPeptidePsms()
    {
        return $this->hasMany(PeptidePsm::class, 'psm_id', 'id');
    }

    public function fraction()
    {
        return $this->belongsTo(Fraction::class, 'fraction_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
