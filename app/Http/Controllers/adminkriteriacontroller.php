<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\kriteria;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class adminkriteriacontroller extends Controller
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
        $pages='kriteria';
        $datas=kriteria
        ::paginate(Fungsi::paginationjml());
        // dd($datas);

        return view('pages.admin.kriteria.index',compact('datas','request','pages'));
    }
    public function cari(Request $request)
    {

        $cari=$request->cari;
        #WAJIB
        $pages='kriteria';
        $datas=kriteria::where('nama','like',"%".$cari."%")
        ->paginate(Fungsi::paginationjml());

        return view('pages.admin.kriteria.index',compact('datas','request','pages'));
    }
    public function create()
    {
        $pages='kriteria';
        $walikriteria=DB::table('kriteria')->whereNull('deleted_at')->get();
        return view('pages.admin.kriteria.create',compact('pages','walikriteria'));
    }

    public function store(Request $request)
    {

            $request->validate([
                'nama'=>'required',

            ],
            [
                'nama.nama'=>'Nama harus diisi',
            ]);

            $cek=DB::table('kriteria')
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



            $data_id=DB::table('kriteria')->insertGetId(
                array(
                    'nama'     =>   $request->nama,
                    'bobot'     =>   $request->bobot,
                    'kode'     =>   $request->kode,
                    'tipe'     =>   $request->tipe,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));






    return redirect()->route('kriteria')->with('status','Data berhasil tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');

    }

    public function edit(kriteria $id)
    {
        $pages='kriteria';

        return view('pages.admin.kriteria.edit',compact('pages','id'));
    }
    public function update(kriteria $id,Request $request)
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


        kriteria::where('id',$id->id)
        ->update([
            'nama'     =>   $request->nama,
            'bobot'     =>   $request->bobot,
            'kode'     =>   $request->kode,
            'tipe'     =>   $request->tipe,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);


    return redirect()->route('kriteria')->with('status','Data berhasil diubah!')->with('tipe','success')->with('icon','fas fa-feather');
    }
    public function destroy(kriteria $id){

        kriteria::destroy($id->id);
        return redirect()->route('kriteria')->with('status','Data berhasil dihapus!')->with('tipe','warning')->with('icon','fas fa-feather');

    }

    public function multidel(Request $request)
    {

        $ids=$request->ids;
        kriteria::whereIn('id',$ids)->delete();

        // load ulang
        #WAJIB
        $pages='kriteria';
        $datas=kriteria
        ::paginate(Fungsi::paginationjml());
        // dd($datas);

        return view('pages.admin.kriteria.index',compact('datas','request','pages'));

    }
}
