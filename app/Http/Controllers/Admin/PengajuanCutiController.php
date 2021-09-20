<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Pengajuan, Absensi, Cuti};
use Session;
use DateTime;
use DateInterval;
use DatePeriod;

class PengajuanCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pengajuan_cuti = Pengajuan::where('jenis_pengajuan', 'Cuti')->orderBy('id', 'desc');
        $q_nama = $request->q_nama;

        if (!empty($q_nama)) {
            $pengajuan_cuti->whereHas('karyawan', function($query) use($q_nama){
                $query->where('nama', 'LIKE', '%'.$q_nama.'%');
            });
        }
        
        $pengajuan_cuti = $pengajuan_cuti->paginate(20);
        $skipped = ($pengajuan_cuti->perPage() * $pengajuan_cuti->currentPage()) - $pengajuan_cuti->perPage();

        return view('apps.admin.pengajuan-cuti.index')->with('pengajuan_cuti', $pengajuan_cuti)
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

        // Masukkan ke table Cuti
        $cuti = Cuti::where('tanggal_mulai', $pengajuan->tanggal_mulai)
                    ->where('tanggal_selesai', $pengajuan->tanggal_selesai)
                    ->first();

        if ($cuti == null) {
            Cuti::create([
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
                    'status' => 'Cuti',
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
