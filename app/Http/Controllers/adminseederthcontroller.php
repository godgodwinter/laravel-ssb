<?php

namespace App\Http\Controllers;

use App\Models\kriteria;
use App\Models\kriteriadetail;
use App\Models\pemain;
use App\Models\pemainseleksi;
use App\Models\penilaian;
use App\Models\penilaiandetail;
use App\Models\posisipemain;
use App\Models\posisiseleksi;
use App\Models\posisiseleksidetail;
use App\Models\prosespenilaian;
use App\Models\tahunpenilaian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class adminseederthcontroller extends Controller
{

    protected $th;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::user()->tipeuser!='admin'){
                return redirect()->route('dashboard')->with('status','Halaman tidak ditemukan!')->with('tipe','danger');
            }

        return $next($request);

        });
    }


    public function kriteria(tahunpenilaian $tahunpenilaian,Request $request){
        // dd('seeder');
        $ambiltahunpenilaian_id=$tahunpenilaian->id;
        DB::table('kriteria')->where('tahunpenilaian_id',$tahunpenilaian->id)->delete();
        DB::table('kriteriadetail')->where('kriteria_id',$tahunpenilaian->id)->delete();
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


        $ambilkriteria=kriteria::where('tahunpenilaian_id',$ambiltahunpenilaian_id)->get();

        // 1. insert
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

     public function pemain(tahunpenilaian $tahunpenilaian,Request $request){
        // dd('seeder');
        $ambiltahunpenilaian_id=$tahunpenilaian->id;
        DB::table('pemainseleksi')->where('tahunpenilaian_id',$tahunpenilaian->id)->delete();

        // 1. insert
        $faker = Faker::create('id_ID');

        $ambildata=pemain::get();

        // 1. insert
        foreach($ambildata as $data){

                    DB::table('pemainseleksi')->insert([
                        'pemain_id' => $data->id,
                        'tahunpenilaian_id' => $ambiltahunpenilaian_id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);



        }


        return redirect()->back()->with('status','Seeder berhasil dimuat!')->with('tipe','success')->with('icon','fas fa-edit');
     }

    public function posisi(tahunpenilaian $tahunpenilaian,Request $request){
        // dd('seeder');
        $ambiltahunpenilaian_id=$tahunpenilaian->id;
        DB::table('posisiseleksi')->where('tahunpenilaian_id',$tahunpenilaian->id)->delete();

        // 1. insert
        $faker = Faker::create('id_ID');

        $ambildata=posisipemain::get();

        // 1. insert
        foreach($ambildata as $data){

                    DB::table('posisiseleksi')->insert([
                        'posisipemain_id' => $data->id,
                        'tahunpenilaian_id' => $ambiltahunpenilaian_id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);



        }


        return redirect()->back()->with('status','Seeder berhasil dimuat!')->with('tipe','success')->with('icon','fas fa-edit');
     }

     public function prosespenilaian(tahunpenilaian $tahunpenilaian,Request $request){
         // dd('seeder');
         $ambiltahunpenilaian_id=$tahunpenilaian->id;
         DB::table('prosespenilaian')->where('tahunpenilaian_id',$tahunpenilaian->id)->delete();

         // 1. insert
         $faker = Faker::create('id_ID');


         // 1. insert

         for($i=0;$i<3;$i++){
                      DB::table('prosespenilaian')->insert([
                         'nama' => 'Penilaian '.$i+1,
                         'tgl' => Carbon::now(),
                         'tahunpenilaian_id' => $ambiltahunpenilaian_id,
                         'created_at' => Carbon::now(),
                         'updated_at' => Carbon::now()
                     ]);
        }



         return redirect()->back()->with('status','Seeder berhasil dimuat!')->with('tipe','success')->with('icon','fas fa-edit');
      }


     public function randomnilaipemain(tahunpenilaian $tahunpenilaian,Request $request){
        $faker = Faker::create('id_ID');
        $ambiltahunpenilaian_id=$tahunpenilaian->id;
        $this->th=$ambiltahunpenilaian_id;

        penilaiandetail::
        whereIn('prosespenilaian_id',function($query){
            $query->select('id')->from('prosespenilaian')->where('tahunpenilaian_id',$this->th);
        })
        ->delete();

        penilaian::whereIn('pemainseleksi_id',function($query){
            $query->select('id')->from('pemainseleksi')->where('tahunpenilaian_id',$this->th);
        })
        ->delete();


        $ambildatapemainseleksi=pemainseleksi::where('tahunpenilaian_id',$tahunpenilaian->id)->get();
        $ambildatakriteriadetail=kriteriadetail::whereIn('kriteria_id',function($query){
            $query->select('id')->from('kriteria')->where('tahunpenilaian_id',$this->th);
        })->get();

        foreach($ambildatapemainseleksi as $pemain){
            $pemainseleksi_id=$pemain->id;
            foreach($ambildatakriteriadetail as $kriteriadetail){
                $kriteriadetail_id=$kriteriadetail->id;
                //insert penilaian dan get id
                      $penilaian_id=DB::table('penilaian')->insertGetId([
                        'pemainseleksi_id' => $pemainseleksi_id,
                        'kriteriadetail_id' => $kriteriadetail_id,
                        'nilai' => 0,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    $ambildataprosespenilaian=prosespenilaian::where('tahunpenilaian_id',$this->th)->get();
                    foreach($ambildataprosespenilaian as $prosespenilaian){
                        $prosespenilaian_id=$prosespenilaian->id;

                        DB::table('penilaiandetail')->insertGetId([
                            'prosespenilaian_id' => $prosespenilaian_id,
                            'penilaian_id' => $penilaian_id,
                            'nilai' => $faker->numberBetween(50,100),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);

                    }
            }
        }

        return redirect()->back()->with('status','Seeder berhasil dimuat!')->with('tipe','success')->with('icon','fas fa-edit');

    }
     public function parameter(tahunpenilaian $tahunpenilaian,Request $request){
        // dd('seeder');
        $ambiltahunpenilaian_id=$tahunpenilaian->id;
        $this->th=$ambiltahunpenilaian_id;
        posisiseleksidetail::whereIn('posisiseleksi_id',function($query){
            $query->select('id')->from('posisiseleksi')->where('tahunpenilaian_id',$this->th);
        })
        ->delete();

        // 1. insert
        $faker = Faker::create('id_ID');


        // 1. insert
        $dataposisi=['Penjaga Gawang','Pemain Bertahan','Gelandang Bertahan','Gelandang Serang','Sayap','Penyerang'];
        foreach($dataposisi as $pos){
            $getid=posisipemain::where('nama',$pos)->first();
        if($getid){

            $getposseleksiid=posisiseleksi::where('posisipemain_id',$getid->id)->where('tahunpenilaian_id',$tahunpenilaian->id)->first();
            $posisiseleksi_id=$getposseleksiid->id;
                // dd($pos,$getid->id,$posisiseleksi_id);
                // 1.penjaga gawang
            if($pos=='Penjaga Gawang'){

            $datasubkriteria=['Keseimbangan','Kelincahan','Loncatan','Mengoper Jarak Jauh','Menangkap Bola','Reflek','Penempatan Posisi','Visi Bermain','Baca Permainan'];
                foreach($datasubkriteria as $datasub){
                    $ambilidkriteriadetail=kriteriadetail::where('nama',$datasub)
                    ->whereIn('kriteria_id',function($query){
                        $query->select('id')->from('kriteria')->where('tahunpenilaian_id',$this->th);
                    })
                    ->first();

                if($ambilidkriteriadetail){
                    $kriteriadetail_id=$ambilidkriteriadetail->id;
                    DB::table('posisiseleksidetail')->insert([
                        'kriteriadetail_id' => $kriteriadetail_id,
                        'posisiseleksi_id' => $posisiseleksi_id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
                }

            }elseif($pos=='Pemain Bertahan'){

            $datasubkriteria=['Keseimbangan','Dayatahan','Kekuatan','Mengoper','Kontrol Bola','Merebut Bola','Mengoper Jarak Jauh','Penempatan Posisi','Baca Permainan'];
            foreach($datasubkriteria as $datasub){
                $ambilidkriteriadetail=kriteriadetail::where('nama',$datasub)
                ->whereIn('kriteria_id',function($query){
                    $query->select('id')->from('kriteria')->where('tahunpenilaian_id',$this->th);
                })
                ->first();

                if($ambilidkriteriadetail){
                $kriteriadetail_id=$ambilidkriteriadetail->id;
                DB::table('posisiseleksidetail')->insert([
                    'kriteriadetail_id' => $kriteriadetail_id,
                    'posisiseleksi_id' => $posisiseleksi_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                }
            }


        }elseif($pos=='Gelandang Bertahan'){

            $datasubkriteria=['Dayatahan','Kelincahan','Stamina','Mengoper','Kontrol Bola','Merebut Bola','Visi Bermain','Baca Permainan'];
            foreach($datasubkriteria as $datasub){
                $ambilidkriteriadetail=kriteriadetail::where('nama',$datasub)
                ->whereIn('kriteria_id',function($query){
                    $query->select('id')->from('kriteria')->where('tahunpenilaian_id',$this->th);
                })
                ->first();

                if($ambilidkriteriadetail){
                $kriteriadetail_id=$ambilidkriteriadetail->id;
                DB::table('posisiseleksidetail')->insert([
                    'kriteriadetail_id' => $kriteriadetail_id,
                    'posisiseleksi_id' => $posisiseleksi_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                }
            }


        }elseif($pos=='Gelandang Serang'){

            $datasubkriteria=['Kelincahan','Keseimbangan','Stamina','Mengoper','Akurasi Tembakan','Kontrol Bola','Visi Bermain','Determinasi'];
            foreach($datasubkriteria as $datasub){
                $ambilidkriteriadetail=kriteriadetail::where('nama',$datasub)
                ->whereIn('kriteria_id',function($query){
                    $query->select('id')->from('kriteria')->where('tahunpenilaian_id',$this->th);
                })
                ->first();

                if($ambilidkriteriadetail){
                $kriteriadetail_id=$ambilidkriteriadetail->id;
                DB::table('posisiseleksidetail')->insert([
                    'kriteriadetail_id' => $kriteriadetail_id,
                    'posisiseleksi_id' => $posisiseleksi_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                }
            }


        }elseif($pos=='Sayap'){

            $datasubkriteria=['Kecepatan','Kelincahan','Stamina','Mengoper','Kontrol Bola','Akurasi Tembakan','Penempatan Posisi'];
            foreach($datasubkriteria as $datasub){
                $ambilidkriteriadetail=kriteriadetail::where('nama',$datasub)
                ->whereIn('kriteria_id',function($query){
                    $query->select('id')->from('kriteria')->where('tahunpenilaian_id',$this->th);
                })
                ->first();

                if($ambilidkriteriadetail){
                $kriteriadetail_id=$ambilidkriteriadetail->id;
                DB::table('posisiseleksidetail')->insert([
                    'kriteriadetail_id' => $kriteriadetail_id,
                    'posisiseleksi_id' => $posisiseleksi_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                }
            }


        }elseif($pos=='Penyerang'){

            $datasubkriteria=['Kuat dan Cepat','Stamina','Loncatan','Kekuatan','Kontrol Bola','Akurasi Tembakan','Menanduk','Penempatan Posisi','Determinasi'];
            foreach($datasubkriteria as $datasub){
                $ambilidkriteriadetail=kriteriadetail::where('nama',$datasub)
                ->whereIn('kriteria_id',function($query){
                    $query->select('id')->from('kriteria')->where('tahunpenilaian_id',$this->th);
                })
                ->first();

                if($ambilidkriteriadetail){
                $kriteriadetail_id=$ambilidkriteriadetail->id;
                DB::table('posisiseleksidetail')->insert([
                    'kriteriadetail_id' => $kriteriadetail_id,
                    'posisiseleksi_id' => $posisiseleksi_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                }
            }

            }
        }

        }





        return redirect()->back()->with('status','Seeder berhasil dimuat!')->with('tipe','success')->with('icon','fas fa-edit');
     }


}
