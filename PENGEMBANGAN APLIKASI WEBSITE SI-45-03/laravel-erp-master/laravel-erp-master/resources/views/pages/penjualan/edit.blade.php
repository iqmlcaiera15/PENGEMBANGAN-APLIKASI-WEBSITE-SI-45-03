@extends('layouts.app')
@section('content')
    <form action="{{ route('penjualan.update', $item->id) }}" method="post">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-5">Edit Penjualan</h4>
                        @csrf
                        @method('patch')
                        <div class='form-group mb-3'>
                            <label for='kode' class='mb-2'>Kode</label>
                            <input type='text' name='kode' class='form-control @error('kode') is-invalid @enderror'
                                value='{{ $item->kode ?? old('kode') }}' disabled>
                            @error('kode')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='pembeli' class='mb-2'>Pembeli</label>
                            <input type='text' name='pembeli' class='form-control @error('pembeli') is-invalid @enderror'
                                value="{{ $item->pembeli }}">
                            @error('pembeli')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='status'>Status</label>
                            <select name='status' id='status'
                                class='form-control @error('status') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih status</option>
                                <option @selected($item->status == 1) value="1">Diproses</option>
                                <option @selected($item->status == 2) value="2">Sukses</option>
                                <option @selected($item->status == 3) value="3">Gagal</option>
                            </select>
                            @error('status')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('penjualan.index') }}" class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Update Penjualan</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md">
                <div class="card">
                    <div class="card-body" id="row">
                        <h4 class="card-title mb-5">Pilih Produk</h4>
                        @foreach ($item->details as $detail)
                            <div class="row">
                                <div class="col-md-4">
                                    <div class='form-group'>
                                        <label for='produk_id'>Produk</label>
                                        <select name='produk_id[]' id='produk_id'
                                            class='form-control produk_id select2 @error('produk_id') is-invalid @enderror'>
                                            <option value='' selected disabled>Pilih Produk</option>
                                            @foreach ($data_produk as $produk)
                                                <option @selected($produk->id == $detail->produk_id) value='{{ $produk->id }}'>
                                                    {{ $produk->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('produk_id')
                                            <div class='invalid-feedback'>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class='form-group mb-3'>
                                        <label for='jumlah' class='mb-2'>Jumlah</label>
                                        <input type='text' name='jumlah[]'
                                            class='form-control jumlah @error('jumlah') is-invalid @enderror'
                                            value="{{ $detail->jumlah }}">
                                        @error('jumlah')
                                            <div class='invalid-feedback'>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class='form-group mb-3'>
                                        <label for='harga' class='mb-2'>Harga</label>
                                        <input type='text' name='harga[]'
                                            class='form-control harga @error('harga') is-invalid @enderror'
                                            value="{{ format_rupiah($detail->harga) }}" readonly>
                                        @error('harga')
                                            <div class='invalid-feedback'>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class='form-group mb-3'>
                                        <label for='total_harga' class='mb-2'>Total Harga</label>
                                        <input type='text' name='total_harga[]'
                                            class='form-control total_harga @error('total_harga') is-invalid @enderror'
                                            readonly value="{{ format_rupiah($detail->total_harga) }}">
                                        @error('total_harga')
                                            <div class='invalid-feedback'>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="newInput"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
<x-Admin.Sweetalert />
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
    <style>
        /* Custom CSS for Select2 */
        .select2-container--bootstrap .select2-selection {
            height: 38px !important;
            /* Sesuaikan tinggi sesuai kebutuhan Anda */
        }

        /* Style untuk menyesuaikan dropdown */
        .select2-container--bootstrap .select2-dropdown {
            margin-top: -1px;
            border-radius: 0;
            border: 1px solid #ced4da;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Style untuk menyesuaikan list item di dropdown */
        .select2-container--bootstrap .select2-results__option {
            padding: 8px 12px !important;
        }

        /* Style untuk menyesuaikan highlight saat item dipilih */
        .select2-container--bootstrap .select2-results__option--highlighted {
            background-color: #007bff;
            color: #fff;
        }

        /* Style untuk menyesuaikan hover item di dropdown */
        .select2-container--bootstrap .select2-results__option--selectable:hover {
            background-color: #f0f0f0;
        }
    </style>
@endpush
@push('scripts')
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
    <script>
        $(function() {
            function formatRupiah(angka) {
                var number_string = angka.toString().replace(/[^,\d]/g, ''),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
                return 'Rp ' + rupiah;
            }

            function unformatRupiah(rupiah) {
                // Menghapus karakter non-digit dari string
                var number_string = rupiah.replace(/[^\d]/g, '');

                // Mengembalikan nilai angka sebagai tipe data integer
                return parseInt(number_string, 10);
            }


            $('.select2').select2({
                theme: 'bootstrap'
            })

            $(".rowAdd").click(function() {

                let newRow = `
                <div class="row">
                            <div class="col-md-4">
                                <div class='form-group'>
                                    <label for='produk_id'>Produk</label>
                                    <select name='produk_id[]' id='produk_id'
                                        class='form-control produk_id select2 @error('produk_id') is-invalid @enderror'>
                                        <option value='' selected disabled>Pilih Produk</option>
                                        @foreach ($data_produk as $produk)
                                            <option @selected($produk->id == old('produk_id')) value='{{ $produk->id }}'>
                                                {{ $produk->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('produk_id')
                                        <div class='invalid-feedback'>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class='form-group mb-3'>
                                    <label for='jumlah' class='mb-2'>Jumlah</label>
                                    <input type='text' name='jumlah[]'
                                        class='form-control jumlah @error('jumlah') is-invalid @enderror'
                                       >
                                    @error('jumlah')
                                        <div class='invalid-feedback'>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class='form-group mb-3'>
                                    <label for='harga' class='mb-2'>Harga</label>
                                    <input type='text' name='harga[]'
                                        class='form-control harga @error('harga') is-invalid @enderror' value='' readonly>
                                    @error('harga')
                                        <div class='invalid-feedback'>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class='form-group mb-3'>
                                    <label for='total_harga' class='mb-2'>Total Harga</label>
                                    <input type='text' name='total_harga[]'
                                        class='form-control total_harga @error('total_harga') is-invalid @enderror' readonly>
                                    @error('total_harga')
                                        <div class='invalid-feedback'>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-1 align-self-end">
                                <div class="form-group">
                                    <button type="button" class="btn rowDelete btn-danger"><i
                                            class="fas fa-plus"></i>Hapus</button>
                                </div>
                            </div>
                        </div>
            `;
                $('.newInput').append(newRow);
            });

            $("body").on("click", ".rowDelete", function() {
                $(this).closest(".row").remove();
            })

            $('body').on('change', '.produk_id', function() {
                // let produk_id = $(this).val();
                var currentElement = $(this);

                let produk_id = currentElement.val();
                // get produk
                $.ajax({
                    url: '{{ route('produk.getByIdJson') }}',
                    type: 'GET',
                    data: {
                        id: produk_id
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        currentElement.closest('.row').find('.jumlah').val(0);
                        currentElement.closest('.row').find('.total_harga').val(0);
                        currentElement.closest('.row').find('.harga').val(formatRupiah(data
                            .harga));
                        var jumlahInput = currentElement.closest('.row').find('.jumlah');
                        var totalHargaInput = currentElement.closest('.row').find(
                            '.total_harga');

                        if (jumlahInput.val() === '' || isNaN(jumlahInput.val())) {
                            totalHargaInput.val('');
                        }
                    }
                })
            })

            $('body').on('input', '.jumlah', function() {
                var currentElement = $(this);

                // Update total harga saat nilai input jumlah berubah
                var hargaInput = currentElement.closest('.row').find('.harga');
                var totalHargaInput = currentElement.closest('.row').find('.total_harga');

                if (unformatRupiah(hargaInput.val()) !== '' && !isNaN(unformatRupiah(hargaInput.val())) && !
                    isNaN(currentElement.val())) {
                    var harga = parseFloat(unformatRupiah(hargaInput.val()));
                    var jumlah = parseFloat(currentElement.val());
                    var totalHarga = harga * jumlah;
                    totalHargaInput.val(formatRupiah(totalHarga));
                } else {
                    totalHargaInput.val('');
                }
            });

        })
    </script>
@endpush
