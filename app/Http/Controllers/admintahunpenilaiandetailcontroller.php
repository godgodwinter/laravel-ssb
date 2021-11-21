<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
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
        // dd($datas);

        return view('pages.admin.tahunpenilaiandetail.index',compact('datas','request','pages','tahunpenilaian'));
    }
}
