@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Project</h4>
                        @can('Project Create')
                            <a href="{{ route('project.create') }}" class="btn my-2 mb-3 btn-sm py-2 btn-primary">Tambah
                                Project</a>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Gambar</th>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Estimasi Harga</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    @canany(['Project Edit', 'Project Delete'])
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
                                        <td>{{ $item->created_at->translatedFormat('d/m/Y') }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ format_rupiah($item->estimasi_harga) }}</td>
                                        <td>{{ format_rupiah($item->harga) }}</td>
                                        <td>{!! $item->status() !!}</td>
                                        @canany(['Project Edit', 'Project Delete'])
                                            <td>
                                                @can('Project Edit')
                                                    @if ($item->status == 2)
                                                        <a href="javascript:void(0)"
                                                            class="btn disabled btn-sm py-2 btn-info">Edit</a>
                                                    @else
                                                        <a href="{{ route('project.edit', $item->id) }}"
                                                            class="btn btn-sm py-2 btn-info">Edit</a>
                                                    @endif
                                                @endcan
                                                @can('Project Delete')
                                                    @if ($item->status == 2)
                                                        <form action="javascript:void(0)" method="post" class="d-inline">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn btn-sm py-2 btn-danger disabled">Hapus</button>
                                                        </form>
                                                    @else
                                                        <form action="javascript:void(0)" method="post" class="d-inline"
                                                            id="formDelete">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                                data-action="{{ route('project.destroy', $item->id) }}">Hapus</button>
                                                        </form>
                                                    @endif
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
