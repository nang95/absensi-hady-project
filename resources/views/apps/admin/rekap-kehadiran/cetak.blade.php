<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table style="width:100%" border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th>Tanggal</th>
                <th>Jam Hadir</th>
                <th>Istirahat</th>
                <th>Masuk Istirahat</th>
                <th>Jam Keluar</th>
                <th>Waktu Telat</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>                        
            @foreach ($kehadiran as $data_kehadiran)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data_kehadiran->tanggal }}</td>
                <td>
                    @if ($data_kehadiran->jam_masuk != null)
                        {{ $data_kehadiran->jam_masuk }}
                    @else
                        -
                    @endif   
                </td>
                <td>
                    @if ($data_kehadiran->istirahat != null)
                        {{ $data_kehadiran->istirahat }}
                    @else
                        -
                    @endif   
                </td>
                <td>
                    @if ($data_kehadiran->jam_masuk_istirahat != null)
                        {{ $data_kehadiran->jam_masuk_istirahat }}
                    @else
                        -
                    @endif   
                </td>
                <td>
                    @if ($data_kehadiran->jam_keluar != null)
                        {{ $data_kehadiran->jam_keluar }}
                    @else
                        -
                    @endif   
                </td>
                <td>
                    @if ($data_kehadiran->waktu_telat != null)
                        {{ $data_kehadiran->waktu_telat }}
                    @else
                        -
                    @endif    
                </td>
                <td>
                    {{ $data_kehadiran->status }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>