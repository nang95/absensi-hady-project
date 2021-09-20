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
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
            </tr>
        </thead>
        <tbody>                        
            @foreach ($izin as $data_izin)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data_izin->karyawan->nama }}</td>
                <td>{{ $data_izin->tanggal_mulai }}</td>
                <td>{{ $data_izin->tanggal_selesai }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>