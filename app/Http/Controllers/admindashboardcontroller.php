<?php

namespace App\Http\Controllers;

use App\Models\guru;
use App\Models\mapel;
use App\Models\member;
use App\Models\perawatan;
use App\Models\produk;
use App\Models\siswa;
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
        $produkJml=produk::count();
        $treatmentJml=treatment::count();
        $transaksiSuccessJml=transaksi::where('status','Success')->count();
        $transaksiTotalJml=transaksi::count();
        $perawatanJml=perawatan::count();
        $laki=member::where('jk','Laki-laki')->count();
        $perempuan=member::where('jk','Perempuan')->count();
        // dd($laki,$perempuan);
        if((Auth::user()->tipeuser)=='admin'){

            return view('pages.admin.dashboard.index',compact('pages','produkJml','laki','perempuan','treatmentJml','transaksiSuccessJml','transaksiTotalJml','perawatanJml'));
        }
        if((Auth::user()->tipeuser)=='member'){

            return view('pages.admin.dashboard.index',compact('pages','produkJml','laki','perempuan','treatmentJml','transaksiSuccessJml','transaksiTotalJml','perawatanJml'));
        }
    }

}
