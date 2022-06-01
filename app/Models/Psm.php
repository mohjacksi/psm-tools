<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Psm extends Model implements HasMedia
{
    use SoftDeletes;
    use MultiTenantModelTrait;
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
        'peptide_with_modification_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function fraction()
    {
        return $this->belongsTo(Fraction::class, 'fraction_id');
    }

    public function peptide_with_modification()
    {
        return $this->belongsTo(PeptideWithModification::class, 'peptide_with_modification_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
