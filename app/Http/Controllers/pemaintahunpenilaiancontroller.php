<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\pemain;
use App\Models\pemainseleksi;
use App\Models\penilaianhasil;
use App\Models\posisiseleksi;
use App\Models\tahunpenilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class pemaintahunpenilaiancontroller extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::user()->tipeuser!='pemain'){
                return redirect()->route('dashboard')->with('status','Halaman tidak ditemukan!')->with('tipe','danger');
            }

        return $next($request);

        });
    }
    public function index(Request $request)
    {
        #WAJIB
        $pages='tahunpenilaian';
        $datas=tahunpenilaian
        ::paginate(Fungsi::paginationjml());
        // dd($datas);

        return view('pages.pemain.tahunpenilaian.index',compact('datas','request','pages'));
    }

    public function grafikhasilpenilaian(tahunpenilaian $tahunpenilaian,Request $request)
    {
        $ambildatapemain=pemain::where('users_id',Auth::user()->id)->first();
        $pemain_id=$ambildatapemain->id;

        $this->th=$tahunpenilaian->id;
        // dd($blnthn);


        $ambildatapemainseleksi=pemainseleksi::with('pemain')->where('tahunpenilaian_id',$tahunpenilaian->id)->where('pemain_id',$pemain_id)->get();
        $hasil= new Collection();
        foreach($ambildatapemainseleksi as $pemain){
            $posisiterbaik= new Collection();
            $ambildatahasil=penilaianhasil::with('posisiseleksi')->where('pemainseleksi_id',$pemain->id)->skip(0)->take($tahunpenilaian->jml)->orderBy('total','desc')->get();
            foreach($ambildatahasil as $h){
                $posisiterbaik->push((object)[
                    'id' => $h->id,
                    // 'nama' => $pemain->pemain!=null?$pemain->pemain->nama:'Data tidak ditemukan',
                    'nama' => $h->posisiseleksi->posisipemain->nama,
                    'total' => $h->total,
                ]);

            }

            $hasil->push((object)[
                'id' => $pemain->id,
                'nama' => $pemain->pemain!=null?$pemain->pemain->nama:'Data tidak ditemukan',
                'posisiterbaik' => $posisiterbaik,
            ]);
        }

        $datas=$hasil;


        $ambildataposisiseleksi=posisiseleksi::with('posisipemain')->with('posisiseleksidetail')->where('tahunpenilaian_id',$tahunpenilaian->id)->get();

        $hasil2= new Collection();
        foreach($ambildataposisiseleksi as $item){

            $pemainterbaik= new Collection();
            $ambildatahasil=penilaianhasil::with('pemainseleksi')->where('posisiseleksi_id',$item->id)->skip(0)->take($tahunpenilaian->jml)->orderBy('total','desc')->get();
            foreach($ambildatahasil as $h){
                $pemainterbaik->push((object)[
                    'id' => $h->id,
                    // 'nama' => $pemain->pemain!=null?$pemain->pemain->nama:'Data tidak ditemukan',
                    'nama' => $h->pemainseleksi->pemain->nama,
                    'total' => $h->total,
                ]);

            }

            $hasil2->push((object)[
                'id' => $item->id,
                'nama' => $item->posisipemain!=null?$item->posisipemain->nama:'Data tidak ditemukan',
                'pemainterbaik' => $pemainterbaik,
            ]);
        }
        $pages='tahunpenilaian';
        return view('pages.pemain.tahunpenilaian.grafik',compact('datas','tahunpenilaian','hasil2','pages'));
    }
}
