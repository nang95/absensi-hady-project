@extends('layouts.app')

@section('custom-style')
    <style>
        .absensi-button{
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
@endsection

@section('content')
<?php
    setlocale(LC_TIME, 'id_ID');
	\Carbon\Carbon::setLocale('id'); 
?>
<div class="row">
    <div class="col-lg-4 col-md-4">
        <div class="well with-header">
            <div class="header bg-blue">
                Absensi
            </div>
                <div class="row">
                    <div class="col-md-12" style="font-size: 12px">Nama</div>
                    <div class="col-md-12" style="font-weight: bold; font-size: 20px">{{ $absensi->karyawan->nama }}</div>
                </div>

                <div class="row">
                    <div class="col-md-12" style="font-size: 12px">Tanggal</div>
                    <div class="col-md-12" style="font-weight: bold; font-size: 20px">{{\Carbon\Carbon::now()->isoFormat('D MMMM Y')}}</div>
                </div>

                <div class="row">
                    <div class="col-md-12" style="font-size: 12px">Jam Kantor</div>
                    <div class="col-md-12" style="font-weight: bold; font-size: 20px">
                        {{ $kantor->jam_masuk }} - {{ $kantor->jam_pulang }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" style="font-size: 12px">Status</div>
                    <div class="col-md-12" style="font-weight: bold; font-size: 20px">
                        @if ($absensi->status == "Hadir")
                            Sudah Absen                            
                        @elseif($absensi->status == "Cuti")
                            Anda sedang cuti.
                        @elseif($absensi->status == "Izin")
                            Anda sedang Izin.
                        @else   
                            Belum Absen                            
                        @endif
                    </div>
                </div>

                <div class="absensi-button">
                    <form action="{{ route('pegawai.absen.checkin') }}" method="POST">
                        @csrf @method('POST')
                            <button class="btn btn-info btn-lg" type="submit"
                            @if ($absensi->status == "Hadir")
                                disabled
                            @endif
                            >Check In</button>
                        </form>

                    @if ($absensi->jam_keluar == null || $absensi->jam_keluar == "")
                    <form action="{{ route('pegawai.absen.checkout') }}" method="POST">
                        @csrf @method('POST')
                            <button class="btn btn-danger btn-lg" style="margin-left: 20px" type="submit"
                            @if ($absensi->status == "Belum/Tidak Hadir")
                                disabled
                            @endif
                            >Check Out</button>
                        @endif
                    </form>
                </div>
        </div>
    </div>

    <div class="col-lg-8 col-md-8">
        <div class="well with-header with-footer">
            <div class="header bg-blue">
                Log Kehadiran Baru-baru ini
            </div>
            <table class="table table-hover">
                <thead class="bordered-darkorange">
                    <tr>
                        <th width="5%">#</th>
                        <th>Tanggal</th>
                        <th>Jam Hadir</th>
                        <th>Jam Keluar</th>
                        <th>Waktu Telat</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>                        
                    @foreach ($log_kehadiran as $data_log_kehadiran)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data_log_kehadiran->tanggal }}</td>
                        <td>
                            @if ($data_log_kehadiran->jam_masuk != null)
                                {{ $data_log_kehadiran->jam_masuk }}
                            @else
                                -
                            @endif   
                        </td>
                        <td>
                            @if ($data_log_kehadiran->jam_keluar != null)
                                {{ $data_log_kehadiran->jam_keluar }}
                            @else
                                -
                            @endif   
                        </td>
                        <td>
                            @if ($data_log_kehadiran->waktu_telat != null)
                                {{ $data_log_kehadiran->waktu_telat }}
                            @else
                                -
                            @endif    
                        </td>
                        <td>
                            <label class="badge {{ $data_log_kehadiran->getStatus($data_log_kehadiran->status) }}">
                                {{ $data_log_kehadiran->status }}
                            </label>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection