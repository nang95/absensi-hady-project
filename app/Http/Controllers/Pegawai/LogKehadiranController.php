<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Karyawan, Absensi};

class LogKehadiranController extends Controller
{
    public function index(){
        $karyawan = Karyawan::where('user_id', auth()->user()->id)->first();
        $log_kehadiran = Absensi::where('karyawan_id', $karyawan->id)
                                ->orderBy('id', 'desc')
                                ->limit('10')
                                ->get();

        return view('apps.pegawai.log-kehadiran.index')->with('log_kehadiran', $log_kehadiran);
    }
}
