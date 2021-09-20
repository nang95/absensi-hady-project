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
    <div class="col-lg-12 col-md-12">
        <div class="well with-header with-footer">
            <div class="header bg-blue">
                Log Kehadiran
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
                    @if (count($log_kehadiran) === 0)
                    <tr>
                        <td colspan="8" style="text-align:center">
                            @if ($q_nama == "")
                                <span>Data Kosong</span>
                            @else
                                <span>Kriteria yang anda cari tidak sesuai</span>
                            @endif
                        </td>
                    </tr>
                    @endif

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