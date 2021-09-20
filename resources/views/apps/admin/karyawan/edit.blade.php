@extends('layouts.app')

@section('title')
    Modul
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8 col-sm-8">
        <div class="widget">
            <div class="widget-header bordered-top bordered-palegreen">
                <span class="widget-caption">Edit Data</span>
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
                    <form role="form" action="{{ route('admin.karyawan.update') }}" method="POST">
                        {{ csrf_field() }} {{ method_field('PUT') }}

                        <input type="hidden" name="id" value="{{ $karyawan->id }}">

                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" value="{{ old('nama', $karyawan->nama) }}" class="form-control input-sm" id="nip">
                        </div>
                        
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" name="alamat" value="{{ old('alamat', $karyawan->alamat) }}" class="form-control input-sm" id="alamat">
                        </div>

                        <div class="form-group">
                            <label for="tgl_lahir">Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir" value="{{ old('tgl_lahir', $karyawan->tgl_lahir) }}" class="form-control input-sm" id="tgl_lahir">
                        </div>

                        <div class="form-group">
                            <label for="tpt_lahir">Tempat Lahir</label>
                            <input type="text" name="tpt_lahir" value="{{ old('tpt_lahir', $karyawan->tpt_lahir) }}" class="form-control input-sm" id="tpt_lahir">
                        </div>

                        <div class="form-group">
                            <label for="no_telp">No Telp</label>
                            <input type="number" name="no_telp" value="{{ old('no_telp', $karyawan->no_telp) }}" class="form-control input-sm" id="no_telp">
                        </div>
                        
                        <div class="form-group">
                            <label for="jabatan_id">Jabatan</label>
                            <select name="jabatan_id" value="{{ old('jabatan_id') }}" class="form-control input-sm" id="jabatan_id">
                                <option value="">-Silahkan Pilih-</option>
                                @foreach ($jabatan as $item)
                                    <option value="{{ $item->id }}"
                                        @if ($item->id == $karyawan->jabatan_id)
                                            selected
                                        @endif>{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">    
                            <label for="email">Email</label>
                            <input type="text" name="email" value="{{ old('email', $karyawan->user->email) }}" class="form-control input-sm" id="email">
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-success btn-sm" type="submit">Simpan</button>
                                </div>
                                <div class="col-md-6" style="text-align:right">
                                    <a href="{{ route('admin.karyawan') }}">
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

@section('footer-scripts')

<script>
</script>  


@endsection