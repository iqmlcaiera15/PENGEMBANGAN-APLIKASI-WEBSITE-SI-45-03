<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $guarded = ['id'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function gambar()
    {
        if ($this->gambar) {
            return asset('storage/' . $this->gambar);
        } else {
            return asset('assets/images/faces/face28.jpg');
        }
    }
}
