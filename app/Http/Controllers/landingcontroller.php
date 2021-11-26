<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\dokter;
use App\Models\kategori;
use App\Models\member;
use App\Models\produk;
use App\Models\testimoni;
use App\Models\treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class landingcontroller extends Controller
{
    public function index(){
        $pages='beranda';
    return view('landing.pages.index',compact('pages'));
    }

    public function pemain(){
        $pages='pemain';
    return view('landing.pages.pemain',compact('pages'));
    }

    public function pelatih(){
        $pages='pelatih';
    return view('landing.pages.pelatih',compact('pages'));
    }

    public function about(){
        $pages='about';
    return view('landing.pages.about',compact('pages'));
    }
}
