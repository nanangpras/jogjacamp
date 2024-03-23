@extends('layout.master')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Kategori</a></li>
            <li class="breadcrumb-item active" aria-current="page">Input Kategory</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit Kategori</h6>
                    @if ($errors->any())
                        <div class="alert alert-danger bg-danger text-white mb-0" role="alert">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <form class="forms-sample" action="{{ route('category.update',$edit->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                          <div class="form-group">
                              <label class="form-label">Nama Kategori</label>
                                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $edit->name }}" placeholder="Nama nama kategori" />
                          </div>
                          <div class="form-group">
                              <label class="form-label">Publish</label>
                              <select name="is_publish" id="" class="form-control">
                                <option selected="true" disabled="disabled"> Pilih Status Publish</option>
                                <option value="1" {{ ($edit->is_publish == 1)? 'selected':''; }}>Ya</option>
                                <option value="0" {{ ($edit->is_publish == 0)? 'selected':''; }}>Tidak</option>
                              </select>
                          </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{route('category.index')}}" type="button" class="btn btn-warning">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
    <script>
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
                if (response.status == true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Data berhasil diupdate',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('input[name="name"]').val('');
                            $('select[name="is_publish"]').val('');
                            window.location.href = '{{route("category.index")}}';
                        }
                    });
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Ada kesalahan sistem!'+ response.message,
                    });
                }
            },
            error: function (xhr) {
                console.log(xhr);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ada kesalahan sistem!'+ xhr,
                });
                // notif('error','Terjadi kesalahan saat menyimpan data');
            }
          });
        });
      });
    </script>
@endpush
