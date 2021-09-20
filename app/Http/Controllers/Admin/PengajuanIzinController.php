<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Pengajuan, Absensi, Izin};
use Session;
use DateTime;
use DateInterval;
use DatePeriod;

class PengajuanIzinController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pengajuan_izin = Pengajuan::where('jenis_pengajuan', 'Izin')->orderBy('id', 'desc');
        $q_nama = $request->q_nama;

        if (!empty($q_nama)) {
            $pengajuan_izin->whereHas('karyawan', function($query) use($q_nama){
                $query->where('nama', 'LIKE', '%'.$q_nama.'%');
            });
        }
        
        $pengajuan_izin = $pengajuan_izin->paginate(20);
        $skipped = ($pengajuan_izin->perPage() * $pengajuan_izin->currentPage()) - $pengajuan_izin->perPage();

        return view('apps.admin.pengajuan-izin.index')->with('pengajuan_izin', $pengajuan_izin)
                                               ->with('skipped', $skipped)
                                               ->with('q_nama', $q_nama);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function approve(Pengajuan $pengajuan)
    {
        $pengajuan->update([
            'status' => 1,
        ]);

        // Masukkan ke table Izin
        $izin = Izin::where('tanggal_mulai', $pengajuan->tanggal_mulai)
                    ->where('tanggal_selesai', $pengajuan->tanggal_selesai)
                    ->first();

        if ($izin == null) {
            Izin::create([
                'karyawan_id' => $pengajuan->karyawan_id,
                'tanggal_mulai' => $pengajuan->tanggal_mulai,
                'tanggal_selesai' => $pengajuan->tanggal_selesai,
            ]);
        }

        $begin = new DateTime($pengajuan->tanggal_mulai);
        $end = new DateTime($pengajuan->tanggal_selesai);

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end->modify( '+1 day' ));

        foreach ($period as $dt) {
            $kehadiran = Absensi::where('tanggal', $dt->format("Y-m-d"))
                                ->where('karyawan_id', $pengajuan->karyawan_id)->first();
            if ($kehadiran == null) {
                Absensi::create([
                    'tanggal' => $dt->format("Y-m-d"),
                    'karyawan_id' => $pengajuan->karyawan_id,
                    'jam_masuk' => null,
                    'keterangan' => null,
                    'status' => 'Izin',
                ]);
            }
        }

        Session::flash('flash_message', 'Pengajuan telah diapprove');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $pengajuan = Pengajuan::findOrFail($request->id);

        $pengajuan->delete();
        return redirect()->back();
    }
}
