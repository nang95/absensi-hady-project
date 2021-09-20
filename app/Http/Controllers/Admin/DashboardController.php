<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Karyawan, Pengajuan, Absensi};
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $karyawan = Karyawan::count();
        $pengajuan_cuti = Pengajuan::where('jenis_pengajuan', 'cuti')->count();
        $pengajuan_izin = Pengajuan::where('jenis_pengajuan', 'izin')->count();

        $log_kehadiran = Absensi::orderBy('id', 'desc')
                                ->limit('10')
                                ->get();

        return view('apps.admin.beranda')->with('karyawan', $karyawan)
                                         ->with('pengajuan_cuti', $pengajuan_cuti)
                                         ->with('pengajuan_izin', $pengajuan_izin)
                                         ->with('log_kehadiran', $log_kehadiran);
    }

   
}
