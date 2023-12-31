<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Dashboard')->only('index');
    }

    public function index()
    {
        $count = [
            'supplier' => Supplier::count(),
            'produk' => Produk::count(),
            'pemasukan' => Pemasukan::sum('nominal'),
            'pengeluaran' => Pengeluaran::sum('nominal')
        ];
        return view('pages.dashboard', [
            'title' => 'Dashboard',
            'count' => $count
        ]);
    }
}
