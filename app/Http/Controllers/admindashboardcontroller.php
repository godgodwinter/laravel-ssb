<?php

namespace App\Http\Controllers;

use App\Models\guru;
use App\Models\mapel;
use App\Models\member;
use App\Models\pelatih;
use App\Models\pemain;
use App\Models\perawatan;
use App\Models\posisipemain;
use App\Models\produk;
use App\Models\siswa;
use App\Models\tahunpenilaian;
use App\Models\transaksi;
use App\Models\treatment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class admindashboardcontroller extends Controller
{
    public function index(){

        $pages='dashboard';
        // dd($laki,$perempuan);
        if((Auth::user()->tipeuser)=='admin'){

            $jmlpemain=pemain::count();
            $jmlpelatih=pelatih::count();
            $jmlposisi=posisipemain::count();
            $jmlproses=tahunpenilaian::count();
            $jmlprosesselesai=tahunpenilaian::where('status','Selesai')->count();
            return view('pages.admin.dashboard.index',compact('pages','jmlpemain','jmlpelatih','jmlposisi','jmlproses','jmlprosesselesai'));
        }
        if((Auth::user()->tipeuser)=='member'){

            return view('pages.admin.dashboard.index',compact('pages','produkJml','laki','perempuan','treatmentJml','transaksiSuccessJml','transaksiTotalJml','perawatanJml'));
        }
    }

}
