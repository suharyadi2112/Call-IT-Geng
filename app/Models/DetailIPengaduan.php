<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class DetailIPengaduan extends Model
{
    use HasFactory;

    protected $table = 'a_detail_pengaduan'; 

    protected $primaryKey = 'id'; 

    public $incrementing = false; 

    protected $keyType = 'string'; 

    protected $fillable = [
        'id',
        'pengaduan_id',
        'picture',
        'tipe',
        'created_at',
        'updated_at',
        
    ];

    protected $hidden = [
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
            return $query->where('picture_pre', 'LIKE', "%$search%");
        }
        return $query;
    }

}
