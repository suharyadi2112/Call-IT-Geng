<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class KatPengaduan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'a_kategori_pengaduan'; 

    protected $primaryKey = 'id'; 

    public $incrementing = false; 

    protected $keyType = 'string'; 

    protected $fillable = [
        'id',
        'nama',
        'gambar',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    protected $dates = ['deleted_at'];

    // public function pengaduan()
    // {
    //     return $this->hasMany(Pengaduan::class, 'id');
    // }

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
            return $query->where('nama', 'LIKE', "%$search%");
        }
        return $query;
    }
}
