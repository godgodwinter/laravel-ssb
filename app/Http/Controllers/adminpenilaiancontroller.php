<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\kriteria;
use App\Models\kriteriadetail;
use App\Models\pemain;
use App\Models\pemainseleksi;
use App\Models\penilaian;
use App\Models\penilaiandetail;
use App\Models\prosespenilaian;
use App\Models\tahunpenilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class adminpenilaiancontroller extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::user()->tipeuser!='admin' AND Auth::user()->tipeuser!='pelatih'){
                return redirect()->route('dashboard')->with('status','Halaman tidak ditemukan!')->with('tipe','danger');
            }

        return $next($request);

        });
    }

    public function penilaianpemain (tahunpenilaian $tahunpenilaian, Request $request)
    {
        // dd($tahunpenilaian);

            #WAJIB
        $pages='pemain';
        $datas=pemainseleksi
        ::with('pemain')->where('tahunpenilaian_id',$tahunpenilaian->id)->paginate(Fungsi::paginationjml());
        // dd($datas);
        $prosespenilaian=prosespenilaian::where('tahunpenilaian_id',$tahunpenilaian->id)->get();

        return view('pages.admin.prosespenilaian.pemain',compact('datas','request','pages','prosespenilaian','tahunpenilaian'));
    }
    public function penilaianpemaininput(tahunpenilaian $tahunpenilaian,pemainseleksi $pemain,prosespenilaian $prosespenilaian, Request $request){

        $pages='tahunpenilaian';
        // dd($pemain->pemain_id);
        $id=pemain::where('id',$pemain->pemain_id)->first();
        $prosesid=$prosespenilaian;
        $prosespenilaian=prosespenilaian::where('tahunpenilaian_id',$tahunpenilaian->id)->get();
        // dd($id);

        return view('pages.admin.prosespenilaian.inputpenilaianpemain',compact('id','request','pages','tahunpenilaian','prosespenilaian','prosesid','pemain'));
    }
    public function penilaianpemaininputstore(tahunpenilaian $tahunpenilaian,pemainseleksi $pemain,prosespenilaian $prosespenilaian, Request $request){
        //proses input penilaian pemain
        // dd($tahunpenilaian,$pemain,$prosespenilaian);
        // dd($request);
        $datakriteria=kriteria::where('tahunpenilaian_id',$tahunpenilaian->id)->get();
        foreach($datakriteria as $kriteria){
            $datakriteriadetail=kriteriadetail::where('kriteria_id',$kriteria->id)->get();
            foreach($datakriteriadetail as $dkd){
                // dd($request[$dkd->id]);
                if($request[$dkd->id]!=0){
                    $getpenilaian_id=penilaian::where('pemainseleksi_id',$pemain->id)->where('kriteriadetail_id',$dkd->id)->first();
                    // dd($getpenilaian_id,$pemain->id,$dkd->id);
                    $periksa=penilaiandetail::where('prosespenilaian_id',$prosespenilaian->id)->where('penilaian_id',$getpenilaian_id)->count();
                    // dd($periksa);
                    if($periksa>0){
                        //update
                            penilaiandetail::where('penilaian_id',$getpenilaian_id)
                            ->where('prosespenilaian_id',$prosespenilaian->id)
                            ->update([
                                'nilai'     =>   $request[$dkd->id],
                            'updated_at'=>date("Y-m-d H:i:s")
                            ]);

                    }else{
                        // insert
                        DB::table('penilaiandetail')->insert(
                            array(
                                    'nilai'     =>   $request[$dkd->id],
                                    'penilaian_id'     =>   $getpenilaian_id,
                                    'prosespenilaian_id'     =>   $prosespenilaian->id,
                                'created_at'=>date("Y-m-d H:i:s"),
                                'updated_at'=>date("Y-m-d H:i:s")
                            ));
                    }
                }
            }
        }

        return redirect()->back()->with('status','Data berhasil tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');

    }

    public function prosespenilaian (tahunpenilaian $tahunpenilaian, Request $request)
    {

            #WAJIB
            $pages='tahunpenilaian';
            $datas=prosespenilaian::where('tahunpenilaian_id',$tahunpenilaian->id)
            ->paginate(Fungsi::paginationjml());
            // dd($datas);

            return view('pages.admin.prosespenilaian.index',compact('datas','request','pages','tahunpenilaian'));
    }

    public function create(tahunpenilaian $tahunpenilaian)
    {
        $pages='pemainseleksi';

        return view('pages.admin.prosespenilaian.create',compact('pages','tahunpenilaian'));
    }


    public function store(tahunpenilaian $tahunpenilaian,Request $request)
    {

            $request->validate([
                'nama'=>'required',

            ],
            [
                'nama.nama'=>'Nama harus diisi',
            ]);




            $data_id=DB::table('prosespenilaian')->insertGetId(
                array(
                    'nama'     =>   $request->nama,
                    'tgl'     =>   $request->tgl,
                    'tahunpenilaian_id'     =>   $tahunpenilaian->id,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));






    return redirect()->route('prosespenilaian',$tahunpenilaian->id)->with('status','Data berhasil tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');

    }

    public function edit(tahunpenilaian $tahunpenilaian,prosespenilaian $id)
    {
        $pages='tahunpenilaian';

        return view('pages.admin.prosespenilaian.edit',compact('pages','id','tahunpenilaian'));
    }
    public function update(tahunpenilaian $tahunpenilaian,prosespenilaian $id,Request $request)
    {


        if($request->nama!==$id->nama){

            $request->validate([
                'nama' => "required",
            ],
            [
            ]);
        }


        $request->validate([
            'nama'=>'required',
            // 'harga'=>'required|integer|min:1',

        ],
        [
            'nama.nama'=>'nama harus diisi',
        ]);


        prosespenilaian::where('id',$id->id)
        ->update([
            'nama'     =>   $request->nama,
            'tgl'     =>   $request->tgl,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);


    return redirect()->route('prosespenilaian',$tahunpenilaian->id)->with('status','Data berhasil diubah!')->with('tipe','success')->with('icon','fas fa-feather');
    }
    public function destroy(tahunpenilaian $tahunpenilaian,prosespenilaian $id){

        prosespenilaian::destroy($id->id);
        return redirect()->route('prosespenilaian',$tahunpenilaian->id)->with('status','Data berhasil dihapus!')->with('tipe','warning')->with('icon','fas fa-feather');

    }

    public function multidel(tahunpenilaian $tahunpenilaian,Request $request)
    {

        $ids=$request->ids;
        prosespenilaian::whereIn('id',$ids)->delete();

        // load ulang
        #WAJIB
            $pages='tahunpenilaian';
            $datas=prosespenilaian
            ::paginate(Fungsi::paginationjml());
            // dd($datas);

            return view('pages.admin.prosespenilaian.index',compact('datas','request','pages','tahunpenilaian'));

    }
}
