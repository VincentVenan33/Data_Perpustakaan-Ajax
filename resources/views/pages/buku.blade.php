{{-- <!doctype html>
<html lang="en"> --}}
    @extends('layouts.app', [
    'namePage' => 'Buku',
    'class' => 'login-page sidebar-mini ',
    'activePage' => 'buku',
    'backgroundImage' => asset('now') . "/img/bg14.jpg",
    ])
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DS || {{  $title }}</title>
    <style>
        body {
            background-color: lightgray !important;
        }

    </style>

</head>

    @section('content')
    <body>
        <div class="panel-header panel-header-sm">

        </div>
    <div class="container" >
        <div class="row">
            <div class="col-md-12">
                <h4 class="text-center">{{  $title }}</h4>
                <div class="card border-0 shadow-sm rounded-md mt-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <a href="javascript:void(0)" class="btn btn-success mb-2" id="btn-create-post">TAMBAH</a>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-3">
                                <label for="filterKategori" class="control-label">Filter Kategori Buku</label>
                                <select class="form-control" id="filterKategori"></select>
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kategori"></div>
                            </div>
                            <div class="col-md-1">
                                <button id="btnAllData" class="btn btn-success mt-4"><i class="now-ui-icons arrows-1_refresh-69"></i></button>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>ISBN</th>
                                    <th>Tahun</th>
                                    <th>Jumlah</th>
                                    <th>Gambar</th>
                                    <th>Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table-posts">
                                @foreach($buku as $bk)
                                <tr id="index_{{ $bk->id }}">
                                    <td>{{ $bk->nama }}</td>
                                    <td>{{ $bk->isbn }}</td>
                                    <td>{{ $bk->tahun }}</td>
                                    <td>{{ $bk->jumlah }}</td>
                                    <td>
                                        @if ($bk->gambar)
                                            <img src="{{ asset('storage/' . $bk->gambar) }}" alt="Image" style="max-width: 100px; max-height: 100px;">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    @if ($bk->kategoris)
                                        <td>{{ $bk->kategoris->nama }}</td>
                                    @else
                                    <td>Kategori Tidak Ada</td>
                                @endif
                                    <td class="text-center">
                                        <a href="javascript:void(0)" id="btn-edit-post" data-id="{{ $bk->id }}" class="btn btn-primary btn-sm">EDIT</a>
                                        <a href="javascript:void(0)" id="btn-delete-post" data-id="{{ $bk->id }}" class="btn btn-danger btn-sm">DELETE</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <nav aria-label="Table Paging" class="mb-0 text-muted" id="pagination-nav">
                            <ul class="pagination justify-content-center mb-0">
                                <li class="page-item{{ ($buku->currentPage() == 1) ? ' disabled' : '' }}">
                                    <a class="page-link" href="{{ $buku->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $buku->lastPage(); $i++)
                                    <li class="page-item{{ ($buku->currentPage() == $i) ? ' active' : '' }}">
                                        <a class="page-link" href="{{ $buku->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item{{ ($buku->currentPage() == $buku->lastPage()) ? ' disabled' : '' }}">
                                    <a class="page-link" href="{{ $buku->nextPageUrl() }}" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.buku.modal-create')
    @include('components.buku.modal-edit')
    @include('components.buku.delete-post')

    @endsection
    <script>
       $(document).ready(function() {
    // Load categories into the filter dropdown
    $.ajax({
        url: '/carikategori', // Menggunakan route yang telah didefinisikan
        type: 'GET',
        success: function(response) {
            let kategorisDropdown = $('#filterKategori');
            kategorisDropdown.empty(); // Clear existing options

            // Add default option
            kategorisDropdown.append('<option selected="true" disabled="disabled">Pilih Kategori Buku</option>');

            // Populate dropdown with data from response
            response.data.forEach(function(kategoris) {
                let option = `<option value="${kategoris.nama}">${kategoris.nama}</option>`;
                kategorisDropdown.append(option);
            });
        },
        error: function(error) {
            console.error('Error fetching kategori data', error);
        }
    });

    // Handler untuk filter kategori
    $('#filterKategori').change(function(e) {
        e.preventDefault();
        fetchFilteredData($(this).val());
        $('#pagination-nav').hide();
    });

    // Handler untuk tombol "All Data"
    $('#btnAllData').click(function(e) {
        e.preventDefault();
        // Set filterKategori ke nilai default
        $('#filterKategori').val('Pilih Kategori Buku');
        fetchAllData();
        $('#pagination-nav').show();
    });

    function fetchFilteredData(selectedKategori) {
        let token = $("meta[name='csrf-token']").attr("content");

        $.ajax({
            url: '{{ route("filterData") }}',
            type: 'GET',
            cache: false,
            data: {
                kategori: selectedKategori,
                _token: token
            },
            success: function(response) {
                console.log("AJAX Response:", response); // Debugging

                // Kosongkan baris tabel yang ada
                $('#table-posts').empty();

                // Perbarui baris tabel
                if (response.data.length > 0) {
                    $.each(response.data, function(index, item) {
                        var row = '<tr>' +
                            '<td>' + item.nama + '</td>' +
                            '<td>' + item.isbn + '</td>' +
                            '<td>' + item.tahun + '</td>' +
                            '<td>' + item.jumlah + '</td>' +
                            '<td><img src="' + '{{ asset('storage') }}' + '/' + item.gambar + '" alt="Image" style="max-width: 100px; max-height: 100px;"></td>' +
                            '<td>' + item.kategori + '</td>' +
                            '<td class="text-center">' +
                            '<a href="javascript:void(0)" id="btn-edit-post" data-id="' + item.id + '" class="btn btn-primary btn-sm">EDIT</a>' +
                            '<a href="javascript:void(0)" id="btn-delete-post" data-id="' + item.id + '" class="btn btn-danger btn-sm">DELETE</a>' +
                            '</td>' +
                            '</tr>';
                        $('#table-posts').append(row);
                    });
                } else {
                    // Tampilkan pesan jika tidak ada data
                    var row = '<tr><td colspan="7" class="text-center">Tidak ada data.</td></tr>';
                    $('#table-posts').append(row);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
            }
        });
    }

    function fetchAllData() {
        let token = $("meta[name='csrf-token']").attr("content");

        $.ajax({
            url: '{{ route("alldata") }}',
            type: 'GET',
            cache: false,
            data: {
                _token: token
            },
            success: function(response) {
                console.log("AJAX Response:", response); // Debugging

                // Kosongkan baris tabel yang ada
                $('#table-posts').empty();

                // Perbarui baris tabel
                if (response.data.data.length > 0) {
                    $.each(response.data.data, function(index, item) {
                        var row = '<tr>' +
                            '<td>' + item.nama + '</td>' +
                            '<td>' + item.isbn + '</td>' +
                            '<td>' + item.tahun + '</td>' +
                            '<td>' + item.jumlah + '</td>' +
                            '<td><img src="' + '{{ asset('storage') }}' + '/' + item.gambar + '" alt="Image" style="max-width: 100px; max-height: 100px;"></td>' +
                            '<td>' + item.kategori + '</td>' +
                            '<td class="text-center">' +
                            '<a href="javascript:void(0)" id="btn-edit-post" data-id="' + item.id + '" class="btn btn-primary btn-sm">EDIT</a>' +
                            '<a href="javascript:void(0)" id="btn-delete-post" data-id="' + item.id + '" class="btn btn-danger btn-sm">DELETE</a>' +
                            '</td>' +
                            '</tr>';
                        $('#table-posts').append(row);
                    });
                } else {
                    // Tampilkan pesan jika tidak ada data
                    var row = '<tr><td colspan="7" class="text-center">Tidak ada data.</td></tr>';
                    $('#table-posts').append(row);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
            }
        });
    }
});
    </script>
</body>
{{--
</html> --}}

