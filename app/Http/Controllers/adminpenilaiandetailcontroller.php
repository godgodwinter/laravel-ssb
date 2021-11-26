<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\kriteriadetail;
use App\Models\pemainseleksi;
use App\Models\penilaian;
use App\Models\penilaiandetail;
use App\Models\prosespenilaian;
use App\Models\tahunpenilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class adminpenilaiandetailcontroller extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::user()->tipeuser!='admin' ){
                return redirect()->route('dashboard')->with('status','Halaman tidak ditemukan!')->with('tipe','danger');
            }

        return $next($request);

        });
    }
    public function index(tahunpenilaian $tahunpenilaian,prosespenilaian $prosespenilaian, Request $request)
    {
        $this->th=$tahunpenilaian->id;
        #WAJIB
        $pages='pemain';
        $datapemainseleksi=pemainseleksi
        ::with('pemain')->where('tahunpenilaian_id',$tahunpenilaian->id)->get();
        // ::with('pemain')->where('tahunpenilaian_id',$tahunpenilaian->id)->paginate(Fungsi::paginationjml());
        // dd($datas);
        $datakriteriadetail=kriteriadetail::whereIn('kriteria_id',function($query){
                $query->select('id')->from('kriteria')->where('tahunpenilaian_id',$this->th);
        })
        ->orderBy('kriteria_id','asc')
        ->get();
        // dd($datapemainseleksi,$datakriteriadetail);


        $datas= new Collection();
        // $detaildatas= new Collection();
        // dd($datas,$detaildatas);

        foreach($datapemainseleksi as $data){
            $detaildatas= new Collection();
            foreach($datakriteriadetail as $item){

                $jmldatapenilaian=penilaian::where('pemainseleksi_id',$data->id)->where('kriteriadetail_id',$item->id)->count();
                if($jmldatapenilaian>0){
                    $nilai=null;

        // dd($datas,$detaildatas,$item);
                    $ambildatapenilaian=penilaian::where('pemainseleksi_id',$data->id)->where('kriteriadetail_id',$item->id)->first();
                    $periksanilai=penilaiandetail::where('penilaian_id',$ambildatapenilaian->id)->where('prosespenilaian_id',$prosespenilaian->id)->count();
                    if($periksanilai>0){
                        $ambilnilai=penilaiandetail::where('penilaian_id',$ambildatapenilaian->id)->where('prosespenilaian_id',$prosespenilaian->id)->first();
                        $nilai=$ambilnilai->nilai;

                    }

                    $detaildatas->push((object)[
                        'id'=> $item->id,
                        'nama'=> $item->nama,
                        'nilai'=>$nilai,
                    ]);
                    // dd($item->nama);

                }else{

                    $detaildatas->push((object)[
                        'id'=> $item->id,
                        'nama'=> $item->nama,
                        'nilai'=>null,
                    ]);
                    // $detaildatas=null;
                }
            }

            $datas->push((object)[
                'id'=> $data->id,
                'nama'=> $data->pemain!=null?$data->pemain->nama:'Data tidak ditemukan',
                'kriteriadetail'=>$detaildatas?$detaildatas:null,
            ]);
        }
        // dd($datas,$prosespenilaian);
        $datasprosespenilaian=prosespenilaian::where('tahunpenilaian_id',$tahunpenilaian->id)->get();

        return view('pages.admin.penilaiandetail.index',compact('datas','request','pages','tahunpenilaian','datakriteriadetail','prosespenilaian','datasprosespenilaian'));
    }
}
