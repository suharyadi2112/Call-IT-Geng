<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class OncallSchedule extends Model
{
    use HasFactory;
    
    protected $table = 'a_oncall_schedule'; 

    protected $primaryKey = 'id'; 

    public $incrementing = false; 

    protected $keyType = 'string'; 

    protected $fillable = [
        'id',
        'nama_oncall',
        'handphone_oncall',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function detailoncall()
    {
        return $this->hasMany(OncallDetail::class, 'id_oncall_schedule', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('nama_oncall', 'LIKE', "%$search%");
        }
        return $query;
    }

}
