{{-- <!doctype html>
<html lang="en"> --}}
    @extends('layouts.app', [
    'namePage' => 'Kategori Buku',
    'class' => 'login-page sidebar-mini ',
    'activePage' => 'kategoribuku',
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

                        <a href="javascript:void(0)" class="btn btn-success mb-2" id="btn-create-post">TAMBAH</a>

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table-posts">
                                @foreach($kategori as $ktgr)
                                <tr id="index_{{ $ktgr->id }}">
                                    <td>{{ $ktgr->nama }}</td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" id="btn-edit-post" data-id="{{ $ktgr->id }}" class="btn btn-primary btn-sm">EDIT</a>
                                        <a href="javascript:void(0)" id="btn-delete-post" data-id="{{ $ktgr->id }}" class="btn btn-danger btn-sm">DELETE</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <nav aria-label="Table Paging" class="mb-0 text-muted">
                            <ul class="pagination justify-content-center mb-0">
                                <li class="page-item{{ ($kategori->currentPage() == 1) ? ' disabled' : '' }}">
                                    <a class="page-link" href="{{ $kategori->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $kategori->lastPage(); $i++)
                                    <li class="page-item{{ ($kategori->currentPage() == $i) ? ' active' : '' }}">
                                        <a class="page-link" href="{{ $kategori->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item{{ ($kategori->currentPage() == $kategori->lastPage()) ? ' disabled' : '' }}">
                                    <a class="page-link" href="{{ $kategori->nextPageUrl() }}" aria-label="Next">
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
    @include('components.kategori.modal-create')
    @include('components.kategori.modal-edit')
    @include('components.kategori.delete-post')

    @endsection
</body>
{{--
</html> --}}

