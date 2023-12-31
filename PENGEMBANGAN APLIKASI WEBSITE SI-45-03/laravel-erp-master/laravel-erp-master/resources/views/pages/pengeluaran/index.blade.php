@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Pengeluaran</h4>
                        @can('Pengeluaran Create')
                            <a href="{{ route('pengeluaran.create') }}" class="btn my-2 mb-3 btn-sm py-2 btn-primary">Tambah
                                Pengeluaran</a>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Keterangan</th>
                                    <th>Nominal</th>
                                    @canany(['Pengeluaran Edit', 'Pengeluaran Delete'])
                                        <th>Aksi</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->created_at->translatedFormat('d/m/Y') }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td>{{ format_rupiah($item->nominal) }}</td>
                                        @canany(['Pengeluaran Edit', 'Pengeluaran Delete'])
                                            <td>
                                                @can('Pengeluaran Edit')
                                                    <a href="{{ route('pengeluaran.edit', $item->id) }}"
                                                        class="btn btn-sm py-2 btn-info">Edit</a>
                                                @endcan
                                                @can('Pengeluaran Delete')
                                                    <form action="javascript:void(0)" method="post" class="d-inline"
                                                        id="formDelete">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                            data-action="{{ route('pengeluaran.destroy', $item->id) }}">Hapus</button>
                                                    </form>
                                                @endcan
                                            </td>
                                        @endcanany
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">Total</th>
                                    <th colspan="2">{{ format_rupiah($items->sum('nominal')) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
<x-Admin.Datatable />
