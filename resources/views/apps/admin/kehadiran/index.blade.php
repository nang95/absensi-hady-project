@extends('layouts.app')

@section('title')
    Kehadiran
@endsection

@section('content')
    @if(Session::has('flash_message'))
    <script type="text/javascript">
        swal("Berhasil!","{{ Session('flash_message') }}", "success");
    </script>
    @endif

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="well with-header with-footer">
                <div class="header bg-blue">
                    Data Kehadiran
                </div>
                <div class="row" style="margin-bottom: 10px">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6" style="display:flex; justify-content: flex-end">
                        <form action="{{ route('admin.kehadiran') }}" style="display: flex" method="GET">
                            <div class="input-group-sm">
                                <input type="text" class="form-control" placeholder="Nama" name="q_nama" value="{{ $q_nama }}">
                            </div>
                            <div class="input-group-sm" style="margin-left: 10px; display:flex; justify-content: center">
                                <button class="btn btn-primary btn-sm">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
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
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        @if (count($kehadiran) === 0)
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

                        @foreach ($kehadiran as $data_kehadiran)
                        <tr>
                            <td>{{ $loop->iteration + $skipped }}</td>
                            <td>{{ $data_kehadiran->karyawan->nama }}</td>
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
                                @if ($data_kehadiran->waktu_telat != null)
                                    {{ $data_kehadiran->waktu_telat }}
                                @else
                                    -
                                @endif    
                            </td>
                            <td>
                                <label class="badge {{ $data_kehadiran->getStatus($data_kehadiran->status) }}">
                                    {{ $data_kehadiran->status }}
                                </label>
                            </td>
                            <td>
                                <a href="{{ route('admin.kehadiran.edit', $data_kehadiran->id) }}">
                                    <button class="btn btn-warning btn-sm">Ubah</button>
                                </a>
                                <form onsubmit="deleteThis(event)" action="{{ route('admin.kehadiran.delete') }}" method="POST" style="display:inline-block">
                                    {{ csrf_field() }} {{ method_field('DELETE') }}
                                    <input type="hidden" name="id" value="{{ $data_kehadiran->id }}">
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="footer">
                    {{ $kehadiran->appends(['q_nama' => $q_nama])->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection

@section('footer-scripts')
    <script type="text/javascript">
        function deleteThis(e){
            e.preventDefault();
            swal({
            title: "Apakah anda yakin?",
            text: "Data akan dihapus secara permanen!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                e.target.submit();
                swal("Data telah dihapus!", {
                icon: "success",
                });
            }
            });

            return false;
        }
    </script>
@endsection