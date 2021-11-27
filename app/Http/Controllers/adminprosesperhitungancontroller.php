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
            if(Auth::user()->tipeuser!='admin' AND Auth::user()->tipeuser!='pelatih'){
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
            // $posisiseleksi_id=$periksaposisiseleksidetail->posisiseleksi_id?$periksaposisiseleksidetail->posisiseleksi_id:0;
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


        $dataakhir= new Collection();
        $ambildataposisi=posisiseleksi::with('posisiseleksidetail')->where('tahunpenilaian_id',$tahunpenilaian->id)->get();

        foreach($ambildataposisi as $data){
            // $fisik=[];
            // $teknik=[];
            // $taktik=[];
            $datakrit= new Collection();
            $ambilkrit=kriteria::where('tahunpenilaian_id',$tahunpenilaian->id)->get();
            foreach($ambilkrit as $item){
                $this->item=$item->id;
                $posisiseleksidetail= new Collection();
                $ambilposisiseleksidetail=posisiseleksidetail::with('kriteriadetail')
                ->where('posisiseleksi_id',$data->id)
                ->whereIn('kriteriadetail_id',function($query) {
                    $query->select('id')->from('kriteriadetail')->where('deleted_at',null)->where('kriteria_id',$this->item);
                })
                ->get();
                foreach($ambilposisiseleksidetail as $posdet){
                    if($posdet->kriteriadetail!=null){
                            $posisiseleksidetail->push((object)[
                               'id' => $posdet->id,
                               'nama' => $posdet->kriteriadetail!=null?$posdet->kriteriadetail->nama:'Data tidak ditemukan',
                           ]);

                    }
                }

                $datakrit->push((object)[
                    'id' => $item->id,
                    'nama' => $item->nama!=null?$item->nama:'Data tidak ditemukan',
                    'posisiseleksidetail' => $posisiseleksidetail,
                ]);
            }
            // dd($datakrit);


            // dd($ambilfisik,$kodefisik_id,$fisik,$taktik,$teknik);
            // dd($ambilfisik,$kodefisik_id,$datafisik,$datataktik,$datateknik);


             $dataakhir->push((object)[
                'id' => $data->id,
                'nama' => $data->posisipemain!=null?$data->posisipemain->nama:'Data tidak ditemukan',
                'kriteria' => $datakrit,
            ]);

        }


        $koleksipemain->push((object)[
            'id'=> $pemain->id,
            'nama' => $pemain->pemain?$pemain->pemain->nama:'Data tidak ditemukan',
            'kriteriadetail' => $kriteriadetail,
            'posisiseleksidetail' => $dataakhir,
            'posisiseleksi' => $posisiseleksi,
        ]);
        }

        // dd($koleksipemain,$ambildatapemainseleksi);
        return redirect()->route('prosesperhitungan.tampil',$tahunpenilaian->id)->with('status','Proses perhitungan berhasil!')->with('tipe','success');
    }

    public function tampil (tahunpenilaian $tahunpenilaian, Request $request)
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
            // $posisiseleksi_id=$periksaposisiseleksidetail->posisiseleksi_id?$periksaposisiseleksidetail->posisiseleksi_id:0;
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

            // $cekhasil=penilaianhasil::where('posisiseleksi_id',$ps->id)
            //     ->where('pemainseleksi_id',$pemain->id)
            //     ->count();
                // if($cekhasil>0){

                //         penilaianhasil::where('posisiseleksi_id',$ps->id)
                //         ->where('pemainseleksi_id',$pemain->id)
                //         ->update([
                //             'total'     =>   $nilaiakhir,
                //         'updated_at'=>date("Y-m-d H:i:s")
                //         ]);

                // }else{
                //     $data_id=DB::table('penilaianhasil')->insertGetId(
                //         array(
                //             'total' => $nilaiakhir,
                //             'posisiseleksi_id'     =>   $ps->id,
                //             'pemainseleksi_id'     =>   $pemain->id,
                //                'created_at'=>date("Y-m-d H:i:s"),
                //                'updated_at'=>date("Y-m-d H:i:s")
                //         ));
                // }
        }


        $dataakhir= new Collection();
        $ambildataposisi=posisiseleksi::with('posisiseleksidetail')->where('tahunpenilaian_id',$tahunpenilaian->id)->get();

        foreach($ambildataposisi as $data){
            $datakrit= new Collection();
            $ambilkrit=kriteria::where('tahunpenilaian_id',$tahunpenilaian->id)->get();
            foreach($ambilkrit as $item){
                $this->item=$item->id;
                $posisiseleksidetail= new Collection();
                $ambilposisiseleksidetail=posisiseleksidetail::with('kriteriadetail')
                ->where('posisiseleksi_id',$data->id)
                ->whereIn('kriteriadetail_id',function($query) {
                    $query->select('id')->from('kriteriadetail')->where('deleted_at',null)->where('kriteria_id',$this->item);
                })
                ->get();
                $jmldata=0;
                $total=0;
                foreach($ambilposisiseleksidetail as $posdet){
                    if($posdet->kriteriadetail!=null){
                        $jmldata++;
                        $total+=$kriteriadetail->where('id',$posdet->kriteriadetail->id)->where('pemain_id',$pemain->id)->sum('bobot');
                            $posisiseleksidetail->push((object)[
                               'id' => $posdet->id,
                               'nama' => $posdet->kriteriadetail!=null?$posdet->kriteriadetail->nama:'Data tidak ditemukan',
                               'nilai'=>$kriteriadetail->where('id',$posdet->kriteriadetail->id)->where('pemain_id',$pemain->id)->sum('bobot'),
                           ]);

                    }
                }

                if($jmldata>0){
                    $avg=$total/$jmldata;
                }else{
                    $avg=0;
                }
                $datakrit->push((object)[
                    'id' => $item->id,
                    'nama' => $item->nama!=null?$item->nama:'Data tidak ditemukan',
                    'posisiseleksidetail' => $posisiseleksidetail,
                    'total'=>$total,
                    'avg'=>$avg,
                ]);
            }
            // dd($datakrit);


            // dd($ambilfisik,$kodefisik_id,$fisik,$taktik,$teknik);
            // dd($ambilfisik,$kodefisik_id,$datafisik,$datataktik,$datateknik);


             $dataakhir->push((object)[
                'id' => $data->id,
                'nama' => $data->posisipemain!=null?$data->posisipemain->nama:'Data tidak ditemukan',
                'kriteria' => $datakrit,
            ]);

        }


        $koleksipemain->push((object)[
            'id'=> $pemain->id,
            'nama' => $pemain->pemain?$pemain->pemain->nama:'Data tidak ditemukan',
            'kriteriadetail' => $kriteriadetail,
            'posisiseleksidetail' => $dataakhir,
            'posisiseleksi' => $posisiseleksi,
        ]);
        }
        $datas=$koleksipemain;


        $dataakhir= new Collection();
        $ambildataposisi=posisiseleksi::with('posisiseleksidetail')->where('tahunpenilaian_id',$tahunpenilaian->id)->get();

        foreach($ambildataposisi as $data){
            $datakrit= new Collection();
            $ambilkrit=kriteria::where('tahunpenilaian_id',$tahunpenilaian->id)->get();
            foreach($ambilkrit as $item){
                $this->item=$item->id;
                $posisiseleksidetail= new Collection();
                $ambilposisiseleksidetail=posisiseleksidetail::with('kriteriadetail')
                ->where('posisiseleksi_id',$data->id)
                ->whereIn('kriteriadetail_id',function($query) {
                    $query->select('id')->from('kriteriadetail')->where('deleted_at',null)->where('kriteria_id',$this->item);
                })
                ->get();
                foreach($ambilposisiseleksidetail as $posdet){
                    if($posdet->kriteriadetail!=null){
                            $posisiseleksidetail->push((object)[
                               'id' => $posdet->id,
                               'nama' => $posdet->kriteriadetail!=null?$posdet->kriteriadetail->nama:'Data tidak ditemukan',
                           ]);

                    }
                }

                $datakrit->push((object)[
                    'id' => $item->id,
                    'nama' => $item->nama!=null?$item->nama:'Data tidak ditemukan',
                    'posisiseleksidetail' => $posisiseleksidetail,
                ]);
            }
            // dd($datakrit);


            // dd($ambilfisik,$kodefisik_id,$fisik,$taktik,$teknik);
            // dd($ambilfisik,$kodefisik_id,$datafisik,$datataktik,$datateknik);


             $dataakhir->push((object)[
                'id' => $data->id,
                'nama' => $data->posisipemain!=null?$data->posisipemain->nama:'Data tidak ditemukan',
                'kriteria' => $datakrit,
            ]);

        }

        $hasil= new Collection();
        foreach($ambildatapemainseleksi as $pemain){
            $posisiterbaik= new Collection();
            $ambildatahasil=penilaianhasil::with('posisiseleksi')->where('pemainseleksi_id',$pemain->id)->skip(0)->take($tahunpenilaian->jml)->orderBy('total','desc')->get();
            foreach($ambildatahasil as $h){
                $posisiterbaik->push((object)[
                    'id' => $h->id,
                    // 'nama' => $pemain->pemain!=null?$pemain->pemain->nama:'Data tidak ditemukan',
                    'nama' => $h->posisiseleksi?$h->posisiseleksi->posisipemain->nama:'Data tidak ditemukan',
                    'total' => $h->total,
                ]);

            }

            $hasil->push((object)[
                'id' => $pemain->id,
                'nama' => $pemain->pemain!=null?$pemain->pemain->nama:'Data tidak ditemukan',
                'posisiterbaik' => $posisiterbaik,
            ]);
        }


        $hasil2= new Collection();
        foreach($ambildataposisiseleksi as $item){

            $pemainterbaik= new Collection();
            $ambildatahasil=penilaianhasil::with('pemainseleksi')->where('posisiseleksi_id',$item->id)->skip(0)->take($tahunpenilaian->jml)->orderBy('total','desc')->get();
            foreach($ambildatahasil as $h){
                $pemainterbaik->push((object)[
                    'id' => $h->id,
                    // 'nama' => $pemain->pemain!=null?$pemain->pemain->nama:'Data tidak ditemukan',
                    'nama' => $h->pemainseleksi->pemain->nama,
                    'total' => $h->total,
                ]);

            }

            $hasil2->push((object)[
                'id' => $item->id,
                'nama' => $item->posisipemain!=null?$item->posisipemain->nama:'Data tidak ditemukan',
                'pemainterbaik' => $pemainterbaik,
            ]);
        }
        // dd($hasil,$hasil2);

        $pages='tahunpenilaian';
        return view('pages.admin.prosesperhitungan.tampil',compact('datas'
        ,'koleksipemain'
        ,'hasil'
        ,'hasil2'
        ,'ambildatakriteriadetail'
        ,'ambilprosespenilaian'
        ,'ambildatakriteria'
        ,'dataakhir'
        ,'ambildataposisiseleksi'
        ,'request','pages','tahunpenilaian','ambildatapemainseleksi'));
        // dd($koleksipemain,$ambildatapemainseleksi);
    }
    public function selesai(tahunpenilaian $tahunpenilaian){


            tahunpenilaian::where('id',$tahunpenilaian->id)
            ->update([
                'status'     =>   'Selesai',
            'updated_at'=>date("Y-m-d H:i:s")
            ]);
        return redirect()->route('tahunpenilaian')->with('status','Proses Perhitungan berhasil diselesaikan!')->with('tipe','success');
    }
}
