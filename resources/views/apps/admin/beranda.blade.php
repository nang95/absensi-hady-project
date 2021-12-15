@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <h3>Dashboard</h3>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="databox bg-white radius-bordered">
            <div class="databox-left bg-themesecondary">
                <div class="databox-piechart">
                    <div data-toggle="easypiechart" class="easyPieChart" data-barcolor="#fff" data-linecap="butt" data-percent="50" data-animate="500" data-linewidth="3" data-size="47" data-trackcolor="rgba(255,255,255,0.1)">
                        <span class="white font-90">Guru {{ $guru }}</span>
                    </div>
                </div>
            </div>
            <div class="databox-right">
                <span class="databox-number themesecondary">Jumlah Guru</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="databox bg-white radius-bordered">
            <div class="databox-left bg-themethirdcolor">
                <div class="databox-piechart">
                    <div data-toggle="easypiechart" class="easyPieChart" data-barcolor="#fff" data-linecap="butt" data-percent="15" data-animate="500" data-linewidth="3" data-size="47" data-trackcolor="rgba(255,255,255,0.2)">
                        <span class="white font-90"> Cuti {{ $pengajuan_cuti }} </span>
                    </div>
                </div>
            </div>
            <div class="databox-right">
                <span class="databox-number themethirdcolor">Jumlah Pengajuan Cuti</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="databox bg-white radius-bordered">
            <div class="databox-left bg-themeprimary">
                <div class="databox-piechart">
                    <div id="users-pie" data-toggle="easypiechart" class="easyPieChart" data-barcolor="#fff" data-linecap="butt" data-percent="76" data-animate="500" data-linewidth="3" data-size="47" data-trackcolor="rgba(255,255,255,0.1)">
                        <span class="white font-90"> Izin {{ $pengajuan_izin }}</span>
                    </div>
                </div>
            </div>
            <div class="databox-right">
                <span class="databox-number themeprimary">Jumlah Pengajuan Izin</span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-themesecondary">
                <i class="widget-icon fa fa-tags themesecondary"></i>
                <span class="widget-caption themesecondary">Log Kehadiran dini hari</span>
            </div><!--Widget Header-->
            <div class="widget-body  no-padding">
                <table class="table table-hover">
                    <thead class="bordered-darkorange">
                        <tr>
                            <th width="5%">#</th>
                            <th>Nama</th>
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
                            <td>{{ $data_log_kehadiran->karyawan->nama }}</td>
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
</div>


@endsection