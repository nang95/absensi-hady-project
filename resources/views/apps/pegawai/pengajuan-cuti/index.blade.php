@extends('layouts.app')

@section('title')
    Pengajuan Cuti
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
                        <a href="{{ route('pegawai.pengajuan-cuti.create') }}" class="btn btn-success btn-sm">
                            Tambah
                        </a>
                    </div>
                </div>
                <table class="table table-hover">
                    <thead class="bordered-darkorange">
                        <tr>
                            <th width="5%">#</th>
                            <th>Tanggal Dari</th>
                            <th>Tanggal Sampai</th>
                            <th>Status</th>
                            <th width="30%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        @if (count($pengajuan_cuti) === 0)
                        <tr>
                            <td colspan="8" style="text-align:center">
                                <span>Kriteria yang anda cari tidak sesuai</span>
                            </td>
                        </tr>
                        @endif

                        @foreach ($pengajuan_cuti as $data_pengajuan_cuti)
                        <tr>
                            <td>{{ $loop->iteration + $skipped }}</td>
                            <td>{{ $data_pengajuan_cuti->tanggal_mulai }}</td>
                            <td>{{ $data_pengajuan_cuti->tanggal_selesai }}</td>
                            <td>
                                @if ($data_pengajuan_cuti->status == 1)
                                    <label class="badge badge-success">Approve</label>
                                @else
                                    <label class="badge badge-danger">Disapprove</label>
                                @endif
                            </td>
                            <td>
                                @if ($data_pengajuan_cuti->status == 0)
                                <a href="{{ route('pegawai.pengajuan-cuti.edit', $data_pengajuan_cuti->id) }}">
                                    <button class="btn btn-warning btn-sm">Edit</button>
                                </a>
                                <form onsubmit="deleteThis(event)" action="{{ route('pegawai.pengajuan-cuti.delete') }}" method="POST" style="display:inline-block">
                                    {{ csrf_field() }} {{ method_field('DELETE') }}
                                    <input type="hidden" name="id" value="{{ $data_pengajuan_cuti->id }}">
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="footer">
                    {{ $pengajuan_cuti->links() }}
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