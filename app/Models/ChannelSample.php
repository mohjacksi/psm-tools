<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChannelSample extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'channel_sample';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'channel_value',
        'psm_id',
        'sample_id',
        'channel_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function Samples()
    {
        return $this->belongsToMany(Sample::class);
    }

    public function psms()
    {
        return $this->belongsToMany(Psm::class);
    }

    public function chennels()
    {
        return $this->belongsToMany(Chennel::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
