<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\tahunpenilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class admintahunpenilaiancontroller extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::user()->tipeuser!='admin'){
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

        return view('pages.admin.tahunpenilaian.index',compact('datas','request','pages'));
    }
    public function cari(Request $request)
    {

        $cari=$request->cari;
        #WAJIB
        $pages='tahunpenilaian';
        $datas=tahunpenilaian::where('nama','like',"%".$cari."%")
        ->paginate(Fungsi::paginationjml());

        return view('pages.admin.tahunpenilaian.index',compact('datas','request','pages'));
    }
    public function create()
    {
        $pages='tahunpenilaian';
        $walitahunpenilaian=DB::table('tahunpenilaian')->whereNull('deleted_at')->get();
        return view('pages.admin.tahunpenilaian.create',compact('pages','walitahunpenilaian'));
    }

    public function store(Request $request)
    {

            $request->validate([
                'nama'=>'required',

            ],
            [
                'nama.nama'=>'Nama harus diisi',
            ]);

            $cek=DB::table('tahunpenilaian')
            ->where('nama',$request->nama)
            ->count();
                if($cek>0){
                        $request->validate([
                        'nama'=>'required|unique:tahunpenilaian,nama',
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



            $data_id=DB::table('tahunpenilaian')->insertGetId(
                array(
                    'nama'     =>   $request->nama,
                    'status'     =>   $request->status,
                    'jml'     =>   $request->jml,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));






    return redirect()->route('tahunpenilaian')->with('status','Data berhasil tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');

    }

    public function edit(tahunpenilaian $id)
    {
        $pages='tahunpenilaian';

        return view('pages.admin.tahunpenilaian.edit',compact('pages','id'));
    }
    public function update(tahunpenilaian $id,Request $request)
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


        tahunpenilaian::where('id',$id->id)
        ->update([
            'nama'     =>   $request->nama,
            'status'     =>   $request->status,
            'jml'     =>   $request->jml,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);


    return redirect()->route('tahunpenilaian')->with('status','Data berhasil diubah!')->with('tipe','success')->with('icon','fas fa-feather');
    }
    public function destroy(tahunpenilaian $id){

        tahunpenilaian::destroy($id->id);
        return redirect()->route('tahunpenilaian')->with('status','Data berhasil dihapus!')->with('tipe','warning')->with('icon','fas fa-feather');

    }

    public function multidel(Request $request)
    {

        $ids=$request->ids;
        tahunpenilaian::whereIn('id',$ids)->delete();

        // load ulang
        #WAJIB
        $pages='tahunpenilaian';
        $datas=tahunpenilaian
        ::paginate(Fungsi::paginationjml());
        // dd($datas);

        return view('pages.admin.tahunpenilaian.index',compact('datas','request','pages'));

    }
}
