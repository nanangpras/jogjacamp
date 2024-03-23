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
                    <h6 class="card-title">Detail Kategori</h6>
                    <form class="forms-sample" action="#" method="POST" enctype="multipart/form-data">

                        <div class="mb-3">
                          <div class="form-group">
                              <label class="form-label">Nama Kategori</label>
                                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" readonly value="{{ $detail->name }}" placeholder="Nama nama kategori" />
                          </div>
                          <div class="form-group">
                              <label class="form-label">Publish</label>
                              <select name="is_publish" id="" class="form-control">
                                <option selected="true" disabled="disabled"> Pilih Status Publish</option>
                                <option value="1" disabled="disabled" {{ ($detail->is_publish == 1)? 'selected':''; }}>Ya</option>
                                <option value="0" disabled="disabled" {{ ($detail->is_publish == 0)? 'selected':''; }}>Tidak</option>
                              </select>
                          </div>
                        </div>
                        <a href="{{route('category.index')}}" type="button" class="btn btn-warning">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
