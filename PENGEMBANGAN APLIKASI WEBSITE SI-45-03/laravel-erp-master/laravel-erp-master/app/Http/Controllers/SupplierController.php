<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Supplier Index')->only('index');
        $this->middleware('can:Supplier Create')->only(['create', 'store']);
        $this->middleware('can:Supplier Edit')->only(['edit', 'update']);
        $this->middleware('can:Supplier Delete')->only('destroy');
    }

    public function index()
    {
        $items = Supplier::orderBy('nama', 'ASC')->get();
        return view('pages.supplier.index', [
            'title' => 'Supplier',
            'items' => $items
        ]);
    }

    public function create()
    {
        return view('pages.supplier.create', [
            'title' => 'Tambah item'
        ]);
    }

    public function store()
    {

        request()->validate([
            'nama' => ['required'],
            'email' => ['required', 'email', 'unique:supplier,email'],
            'nomor_telepon' => ['required'],
            'alamat' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $data = request()->all();
            Supplier::create($data);

            DB::commit();
            return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $item = Supplier::findOrFail($id);
        return view('pages.supplier.edit', [
            'title' => 'Edit Supplier',
            'item' => $item
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'nama' => ['required'],
            'email' => ['required', 'email', Rule::unique('supplier', 'email')->ignore($id)],
            'nomor_telepon' => ['required'],
            'alamat' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $item = Supplier::findOrFail($id);
            $data = request()->all();
            $item->update($data);

            DB::commit();
            return redirect()->route('supplier.index')->with('success', 'Supplier berhasil diupdate.');
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
            $item = Supplier::findOrFail($id);
            $item->delete();
            DB::commit();
            return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
