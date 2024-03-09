<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndikatorMutu extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'a_indikator_mutu'; 

    protected $primaryKey = 'id'; 

    public $incrementing = false; 

    protected $keyType = 'string'; 

    protected $fillable = [
        'id',
        'nama_indikator',
        'target',
        'created_at',
        'updated_at',
        'deleted_at',
        
    ];

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
            return $query->where('nama_indikator', 'LIKE', "%$search%")
                        ->orWhere('target', 'LIKE', "%$search");
        }
        return $query;
    }
}
