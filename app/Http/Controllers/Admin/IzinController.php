<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Karyawan, Izin, Absensi};
use Session;
use App\Http\Requests\Izin\{CreateRequest, UpdateRequest};
use PDF;
use DateTime;
use DateInterval;
use DatePeriod;

class IzinController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $izin = Izin::orderBy('id', 'desc');
        $q_nama = $request->nama;

        if (!empty($q_nama)) {
            $izin->whereHas('karyawan', function($query){
                $query->where('nama', 'LIKE', '%'.$q_nama.'%');
            });
        }
        
        $izin = $izin->paginate(20);
        $skipped = ($izin->perPage() * $izin->currentPage()) - $izin->perPage();

        return view('apps.admin.izin.index')->with('izin', $izin)
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
        return view('apps.admin.izin.create')->with('karyawan', $karyawan);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $izin = $request->all();
        Izin::create($izin);

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
                    'status' => 'Izin',
                ]);
            }
        }

        Session::flash('flash_message', 'Data telah disimpan');
        return redirect()->route('admin.izin');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(izin $izin)
    {
        $karyawan = Karyawan::orderBy('nama', 'asc')->get();
        return view('apps.admin.izin.edit')->with('izin', $izin)
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
        $izin = Izin::findOrFail($request->id);

        $izin->update($request->all());

        Session::flash('flash_message', 'Data telah diubah');
        return redirect()->route('admin.izin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $izin = Izin::findOrFail($request->id);
        
        $izin->delete();

        return redirect()->back();
    }

    public function cetak(Request $request){
        $izin = Izin::get();

        $pdf = PDF::loadview('apps.admin.izin.cetak',['izin'=>$izin]);
    	return $pdf->download('laporan-izin.pdf');
    }
}
