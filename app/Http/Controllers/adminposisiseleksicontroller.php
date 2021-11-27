<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\posisipemain;
use App\Models\posisiseleksi;
use App\Models\tahunpenilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class adminposisiseleksicontroller extends Controller
{

    protected $th;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::user()->tipeuser!='admin' AND Auth::user()->tipeuser!='pelatih'){
                return redirect()->route('dashboard')->with('status','Halaman tidak ditemukan!')->with('tipe','danger');
            }

        return $next($request);

        });
    }
    public function index(tahunpenilaian $tahunpenilaian, Request $request)
    {
        #WAJIB
        $pages='pemain';
        $datas=posisiseleksi
        ::with('posisipemain')->where('tahunpenilaian_id',$tahunpenilaian->id)->paginate(Fungsi::paginationjml());
        // dd($datas);

        return view('pages.admin.posisiseleksi.index',compact('datas','request','pages','tahunpenilaian'));
    }
    public function cari(tahunpenilaian $tahunpenilaian,Request $request)
    {

        $cari=$request->cari;
        #WAJIB
        $pages='posisiseleksi';
        $datas=posisiseleksi::where('nama','like',"%".$cari."%")
        ->paginate(Fungsi::paginationjml());

        return view('pages.admin.posisiseleksi.index',compact('datas','request','pages','tahunpenilaian'));
    }
    public function create(tahunpenilaian $tahunpenilaian)
    {
        $this->th=$tahunpenilaian->id;
        $pages='posisiseleksi';

        $posisipemain=posisipemain::select('*')->whereNotIn('id',function($query) {
            // global $tahunpenilaian;
            // dd($this->th);
            $query->select('posisipemain_id')->from('posisiseleksi')->where('deleted_at',null)->where('tahunpenilaian_id',$this->th);

        })->get();
        // dd($pemain);
        return view('pages.admin.posisiseleksi.create',compact('pages','tahunpenilaian','posisipemain'));
    }

    public function store(tahunpenilaian $tahunpenilaian,Request $request)
    {

            $request->validate([
                'posisipemain_id'=>'required',

            ],
            [
                'posisipemain_id.nama'=>'posisipemain_id harus diisi',
            ]);





            $data_id=DB::table('posisiseleksi')->insertGetId(
                array(
                    'posisipemain_id'     =>   $request->posisipemain_id,
                    'tahunpenilaian_id'     =>   $tahunpenilaian->id,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));






    return redirect()->route('posisiseleksi',$tahunpenilaian->id)->with('status','Data berhasil tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');

    }

    public function edit(tahunpenilaian $tahunpenilaian,posisiseleksi $id)
    {
        $pages='posisiseleksi';

        return view('pages.admin.posisiseleksi.edit',compact('pages','id','tahunpenilaian'));
    }
    public function update(tahunpenilaian $tahunpenilaian,posisiseleksi $id,Request $request)
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


        posisiseleksi::where('id',$id->id)
        ->update([
            'nama'     =>   $request->nama,
            'bobot'     =>   $request->bobot,
            'kode'     =>   $request->kode,
            'tipe'     =>   $request->tipe,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);


    return redirect()->route('posisiseleksi',$tahunpenilaian->id)->with('status','Data berhasil diubah!')->with('tipe','success')->with('icon','fas fa-feather');
    }
    public function destroy(tahunpenilaian $tahunpenilaian,posisiseleksi $id){

        posisiseleksi::destroy($id->id);
        return redirect()->route('posisiseleksi',$tahunpenilaian->id)->with('status','Data berhasil dihapus!')->with('tipe','warning')->with('icon','fas fa-feather');

    }

    public function multidel(tahunpenilaian $tahunpenilaian,Request $request)
    {

        $ids=$request->ids;
        posisiseleksi::whereIn('id',$ids)->delete();

        // load ulang
        #WAJIB
        $pages='posisiseleksi';
        $datas=posisiseleksi
        ::where('tahunpenilaian_id',$tahunpenilaian->id)->paginate(Fungsi::paginationjml());
        // dd($datas);

        return view('pages.admin.posisiseleksi.index',compact('datas','request','pages','tahunpenilaian'));

    }
}
