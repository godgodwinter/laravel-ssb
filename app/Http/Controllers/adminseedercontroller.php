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


    public function kriteria(Request $request){
        // dd('seeder');
        $ambiltahunpenilaian=tahunpenilaian::first();
        $ambiltahunpenilaian_id=$ambiltahunpenilaian->id;
        DB::table('kriteria')->where('tahunpenilaian_id',$ambiltahunpenilaian_id)->delete();
        // 1. insert
        $faker = Faker::create('id_ID');



        DB::table('kriteria')->insert([
            'nama' => 'Fisik',
            'kode' => 'fisik',
            'bobot' => '40',
            'tahunpenilaian_id' => $ambiltahunpenilaian_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('kriteria')->insert([
            'nama' => 'Teknik',
            'kode' => 'teknik',
            'bobot' => '50',
            'tahunpenilaian_id' => $ambiltahunpenilaian_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);


        DB::table('kriteria')->insert([
            'nama' => 'Taktik',
            'kode' => 'taktik',
            'bobot' => '10',
            'tahunpenilaian_id' => $ambiltahunpenilaian_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);


        return redirect()->back()->with('status','Seeder berhasil dimuat!')->with('tipe','success')->with('icon','fas fa-edit');
     }


    public function kriteriadetail(Request $request){
        // dd('seeder');
        $ambiltahunpenilaian=tahunpenilaian::first();
        $ambiltahunpenilaian_id=$ambiltahunpenilaian->id;
        $ambilkriteria=kriteria::where('tahunpenilaian_id',$ambiltahunpenilaian_id)->get();
        kriteriadetail::truncate();

        // 1. insert
        $faker = Faker::create('id_ID');

        foreach($ambilkriteria as $data){
            if($data->nama=='Fisik'){
                $datas=['Kecepatan','Keseimbangan','Kekuatan','Dayatahan'
                ,'Kelincahan'
                ,'Kuat dan Cepat'
                ,'Stamina'
                ,'Loncatan'
            ];
                for($i=0;$i<count($datas);$i++){

                    DB::table('kriteriadetail')->insert([
                        'nama' => $datas[$i],
                        'kriteria_id' => $data->id,
                        'tipe' => 'angka',
                        'bobot' => 0,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                }

            }elseif($data->nama=='Teknik'){
                $datas=['Mengoper','Kontrol Bola','Mengoper Jarak Jauh','Akurasi Tembakan'
                ,'Menanduk'
                ,'Merebut Bola'
                ,'Menangkap Bola'
                ,'Reflek'
            ];
                for($i=0;$i<count($datas);$i++){

                    DB::table('kriteriadetail')->insert([
                        'nama' => $datas[$i],
                        'kriteria_id' => $data->id,
                        'tipe' => 'angka',
                        'bobot' => 0,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                }

            }elseif($data->nama=='Taktik'){
                $datas=['Penempatan Posisi','Visi Bermain'
                ,'Determinasi'
                ,'Baca Permainan'
            ];
                for($i=0;$i<count($datas);$i++){

                    DB::table('kriteriadetail')->insert([
                        'nama' => $datas[$i],
                        'kriteria_id' => $data->id,
                        'tipe' => 'angka',
                        'bobot' => 0,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                }

            }

        }


        return redirect()->back()->with('status','Seeder berhasil dimuat!')->with('tipe','success')->with('icon','fas fa-edit');
     }



    public function posisi(Request $request){
        // dd('seeder');
        // 1. insert
        $faker = Faker::create('id_ID');


        posisipemain::truncate();

        DB::table('posisipemain')->insert([
            'nama' => 'Penjaga Gawang',
            'kode' => 'GK',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('posisipemain')->insert([
            'nama' => 'Pemain Bertahan',
            'kode' => 'CB',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);


        DB::table('posisipemain')->insert([
            'nama' => 'Gelandang Bertahan',
            'kode' => 'CMD',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);



        DB::table('posisipemain')->insert([
            'nama' => 'Gelandang Serang',
            'kode' => 'CMF',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);



        DB::table('posisipemain')->insert([
            'nama' => 'Sayap',
            'kode' => 'WF',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);


        DB::table('posisipemain')->insert([
            'nama' => 'Penyerang',
            'kode' => 'LMF',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);


        return redirect()->back()->with('status','Seeder berhasil dimuat!')->with('tipe','success')->with('icon','fas fa-edit');
     }
    public function hard(Request $request){
        tahunpenilaian::truncate();
        pemain::truncate();
        pelatih::truncate();
        posisipemain::truncate();
        kriteria::truncate();
        kriteriadetail::truncate();
        DB::table('users')->where('tipeuser','pemain')->delete();
        DB::table('users')->where('tipeuser','pelatih')->delete();
        // DB::table('users')->where('tipeuser','guru')->delete();
        return redirect()->back()->with('status','Hard Reset berhasil dimuat!')->with('tipe','success')->with('icon','fas fa-edit');
    }



    public function pemain(Request $request){
        // dd('seeder');
        $jmlseeder=10;
        // 1. insert data sekolah
        $faker = Faker::create('id_ID');

        // 4. input walikelas, kelas,  pengguna referensi , bidang studi , siswa

        for($i=0;$i<$jmlseeder;$i++){
            // 3. insert data siswa

            $nama=$faker->unique()->name;
            $nomerinduk=$faker->unique()->ean8;
            $users_id=DB::table('users')->insertGetId([
                'name' =>  $nama,
                'email' => $faker->unique()->email,
                'username'=>date('YmdHid').$i,
                'nomerinduk'=>$nomerinduk,
                'password' => Hash::make('123'),
                'tipeuser' => 'pemain',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);


            DB::table('pemain')->insert([
                'nama' => $nama,
                'jk' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'alamat' => $faker->unique()->address,
                'telp' => $faker->unique()->phoneNumber,
                'tgllahir' => $faker->numberBetween(1990,2020).'-0'.$faker->numberBetween(1,9).'-'.$faker->numberBetween(10,29),
                'tgldaftar' => $faker->numberBetween(1990,2020).'-0'.$faker->numberBetween(1,9).'-'.$faker->numberBetween(10,29),
                'users_id' => $users_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);



     }



        return redirect()->back()->with('status','Seeder berhasil dimuat!')->with('tipe','success')->with('icon','fas fa-edit');

    }



    public function pelatih(Request $request){
        // dd('seeder');
        $jmlseeder=10;
        // 1. insert data sekolah
        $faker = Faker::create('id_ID');

        // 4. input walikelas, kelas,  pengguna referensi , bidang studi , siswa

        for($i=0;$i<$jmlseeder;$i++){
            // 3. insert data siswa

            $nama=$faker->unique()->name;
            $nomerinduk=$faker->unique()->ean8;
            $users_id=DB::table('users')->insertGetId([
                'name' =>  $nama,
                'email' => $faker->unique()->email,
                'username'=>date('YmdHid').$i,
                'nomerinduk'=>$nomerinduk,
                'password' => Hash::make('123'),
                'tipeuser' => 'pelatih',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);


            DB::table('pelatih')->insert([
                'nama' => $nama,
                'jk' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'alamat' => $faker->unique()->address,
                'telp' => $faker->unique()->phoneNumber,
                'tgllahir' => $faker->numberBetween(1990,2020).'-0'.$faker->numberBetween(1,9).'-'.$faker->numberBetween(10,29),
                'spesialis' => $faker->randomElement(['Taktik', 'Teknik','Fisik']),
                'users_id' => $users_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);



     }



        return redirect()->back()->with('status','Seeder berhasil dimuat!')->with('tipe','success')->with('icon','fas fa-edit');

    }

}
