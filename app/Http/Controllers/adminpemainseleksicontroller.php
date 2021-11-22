<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\pemain;
use App\Models\pemainseleksi;
use App\Models\tahunpenilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class adminpemainseleksicontroller extends Controller
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
    public function index(tahunpenilaian $tahunpenilaian, Request $request)
    {
        #WAJIB
        $pages='pemain';
        $datas=pemainseleksi
        ::with('pemain')->where('tahunpenilaian_id',$tahunpenilaian->id)->paginate(Fungsi::paginationjml());
        // dd($datas);

        return view('pages.admin.pemainseleksi.index',compact('datas','request','pages','tahunpenilaian'));
    }
    public function cari(tahunpenilaian $tahunpenilaian,Request $request)
    {

        $cari=$request->cari;
        #WAJIB
        $pages='pemainseleksi';
        $datas=pemainseleksi::where('nama','like',"%".$cari."%")
        ->paginate(Fungsi::paginationjml());

        return view('pages.admin.pemainseleksi.index',compact('datas','request','pages','tahunpenilaian'));
    }
    public function create(tahunpenilaian $tahunpenilaian)
    {
        $this->th=$tahunpenilaian->id;
        $pages='pemainseleksi';
        $pemain=pemain::get();

        $pemain=pemain::select('*')->whereNotIn('id',function($query) {
            // global $tahunpenilaian;
            // dd($this->th);
            $query->select('pemain_id')->from('pemainseleksi')->where('deleted_at',null)->where('tahunpenilaian_id',$this->th);

        })->get();
        // dd($pemain);
        return view('pages.admin.pemainseleksi.create',compact('pages','tahunpenilaian','pemain'));
    }

    public function store(tahunpenilaian $tahunpenilaian,Request $request)
    {

            $request->validate([
                'pemain_id'=>'required',

            ],
            [
                'pemain_id.nama'=>'pemain_id harus diisi',
            ]);





            $data_id=DB::table('pemainseleksi')->insertGetId(
                array(
                    'pemain_id'     =>   $request->pemain_id,
                    'tahunpenilaian_id'     =>   $tahunpenilaian->id,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));






    return redirect()->route('pemainseleksi',$tahunpenilaian->id)->with('status','Data berhasil tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');

    }

    public function edit(tahunpenilaian $tahunpenilaian,pemainseleksi $id)
    {
        $pages='pemainseleksi';

        return view('pages.admin.pemainseleksi.edit',compact('pages','id','tahunpenilaian'));
    }
    public function update(tahunpenilaian $tahunpenilaian,pemainseleksi $id,Request $request)
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


        pemainseleksi::where('id',$id->id)
        ->update([
            'nama'     =>   $request->nama,
            'bobot'     =>   $request->bobot,
            'kode'     =>   $request->kode,
            'tipe'     =>   $request->tipe,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);


    return redirect()->route('pemainseleksi',$tahunpenilaian->id)->with('status','Data berhasil diubah!')->with('tipe','success')->with('icon','fas fa-feather');
    }
    public function destroy(tahunpenilaian $tahunpenilaian,pemainseleksi $id){

        pemainseleksi::destroy($id->id);
        return redirect()->route('pemainseleksi',$tahunpenilaian->id)->with('status','Data berhasil dihapus!')->with('tipe','warning')->with('icon','fas fa-feather');

    }

    public function multidel(tahunpenilaian $tahunpenilaian,Request $request)
    {

        $ids=$request->ids;
        pemainseleksi::whereIn('id',$ids)->delete();

        // load ulang
        #WAJIB
        $pages='pemainseleksi';
        $datas=pemainseleksi
        ::where('tahunpenilaian_id',$tahunpenilaian->id)->paginate(Fungsi::paginationjml());
        // dd($datas);

        return view('pages.admin.pemainseleksi.index',compact('datas','request','pages','tahunpenilaian'));

    }
}
