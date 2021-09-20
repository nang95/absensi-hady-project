<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Pengajuan, Karyawan};
use App\Http\Requests\PengajuanCuti\{CreateRequest, UpdateRequest};
use Session;

class PengajuanCutiController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $karyawan = Karyawan::where('user_id', auth()->user()->id)->first();
        $pengajuan_cuti = Pengajuan::where('jenis_pengajuan', 'Cuti')
                                    ->where('karyawan_id', $karyawan->id)
                                    ->orderBy('id', 'desc');
        
        $pengajuan_cuti = $pengajuan_cuti->paginate(20);
        $skipped = ($pengajuan_cuti->perPage() * $pengajuan_cuti->currentPage()) - $pengajuan_cuti->perPage();

        return view('apps.pegawai.pengajuan-cuti.index')->with('pengajuan_cuti', $pengajuan_cuti)
                                                        ->with('skipped', $skipped);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $karyawan = Karyawan::where('user_id', auth()->user()->id)->first();
        return view('apps.pegawai.pengajuan-cuti.create')->with('karyawan', $karyawan);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $data = $request->all();

        Pengajuan::create([
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'karyawan_id' => $request->karyawan_id,
            'jenis_pengajuan' => 'Cuti',
        ]);

        Session::flash('flash_message', 'Data telah disimpan');
        return redirect()->route('pegawai.pengajuan-cuti');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengajuan $pengajuan)
    {
        $karyawan = Karyawan::where('user_id', auth()->user()->id)->first();
        return view('apps.pegawai.pengajuan-cuti.edit')->with('karyawan', $karyawan)
                                               ->with('pengajuan', $pengajuan);
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
        $data = $request->all();
        $pengajuan_cuti = Pengajuan::findOrFail($request->id);

        $pengajuan_cuti->update([
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'karyawan_id' => $request->karyawan_id,
            'jenis_pengajuan' => 'Cuti',
        ]);

        Session::flash('flash_message', 'Data telah disimpan');
        return redirect()->route('pegawai.pengajuan-cuti');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $karyawan = Karyawan::findOrFail($request->id);
        
        $karyawan->delete();

        return redirect()->back();
    }

}
