<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Role};
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin_role = Role::create([
            'name' => 'admin'
        ]);

        $karyawan_role = Role::create([
            'name' => 'pegawai'
        ]);

        $admin = User::create([
            'name' => 'Jhon Doe',
            'email' => 'jhon_doe@gmail.com',
            'password' => Hash::make('password')
        ]);

        $rudy = User::create([
            'name' => 'Rudy',
            'email' => 'rudy@gmail.com',
            'password' => Hash::make('password')
        ]);

        $admin = User::findOrFail($admin->id);
        $pegawai = User::findOrFail($rudy->id);
 
        // get Roles to attach admin roles
        $role_admin = Role::where('name', 'admin')->first();
        // get Roles to attach pegawai roles
        $role_pegawai = Role::where('name', 'pegawai')->first();

        // attach & detach
        $admin->roles()->detach($role_admin->id);
        $admin->roles()->attach($role_admin->id);
        
        $pegawai->roles()->detach($role_pegawai->id);
        $pegawai->roles()->attach($role_pegawai->id);
    }
}
