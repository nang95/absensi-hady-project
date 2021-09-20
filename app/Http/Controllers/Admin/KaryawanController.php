<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Jabatan, Karyawan, Role, User};
use Illuminate\Support\Facades\Hash;
use Session;
use App\Http\Requests\Karyawan\{CreateRequest, UpdateRequest};

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function index(Request $request)
    {
        $karyawan = Karyawan::orderBy('nama', 'asc');
        $q_nama = $request->q_nama;

        if (!empty($q_nama)) {
            $karyawan->where('nama', 'LIKE', '%'.$q_nama.'%');
        }
        
        $karyawan = $karyawan->paginate(20);
        $skipped = ($karyawan->perPage() * $karyawan->currentPage()) - $karyawan->perPage();

        return view('apps.admin.karyawan.index')->with('karyawan', $karyawan)
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
        $jabatan = Jabatan::orderBy('nama', 'asc')->get();
        return view('apps.admin.karyawan.create')->with('jabatan', $jabatan);
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

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $data['user_id'] = $user->id;
        
        Karyawan::create($data);

        $user = User::findOrFail($user->id);
 
        // get Roles to attach admin roles
        $role = Role::where('name', 'pegawai')->first();

        // attach & detach
        $user->roles()->attach($role->id);

        Session::flash('flash_message', 'Data telah disimpan');
        return redirect()->route('admin.karyawan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Karyawan $karyawan)
    {
        $jabatan = Jabatan::orderBy('nama', 'asc')->get();
        return view('apps.admin.karyawan.edit')->with('karyawan', $karyawan)
                                               ->with('jabatan', $jabatan);
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
        $karyawan = Karyawan::findOrFail($request->id);
        $karyawan->update($request->all());

        $user = User::findOrFail($karyawan->user_id);
        $user->update([
            'email' => $request->email
        ]);
    
        Session::flash('flash_message', 'Data telah diubah');
        return redirect()->route('admin.karyawan');
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
