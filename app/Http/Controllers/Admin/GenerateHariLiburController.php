<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Absensi, Karyawan};
use Session;

class GenerateHariLiburController extends Controller
{
    public function index(){
        return view('apps.admin.generate-libur.index');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kehadiran = Absensi::where('tanggal', date('Y-m-d'))->get();
        $karyawan = Karyawan::whereNotIn('id', function($query) use($request){
            $query->select('karyawan_id')->from('absensis')
                                         ->where('tanggal', $request->tanggal);
        })->get();
        

        // jika ada data karyawan yang belum ada didata absensi/kehadiran pada tanggal hari ini
        if (count($karyawan) > 0) {
            foreach ($karyawan as $key => $item) {
                $kehadiran = Absensi::create([
                    'tanggal' => $request->tanggal,
                    'karyawan_id' => $item->id,
                    'istirahat' => null,
                    'jam_masuk_istirahat' => null,
                    'jam_masuk' => null,
                    'keterangan' => null,
                    'status' => 'Belum/Tidak Hadir',
                ]);
            }
        }

        $kehadiran = Absensi::where('tanggal', $request->tanggal)->get();
        
        // Ubah hari ini menjadi hari libur
        foreach ($kehadiran as $key => $item) {
            $kehadiran = Absensi::findOrFail($item->id);
            $kehadiran->update(['status' => 'Libur']);
        }
        
        Session::flash('flash_message', 'Absensi Hari Ini telah diset hari libur');
        return redirect()->back();
    }
}
