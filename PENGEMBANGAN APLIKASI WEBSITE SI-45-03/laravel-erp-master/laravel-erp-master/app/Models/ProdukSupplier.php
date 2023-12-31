<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukSupplier extends Model
{
    use HasFactory;
    protected $table = 'produk_supplier';
    protected $guarded = ['id'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
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
