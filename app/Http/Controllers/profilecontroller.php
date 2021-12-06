<?php

namespace App\Http\Controllers;

use App\Models\pelatih;
use App\Models\pemain;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class profilecontroller extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::user()->tipeuser!='pelatih' && Auth::user()->tipeuser!='pemain'){
                return redirect()->route('dashboard')->with('status','Halaman tidak ditemukan!')->with('tipe','danger');
            }

        return $next($request);

        });
    }
    public function pelatih(){

        $pages='profile';



        $datas=DB::table('users')->where('id',Auth::user()->id)->first();
        $data=pelatih::with('users')->where('users_id',Auth::user()->id)->first();
        return view('pages.admin.settings.pelatih',compact('datas','pages','data'));
    }
    public function pelatihupdate (Request $request)
    {
        $myprofile=Auth::user();
        // dd($myprofile,$request->username);

        if($myprofile->username!==$request->username){

            $request->validate([
                'username' => "required|unique:users,username",
            ],
            [
            ]);
        }

        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'username'=>'required',
        ],
        [
            'nama.required'=>'nama harus diisi',
        ]);


        if($request->password!=null OR $request->password!=''){

        $request->validate([
            'password' => 'min:3|required_with:password2|same:password2',
            'password2' => 'min:3',
        ],
        [
            'nama.required'=>'nama harus diisi',
        ]);
            User::where('id',$myprofile->id)
            ->update([
                'name'     =>   $request->name,
                'email'     =>   $request->email,
                'username'     =>   $request->username,
                'password' => Hash::make($request->password),
               'updated_at'=>date("Y-m-d H:i:s")
            ]);
        }else{
            User::where('id',$myprofile->id)
            ->update([
                'name'     =>   $request->name,
                'username'     =>   $request->username,
                'email'     =>   $request->email,
               'updated_at'=>date("Y-m-d H:i:s")
            ]);

        }

        $data=pelatih::with('users')->where('users_id',Auth::user()->id)->first();

        pelatih::where('id',$data->id)
        ->update([
            'nama'     =>   $request->name,
            'telp'     =>   $request->telp,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);

        $files = $request->file('files');


        if($files!=null){


            // dd('storage'.'/'.$id->sekolah_logo);
            $namafilebaru=$data->id;
            $tujuan_upload = 'storage/pelatih';
                    // upload file
            $files->move($tujuan_upload,"pelatih/".$namafilebaru.".jpg");

            $photo="pelatih/".$namafilebaru.".jpg";


            pelatih::where('id',$data->id)
            ->update([
                'photo'     =>   $photo,
            'updated_at'=>date("Y-m-d H:i:s")
            ]);
        }


    return redirect()->route('pelatih.profile')->with('status','Data berhasil diubah!')->with('tipe','success')->with('icon','fas fa-feather');
    }
    public function pemain(){

        $pages='profile';



        $datas=DB::table('users')->where('id',Auth::user()->id)->first();
        $data=pemain::with('users')->where('users_id',Auth::user()->id)->first();
        return view('pages.admin.settings.pemain',compact('datas','pages','data'));
    }
    public function pemainupdate (Request $request)
    {
        $myprofile=Auth::user();
        // dd($myprofile,$request->username);

        if($myprofile->username!==$request->username){

            $request->validate([
                'username' => "required|unique:users,username",
            ],
            [
            ]);
        }

        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'username'=>'required',
        ],
        [
            'nama.required'=>'nama harus diisi',
        ]);


        if($request->password!=null OR $request->password!=''){

        $request->validate([
            'password' => 'min:3|required_with:password2|same:password2',
            'password2' => 'min:3',
        ],
        [
            'nama.required'=>'nama harus diisi',
        ]);
            User::where('id',$myprofile->id)
            ->update([
                'name'     =>   $request->name,
                'email'     =>   $request->email,
                'username'     =>   $request->username,
                'password' => Hash::make($request->password),
               'updated_at'=>date("Y-m-d H:i:s")
            ]);
        }else{
            User::where('id',$myprofile->id)
            ->update([
                'name'     =>   $request->name,
                'username'     =>   $request->username,
                'email'     =>   $request->email,
               'updated_at'=>date("Y-m-d H:i:s")
            ]);

        }

        $data=pemain::with('users')->where('users_id',Auth::user()->id)->first();

        pemain::where('id',$data->id)
        ->update([
            'nama'     =>   $request->name,
            'telp'     =>   $request->telp,
            'tgllahir'     =>   $request->tgllahir,
            'alamat'     =>   $request->alamat,
            'jk'     =>   $request->jk,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);

        $files = $request->file('files');


        if($files!=null){


            // dd('storage'.'/'.$id->sekolah_logo);
            $namafilebaru=$data->id;
            $tujuan_upload = 'storage/pemain';
                    // upload file
            $files->move($tujuan_upload,"pemain/".$namafilebaru.".jpg");

            $photo="pemain/".$namafilebaru.".jpg";


            pemain::where('id',$data->id)
            ->update([
                'photo'     =>   $photo,
            'updated_at'=>date("Y-m-d H:i:s")
            ]);
        }


    return redirect()->route('pemain.profile')->with('status','Data berhasil diubah!')->with('tipe','success')->with('icon','fas fa-feather');
    }
}
