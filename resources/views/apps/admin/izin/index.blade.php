@extends('layouts.app')

@section('title')
    Izin
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
                    Data Izin
                </div>
                <div class="row" style="margin-bottom: 10px">
                    <div class="col-md-6">
                        <a href="{{ route('admin.izin.create') }}" class="btn btn-success btn-sm">
                            Tambah
                        </a>
                        <a href="{{ route('admin.izin.cetak') }}" class="btn btn-info btn-sm">
                            Cetak
                        </a>
                    </div>
                    <div class="col-md-6" style="display:flex; justify-content: flex-end">
                        <form action="{{ route('admin.izin') }}" style="display: flex" method="GET">
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
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th width="30%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        @if (count($izin) === 0)
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

                        @foreach ($izin as $data_izin)
                        <tr>
                            <td>{{ $loop->iteration + $skipped }}</td>
                            <td>{{ $data_izin->karyawan->nama }}</td>
                            <td>{{ $data_izin->tanggal_mulai }}</td>
                            <td>{{ $data_izin->tanggal_selesai }}</td>
                            <td>
                                <form onsubmit="deleteThis(event)" action="{{ route('admin.izin.delete') }}" method="POST" style="display:inline-block">
                                    {{ csrf_field() }} {{ method_field('DELETE') }}
                                    <input type="hidden" name="id" value="{{ $data_izin->id }}">
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="footer">
                    {{ $izin->appends(['q_nama' => $q_nama])->links() }}
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