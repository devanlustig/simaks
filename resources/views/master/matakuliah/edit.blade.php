@push('customCss')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/ruangdev/cdn@idn/starterkit/datepicker/css/datepicker.css" integrity="sha512-n/98Hzv7vnNVN8bL5s+hajql1X8LVhS/kPJIMxpXinGzcIVcM+SKTG54IKnRVz8vPIJmWWtyRyP3p4aK3vLiZw==" crossorigin="anonymous">
@endpush

@section('tittle')
| Edit Matakuliah
@endsection

@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-first">
                <h3>Edit Matakuliah</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-last">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">List Matakuliah</li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Matakuliah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    
    <section class="section">
        <div class="card">
            <div class="card-body">
                <form class="form" action="{{ route('matakuliah.update',$result->id) }}" method="POST">
                    @csrf

                    <div class="row">

                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="nama_matakuliah">Matakuliah</label>
                                <input type="text" id="nama_matakuliah" class="form-control @error('nama_matakuliah') is-invalid @enderror"
                                    value="{{ old('nama_matakuliah', $result->nama_matakuliah) }}"
                                    placeholder="Matakuliah..." name="nama_matakuliah" autofocus>

                                    @error('nama_matakuliah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>

                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="sks">SKS</label>
                                <input type="number" id="sks" class="form-control @error('sks') is-invalid @enderror"
                                    value="{{ old('sks', $result->sks) }}"
                                    placeholder="Sks..." name="sks">

                                    @error('sks')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>


                        <div class="col-12 d-flex justify-content-end">
                            <a href="{{ route('matakuliah.index') }}" class="btn btn-outline-secondary icon icon-left me-1 mb-1"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>
                            <button type="submit" class="btn btn-primary icon icon-left me-1 mb-1"><i class="fas fa-edit"></i> Edit</button>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </section>
</div>
@stop
@push('customJs')
<script src="https://cdn.jsdelivr.net/gh/ruangdev/cdn@idn/starterkit/datatables/js/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/gh/ruangdev/cdn@idn/starterkit/datepicker/js/datepicker.js" integrity="sha512-zTadvlTFbfS8sBJpRcCpwz5NobiDyGe3Tm39xRlDjHCitm1gKu0ciMq24Zl+BGX2oLqtK5sfKUprFNdRHVgWNA==" crossorigin="anonymous"></script>
@endpush

