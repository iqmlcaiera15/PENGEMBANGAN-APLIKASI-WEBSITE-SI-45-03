@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Penjualan</h4>
                        @can('Penjualan Create')
                            <a href="{{ route('penjualan.create') }}" class="btn my-2 mb-3 btn-sm py-2 btn-primary">Tambah
                                Penjualan</a>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>Kode</th>
                                    <th>Pembeli</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    @canany(['Penjualan Edit', 'Penjualan Delete'])
                                        <th>Aksi</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->created_at->translatedFormat('d/m/Y') }}</td>
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->pembeli }}</td>
                                        <td>{{ format_rupiah($item->total) }}</td>
                                        <td>{!! $item->status() !!}</td>
                                        @canany(['Penjualan Edit', 'Penjualan Delete'])
                                            <td>
                                                @can('Penjualan Edit')
                                                    <a href="{{ route('penjualan.edit', $item->id) }}"
                                                        class="btn btn-sm py-2 btn-info">Edit</a>
                                                @endcan
                                                @can('Penjualan Delete')
                                                    <form action="javascript:void(0)" method="post" class="d-inline"
                                                        id="formDelete">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                            data-action="{{ route('penjualan.destroy', $item->id) }}">Hapus</button>
                                                    </form>
                                                @endcan
                                            </td>
                                        @endcanany
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
<x-Admin.Datatable />
