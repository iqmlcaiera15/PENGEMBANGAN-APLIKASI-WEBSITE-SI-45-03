@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Produk Supplier</h4>
                        @can('Produk Supplier Create')
                            <a href="{{ route('produk-supplier.create') }}" class="btn my-2 mb-3 btn-sm py-2 btn-primary">Tambah
                                Produk Supplier</a>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Gambar</th>
                                    <th>Nama</th>
                                    <th>Supplier</th>
                                    <th>Deskripsi</th>
                                    <th>Harga</th>
                                    @canany(['Produk Supplier Edit', 'Produk Supplier Delete'])
                                        <th>Aksi</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ $item->gambar() }}" class="img-fluid" alt="">
                                        </td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->supplier->nama }}</td>
                                        <td>{{ $item->deskripsi }}</td>
                                        <td>Rp {{ number_format($item->harga) }}</td>

                                        @canany(['Produk Supplier Edit', 'Produk Supplier Delete'])
                                            <td>
                                                @can('Produk Supplier Edit')
                                                    <a href="{{ route('produk-supplier.edit', $item->id) }}"
                                                        class="btn btn-sm py-2 btn-info">Edit</a>
                                                @endcan
                                                @can('Produk Supplier Delete')
                                                    <form action="javascript:void(0)" method="post" class="d-inline"
                                                        id="formDelete">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                            data-action="{{ route('produk-supplier.destroy', $item->id) }}">Hapus</button>
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
