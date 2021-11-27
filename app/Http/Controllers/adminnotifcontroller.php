<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\pemain;
use App\Models\pemainseleksi;
use App\Models\penilaianhasil;
use App\Models\tahunpenilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class adminnotifcontroller extends Controller
{
    protected $th;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::user()->tipeuser!='admin' AND Auth::user()->tipeuser!='pelatih'){
                return redirect()->route('dashboard')->with('status','Halaman tidak ditemukan!')->with('tipe','danger');
            }

        return $next($request);

        });
    }
    public function notif(tahunpenilaian $tahunpenilaian,Request $request)
    {
        $this->th=$tahunpenilaian->id;
        #WAJIB
        $pages='tahunpenilaian';

        //ambil datamember dari pemainseleksi
        $ambildatapemain=pemain::with('pemainseleksi')->whereIn('id',function($query){
            $query->select('pemain_id')->from('pemainseleksi')->where('tahunpenilaian_id',$this->th);
        })->get();
        $datapemain = new Collection();
        foreach($ambildatapemain as $item){
            $pemainseleksi=pemainseleksi::where('pemain_id',$item->id)->where('tahunpenilaian_id',$this->th)->first();
            $pemainseleksi_id=$pemainseleksi->id;

            $hasil= new Collection();
                $posisiterbaik= new Collection();
                $ambildatahasil=penilaianhasil::with('posisiseleksi')->where('pemainseleksi_id',$pemainseleksi_id)->skip(0)->take($tahunpenilaian->jml)->orderBy('total','desc')->get();
                foreach($ambildatahasil as $h){
                    $posisiterbaik->push((object)[
                        'id' => $h->id,
                        // 'nama' => $pemain->pemain!=null?$pemain->pemain->nama:'Data tidak ditemukan',
                        'nama' => $h->posisiseleksi->posisipemain->nama,
                        'total' => $h->total,
                    ]);
                }
                $hasil->push((object)[
                    'posisiterbaik' => $posisiterbaik,
                ]);
            $datapemain->push((object)[
                'id'=> $item->id,
                'nama'=> $item->nama,
                'number'=> $item->telp,
                'pemainseleksi'=> $hasil,
            ]);

        }
        // dd($datapemain,$ambildatapemain);
        foreach($datapemain as $kirimpesan){
            $hasil='';
            foreach($kirimpesan->pemainseleksi as $item2){
                // dd($item2->posisiterbaik);
                foreach($item2->posisiterbaik as $item){
                    $hasil.=$item->nama.' Skor '.$item->total.' ,';
                }
            }
            $endpoint = "http://localhost:8081/send-message";
            $client = new \GuzzleHttp\Client();
            $number = $kirimpesan->number;
            $message = 'Yth Sdra/Sdri '.$kirimpesan->nama .'
            Kami dari '.Fungsi::app_nama().' memberikan Hasil dari Penilaian Posisi Pemain.
            Posisi Terbaik anda adalah '.$hasil;
            // dd($message);
            $response = $client->request('POST', $endpoint, ['form_params' => [
                'number' => $number,
                'message' => $message,
                ]]);
            $statusCode = $response->getStatusCode();
            $content = $response->getBody();
        }
        // dd($statusCode,$content);
        return redirect()->route('tahunpenilaian')->with('status','Notifikasi telah terkirim!')->with('tipe','success');
    }

    public function basic(Request $request)
    {
        #WAJIB
        $pages='tahunpenilaian';

            $endpoint = "http://localhost:8081/send-message";
            $client = new \GuzzleHttp\Client();
            $number = '085736862399';
            $message = 'Ini dari Laravel-ssb';

            $response = $client->request('POST', $endpoint, ['form_params' => [
                'number' => $number,
                'message' => $message,
                ]]);

            // url will be: http://my.domain.com/test.php?key1=5&key2=ABC;

            $statusCode = $response->getStatusCode();
            $content = $response->getBody();
        dd($statusCode,$content);

        return view('pages.admin.tahunpenilaian.index',compact('request','pages'));
    }
}
