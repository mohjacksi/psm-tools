<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peptide extends Model
{
    use SoftDeletes;
    use MultiTenantModelTrait;
    use Auditable;
    use HasFactory;

    public $table = 'peptides';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'sequence',
        'canonical',
        'canonical_frame_value',
        'category_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
    ];

    public function peptideProteins()
    {
        return $this->hasMany(Protein::class, 'peptide_id', 'id');
    }
    public function proteins()
    {
        return $this->belongsToMany(
            User::class,
            'peptides_proteins',
            'peptide_id',
            'protein_id'
        );
    }
    public function category()
    {
        return $this->belongsTo(PeptidCategory::class, 'category_id');
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
