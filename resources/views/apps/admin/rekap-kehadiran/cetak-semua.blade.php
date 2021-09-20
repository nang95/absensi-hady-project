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
                <th>Nama</th>
                <th>Persentase</th>
                <th>Jumlah Izin</th>
                <th>Jumlah Cuti</th>
                <th>Jumlah Libur Kantor</th>
            </tr>
        </thead>
        <tbody>                        
            @foreach ($kehadiran as $data_kehadiran)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data_kehadiran->karyawan->nama }}</td>
                <td>{{ $data_kehadiran->getPersentaseKehadiran($data_kehadiran->karyawan_id, $periode, $jangka) }}%</td>
                <td>{{ $data_kehadiran->getJumlahIzin($data_kehadiran->karyawan_id, $periode, $jangka) }}</td>
                <td>{{ $data_kehadiran->getJumlahCuti($data_kehadiran->karyawan_id, $periode, $jangka) }}</td>
                <td>{{ $data_kehadiran->getJumlahLibur($data_kehadiran->karyawan_id, $periode, $jangka) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>