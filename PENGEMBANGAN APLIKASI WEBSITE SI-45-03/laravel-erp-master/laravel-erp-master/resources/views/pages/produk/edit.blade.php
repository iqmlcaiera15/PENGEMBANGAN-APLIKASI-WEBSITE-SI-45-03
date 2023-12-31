@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Edit Produk</h4>
                    <form action="{{ route('produk.update', $item->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class='form-group mb-3'>
                            <label for='gambar' class='mb-2'>Gambar</label>
                            <input type='file' name='gambar' class='form-control @error('gambar') is-invalid @enderror'>
                            @error('gambar')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='nama' class='mb-2'>Nama</label>
                            <input type='text' name='nama' class='form-control @error('nama') is-invalid @enderror'
                                value='{{ $item->nama ?? old('nama') }}'>
                            @error('nama')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='kategori_id'>Kategori</label>
                            <select name='kategori_id' id='kategori_id'
                                class='form-control @error('kategori_id') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih Kategori</option>
                                @foreach ($data_kategori as $kategori)
                                    <option @selected($kategori->id == $item->kategori_id) value='{{ $kategori->id }}'>{{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='harga' class='mb-2'>Harga</label>
                            <input type='number' name='harga' class='form-control @error('harga') is-invalid @enderror'
                                value='{{ $item->harga ?? old('harga') }}'>
                            @error('harga')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='stok' class='mb-2'>Stok</label>
                            <input type='number' name='stok' class='form-control @error('stok') is-invalid @enderror'
                                value='{{ $item->stok ?? old('stok') }}'>
                            @error('stok')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='deskripsi' class='mb-2'>Deskripsi</label>
                            <textarea name='deskripsi' id='deskripsi' cols='30' rows='3'
                                class='form-control @error('deskripsi') is-invalid @enderror'>{{ $item->deskripsi ?? old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('produk.index') }}" class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Update Produk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
    <script>
        $(function() {
            $('#roles').select2({
                theme: 'bootstrap',
                placeholder: 'Anda bisa memilih lebih dari 1 role'
            })
        })
    </script>
@endpush
