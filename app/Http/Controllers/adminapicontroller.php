<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\dataajar;
use App\Models\inputnilai;
use App\Models\kelas;
use App\Models\penilaian;
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
            if(Auth::user()->tipeuser!='admin' AND Auth::user()->tipeuser!='guru'){
                return redirect()->route('dashboard')->with('status','Halaman tidak ditemukan!')->with('tipe','danger');
            }

        return $next($request);

        });
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

}
