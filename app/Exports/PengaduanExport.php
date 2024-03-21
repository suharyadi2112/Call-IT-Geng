<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Pengaduan;

class PengaduanExport implements FromCollection
{
    protected $pengaduan;

    public function __construct($pengaduan)
    {
        $this->pengaduan = $pengaduan;
    }

    public function collection()
    {
        return $this->pengaduan;
    }
}
