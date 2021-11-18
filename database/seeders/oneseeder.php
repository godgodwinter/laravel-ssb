<?php

namespace Database\Seeders;

use App\Models\kategori;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class oneseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //ADMIN SEEDER
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'tipeuser' => 'admin',
            'nomerinduk' => '1',
            'username' => 'admin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);


          //settings SEEDER
        DB::table('settings')->insert([
            'app_nama' => 'SSB Tulusrejo FC',
            'app_namapendek' => 'SSB',
            'paginationjml' => '10',
            'lembaga_nama' => 'SSB Tulusrejo FC',
            'lembaga_jalan' => 'Jl. Raya Kromengan No. 11, Kec. Kromengan, Kab. Malang',
            'lembaga_telp' => '0341-123456',
            'lembaga_kota' => 'Malang',
            'lembaga_logo' => 'assets/upload/logo.png',
            'sekolahttd' => 'Nama Kepala Sekolah M.Pd',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
         ]);





    }
}
