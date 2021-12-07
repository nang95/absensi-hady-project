@extends('layouts.app')

@section('title')
    Guru
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8 col-sm-8">
        <div class="widget">
            <div class="widget-header bordered-top bordered-palegreen">
                <span class="widget-caption">Tambah Data</span>
            </div>
            
            <div class="widget-body">
                @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                        @foreach ($errors->all() as $error)
                            <ul>
                                <li>{{ $error }}</li>
                            </ul>
                        @endforeach
                    </div>
                @endif
                <div class="collapse in">
                    <form role="form" action="{{ route('admin.guru.store') }}" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}

                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" value="{{ old('nama') }}" class="form-control input-sm" id="nama">
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" name="alamat" value="{{ old('alamat') }}" class="form-control input-sm" id="alamat">
                        </div>

                        <div class="form-group">
                            <label for="tgl_lahir">Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir" value="{{ old('tgl_lahir') }}" class="form-control input-sm" id="tgl_lahir">
                        </div>

                        <div class="form-group">
                            <label for="tpt_lahir">Tempat Lahir</label>
                            <input type="text" name="tpt_lahir" value="{{ old('tpt_lahir') }}" class="form-control input-sm" id="tpt_lahir">
                        </div>

                        <div class="form-group">
                            <label for="no_telp">No Telp</label>
                            <input type="number" name="no_telp" value="{{ old('no_telp') }}" class="form-control input-sm" id="no_telp">
                        </div>
                        
                        <div class="form-group">
                            <label for="jabatan_id">Jabatan</label>
                            <select name="jabatan_id" value="{{ old('jabatan_id') }}" class="form-control input-sm" id="jabatan_id">
                                <option value="">-Silahkan Pilih-</option>
                                @foreach ($jabatan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" value="{{ old('email') }}" class="form-control input-sm" id="email">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" value="{{ old('password') }}" class="form-control input-sm" id="password">
                        </div>
                       
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-success btn-sm" type="submit">Simpan</button>
                                </div>
                                <div class="col-md-6" style="text-align:right">
                                    <a href="{{ route('admin.guru') }}">
                                        <button class="btn btn-danger btn-sm" type="button">Batal</button>
                                    </a>  
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection