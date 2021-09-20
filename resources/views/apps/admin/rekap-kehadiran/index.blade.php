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
        <div class="col-lg-8 col-md-8">
            <div class="well with-header with-footer">
                <div class="header bg-blue">
                    Data Kehadiran
                </div>
                <div class="row" style="margin-bottom: 10px">
                    <div class="col-md-6">
                        @if ($q_jangka != "")
                        <a href="{{ route('admin.rekap-kehadiran.cetak-semua', [$q_jangka, $q_periode]) }}" class="btn btn-success btn-sm">
                            Cetak
                        </a>
                        @endif
                    </div>
                    <div class="col-md-6" style="display:flex; justify-content: flex-end">
                        <form action="{{ route('admin.rekap-kehadiran') }}" style="display: flex" method="GET">
                            <div class="input-group-sm">
                                <select name="q_periode" id="" style="margin-right: 5px" class="form-control form-control-sm">
                                    <option value="">-Periode-</option>
                                    <option value="Bulan" @if ($q_periode == "Bulan")
                                        selected
                                    @endif>Bulan</option>
                                    <option value="Tahun"
                                    @if ($q_periode == "Tahun")
                                        selected
                                    @endif>Tahun</option>
                                </select>
                            </div>
                            <div class="input-group-sm">
                                <input type="number" min="1" max="2099" step="1" class="form-control" 
                                       placeholder="Bulan/Tahun" name="q_jangka" value="{{ $q_jangka }}"
                                       style="margin-left: 5px">
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
                            <th>Persentase</th>
                            <th>Jumlah Izin</th>
                            <th>Jumlah Cuti</th>
                            <th>Jumlah Libur Kantor</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        @if ($q_jangka == "")
                        <tr>
                            <td colspan="8" style="text-align:center">
                                <span>Silahkan cari datanya terlebih dahulu</span>
                            </td>
                        </tr>
                        @elseif (count($kehadiran) === 0)
                        <tr>
                            <td colspan="8" style="text-align:center">
                                @if ($q_jangka == "")
                                    <span>Data Kosong</span>
                                @else
                                    <span>Kriteria yang anda cari tidak sesuai</span>
                                @endif
                            </td>
                        </tr>
                        @else
                            @foreach ($kehadiran as $data_kehadiran)
                            <tr>
                                <td>{{ $loop->iteration + $skipped }}</td>
                                <td>{{ $data_kehadiran->karyawan->nama }}</td>
                                <td>{{ $data_kehadiran->getPersentaseKehadiran($data_kehadiran->karyawan_id, $q_periode, $q_jangka) }}%</td>
                                <td>{{ $data_kehadiran->getJumlahIzin($data_kehadiran->karyawan_id, $q_periode, $q_jangka) }}</td>
                                <td>{{ $data_kehadiran->getJumlahCuti($data_kehadiran->karyawan_id, $q_periode, $q_jangka) }}</td>
                                <td>{{ $data_kehadiran->getJumlahLibur($data_kehadiran->karyawan_id, $q_periode, $q_jangka) }}</td>
                                <td>
                                    <a href="{{ route('admin.rekap-kehadiran.cetak', [$data_kehadiran->karyawan_id, $q_jangka, $q_periode]) }}">
                                        <button class="btn btn-warning btn-sm">Cetak</button>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                @if ($q_jangka != "")
                <div class="footer">
                    {{ $kehadiran->appends(['q_jangka' => $q_jangka])->links() }}
                </div>
                @endif
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