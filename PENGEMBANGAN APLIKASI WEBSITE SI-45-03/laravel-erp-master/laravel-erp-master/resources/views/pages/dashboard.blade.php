@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Selamat Datang {{ auth()->user()->name }},</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin transparent">
            <div class="row">
                <div class="col-md-3 mb-4 stretch-card transparent">
                    <div class="card card-tale">
                        <div class="card-body">
                            <p class="mb-4">Total Pemasukan</p>
                            <p class="fs-30 mb-2">{{ format_rupiah($count['pemasukan']) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <p class="mb-4">Total Pengeluaran</p>
                            <p class="fs-30 mb-2">{{ format_rupiah($count['pengeluaran']) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4 stretch-card transparent">
                    <div class="card card-light-blue">
                        <div class="card-body">
                            <p class="mb-4">Total Produk</p>
                            <p class="fs-30 mb-2">{{ $count['produk'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4 stretch-card transparent">
                    <div class="card card-light-blue">
                        <div class="card-body">
                            <p class="mb-4">Total Supplier</p>
                            <p class="fs-30 mb-2">{{ $count['supplier'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
