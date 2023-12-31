<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use App\Models\ProdukSupplier;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Project Index')->only('index');
        $this->middleware('can:Project Create')->only(['create', 'store']);
        $this->middleware('can:Project Edit')->only(['edit', 'update']);
        $this->middleware('can:Project Delete')->only('destroy');
    }

    public function index()
    {
        $items = Project::with(['details'])->latest()->get();
        return view('pages.project.index', [
            'title' => 'Project',
            'items' => $items
        ]);
    }

    public function create()
    {
        $data_produk_supplier = ProdukSupplier::orderBy('nama', 'ASC')->get();
        return view('pages.project.create', [
            'title' => 'Tambah Project',
            'data_produk_supplier' => $data_produk_supplier
        ]);
    }

    public function store()
    {

        request()->validate([
            'gambar' => ['image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'nama' => ['required'],
            'deskripsi' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $data_produk_supplier = request('produk_supplier_id');
            $data_jumlah = request('jumlah');
            $data_keterangan = request('keterangan');
            $estimasi_harga = 0;
            foreach ($data_produk_supplier as $key => $produk) {
                $item = ProdukSupplier::findOrFail($produk);
                $estimasi_harga = $estimasi_harga + ($item->harga * $data_jumlah[$key]);
            }
            $project = Project::create([
                'nama' => request('nama'),
                'estimasi_harga' => $estimasi_harga,
                'status' => 0,
                'deskripsi' => request('deskripsi'),
                'harga' => $estimasi_harga,
                'status' => request('status'),
                'gambar' => request()->file('gambar') ? request()->file('gambar')->store('project', 'public') : NULL
            ]);

            // cek status
            if (request('status') == 2) {
                // tambah pemasukan
                Pemasukan::create([
                    'nama' =>  "Project Baru : " . $item->nama,
                    'nominal' => $estimasi_harga,
                    'keterangan' => NULL
                ]);
            }

            foreach ($data_produk_supplier as $key => $produk) {
                $item = ProdukSupplier::findOrFail($produk);
                $total_harga = $item->harga * $data_jumlah[$key];
                $project->details()->create([
                    'produk_supplier_id' => $item->id,
                    'harga' => $item->harga,
                    'jumlah' => $data_jumlah[$key],
                    'total_harga' => $total_harga,
                    'keterangan' => $data_keterangan[$key]
                ]);
            }

            DB::commit();
            return redirect()->route('project.index')->with('success', 'Project berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $item = Project::with(['details'])->findOrFail($id);
        $data_produk_supplier = ProdukSupplier::orderBy('nama', 'ASC')->get();
        return view('pages.project.edit', [
            'title' => 'Edit Project',
            'item' => $item,
            'data_produk_supplier' => $data_produk_supplier
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'gambar' => ['image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'nama' => ['required'],
            'deskripsi' => ['required'],
            'status' => ['required'],
            'harga_project' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $project = Project::findOrFail($id);
            $data_produk_supplier = request('produk_supplier_id');
            $data_jumlah = request('jumlah');
            $data_keterangan = request('keterangan');
            $estimasi_harga = 0;
            if (!empty($data_produk_supplier)) {
                foreach ($data_produk_supplier as $key => $produk) {
                    $item = ProdukSupplier::findOrFail($produk);
                    $estimasi_harga = $estimasi_harga + ($item->harga * $data_jumlah[$key]);
                }
            }
            if (request()->file('gambar')) {
                if ($project->gambar) {
                    Storage::disk('public')->delete($project->gambar);
                }
                $gambar = request()->file('gambar')->store('project', 'public');
            } else {
                $gambar = $project->gambar;
            }
            $project->update([
                'nama' => request('nama'),
                'estimasi_harga' => $estimasi_harga,
                'status' => request('status'),
                'deskripsi' => request('deskripsi'),
                'harga' => request('harga_project'),
                'status' => request('status'),
                'gambar' => $gambar
            ]);

            // cek status
            if (request('status') == 2 && $item->status != 2) {
                // tambah pemasukan
                Pemasukan::create([
                    'nama' =>  "Project Baru : " . $item->nama,
                    'nominal' => request('harga_project'),
                    'keterangan' => NULL
                ]);
            }

            $project->details()->delete();
            if (!empty($data_produk_supplier)) {
                foreach ($data_produk_supplier as $key => $produk) {
                    $item = ProdukSupplier::findOrFail($produk);
                    $total_harga = $item->harga * $data_jumlah[$key];
                    $project->details()->create([
                        'produk_supplier_id' => $item->id,
                        'harga' => $item->harga,
                        'jumlah' => $data_jumlah[$key],
                        'total_harga' => $total_harga,
                        'keterangan' => $data_keterangan[$key]
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('project.index')->with('success', 'Project berhasil diupdate.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {

        DB::beginTransaction();
        try {
            $item = Project::findOrFail($id);
            $item->gambar ? Storage::disk('public')->delete($item->gambar) : NULL;
            $item->delete();
            DB::commit();
            return redirect()->route('project.index')->with('success', 'Project berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
