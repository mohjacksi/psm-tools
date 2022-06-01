<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fraction extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'fractions';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'biological_set_id',
        'spectra_file_name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function fractionPsms()
    {
        return $this->hasMany(Psm::class, 'fraction_id', 'id');
    }

    public function biological_set()
    {
        return $this->belongsTo(BiologicalSet::class, 'biological_set_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
