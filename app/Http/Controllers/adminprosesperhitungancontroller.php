<?php

namespace App\Http\Controllers;

use App\Models\kriteria;
use App\Models\kriteriadetail;
use App\Models\pemainseleksi;
use App\Models\penilaiandetail;
use App\Models\penilaianhasil;
use App\Models\posisiseleksi;
use App\Models\posisiseleksidetail;
use App\Models\prosespenilaian;
use App\Models\tahunpenilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class adminprosesperhitungancontroller extends Controller
{
    protected $th;
    protected $k;
    protected $pemain;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::user()->tipeuser!='admin' AND Auth::user()->tipeuser!='guru'){
                return redirect()->route('dashboard')->with('status','Halaman tidak ditemukan!')->with('tipe','danger');
            }

        return $next($request);

        });
    }
    public function index (tahunpenilaian $tahunpenilaian, Request $request)
    {
        $this->th=$tahunpenilaian->id;
        $ambildatapemainseleksi=pemainseleksi::with('pemain')->where('tahunpenilaian_id',$tahunpenilaian->id)->get();
        $koleksipemain= new Collection();
        foreach($ambildatapemainseleksi as $pemain){
            $this->pemain=$pemain->id;
        // step1
        $kriteriadetail= new Collection();
        $ambildatakriteriadetail=kriteriadetail::with('kriteria')->whereIn('kriteria_id',function($query){
            $query->select('id')->from('kriteria')->where('tahunpenilaian_id',$this->th);
        })->get();
        foreach($ambildatakriteriadetail as $k){
            $this->k=$k->id;
            $prosespenilaian=new Collection();
            $nilai=0;
            $ambilprosespenilaian=prosespenilaian::where('tahunpenilaian_id',$this->th)->get();
            foreach($ambilprosespenilaian as $p){
                $ambilnilai=penilaiandetail::with('penilaian')
                ->whereIn('penilaian_id',function($query){
                    $query->select('id')->from('penilaian')->where('kriteriadetail_id',$this->k)
                    ->where('pemainseleksi_id',$this->pemain)
                    // ->where('tahunpenilaian_id',$this->th)
                    ;
                })
                ->where('prosespenilaian_id',$p->id)->first();
                $nilai=$ambilnilai?$ambilnilai->nilai:0;
                // dd($ambilnilai);
                $prosespenilaian->push((object)[
                    'id'=> $p->id,
                    'nama'=> $p->nama,
                    'nilai'=>$nilai,
                ]);
            }
            $bobot=$prosespenilaian->avg('nilai')/100;
            // dd($prosespenilaian->avg('nilai'),$bobot);
            $periksaposisiseleksidetail=posisiseleksidetail::where('kriteriadetail_id',$k->id)->first();
            $posisiseleksi_id=$periksaposisiseleksidetail->posisiseleksi_id;
            $kriteriadetail->push((object)[
                'id'=>$k->id,
                // 'posisiseleksi_id'=>$posisiseleksi_id,
                'pemain_id'=>$pemain->pemain?$pemain->id:'Data tidak ditemukan',
                'pemain_nama'=>$pemain->pemain?$pemain->pemain->nama:'Data tidak ditemukan',
                'nama'=>$k->nama?$k->nama:'Data tidak ditemukan',
                'kriteria_id'=>$k->kriteria?$k->kriteria->id:'Data tidak ditemukan',
                'kriteria_nama'=>$k->kriteria?$k->kriteria->nama:'Data tidak ditemukan',
                'nilai'=>$prosespenilaian,
                'avg'=>$prosespenilaian->avg('nilai'),
                'bobot'=>$bobot,
            ]);
        }
        // dd($kriteriadetail);
        // dd($kriteriadetail->where('kriteria_nama','Taktik'));
        // dd($kriteriadetail->where('kriteria_id','4')->where('pemain_id','1')->where('id','1')->sum('bobot'));
        // dd($kriteriadetail->where('kriteria_nama','Fisik')->sum('bobot'));
        // dd($kriteriadetail->where('kriteria_nama','Fisik')->count());
        //step2
        $posisiseleksi= new Collection();
        $ambildataposisiseleksi=posisiseleksi::with('posisipemain')->with('posisiseleksidetail')->where('tahunpenilaian_id',$tahunpenilaian->id)->get();
        foreach($ambildataposisiseleksi as $ps){


        $kriteria= new Collection();
        $ambildatakriteria=kriteria::where('tahunpenilaian_id',$tahunpenilaian->id)->get();
        $nilaiakhir=0;
        foreach($ambildatakriteria as $krit){
            $jmldata=0;
            $sumbobot=0;
            $sumbobotperjmldata=0;
            foreach($ps->posisiseleksidetail as $psd){

                $sumbobot+=$kriteriadetail->where('id',$psd->kriteriadetail_id)->where('kriteria_id',$krit->id)->sum('bobot');
                // dd($sumbobot);
                if($kriteriadetail->where('id',$psd->kriteriadetail_id)->where('kriteria_id',$krit->id)->sum('bobot')!=null){
                    $jmldata+=1;
                };

            }
            // dd($ps->posisiseleksidetail,$sumbobot,$jmldata);
            $weight=$krit->bobot/100;
            if($jmldata>0){

                $sumbobotperjmldata=number_format(($sumbobot/$jmldata),4);
            }
            $kriteria->push((object)[
                'id'=>$krit->id,
                'kriteria_nama'=>$krit->nama,
                'kriteriadetail'=>$kriteriadetail->where('kriteria_id',$krit->id)->where('pemain_id',$pemain->id),
                'evaluation'=>$sumbobotperjmldata,
                'weight'=>$weight,
                'weightevaluation'=>$sumbobotperjmldata*$weight,
            ]);
        }
                $nilaiakhir=$kriteria->sum('weightevaluation');
                $posisiseleksi->push((object)[
                    'id'=>$ps->id,
                    'nama'=>$ps->posisipemain?$ps->posisipemain->nama:'Data tidak ditemukan',
                    'kriteria'=>$kriteria,
                    'nilaiakhir'=> $nilaiakhir,
                ]);

            $cekhasil=penilaianhasil::where('posisiseleksi_id',$ps->id)
                ->where('pemainseleksi_id',$pemain->id)
                ->count();
                if($cekhasil>0){

                        penilaianhasil::where('posisiseleksi_id',$ps->id)
                        ->where('pemainseleksi_id',$pemain->id)
                        ->update([
                            'total'     =>   $nilaiakhir,
                        'updated_at'=>date("Y-m-d H:i:s")
                        ]);

                }else{
                    $data_id=DB::table('penilaianhasil')->insertGetId(
                        array(
                            'total' => $nilaiakhir,
                            'posisiseleksi_id'     =>   $ps->id,
                            'pemainseleksi_id'     =>   $pemain->id,
                               'created_at'=>date("Y-m-d H:i:s"),
                               'updated_at'=>date("Y-m-d H:i:s")
                        ));
                }
        }


        $koleksipemain->push((object)[
            'id'=> $pemain->id,
            'nama' => $pemain->pemain?$pemain->pemain->nama:'Data tidak ditemukan',
            'kriteriadetail' => $kriteriadetail,
            'posisiseleksi' => $posisiseleksi,
        ]);
        }

        dd($koleksipemain,$ambildatapemainseleksi);
    }
}
