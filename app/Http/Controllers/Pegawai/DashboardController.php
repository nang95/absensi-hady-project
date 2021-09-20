<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Karyawan, Absensi};

class DashboardController extends Controller
{
    public function index(){
        date_default_timezone_set("Asia/Bangkok");
        $karyawan = Karyawan::where('user_id', auth()->user()->id)->first();
        $absensi = Absensi::where('tanggal', date('Y-m-d'))
                            ->where('karyawan_id', $karyawan->id)
                            ->orderBy('id', 'desc')
                            ->first();

        if ($absensi == null) {
                $absensi = Absensi::create([
                    'tanggal' => date('Y-m-d'),
                    'karyawan_id' => $karyawan->id,
                    'istirahat' => null,
                    'jam_masuk_istirahat' => null,
                    'jam_masuk' => null,
                    'keterangan' => null,
                    'status' => 'Belum/Tidak Hadir',
                ]);
        }

        $log_kehadiran = Absensi::where('karyawan_id', $karyawan->id)
                                ->orderBy('id', 'desc')
                                ->limit('10')
                                ->get();

        return view('apps.pegawai.beranda')->with('absensi', $absensi)
                                           ->with('log_kehadiran', $log_kehadiran);
    }
}
