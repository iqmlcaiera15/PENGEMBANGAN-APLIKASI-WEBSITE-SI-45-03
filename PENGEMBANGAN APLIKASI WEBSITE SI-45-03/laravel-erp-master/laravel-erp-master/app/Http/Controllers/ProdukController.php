<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Produk Index')->only('index');
        $this->middleware('can:Produk Create')->only(['create', 'store']);
        $this->middleware('can:Produk Edit')->only(['edit', 'update']);
        $this->middleware('can:Produk Delete')->only('destroy');
    }

    public function index()
    {
        $items = Produk::orderBy('nama', 'ASC')->get();
        return view('pages.produk.index', [
            'title' => 'Produk',
            'items' => $items
        ]);
    }

    public function create()
    {
        $data_kategori = Kategori::orderBy('nama', 'ASC')->get();
        return view('pages.produk.create', [
            'title' => 'Tambah Produk',
            'data_kategori' => $data_kategori
        ]);
    }

    public function store()
    {
        request()->validate([
            'nama' => ['required', 'min:3'],
            'kategori_id' => ['required'],
            'harga' => ['required'],
            'stok' => ['required'],
            'deskripsi' => ['required'],
            'gambar' => ['required', 'image', 'mimes:jpg,jpeg,png,svg', 'max:2048']
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['nama', 'kategori_id', 'harga', 'stok', 'deskripsi']);
            request()->file('gambar') ? $data['gambar'] = request()->file('gambar')->store('produk', 'public') : NULL;
            Produk::create($data);
            DB::commit();
            return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $item = Produk::findOrFail($id);
        $data_kategori = Kategori::orderBy('nama', 'ASC')->get();
        return view('pages.produk.edit', [
            'title' => 'Edit Produk',
            'item' => $item,
            'data_kategori' => $data_kategori
        ]);
    }

    public function update($id)
    {
        $item = Produk::findOrFail($id);
        request()->validate([
            'nama' => ['required', 'min:3'],
            'kategori_id' => ['required'],
            'harga' => ['required'],
            'stok' => ['required'],
            'deskripsi' => ['required'],
            'gambar' => ['image', 'mimes:jpg,jpeg,png,svg', 'max:2048']
        ]);


        DB::beginTransaction();
        try {
            $data = request()->only(['nama', 'kategori_id', 'harga', 'stok', 'deskripsi']);
            if (request()->file('gambar')) {
                $item->gambar ? Storage::disk('public')->delete($item->gambar) : NULL;
                $data['gambar'] = request()->file('gambar')->store('produk', 'public');
            } else {
                $data['gambar'] = $item->gambar;
            }
            $item->update($data);
            DB::commit();
            return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        $item = Produk::findOrFail($id);

        DB::beginTransaction();
        try {
            $item->gambar ? Storage::disk('public')->delete($item->gambar) : NULL;
            $item->delete();
            DB::commit();
            return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function getByIdJson()
    {
        $item = Produk::findOrFail(request('id'));
        return response()->json($item);
    }
}
