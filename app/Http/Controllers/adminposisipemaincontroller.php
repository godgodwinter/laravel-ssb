<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\posisipemain;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class adminposisipemaincontroller extends Controller
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
    public function index(Request $request)
    {
        #WAJIB
        $pages='posisipemain';
        $datas=posisipemain
        ::paginate(Fungsi::paginationjml());
        // dd($datas);

        return view('pages.admin.posisipemain.index',compact('datas','request','pages'));
    }
    public function cari(Request $request)
    {

        $cari=$request->cari;
        #WAJIB
        $pages='posisipemain';
        $datas=posisipemain::where('nama','like',"%".$cari."%")
        ->paginate(Fungsi::paginationjml());

        return view('pages.admin.posisipemain.index',compact('datas','request','pages'));
    }
    public function create()
    {
        $pages='posisipemain';
        $waliposisipemain=DB::table('posisipemain')->whereNull('deleted_at')->get();
        return view('pages.admin.posisipemain.create',compact('pages','waliposisipemain'));
    }

    public function store(Request $request)
    {


            $cek=DB::table('posisipemain')
            ->where('nama',$request->nama)
            ->count();
                if($cek>0){
                        $request->validate([
                        'nama'=>'required|unique:posisipemain,nama',
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


            $data_id=DB::table('posisipemain')->insertGetId(
                array(
                       'nama'     =>   $request->nama,
                       'kode'     =>   $request->kode,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));






    return redirect()->route('posisipemain')->with('status','Data berhasil tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');

    }

    public function edit(posisipemain $id)
    {
        $pages='posisipemain';

        return view('pages.admin.posisipemain.edit',compact('pages','id'));
    }
    public function update(posisipemain $id,Request $request)
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


        posisipemain::where('id',$id->id)
        ->update([
            'nama'     =>   $request->nama,
            'kode'     =>   $request->kode,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);


    return redirect()->route('posisipemain')->with('status','Data berhasil diubah!')->with('tipe','success')->with('icon','fas fa-feather');
    }
    public function destroy(posisipemain $id){

        posisipemain::destroy($id->id);
        return redirect()->route('posisipemain')->with('status','Data berhasil dihapus!')->with('tipe','warning')->with('icon','fas fa-feather');

    }

    public function multidel(Request $request)
    {

        $ids=$request->ids;
        posisipemain::whereIn('id',$ids)->delete();

        // load ulang
        #WAJIB
        $pages='posisipemain';
        $datas=posisipemain
        ::paginate(Fungsi::paginationjml());
        // dd($datas);

        return view('pages.admin.posisipemain.index',compact('datas','request','pages'));

    }
}
