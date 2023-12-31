<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Pemasukan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Penjualan Index')->only('index');
        $this->middleware('can:Penjualan Create')->only(['create', 'store']);
        $this->middleware('can:Penjualan Edit')->only(['edit', 'update']);
        $this->middleware('can:Penjualan Delete')->only('destroy');
    }

    public function index()
    {
        $items = Penjualan::with(['details'])->latest()->get();
        return view('pages.penjualan.index', [
            'title' => 'Penjualan',
            'items' => $items
        ]);
    }

    public function create()
    {
        $kode_baru = Penjualan::getKodeBaru();
        $data_produk = Produk::orderBy('nama', 'ASC')->get();
        return view('pages.penjualan.create', [
            'title' => 'Tambah Penjualan',
            'kode_baru' => $kode_baru,
            'data_produk' => $data_produk
        ]);
    }

    public function store()
    {

        request()->validate([
            'pembeli' => ['required'],
            'status' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $data_produk = request('produk_id');
            $data_jumlah = request('jumlah');
            $kode_baru = Penjualan::getKodeBaru();
            $total = 0;
            foreach ($data_produk as $key => $produk) {
                $item = Produk::findOrFail($produk);
                $total = $total + ($item->harga * $data_jumlah[$key]);
            }
            $penjualan = Penjualan::create([
                'kode' => $kode_baru,
                'pembeli' => request('pembeli'),
                'total' => $total,
                'status' => request('status')
            ]);

           // cek status
            if (request('status') == 2) {
                // tambah pemasukan
                Pemasukan::create([
                    'nama' =>  "Penjualan Produk : #" . $penjualan->kode,
                    'nominal' => $total,
                    'keterangan' => NULL
                ]);
            }

            foreach ($data_produk as $key => $produk) {
                $item = Produk::findOrFail($produk);
                $total_harga = $item->harga * $data_jumlah[$key];
                $penjualan->details()->create([
                    'produk_id' => $item->id,
                    'harga' => $item->harga,
                    'jumlah' => $data_jumlah[$key],
                    'total_harga' => $total_harga
                ]);

                // kurangi quantity produk
                $item->decrement('stok',$data_jumlah[$key]);
            }

            DB::commit();
            return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $item = Penjualan::with(['details'])->findOrFail($id);
        $data_produk = Produk::orderBy('nama', 'ASC')->get();
        return view('pages.penjualan.edit', [
            'title' => 'Edit Penjualan',
            'item' => $item,
            'data_produk' => $data_produk
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'pembeli' => ['required'],
            'status' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $item = Penjualan::findOrFail($id);
            $data = request()->only(['pembeli', 'status']);


            $total_harga = 0;
            foreach ($item->details as $key => $detail) {
                $produk = Produk::findOrFail($detail->produk_id);
                $total_harga = $produk->harga * $detail->jumlah;

                // kurangi quantity produk
                $produk->decrement('stok',$detail->jumlah);
            }
            // dd($item->status);
        //    dd(request()->all());
              // cek status
            if (request('status') == 2 && $item->status != 2) {
                // tambah pemasukan
                Pemasukan::create([
                    'nama' =>  "Penjualan Baru : #" . $item->kode,
                    'nominal' => $total_harga,
                    'keterangan' => NULL
                ]);
            }
   $item->update($data);

            DB::commit();
            return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil diupdate.');
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
            $item = Penjualan::findOrFail($id);
            $item->delete();
            DB::commit();
            return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
