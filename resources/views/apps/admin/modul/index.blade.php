@extends('layouts.app')

@section('title')
    Modul
@endsection

@section('content')
    @if(Session::has('flash_message'))
    <script type="text/javascript">
        swal("Berhasil!","{{ Session('flash_message') }}", "success");
    </script>
    @endif

    <div class="row">
        <div class="col-lg-8 col-md-8">
            <div class="well with-header with-footer">
                <div class="header bg-blue">
                    Data Modul
                </div>
                <div class="row" style="margin-bottom: 10px">
                    <div class="col-md-6">
                        <a href="{{ route('admin.modul.create') }}" class="btn btn-success btn-sm">
                            Tambah
                        </a>
                    </div>
                    <div class="col-md-6" style="display:flex; justify-content: flex-end">
                        <form action="{{ route('admin.modul') }}" style="display: flex" method="GET">
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
                            <th>link</th>
                            <th width="30%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        @if (count($modul) === 0)
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

                        @foreach ($modul as $data_modul)
                        <tr>
                            <td>{{ $loop->iteration + $skipped }}</td>
                            <td>{{ $data_modul->nama }}</td>
                            <td>{{ $data_modul->link }}</td>
                            <td>
                                <a href="{{ route('admin.modul.edit', $data_modul->id) }}">
                                    <button class="btn btn-warning btn-sm">Ubah</button>
                                </a>
                                <form onsubmit="deleteThis(event)" action="{{ route('admin.modul.delete') }}" method="POST" style="display:inline-block">
                                    {{ csrf_field() }} {{ method_field('DELETE') }}
                                    <input type="hidden" name="id" value="{{ $data_modul->id }}">
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="footer">
                    {{ $modul->appends(['q_nama' => $q_nama])->links() }}
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