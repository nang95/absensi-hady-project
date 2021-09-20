@extends('layouts.app')

@section('title')
    Kantor
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8 col-sm-8">
        <div class="widget">
            <div class="widget-header bordered-top bordered-palegreen">
                <span class="widget-caption">Kantor Profile</span>
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
                    <form role="form" action="{{ route('admin.kantor.update') }}" method="POST">
                        {{ csrf_field() }} {{ method_field('PUT') }}

                        <input type="hidden" value="{{ $kantor->id }}" name="id">

                        <div class="form-group">
                            <label for="name">Nama Kantor</label>
                            <input type="text" name="name" value="{{ old('name', $kantor->name) }}" class="form-control input-sm" id="jam_masuk_istirahat">
                        </div>

                        <div class="form-group">
                            <label for="">Jam Masuk</label>
                            <input type="time" name="jam_masuk" value="{{ old('jam_masuk', $kantor->jam_masuk) }}" id="" class="form-control input-sm">
                        </div>

                        <div class="form-group">
                            <label for="">Jam Pulang</label>
                            <input type="time" name="jam_pulang" value="{{ old('jam_pulang', $kantor->jam_pulang) }}" id="" class="form-control input-sm">
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-success btn-sm" type="submit">Simpan</button>
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