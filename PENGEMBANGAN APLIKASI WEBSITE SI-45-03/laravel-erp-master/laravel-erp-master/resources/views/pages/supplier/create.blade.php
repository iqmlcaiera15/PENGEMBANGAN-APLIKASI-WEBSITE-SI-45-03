@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Tambah Supplier</h4>
                    <form action="{{ route('supplier.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class='form-group mb-3'>
                            <label for='nama' class='mb-2'>Nama</label>
                            <input type='text' name='nama' class='form-control @error('nama') is-invalid @enderror'
                                value='{{ old('nama') }}'>
                            @error('nama')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='email' class='mb-2'>Email</label>
                            <input type='text' name='email' class='form-control @error('email') is-invalid @enderror'
                                value='{{ old('email') }}'>
                            @error('email')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='nomor_telepon' class='mb-2'>Nomor Telepon</label>
                            <input type='text' name='nomor_telepon'
                                class='form-control @error('nomor_telepon') is-invalid @enderror'
                                value='{{ old('nomor_telepon') }}'>
                            @error('nomor_telepon')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='alamat' class='mb-2'>Alamat</label>
                            <textarea name='alamat' id='alamat' cols='30' rows='3'
                                class='form-control @error('alamat') is-invalid @enderror'>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('supplier.index') }}" class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Tambah Supplier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
