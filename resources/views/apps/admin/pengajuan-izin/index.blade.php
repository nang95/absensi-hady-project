@extends('layouts.app')

@section('title')
    Pengajuan Izin
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
                    Data Pengajuan
                </div>
                <div class="row" style="margin-bottom: 10px">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6" style="display:flex; justify-content: flex-end">
                        <form action="{{ route('admin.pengajuan_izin') }}" style="display: flex" method="GET">
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
                            <th>Tanggal Dari</th>
                            <th>Tanggal Sampai</th>
                            <th>Status</th>
                            <th width="30%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        @if (count($pengajuan_izin) === 0)
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

                        @foreach ($pengajuan_izin as $data_pengajuan_izin)
                        <tr>
                            <td>{{ $loop->iteration + $skipped }}</td>
                            <td>{{ $data_pengajuan_izin->karyawan->nama }}</td>
                            <td>{{ $data_pengajuan_izin->tanggal_mulai }}</td>
                            <td>{{ $data_pengajuan_izin->tanggal_selesai }}</td>
                            <td>
                                @if ($data_pengajuan_izin->status == 1)
                                    <label class="badge badge-success">Approve</label>
                                @else
                                    <label class="badge badge-danger">Disapprove</label>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.pengajuan_izin.approve', $data_pengajuan_izin->id) }}">
                                    <button class="btn btn-warning btn-sm">Approve</button>
                                </a>
                                <form onsubmit="deleteThis(event)" action="{{ route('admin.pengajuan_izin.delete') }}" method="POST" style="display:inline-block">
                                    {{ csrf_field() }} {{ method_field('DELETE') }}
                                    <input type="hidden" name="id" value="{{ $data_pengajuan_izin->id }}">
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="footer">
                    {{ $pengajuan_izin->appends(['q_nama' => $q_nama])->links() }}
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