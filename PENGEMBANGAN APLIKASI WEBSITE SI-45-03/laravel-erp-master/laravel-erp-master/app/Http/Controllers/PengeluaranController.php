<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengeluaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Pengeluaran Index')->only('index');
        $this->middleware('can:Pengeluaran Create')->only(['create', 'store']);
        $this->middleware('can:Pengeluaran Edit')->only(['edit', 'update']);
        $this->middleware('can:Pengeluaran Delete')->only('destroy');
    }

    public function index()
    {
        $items = Pengeluaran::latest()->get();
        return view('pages.pengeluaran.index', [
            'title' => 'Pengeluaran',
            'items' => $items
        ]);
    }

    public function create()
    {
        return view('pages.pengeluaran.create', [
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
            Pengeluaran::create($data);

            DB::commit();
            return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $item = Pengeluaran::findOrFail($id);
        return view('pages.pengeluaran.edit', [
            'title' => 'Edit Pengeluaran',
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
            $item = Pengeluaran::findOrFail($id);
            $data = request()->all();
            $item->update($data);

            DB::commit();
            return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil diupdate.');
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
            $item = Pengeluaran::findOrFail($id);
            $item->delete();
            DB::commit();
            return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
