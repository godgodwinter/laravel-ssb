<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\kriteria;
use App\Models\kriteriadetail;
use App\Models\tahunpenilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class admintahunpenilaiandetailcontroller extends Controller
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
    public function index(tahunpenilaian $tahunpenilaian,Request $request)
    {
        #WAJIB
        $pages='tahunpenilaian';
        $datas=tahunpenilaian
        ::paginate(Fungsi::paginationjml());

        $jmlkriteria=kriteria::where('tahunpenilaian_id',$tahunpenilaian->id)->count();
        $ambilkriteria=kriteria::where('tahunpenilaian_id',$tahunpenilaian->id)->get();
        $jmlkriteriadetail=0;
        foreach($ambilkriteria as $data){
            $jmlkriteriadetail+=kriteriadetail::where('kriteria_id',$data->id)->count();
        }

        // dd($jml);

        return view('pages.admin.tahunpenilaiandetail.index',compact('datas','request','pages','tahunpenilaian','jmlkriteria','jmlkriteriadetail'));
    }
}
