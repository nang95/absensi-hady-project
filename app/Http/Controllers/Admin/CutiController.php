<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Karyawan, Cuti, Absensi};
use Session;
use App\Http\Requests\Cuti\{CreateRequest, UpdateRequest};
use PDF;
use DateTime;
use DateInterval;
use DatePeriod;

class CutiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cuti = Cuti::orderBy('id', 'desc');
        $q_nama = $request->nama;

        if (!empty($q_nama)) {
            $cuti->whereHas('karyawan', function($query){
                $query->where('nama', 'LIKE', '%'.$q_nama.'%');
            });
        }
        
        $cuti = $cuti->paginate(20);
        $skipped = ($cuti->perPage() * $cuti->currentPage()) - $cuti->perPage();

        return view('apps.admin.cuti.index')->with('cuti', $cuti)
                                                 ->with('skipped', $skipped)
                                                 ->with('q_nama', $q_nama);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $karyawan = Karyawan::orderBy('nama', 'asc')->get();
        return view('apps.admin.cuti.create')->with('karyawan', $karyawan);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $cuti = $request->all();
        Cuti::create($cuti);

        $begin = new DateTime($request->tanggal_mulai);
        $end = new DateTime($request->tanggal_selesai);

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end->modify( '+1 day' ));

        foreach ($period as $dt) {
            $kehadiran = Absensi::where('tanggal', $dt->format("Y-m-d"))
                                ->where('karyawan_id', $request->karyawan_id)->first();

            if ($kehadiran == null) {
                Absensi::create([
                    'tanggal' => $dt->format("Y-m-d"),
                    'karyawan_id' => $request->karyawan_id,
                    'istirahat' => null,
                    'jam_masuk_istirahat' => null,
                    'jam_masuk' => null,
                    'keterangan' => null,
                    'status' => 'Cuti',
                ]);
            }
        }

        Session::flash('flash_message', 'Data telah disimpan');
        return redirect()->route('admin.cuti');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Cuti $cuti)
    {
        $karyawan = Karyawan::orderBy('nama', 'asc')->get();
        return view('apps.admin.cuti.edit')->with('cuti', $cuti)
                                               ->with('karyawan', $karyawan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request)
    {
        $cuti = Cuti::findOrFail($request->id);

        $cuti->update($request->all());

        Session::flash('flash_message', 'Data telah diubah');
        return redirect()->route('admin.cuti');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $cuti = Cuti::findOrFail($request->id);
        
        $cuti->delete();
        return redirect()->back();
    }

    public function cetak(Request $request){
        $cuti = Cuti::get();

        $pdf = PDF::loadview('apps.admin.cuti.cetak',['cuti'=>$cuti]);
    	return $pdf->download('laporan-cuti.pdf');
    }
}
