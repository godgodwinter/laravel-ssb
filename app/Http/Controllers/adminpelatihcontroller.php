<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\pelatih;
use App\Models\pemain;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class adminpelatihcontroller extends Controller
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
        $pages='pelatih';
        $datas=pelatih
        ::with('users')->paginate(Fungsi::paginationjml());
        // dd($datas);

        return view('pages.admin.pelatih.index',compact('datas','request','pages'));
    }
    public function cari(Request $request)
    {

        $cari=$request->cari;
        #WAJIB
        $pages='pelatih';
        $datas=pelatih::where('nama','like',"%".$cari."%")
        ->paginate(Fungsi::paginationjml());

        return view('pages.admin.pelatih.index',compact('datas','request','pages'));
    }
    public function create()
    {
        $pages='pelatih';
        $walipelatih=DB::table('pelatih')->whereNull('deleted_at')->get();
        return view('pages.admin.pelatih.create',compact('pages','walipelatih'));
    }

    public function store(Request $request)
    {

        $cek=DB::table('users')
        // ->whereNull('deleted_at')
        ->where('username',$request->username)
        ->orWhere('email',$request->email)
        ->count();
        // dd($cek);
            if($cek>0){
                    $request->validate([
                    'username'=>'required|unique:users,username',
                    'email'=>'required|unique:users,email',
                    'password' => 'min:3|required_with:password2|same:password2',
                    'password2' => 'min:3',

                    ],
                    [
                        'username.unique'=>'username sudah digunakan',
                    ]);

            }

            $request->validate([
                'nama'=>'required',
                'username'=>'required',
                'password' => 'min:3|required_with:password2|same:password2',
                'password2' => 'min:3',

            ],
            [
                'nama.nama'=>'Nama harus diisi',
            ]);

            $cek=DB::table('pelatih')
            ->where('nama',$request->nama)
            ->count();
                if($cek>0){
                        $request->validate([
                        'nama'=>'required|unique:pelatih,nama',
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

            $users_id=DB::table('users')->insertGetId(
                array(
                       'name'     =>   $request->nama,
                       'email'     =>   $request->email,
                       'username'     =>   $request->username,
                       'nomerinduk'     => date('YmdHis'),
                       'password' => Hash::make($request->password),
                       'tipeuser' => 'pelatih',
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));



            $data_id=DB::table('pelatih')->insertGetId(
                array(
                       'nama'     =>   $request->nama,
                       'jk'     =>   $request->jk,
                       'spesialis'     =>   $request->spesialis,
                       'telp'     =>   $request->telp,
                       'tgllahir'     =>   $request->tgllahir,
                       'alamat'     =>   $request->alamat,
                       'users_id'     =>   $users_id,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));


        $files = $request->file('files');


        if($files!=null){


            // dd('storage'.'/'.$id->sekolah_logo);
            $namafilebaru=$data_id;
            $tujuan_upload = 'storage/pelatih';
                    // upload file
            $files->move($tujuan_upload,"pelatih/".$namafilebaru.".jpg");

            $photo="pelatih/".$namafilebaru.".jpg";


            pelatih::where('id',$data_id)
            ->update([
                'photo'     =>   $photo,
            'updated_at'=>date("Y-m-d H:i:s")
            ]);
        }




    return redirect()->route('pelatih')->with('status','Data berhasil tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');

    }

    public function edit(pelatih $id)
    {
        $pages='pelatih';

        return view('pages.admin.pelatih.edit',compact('pages','id'));
    }
    public function update(pelatih $id,Request $request)
    {


        if($request->email!==$id->users->email){
            $request->validate([
                'email'=>'required|unique:users,email',
            ]);
        }
        if($request->username!==$id->users->username){
            $request->validate([
                'username'=>'required|unique:users,username',
            ]);
        }
// dd('test');

        if($request->password!=null OR $request->password!=''){

        $request->validate([
            'password' => 'min:3|required_with:password2|same:password2',
            'password2' => 'min:3',
        ],
        [
            'nama.required'=>'nama harus diisi',
        ]);
            User::where('id',$id->users_id)
            ->update([
                'name'     =>   $request->nama,
                'email'     =>   $request->email,
                'username'     =>   $request->username,
                'password' => Hash::make($request->password),
               'updated_at'=>date("Y-m-d H:i:s")
            ]);
        }else{
            User::where('id',$id->users_id)
            ->update([
                'name'     =>   $request->nama,
                'username'     =>   $request->username,
                'email'     =>   $request->email,
               'updated_at'=>date("Y-m-d H:i:s")
            ]);

        }

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


        pelatih::where('id',$id->id)
        ->update([
            'nama'     =>   $request->nama,
            'jk'     =>   $request->jk,
            'telp'     =>   $request->telp,
            'tgllahir'     =>   $request->tgllahir,
            'alamat'     =>   $request->alamat,
            'spesialis'     =>   $request->spesialis,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);


        $files = $request->file('files');


        if($files!=null){


            // dd('storage'.'/'.$id->sekolah_logo);
            $namafilebaru=$id->id;
            $tujuan_upload = 'storage/pelatih';
                    // upload file
            $files->move($tujuan_upload,"pelatih/".$namafilebaru.".jpg");

            $photo="pelatih/".$namafilebaru.".jpg";


            pelatih::where('id',$id->id)
            ->update([
                'photo'     =>   $photo,
            'updated_at'=>date("Y-m-d H:i:s")
            ]);
        }


    return redirect()->route('pelatih')->with('status','Data berhasil diubah!')->with('tipe','success')->with('icon','fas fa-feather');
    }
    public function destroy(pelatih $id){

        pelatih::destroy($id->id);
        return redirect()->route('pelatih')->with('status','Data berhasil dihapus!')->with('tipe','warning')->with('icon','fas fa-feather');

    }

    public function multidel(Request $request)
    {

        $ids=$request->ids;
        pelatih::whereIn('id',$ids)->delete();

        // load ulang
        #WAJIB
        $pages='pelatih';
        $datas=pelatih
        ::paginate(Fungsi::paginationjml());
        // dd($datas);

        return view('pages.admin.pelatih.index',compact('datas','request','pages'));

    }
}
