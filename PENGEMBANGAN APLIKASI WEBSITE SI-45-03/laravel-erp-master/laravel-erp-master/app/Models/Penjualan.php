<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualan';
    protected $guarded = ['id'];

    public function details()
    {
        return $this->hasMany(PenjualanDetail::class, 'penjualan_id');
    }

    public function status()
    {
        if ($this->status == 1) {
            return '<span class="badge badge-warning">Diproses</span>';
        } elseif ($this->status = 2) {
            return '<span class="badge badge-success">Sukses</span>';
        } else {
            return '<span class="badge badge-danger">Gagal</span>';
        }
    }

    public static function getKodeBaru()
    {
        // Mendapatkan data terakhir dari tabel penjualan
        $lastData = self::latest()->first();

        // Jika ada data terakhir, ekstrak angka dari kode
        if ($lastData) {
            $kodeSebelumnya = $lastData->kode;
            $angkaSebelumnya = (int) substr($kodeSebelumnya, 3);
        } else {
            // Jika tidak ada data, gunakan nilai default
            $angkaSebelumnya = 0;
        }

        // Membuat kode baru dengan increment angka sebelumnya
        $angkaBaru = $angkaSebelumnya + 1;
        $kodeBaru = 'PNJ' . str_pad($angkaBaru, 3, '0', STR_PAD_LEFT);

        return $kodeBaru;
    }
}
