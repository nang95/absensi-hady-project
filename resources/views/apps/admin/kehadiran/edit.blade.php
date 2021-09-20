@extends('layouts.app')

@section('title')
    Kehadiran
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
                    <form role="form" action="{{ route('admin.kehadiran.update') }}" method="POST">
                        {{ csrf_field() }} {{ method_field('PUT') }}

                        <input type="hidden" name="id" value="{{ $absensi->id }}">

                        <div class="form-group">
                            <label for="karyawan_id">Karyawan</label>
                            <select name="karyawan_id" value="{{ old('karyawan_id') }}" class="form-control input-sm" id="karyawan_id">
                                <option value="">-Silahkan Pilih-</option>
                                @foreach ($karyawan as $item)
                                    <option value="{{ $item->id }}"
                                        @if ($absensi->karyawan_id == $item->id)
                                            selected
                                        @endif>{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" name="tanggal" value="{{ old('tanggal', $absensi->tanggal) }}" class="form-control input-sm" id="tanggal">
                        </div>
                        
                        <div class="form-group">
                            <label for="jam_keluar">Jam Hadir</label>
                            <input type="time" name="jam_masuk" value="{{ old('jam_keluar', $absensi->jam_masuk) }}" class="form-control input-sm" id="jam_keluar">
                        </div>

                        <div class="form-group">
                            <label for="jam_keluar">Jam Pulang</label>
                            <input type="time" name="jam_keluar" value="{{ old('jam_keluar', $absensi->jam_keluar) }}" class="form-control input-sm" id="jam_keluar">
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" name="keterangan" value="{{ old('keterangan', $absensi->keterangan) }}" class="form-control input-sm" id="keterangan">
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
// var x = document.getElementById("demo");

// function getLocation() {
//  if (navigator.geolocation) {
//    navigator.geolocation.getCurrentPosition(showPosition);
//  } else { 
//    x.innerHTML = "Geolocation tidak didukung oleh browser ini.";
//  }
// }

// function showPosition(position) {
//  x.innerHTML = "Latitude: " + position.coords.latitude + 
//  "<br>Longitude: " + position.coords.longitude + 
//  "<br><b>Lokasi Telah Aktif</b>"; 
// }

// function arePointsNear(checkPoint, centerPoint, km) {
//   var ky = 40000 / 360;
//   var kx = Math.cos(Math.PI * centerPoint.lat / 180.0) * ky;
//   var dx = Math.abs(centerPoint.lng - checkPoint.lng) * kx;
//   var dy = Math.abs(centerPoint.lat - checkPoint.lat) * ky;
//   return Math.sqrt(dx * dx + dy * dy) <= km;
// }

// console.log(arePointsNear({lat: 3.588096, lng: 98.6710016}, {lat: 3.601584, lng: 98.681378}, ));

// https://stackoverflow.com/questions/24680247/check-if-a-latitude-and-longitude-is-within-a-circle-google-maps
// https://stackoverflow.com/questions/1502590/calculate-distance-between-two-points-in-google-maps-v3
</script>  


@endsection