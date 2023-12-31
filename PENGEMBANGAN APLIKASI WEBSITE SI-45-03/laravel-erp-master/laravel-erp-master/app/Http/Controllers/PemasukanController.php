<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemasukanController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Pemasukan Index')->only('index');
        $this->middleware('can:Pemasukan Create')->only(['create', 'store']);
        $this->middleware('can:Pemasukan Edit')->only(['edit', 'update']);
        $this->middleware('can:Pemasukan Delete')->only('destroy');
    }

    public function index()
    {
        $items = Pemasukan::latest()->get();
        return view('pages.pemasukan.index', [
            'title' => 'Pemasukan',
            'items' => $items
        ]);
    }

    public function create()
    {
        return view('pages.pemasukan.create', [
            'title' => 'Tambah item'
        ]);
    }

    public function store()
    {

        request()->validate([
            'nama' => ['required'],
            'nominal' => ['required', 'numeric']
        ]);

        DB::beginTransaction();
        try {
            $data = request()->all();
            Pemasukan::create($data);

            DB::commit();
            return redirect()->route('pemasukan.index')->with('success', 'Pemasukan berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $item = Pemasukan::findOrFail($id);
        return view('pages.pemasukan.edit', [
            'title' => 'Edit Pemasukan',
            'item' => $item
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'nama' => ['required'],
            'nominal' => ['required', 'numeric']
        ]);

        DB::beginTransaction();
        try {
            $item = Pemasukan::findOrFail($id);
            $data = request()->all();
            $item->update($data);

            DB::commit();
            return redirect()->route('pemasukan.index')->with('success', 'Pemasukan berhasil diupdate.');
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
            $item = Pemasukan::findOrFail($id);
            $item->delete();
            DB::commit();
            return redirect()->route('pemasukan.index')->with('success', 'Pemasukan berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
