@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Table</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <a href="{{route('category.create')}}"><i style="float: right"
                        class="link-icon" data-feather="plus-circle"></i></a>
                    {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i style="float: right"
                        class="link-icon" data-feather="plus-circle"></i></a> --}}
                    <h6 class="card-title">Data Table</h6>
                    <p class="text-muted mb-3">Read the <a href="https://datatables.net/" target="_blank"> Official
                            DataTables Documentation </a>for a full list of instructions and other options.</p>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Publish</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($category as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->is_publish}}</td>
                                    <td>
                                        <a href="{{route('category.show',$item->id)}}" type="button" class="btn btn-inverse-primary">Detail</a>
                                        <a href="{{route('category.edit',$item->id)}}" type="button" class="btn btn-inverse-warning">Edit</a>
                                        <button type="button" class="btn btn-inverse-danger delete-btn" data-id="{{$item->id}}">Hapus</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal input --}}
    <div class="modal fade" id="exampleModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Input Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                      <form class="forms-sample" action="{{route('category.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputUsername1" class="form-label">Nama Kategori</label>
                            <input type="text" name="name" class="form-control" id="exampleInputUsername1" autocomplete="off"
                                placeholder="Nama Kategori">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1">Publish</label>
                            <select name="publish" id="publish" class="form-control">
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- modal shoe --}}
     <!-- CSRF Token -->
  <meta name="_token" content="{{ csrf_token() }}">

@endsection

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
    <script>
        var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
        $(document).ready(function () {
            $(".forms-sample").submit(function (e) {
                e.preventDefault();
                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log(response);
                        // notif('success','Data berhasil ditambahkan');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Data berhasil ditambahkan',
                        });
                        $("#exampleModal").modal('hide');
                    },
                    error: function (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Ada kesalahan sistem!'+ error,
                        });
                    }
                });
            });

            $('.delete-btn').on('click', function () {
                var categoryId = $(this).data('id');
                Swal.fire({
                    title: 'Anda yakin?',
                    text: "Anda tidak akan dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus saja!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: '/category/'+categoryId,
                            data: {
                                _token : CSRF_TOKEN
                            },
                            success: function (response) {
                                console.log(response);
                                if (response.status) {
                                    Swal.fire(
                                        'Terhapus!',
                                        response.message,
                                        'success'
                                    );
                                    setTimeout(function() {
                                        window.location.href = '{{ route("category.index") }}';
                                    }, 1000);
                                } else {
                                    Swal.fire(
                                        'Gagal!',
                                        response.message,
                                        'error'
                                    );
                                }

                            },
                            error: function(xhr, status, error) {
                                console.log(xhr);
                                console.log(error);
                                console.log(status);
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat menghapus data.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
