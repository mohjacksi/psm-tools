<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BiologicalSet extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'biological_sets';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'experiment_biological_set_id',
        'stripe_id',
        'fragment_method_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function experiment_biological_set()
    {
        return $this->belongsTo(ExperimentBiologicalSet::class, 'experiment_biological_set_id');
    }

    public function stripe()
    {
        return $this->belongsTo(Stripe::class, 'stripe_id');
    }

    public function fragment_method()
    {
        return $this->belongsTo(FragmentMethod::class, 'fragment_method_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
