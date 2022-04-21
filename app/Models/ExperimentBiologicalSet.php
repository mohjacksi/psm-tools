<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExperimentBiologicalSet extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'experiment_biological_sets';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'set',
        'experiment_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function experimentBiologicalSetBiologicalSets()
    {
        return $this->hasMany(BiologicalSet::class, 'experiment_biological_set_id', 'id');
    }

    public function experiment()
    {
        return $this->belongsTo(Experiment::class, 'experiment_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
