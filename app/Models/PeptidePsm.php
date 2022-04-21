<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeptidePsm extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'peptide_psms';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'peptide_id',
        'psm_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function peptide()
    {
        return $this->belongsTo(Peptide::class, 'peptide_id');
    }

    public function psm()
    {
        return $this->belongsTo(Psm::class, 'psm_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
