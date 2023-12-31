<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Kategori Index')->only('index');
        $this->middleware('can:Kategori Create')->only(['create', 'store']);
        $this->middleware('can:Kategori Edit')->only(['edit', 'update']);
        $this->middleware('can:Kategori Delete')->only('destroy');
    }

    public function index()
    {
        $items = Kategori::orderBy('nama', 'ASC')->get();
        return view('pages.kategori.index', [
            'title' => 'Kategori',
            'items' => $items
        ]);
    }

    public function create()
    {
        return view('pages.kategori.create', [
            'title' => 'Tambah item'
        ]);
    }

    public function store()
    {

        request()->validate([
            'nama' => ['required', 'unique:kategori,nama'],
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['nama']);
            Kategori::create($data);

            DB::commit();
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $item = Kategori::findOrFail($id);
        return view('pages.kategori.edit', [
            'title' => 'Edit Kategori',
            'item' => $item
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'nama' => ['required', 'unique:kategori,nama,' . $id . ''],
        ]);

        DB::beginTransaction();
        try {
            $item = Kategori::findOrFail($id);
            $data = request()->only(['nama']);
            $item->update($data);

            DB::commit();
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diupdate.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {

        DB::beginTransaction();
        try {
            $item = Kategori::findOrFail($id);
            $item->delete();
            DB::commit();
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
