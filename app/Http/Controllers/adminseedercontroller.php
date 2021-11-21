<?php

namespace App\Http\Controllers;

use App\Models\kriteria;
use App\Models\kriteriadetail;
use App\Models\pelatih;
use App\Models\pemain;
use App\Models\posisipemain;
use App\Models\tahunpenilaian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class adminseedercontroller extends Controller
{

    public function tahunpenilaian(Request $request){
        // dd('seeder');
        $jmlseeder=1;
        // 1. insert dokter
        $faker = Faker::create('id_ID');

        for($i=0;$i<$jmlseeder;$i++){
            $tahun=$faker->numberBetween(2021,2040);
        $users_id=DB::table('tahunpenilaian')->insertGetId([
            'nama' => $tahun.' - '.$tahun+1,
            'status' => $faker->randomElement(['Proses', 'Selesai']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
     }
        return redirect()->back()->with('status','Seeder berhasil dimuat!')->with('tipe','success')->with('icon','fas fa-edit');
     }

    public function hard(Request $request){
        tahunpenilaian::truncate();
        pemain::truncate();
        pelatih::truncate();
        posisipemain::truncate();
        kriteria::truncate();
        kriteriadetail::truncate();
        DB::table('users')->where('tipeuser','member')->delete();
        // DB::table('users')->where('tipeuser','guru')->delete();
        return redirect()->back()->with('status','Hard Reset berhasil dimuat!')->with('tipe','success')->with('icon','fas fa-edit');
    }

}
