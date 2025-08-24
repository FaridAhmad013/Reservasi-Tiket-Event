<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!User::where('email', 'admin@gmail.com')->first()){
            // id, username, password, email, nama_depan, nama_belakang, status, role_id,
            User::create([
                'username' => 'admin',
                'password' => bcrypt('rahasia'),
                'email' => 'admin@gmail.com',
                'nama_depan' => 'Admin',
                'nama_belakang' => '',
                'status' => '1',
                'role_id' => '1'
            ]);
        }
        if(!User::where('email', 'admin_farid@gmail.com')->first()){
            // id, username, password, email, nama_depan, nama_belakang, status, role_id,
            User::create([
                'username' => 'admin_farid',
                'password' => bcrypt('rahasia'),
                'email' => 'admin_farid@gmail.com',
                'nama_depan' => 'Admin',
                'nama_belakang' => 'Farid',
                'status' => '1',
                'role_id' => '1'
            ]);
        }
        if(!User::where('email', 'admin_roofi@gmail.com')->first()){
            // id, username, password, email, nama_depan, nama_belakang, status, role_id,
            User::create([
                'username' => 'admin_roofi',
                'password' => bcrypt('rahasia'),
                'email' => 'admin_roofi@gmail.com',
                'nama_depan' => 'Admin',
                'nama_belakang' => 'Roofi',
                'status' => '1',
                'role_id' => '1'
            ]);
        }
        if(!User::where('email', 'admin_alif@gmail.com')->first()){
            // id, username, password, email, nama_depan, nama_belakang, status, role_id,
            User::create([
                'username' => 'admin_alif',
                'password' => bcrypt('rahasia'),
                'email' => 'admin_alif@gmail.com',
                'nama_depan' => 'Admin',
                'nama_belakang' => 'Alif',
                'status' => '1',
                'role_id' => '1'
            ]);
        }
    }
}
