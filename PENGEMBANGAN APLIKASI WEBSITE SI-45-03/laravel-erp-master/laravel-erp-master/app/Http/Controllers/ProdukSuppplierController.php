<?php

namespace App\Http\Controllers;

use App\Models\ProdukSupplier;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProdukSuppplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Produk Supplier Index')->only('index');
        $this->middleware('can:Produk Supplier Create')->only(['create', 'store']);
        $this->middleware('can:Produk Supplier Edit')->only(['edit', 'update']);
        $this->middleware('can:Produk Supplier Delete')->only('destroy');
    }

    public function index()
    {
        $items = ProdukSupplier::orderBy('nama', 'ASC')->get();
        return view('pages.produk-supplier.index', [
            'title' => 'Produk',
            'items' => $items
        ]);
    }

    public function create()
    {
        $data_supplier = Supplier::orderBy('nama', 'ASC')->get();
        return view('pages.produk-supplier.create', [
            'title' => 'Tambah Produk',
            'data_supplier' => $data_supplier
        ]);
    }

    public function store()
    {
        request()->validate([
            'nama' => ['required', 'min:3'],
            'supplier_id' => ['required'],
            'harga' => ['required'],
            'deskripsi' => ['required'],
            'gambar' => ['required', 'image', 'mimes:jpg,jpeg,png,svg', 'max:2048']
        ]);

        DB::beginTransaction();
        try {
            $data = request()->all();
            request()->file('gambar') ? $data['gambar'] = request()->file('gambar')->store('produk-supplier', 'public') : NULL;
            ProdukSupplier::create($data);
            DB::commit();
            return redirect()->route('produk-supplier.index')->with('success', 'Produk Supplier berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $item = ProdukSupplier::findOrFail($id);
        $data_supplier = Supplier::orderBy('nama', 'ASC')->get();
        return view('pages.produk-supplier.edit', [
            'title' => 'Edit Produk',
            'item' => $item,
            'data_supplier' => $data_supplier
        ]);
    }

    public function update($id)
    {
        $item = ProdukSupplier::findOrFail($id);
        request()->validate([
            'nama' => ['required', 'min:3'],
            'supplier_id' => ['required'],
            'harga' => ['required'],
            'deskripsi' => ['required'],
            'gambar' => ['image', 'mimes:jpg,jpeg,png,svg', 'max:2048']
        ]);


        DB::beginTransaction();
        try {
            $data = request()->only(['nama', 'supplier_id', 'harga', 'stok', 'deskripsi']);
            if (request()->file('gambar')) {
                $item->gambar ? Storage::disk('public')->delete($item->gambar) : NULL;
                $data['gambar'] = request()->file('gambar')->store('produk-supplier', 'public');
            } else {
                $data['gambar'] = $item->gambar;
            }
            $item->update($data);
            DB::commit();
            return redirect()->route('produk-supplier.index')->with('success', 'Produk Supplier berhasil diupdate.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        $item = ProdukSupplier::findOrFail($id);

        DB::beginTransaction();
        try {
            $item->gambar ? Storage::disk('public')->delete($item->gambar) : NULL;
            $item->delete();
            DB::commit();
            return redirect()->route('produk-supplier.index')->with('success', 'Produk Supplier berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function getByIdJson()
    {
        $item = ProdukSupplier::findOrFail(request('id'));
        return response()->json($item);
    }
}
