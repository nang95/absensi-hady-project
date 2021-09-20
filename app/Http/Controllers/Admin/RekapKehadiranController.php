<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Absensi, Karyawan};
use PDF;

class RekapKehadiranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q_periode = $request->q_periode;
        $q_jangka = $request->q_jangka;
        
        $kehadiran = [];
        $skipped = 0;

        if ($q_periode == "Bulan") {
            $kehadiran = Absensi::groupBy('karyawan_id')
                                    ->whereMonth('tanggal', $q_jangka);
            
            $kehadiran = $kehadiran->paginate(20);
        }else{
            $kehadiran = Absensi::groupBy('karyawan_id')
                                    ->whereYear('tanggal', $q_jangka);
            $kehadiran = $kehadiran->paginate(20);
        }

        $skipped = ($kehadiran->perPage() * $kehadiran->currentPage()) - $kehadiran->perPage();

        return view('apps.admin.rekap-kehadiran.index')->with('kehadiran', $kehadiran)
                                                 ->with('skipped', $skipped)
                                                 ->with('q_jangka', $q_jangka)
                                                 ->with('q_periode', $q_periode);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cetakSemua($jangka, $periode)
    {   
        $kehadiran = [];

        if ($periode == "Bulan") {
            $kehadiran = Absensi::groupBy('karyawan_id')
                                    ->whereMonth('tanggal', $jangka)
                                    ->get();
            
        }else{
            $kehadiran = Absensi::groupBy('karyawan_id')
                                    ->whereYear('tanggal', $jangka)
                                    ->get();
        }

        $pdf = PDF::loadview('apps.admin.rekap-kehadiran.cetak-semua',['kehadiran'=>$kehadiran,
                                                      'jangka'=>$jangka,
                                                      'periode'=>$periode
                                                     ]);
    	return $pdf->download('rekap-kehadiran.pdf');
    }

      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cetak(Karyawan $karyawan, $jangka, $periode)
    {   
        $kehadiran = [];

        if ($periode == "Bulan") {
            $kehadiran = Absensi::where('karyawan_id', $karyawan->id)
                                    ->whereMonth('tanggal', $jangka)
                                    ->get();
        
        }else{
            $kehadiran = Absensi::where('karyawan_id', $karyawan->id)
                                    ->whereYear('tanggal', $jangka)
                                    ->get();
        }


        $pdf = PDF::loadview('apps.admin.rekap-kehadiran.cetak',['kehadiran'=>$kehadiran,
                                                                 'jangka'=>$jangka,
                                                                 'periode'=>$periode
                                                                ]);
    	return $pdf->download('rekap-kehadiran-pegawai.pdf');
    }
}
