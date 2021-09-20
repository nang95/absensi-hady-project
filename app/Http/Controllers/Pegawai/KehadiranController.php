<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Absensi, Kantor, Karyawan};
use Session;
use DateTime;
class KehadiranController extends Controller
{
    public function checkIn(){
        date_default_timezone_set("Asia/Bangkok");
        $karyawan = Karyawan::where('user_id', auth()->user()->id)->first();
        
        // Update absensi dengan status hadir
        $kehadiran = Absensi::where('karyawan_id', $karyawan->id)
                          ->where('tanggal', date('Y-m-d'))
                          ->first();

        $kantor = Kantor::first();

        $jam_telat = null;
        
        if (date('H:i:s') > date('H:i:s', strtotime($kantor->jam_masuk))) {
            $jam_masuk_kantor = new DateTime(date('H:i:s', strtotime($kantor->jam_masuk)));
            $jam_sekarang = new DateTime(date('H:i:s'));
            $interval = $jam_masuk_kantor->diff($jam_sekarang);

            $jam_telat = $interval->format("%H:%i:%s");
        }

        if ($kehadiran == null) {
            $kehadiran = Absensi::create([
                'tanggal' => date('Y-m-d'),
                'karyawan_id' => $karyawan->id,
                'istirahat' => null,
                'jam_masuk_istirahat' => null,
                'jam_masuk' => date('H:i:s'),
                'keterangan' => null,
                'status' => 'Hadir',
                'waktu_telat' => $jam_telat == null ? null : $jam_telat
            ]);
        }else{
            if ($kehadiran->status == "Cuti") {
                Session::flash('flash_cuti', 'tidak dapat melakukan absensi, status cuti');
            }

            if ($kehadiran->status == "Izin") {
                Session::flash('flash_cuti', 'tidak dapat melakukan absensi, status izin');
            }
            
            $kehadiran->update([
                'jam_masuk' => date('H:i:s'),
                'status' => 'Hadir',
                'waktu_telat' => $jam_telat == null ? null : $jam_telat
            ]); 
        }

        Session::flash('flash_message', 'Berhasil melakukan absensi!');
        return redirect()->back();
    }

    public function checkout(){
        date_default_timezone_set("Asia/Bangkok");
        $karyawan = Karyawan::where('user_id', auth()->user()->id)->first();
        
        // Update absensi dengan status hadir
        $kehadiran = Absensi::where('karyawan_id', $karyawan->id)
                          ->where('tanggal', date('Y-m-d'))
                          ->first();


        $kehadiran->update([
            'jam_keluar' => date('H:i:s'),
        ]); 

        Session::flash('flash_message', 'Berhasil melakukan absensi!');
        return redirect()->back();
    }
}
