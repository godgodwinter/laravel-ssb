<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\kriteria;
use App\Models\kriteriadetail;
use App\Models\pemainseleksi;
use App\Models\penilaianhasil;
use App\Models\posisiseleksi;
use App\Models\posisiseleksidetail;
use App\Models\prosespenilaian;
use App\Models\tahunpenilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class pelatihtahunpenilaiancontroller extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::user()->tipeuser!='pelatih'){
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

        return view('pages.pelatih.tahunpenilaian.index',compact('datas','request','pages'));
    }


    public function detail(tahunpenilaian $tahunpenilaian,Request $request)
    {
        $this->th=$tahunpenilaian->id;
        #WAJIB
        $pages='tahunpenilaian';
        $datas=tahunpenilaian
        ::paginate(Fungsi::paginationjml());

        $kriteriadetail=null;

        //ambiljumlah
        $jmlkriteria=kriteria::where('tahunpenilaian_id',$tahunpenilaian->id)->count();
        $jmlposisi=posisiseleksi::where('tahunpenilaian_id',$tahunpenilaian->id)->count();
        $jmlpemain=pemainseleksi::where('tahunpenilaian_id',$tahunpenilaian->id)->count();
        $jmprosespenilaian=prosespenilaian::where('tahunpenilaian_id',$tahunpenilaian->id)->count();

        //ambilkode kriteria
        $ambilkriteria=kriteria::where('tahunpenilaian_id',$tahunpenilaian->id)->get();
        $jmlkriteriadetail=0;
        foreach($ambilkriteria as $data){
            $jmlkriteriadetail+=kriteriadetail::where('kriteria_id',$data->id)->count();
        }


        $dataakhir= new Collection();
        $ambildataposisi=posisiseleksi::with('posisiseleksidetail')->where('tahunpenilaian_id',$tahunpenilaian->id)->get();

        foreach($ambildataposisi as $data){
            // $fisik=[];
            // $teknik=[];
            // $taktik=[];
            $datakrit= new Collection();
            $ambilkrit=kriteria::where('tahunpenilaian_id',$tahunpenilaian->id)->get();
            foreach($ambilkrit as $item){
                $this->item=$item->id;
                $posisiseleksidetail= new Collection();
                $ambilposisiseleksidetail=posisiseleksidetail::with('kriteriadetail')
                ->where('posisiseleksi_id',$data->id)
                ->whereIn('kriteriadetail_id',function($query) {
                    $query->select('id')->from('kriteriadetail')->where('deleted_at',null)->where('kriteria_id',$this->item);
                })
                ->get();
                foreach($ambilposisiseleksidetail as $posdet){
                    if($posdet->kriteriadetail!=null){
                            $posisiseleksidetail->push((object)[
                               'id' => $posdet->id,
                               'nama' => $posdet->kriteriadetail!=null?$posdet->kriteriadetail->nama:'Data tidak ditemukan',
                           ]);

                    }
                }

                $datakrit->push((object)[
                    'id' => $item->id,
                    'nama' => $item->nama!=null?$item->nama:'Data tidak ditemukan',
                    'posisiseleksidetail' => $posisiseleksidetail,
                ]);
            }
            // dd($datakrit);


            // dd($ambilfisik,$kodefisik_id,$fisik,$taktik,$teknik);
            // dd($ambilfisik,$kodefisik_id,$datafisik,$datataktik,$datateknik);


             $dataakhir->push((object)[
                'id' => $data->id,
                'nama' => $data->posisipemain!=null?$data->posisipemain->nama:'Data tidak ditemukan',
                'kriteria' => $datakrit,
            ]);

        }


        $kriteriadetail=kriteriadetail::select('*')
        ->whereIn('kriteria_id',function($query) {
            $query->select('id')->from('kriteria')->where('deleted_at',null)->where('tahunpenilaian_id',$this->th);
        })
        ->get();

        $datakriteria=kriteria::where('tahunpenilaian_id',$tahunpenilaian->id)->get();
        // dd($kriteriadetail,$dataakhir);

        return view('pages.admin.tahunpenilaiandetail.index',compact('datas','request','pages','tahunpenilaian','jmlkriteria','jmlkriteriadetail','dataakhir','jmlposisi','jmlpemain','kriteriadetail','datakriteria','jmprosespenilaian'));
    }

    public function grafikhasilpenilaian(tahunpenilaian $tahunpenilaian,Request $request)
    {

        $this->th=$tahunpenilaian->id;
        // dd($blnthn);


        $ambildatapemainseleksi=pemainseleksi::with('pemain')->where('tahunpenilaian_id',$tahunpenilaian->id)->get();
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
        return view('pages.pelatih.tahunpenilaian.grafik',compact('datas','tahunpenilaian','hasil2','pages'));
    }

}
