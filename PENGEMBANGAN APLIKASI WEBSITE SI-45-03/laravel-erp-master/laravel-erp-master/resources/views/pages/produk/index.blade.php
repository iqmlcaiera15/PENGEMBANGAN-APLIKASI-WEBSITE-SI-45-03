@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Produk</h4>
                        @can('Produk Create')
                            <a href="{{ route('produk.create') }}" class="btn my-2 mb-3 btn-sm py-2 btn-primary">Tambah
                                Produk</a>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Gambar</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Stok</th>
                                    <th>Harga</th>
                                    <th>Terjual</th>
                                    @canany(['Produk Edit', 'Produk Delete'])
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
                                        <td>{{ $item->kategori->nama }}</td>
                                        <td>{{ $item->stok }}</td>
                                        <td>Rp {{ number_format($item->harga) }}</td>
                                        <td>{{ $item->terjual }}</td>

                                        @canany(['Produk Edit', 'Produk Delete'])
                                            <td>
                                                @can('Produk Edit')
                                                    <a href="{{ route('produk.edit', $item->id) }}"
                                                        class="btn btn-sm py-2 btn-info">Edit</a>
                                                @endcan
                                                @can('Produk Delete')
                                                    <form action="javascript:void(0)" method="post" class="d-inline"
                                                        id="formDelete">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                            data-action="{{ route('produk.destroy', $item->id) }}">Hapus</button>
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
