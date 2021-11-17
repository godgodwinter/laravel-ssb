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

}
