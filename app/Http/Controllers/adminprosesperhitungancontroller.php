<?php

namespace App\Http\Controllers;

use App\Models\kriteriadetail;
use App\Models\pemainseleksi;
use App\Models\penilaiandetail;
use App\Models\posisiseleksi;
use App\Models\prosespenilaian;
use App\Models\tahunpenilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class adminprosesperhitungancontroller extends Controller
{
    protected $th;
    protected $k;
    protected $pemain;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::user()->tipeuser!='admin' AND Auth::user()->tipeuser!='guru'){
                return redirect()->route('dashboard')->with('status','Halaman tidak ditemukan!')->with('tipe','danger');
            }

        return $next($request);

        });
    }
    public function index (tahunpenilaian $tahunpenilaian, Request $request)
    {
        $this->th=$tahunpenilaian->id;
        $ambildatapemainseleksi=pemainseleksi::with('pemain')->where('tahunpenilaian_id',$tahunpenilaian->id)->get();
        $koleksipemain= new Collection();
        foreach($ambildatapemainseleksi as $pemain){
            $this->pemain=$pemain->id;
        // step1
        $kriteriadetail= new Collection();
        $ambildatakriteriadetail=kriteriadetail::with('kriteria')->whereIn('kriteria_id',function($query){
            $query->select('id')->from('kriteria')->where('tahunpenilaian_id',$this->th);
        })->get();
        foreach($ambildatakriteriadetail as $k){
            $this->k=$k->id;
            $prosespenilaian=new Collection();
            $nilai=0;
            $ambilprosespenilaian=prosespenilaian::where('tahunpenilaian_id',$this->th)->get();
            foreach($ambilprosespenilaian as $p){
                $ambilnilai=penilaiandetail::with('penilaian')
                ->whereIn('penilaian_id',function($query){
                    $query->select('id')->from('penilaian')->where('kriteriadetail_id',$this->k)
                    ->where('pemainseleksi_id',$this->pemain)
                    // ->where('tahunpenilaian_id',$this->th)
                    ;
                })
                ->where('prosespenilaian_id',$p->id)->first();
                $nilai=$ambilnilai?$ambilnilai->nilai:0;

                $prosespenilaian->push((object)[
                    'id'=> $p->id,
                    'nama'=> $p->nama,
                    'nilai'=>$nilai,
                ]);
            }
            $bobot=$prosespenilaian->avg('nilai')/100;
            // dd($prosespenilaian->avg('nilai'),$bobot);
            $kriteriadetail->push((object)[
                'id'=>$k->id,
                'nama'=>$k->nama?$k->nama:'Data tidak ditemukan',
                'nilai'=>$prosespenilaian,
                'avg'=>$prosespenilaian->avg('nilai'),
                'bobot'=>$bobot,
            ]);
        }

        //step2
        $posisiseleksi= new Collection();
        $ambildataposisiseleksi=posisiseleksi::with('posisipemain')->with('posisiseleksidetail')->where('tahunpenilaian_id',$tahunpenilaian->id)->get();
        foreach($ambildataposisiseleksi as $ps){
                $nilaiakhir=0;
                $posisiseleksi->push((object)[
                    'id'=>$ps->id,
                    'nama'=>$ps->posisipemain?$ps->posisipemain->nama:'Data tidak ditemukan',
                    'posisiseleksidetail'=>$ps->posisiseleksidetail,
                    'nilaiakhir'=> $nilaiakhir,
                ]);
        }


        $koleksipemain->push((object)[
            'id'=> $pemain->id,
            'nama' => $pemain->pemain?$pemain->pemain->nama:'Data tidak ditemukan',
            'kriteriadetail' => $kriteriadetail,
            'posisiseleksi' => $posisiseleksi,
        ]);
        }

        dd($koleksipemain,$ambildatapemainseleksi);
    }
}
