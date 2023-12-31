<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'project';
    protected $guarded = ['id'];

    public function details()
    {
        return $this->hasMany(ProjectDetail::class, 'project_id');
    }

    public function status()
    {
        if ($this->status == 0) {
            return '<span class="badge badge-secondary">Belum Dikerjakan</span>';
        } elseif ($this->status == 1) {
            return '<span class="badge badge-warning">Sedang Dikerjakan</span>';
        } elseif ($this->status == 2) {
            return '<span class="badge badge-success">Sudah Selesai</span>';
        } else {
            return '<span class="badge badge-danger">Dibatalkan</span>';
        }
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
