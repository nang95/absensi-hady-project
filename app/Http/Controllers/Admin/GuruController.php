<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Jabatan, Karyawan, Role, User};
use Illuminate\Support\Facades\Hash;
use Session;
use App\Http\Requests\Karyawan\{CreateRequest, UpdateRequest};

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function index(Request $request)
    {
        $guru = Karyawan::orderBy('nama', 'asc');
        $q_nama = $request->q_nama;

        if (!empty($q_nama)) {
            $guru->where('nama', 'LIKE', '%'.$q_nama.'%');
        }
        
        $guru = $guru->paginate(20);
        $skipped = ($guru->perPage() * $guru->currentPage()) - $guru->perPage();

        return view('apps.admin.guru.index')->with('guru', $guru)
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
        return view('apps.admin.guru.create')->with('jabatan', $jabatan);
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
        return redirect()->route('admin.guru');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Karyawan $guru)
    {
        $jabatan = Jabatan::orderBy('nama', 'asc')->get();
        return view('apps.admin.guru.edit')->with('guru', $guru)
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
        $guru = Karyawan::findOrFail($request->id);
        $guru->update($request->all());

        $user = User::findOrFail($guru->user_id);
        $user->update([
            'email' => $request->email
        ]);
    
        Session::flash('flash_message', 'Data telah diubah');
        return redirect()->route('admin.guru');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $guru = Karyawan::findOrFail($request->id);
        
        $guru->delete();

        return redirect()->back();
    }
}
