@extends('layouts.app')

@section('title')
    Cuti
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
                    <form role="form" action="{{ route('admin.cuti.update') }}" method="POST">
                        {{ csrf_field() }} {{ method_field('PUT') }}

                        <input type="hidden" name="id" value="{{ $cuti->id }}">
                        <div class="form-group">
                            <label for="karyawan_id">Karyawan</label>
                            <select name="karyawan_id" value="{{ old('karyawan_id') }}" class="form-control input-sm" id="karyawan_id">
                                <option value="">-Silahkan Pilih-</option>
                                @foreach ($karyawan as $item)
                                    <option value="{{ $item->id }}"
                                        @if ($item->id == $cuti->karyawan_id)
                                            selected
                                        @endif>{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $cuti->tanggal_mulai) }}" class="form-control input-sm" id="jam_masuk_istirahat">
                        </div>

                        <div class="form-group">
                            <label for="tanggal_selesai">Tanggal Selesai </label>
                            <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $cuti->tanggal_selesai) }}" class="form-control input-sm" id="jam_keluar">
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-success btn-sm" type="submit">Simpan</button>
                                </div>
                                <div class="col-md-6" style="text-align:right">
                                    <a href="{{ route('admin.cuti') }}">
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