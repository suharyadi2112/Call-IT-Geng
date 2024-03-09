<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Pengaduan extends Model
{
    use HasFactory;
    
    protected $table = 'a_pengaduan'; 

    protected $primaryKey = 'id'; 

    public $incrementing = false; 

    protected $keyType = 'string'; 

    protected $fillable = [
        'id',
        'kode_laporan',
        'indikator_mutu_id',
        'pelapor_id',
        'kategori_pengaduan_id',
        'admin_id',
        'lokasi',
        'lantai',
        'judul_pengaduan',
        'dekskripsi_pelaporan',
        'prioritas',
        'nomor_handphone',
        'status_pelaporan',
        'tanggal_pelaporan',
        'tanggal_selesai',
    ];

    public function detailpengaduan()
    {
        return $this->hasMany(DetailIPengaduan::class, 'pengaduan_id', 'id');
    }
    public function kategoripengaduan()
    {
        return $this->belongsTo(KatPengaduan::class, 'kategori_pengaduan_id', 'id');
    }
    public function indikatormutu()
    {
        return $this->belongsTo(IndikatorMutu::class, 'indikator_mutu_id', 'id');
    }
    public function pelapor()
    {
        return $this->belongsTo(User::class, 'pelapor_id', 'id');
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
            return $query->where('judul_pengaduan', 'LIKE', "%$search%")
                        ->orWhere('lantai', 'LIKE', "%$search%");
        }
        return $query;
    }
}
