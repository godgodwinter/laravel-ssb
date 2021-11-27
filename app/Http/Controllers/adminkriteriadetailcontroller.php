<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\kriteria;
use App\Models\kriteriadetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class adminkriteriadetailcontroller extends Controller
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
    public function index(kriteria $kriteria,Request $request)
    {
        #WAJIB
        $pages='tahunpenilaian';
        $datas=kriteriadetail
        ::where('kriteria_id',$kriteria->id)->paginate(Fungsi::paginationjml());
        // dd($datas);

        return view('pages.admin.kriteriadetail.index',compact('datas','request','pages','kriteria'));
    }
    public function cari(kriteria $kriteria,Request $request)
    {

        $cari=$request->cari;
        #WAJIB
        $pages='tahunpenilaian';
        $datas=kriteriadetail::where('nama','like',"%".$cari."%")
        ->paginate(Fungsi::paginationjml());

        return view('pages.admin.kriteriadetail.index',compact('datas','request','pages','kriteria'));
    }
    public function create(kriteria $kriteria)
    {
        $pages='tahunpenilaian';
        return view('pages.admin.kriteriadetail.create',compact('pages','kriteria'));
    }

    public function store(kriteria $kriteria,Request $request)
    {

            $request->validate([
                'nama'=>'required',

            ],
            [
                'nama.nama'=>'Nama harus diisi',
            ]);

            $cek=DB::table('kriteriadetail')
            ->where('nama',$request->nama)
            ->count();
                if($cek>0){
                        $request->validate([
                        'nama'=>'required|unique:kriteria,nama',
                        ],
                        [
                            'nama.unique'=>'nama sudah digunakan',
                        ]);

                }

                $request->validate([
                    'nama'=>'required',

                ],
                [
                    'nama.nama'=>'nama harus diisi',
                ]);



            $data_id=DB::table('kriteriadetail')->insertGetId(
                array(
                    'nama'     =>   $request->nama,
                    'bobot'     =>   $request->bobot?$request->bobot:'0',
                    'kode'     =>   $request->kode,
                    'kriteria_id'     =>   $kriteria->id,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));






    return redirect()->route('kriteriadetail',$kriteria->id)->with('status','Data berhasil tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');

    }

    public function edit(kriteria $kriteria,kriteriadetail $id)
    {
        $pages='tahunpenilaian';

        return view('pages.admin.kriteriadetail.edit',compact('pages','id','kriteria'));
    }
    public function update(kriteria $kriteria,kriteriadetail $id,Request $request)
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


        kriteriadetail::where('id',$id->id)
        ->update([
            'nama'     =>   $request->nama,
            'bobot'     =>   $request->bobot?$request->bobot:'0',
            'kode'     =>   $request->kode,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);


    return redirect()->route('kriteriadetail',$kriteria->id)->with('status','Data berhasil diubah!')->with('tipe','success')->with('icon','fas fa-feather');
    }
    public function destroy(kriteria $kriteria,kriteriadetail $id){

        kriteriadetail::destroy($id->id);
        return redirect()->route('kriteriadetail',$kriteria->id)->with('status','Data berhasil dihapus!')->with('tipe','warning')->with('icon','fas fa-feather');

    }

    public function multidel(kriteria $kriteria,Request $request)
    {

        $ids=$request->ids;
        kriteriadetail::whereIn('id',$ids)->delete();

        // load ulang
        #WAJIB
        $pages='tahunpenilaian';
        $datas=kriteriadetail
        ::where('kriteria_id',$kriteria->id)->paginate(Fungsi::paginationjml());
        // dd($datas);

        return view('pages.admin.kriteriadetail.index',compact('datas','request','pages','kriteria'));

    }
}
