<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BiologicalSet extends Model
{
    use SoftDeletes;
    use MultiTenantModelTrait;
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
        'labeling_number',
        'stripe_id',
        'fragment_method_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
        'experiment_id',
    ];

    public function experiment()
    {
        return $this->belongsTo(Experiment::class);
    }

    // public function hasExperiment($experiment) {
    //     return $this->experiments->contains($experiment);
    // }

    public function stripe()
    {
        return $this->belongsTo(Stripe::class, 'stripe_id');
    }

    public function fragment_method()
    {
        return $this->belongsTo(FragmentMethod::class, 'fragment_method_id');
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
