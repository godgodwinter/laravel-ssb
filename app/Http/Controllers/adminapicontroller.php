<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\dataajar;
use App\Models\inputnilai;
use App\Models\kelas;
use App\Models\kriteriadetail;
use App\Models\pemainseleksi;
use App\Models\penilaian;
use App\Models\penilaiandetail;
use App\Models\prosespenilaian;
use App\Models\siswa;
use App\Models\tahunpenilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class adminapicontroller extends Controller
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


    public function penilaiandetail_inputnilai(tahunpenilaian $tahunpenilaian,prosespenilaian $prosespenilaian, Request $request)
    {
        // dd($request);
        $cek=penilaian::where('pemainseleksi_id',$request->pemainseleksi_id)
        ->where('kriteriadetail_id',$request->kriteriadetail_id)
        ->count();
        if($cek>0){
            // penilaian::where('pemainseleksi_id',$request->pemainseleksi_id)
            // ->where('kriteriadetail_id',$request->kriteriadetail_id)
            // ->update([
            //     'nilai'     =>   $request->nilai,
            //    'updated_at'=>date("Y-m-d H:i:s")
            // ]);
            // 1.periksa apakah penilaiandetailada

        $ambildatapenilaian=penilaian::where('pemainseleksi_id',$request->pemainseleksi_id)
        ->where('kriteriadetail_id',$request->kriteriadetail_id)
        ->first();
        $penilaian_id=$ambildatapenilaian->id;
        $cek2=penilaiandetail::where('penilaian_id',$penilaian_id)
        ->where('prosespenilaian_id',$prosespenilaian->id)
        ->count();
        if($cek2>0){
            penilaiandetail::where('penilaian_id',$penilaian_id)
            ->where('prosespenilaian_id',$prosespenilaian->id)
            ->update([
                'nilai'     =>   $request->nilai,
               'updated_at'=>date("Y-m-d H:i:s")
            ]);



        }else{

            DB::table('penilaiandetail')->insertGetId(
                array(
                        'nilai'     =>   $request->nilai,
                        'penilaian_id'     =>   $penilaian_id,
                        'prosespenilaian_id'     =>   $prosespenilaian->id,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));

        }


        }else{

            $data_id=DB::table('penilaian')->insertGetId(
                array(
                        'nilai'     =>   $request->nilai,
                        'pemainseleksi_id'     =>   $request->pemainseleksi_id,
                        'kriteriadetail_id'     =>   $request->kriteriadetail_id,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));

            DB::table('penilaiandetail')->insertGetId(
                array(
                        'nilai'     =>   $request->nilai,
                        'penilaian_id'     =>   $data_id,
                        'prosespenilaian_id'     =>   $prosespenilaian->id,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));

        }

        $output='Data berhasil di update';
        return response()->json([
            'success' => true,
            'message' => 'success',
            'output' => $output,
        ], 200);
    }


    public function pemainseleksi_inputnilai(tahunpenilaian $tahunpenilaian, Request $request)
    {
        // dd($request);
        $cek=penilaian::where('pemainseleksi_id',$request->pemainseleksi_id)
        ->where('kriteriadetail_id',$request->kriteriadetail_id)
        ->count();
        if($cek>0){
            penilaian::where('pemainseleksi_id',$request->pemainseleksi_id)
            ->where('kriteriadetail_id',$request->kriteriadetail_id)
            ->update([
                'nilai'     =>   $request->nilai,
               'updated_at'=>date("Y-m-d H:i:s")
            ]);

        }else{

            DB::table('penilaian')->insert(
                array(
                        'nilai'     =>   $request->nilai,
                        'pemainseleksi_id'     =>   $request->pemainseleksi_id,
                        'kriteriadetail_id'     =>   $request->kriteriadetail_id,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));

        }

        $output='Data berhasil di update';
        return response()->json([
            'success' => true,
            'message' => 'success',
            'output' => $output,
        ], 200);
    }
    public function nilaipersiswa(prosespenilaian $prosespenilaian,pemainseleksi $pemainseleksi,kriteriadetail $kriteriadetail,Request $request){
        // dd($pemainseleksi,$kriteriadetail);
        $penilaian_id=null;
        $getpenilaian_id=penilaian::where('pemainseleksi_id',$pemainseleksi->id)->where('kriteriadetail_id',$kriteriadetail->id)->first();
        $periksa=penilaiandetail::where('prosespenilaian_id',$prosespenilaian->id)->where('penilaian_id',$getpenilaian_id)->count();

        $data=0;
        if($periksa>0){
            $getdata=penilaiandetail::where('prosespenilaian_id',$prosespenilaian->id)->where('penilaian_id',$getpenilaian_id)->first();
            $data=$getdata->nilai;
        }
        // dd($prosespenilaian->id,$getpenilaian_id,$periksa);
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $data,
        ], 200);
    }

}
