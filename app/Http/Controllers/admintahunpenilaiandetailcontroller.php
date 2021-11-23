<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\kriteria;
use App\Models\kriteriadetail;
use App\Models\pemainseleksi;
use App\Models\posisiseleksi;
use App\Models\posisiseleksidetail;
use App\Models\tahunpenilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class admintahunpenilaiandetailcontroller extends Controller
{
    protected $th;
    protected $item;
    protected $request;
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
        $this->th=$tahunpenilaian->id;
        #WAJIB
        $pages='tahunpenilaian';
        $datas=tahunpenilaian
        ::paginate(Fungsi::paginationjml());

        $kriteriadetail=null;

        //ambiljumlah
        $jmlkriteria=kriteria::where('tahunpenilaian_id',$tahunpenilaian->id)->count();
        $jmlposisi=posisiseleksi::where('tahunpenilaian_id',$tahunpenilaian->id)->count();
        $jmlpemain=pemainseleksi::where('tahunpenilaian_id',$tahunpenilaian->id)->count();

        //ambilkode kriteria
        $ambilkriteria=kriteria::where('tahunpenilaian_id',$tahunpenilaian->id)->get();
        $jmlkriteriadetail=0;
        foreach($ambilkriteria as $data){
            $jmlkriteriadetail+=kriteriadetail::where('kriteria_id',$data->id)->count();
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


        $kriteriadetail=kriteriadetail::select('*')
        ->whereIn('kriteria_id',function($query) {
            $query->select('id')->from('kriteria')->where('deleted_at',null)->where('tahunpenilaian_id',$this->th);
        })
        ->get();

        $datakriteria=kriteria::where('tahunpenilaian_id',$tahunpenilaian->id)->get();
        // dd($kriteriadetail,$dataakhir);

        return view('pages.admin.tahunpenilaiandetail.index',compact('datas','request','pages','tahunpenilaian','jmlkriteria','jmlkriteriadetail','dataakhir','jmlposisi','jmlpemain','kriteriadetail','datakriteria'));
    }


    public function store(tahunpenilaian $tahunpenilaian,Request $request)
    {
            $data_id=DB::table('posisiseleksidetail')->insertGetId(
                array(
                    'posisiseleksi_id'     =>   $request->posisiseleksi_id,
                    'kriteriadetail_id'     =>   $request->kriteriadetail_id,
                       'created_at'=>date("Y-m-d H:i:s"),
                       'updated_at'=>date("Y-m-d H:i:s")
                ));

    return redirect()->route('tahunpenilaian.detail',$tahunpenilaian->id)->with('status','Data berhasil tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');

    }
    public function updatekuota(tahunpenilaian $tahunpenilaian,Request $request)
    {

        tahunpenilaian::where('id',$tahunpenilaian->id)
        ->update([
            'jml'     =>   $request->jml,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);

    return redirect()->route('tahunpenilaian.detail',$tahunpenilaian->id)->with('status','Data berhasil diubah!')->with('tipe','success')->with('icon','fas fa-feather');

    }
    public function destroy(tahunpenilaian $tahunpenilaian,posisiseleksidetail $id){

        posisiseleksidetail::destroy($id->id);
        return redirect()->route('tahunpenilaian.detail',$tahunpenilaian->id)->with('status','Data berhasil dihapus!')->with('tipe','warning')->with('icon','fas fa-feather');

    }

    public function apikriteriadetail(tahunpenilaian $tahunpenilaian, Request $request)
    {
        $this->th=$tahunpenilaian->id;
        $datas=null;
        if($request->kriteria!=null){
            $this->request=$request;
            // $datas='Fisik';
            $kriteriadetail=kriteriadetail::select('*')
            ->whereIn('kriteria_id',function($query) {
                $query->select('id')->from('kriteria')->where('deleted_at',null)
                ->where('tahunpenilaian_id',$this->th)
                ->where('nama',$this->request->kriteria);
            })
            ->whereNotIn('id',function($query) {
                $query->select('kriteriadetail_id')->from('posisiseleksidetail')
                ->where('posisiseleksi_id',$this->request->posisiseleksi_id)
                ->where('deleted_at',null);
            })
            ->get();

        }else{
            $kriteriadetail=kriteriadetail::select('*')
            ->whereIn('kriteria_id',function($query) {
                $query->select('id')->from('kriteria')->where('deleted_at',null)->where('tahunpenilaian_id',$this->th);
            })
            ->get();

        }
        $datas=$kriteriadetail;
        // dd($datas,$this->th);
        $output='Data berhasil di muat!';
        // $output=$request->posisiseleksi_id;
        return response()->json([
            'success' => true,
            'message' => 'success',
            'output' => $output,
            'datas' => $datas,
        ], 200);
    }

    public function index_old(tahunpenilaian $tahunpenilaian,Request $request)
    {
        $this->th=$tahunpenilaian->id;
        #WAJIB
        $pages='tahunpenilaian';
        $datas=tahunpenilaian
        ::paginate(Fungsi::paginationjml());

        $kriteriadetail=null;

        //ambiljumlah
        $jmlkriteria=kriteria::where('tahunpenilaian_id',$tahunpenilaian->id)->count();
        $jmlposisi=posisiseleksi::where('tahunpenilaian_id',$tahunpenilaian->id)->count();
        $jmlpemain=pemainseleksi::where('tahunpenilaian_id',$tahunpenilaian->id)->count();

        //ambilkode kriteria
        $kodefisik=kriteria::where('tahunpenilaian_id',$tahunpenilaian->id)->where('kode','fisik')->first();
        $kodefisik_id=$kodefisik?$kodefisik->id:null;

        $kodetaktik=kriteria::where('tahunpenilaian_id',$tahunpenilaian->id)->where('kode','taktik')->first();
        $kodetaktik_id=$kodetaktik?$kodetaktik->id:null;

        $kodeteknik=kriteria::where('tahunpenilaian_id',$tahunpenilaian->id)->where('kode','teknik')->first();
        $kodeteknik_id=$kodeteknik?$kodeteknik->id:null;


        $ambilkriteria=kriteria::where('tahunpenilaian_id',$tahunpenilaian->id)->get();
        $jmlkriteriadetail=0;
        foreach($ambilkriteria as $data){
            $jmlkriteriadetail+=kriteriadetail::where('kriteria_id',$data->id)->count();
        }


        $dataakhir= new Collection();
        $ambildataposisi=posisiseleksi::with('posisiseleksidetail')->where('tahunpenilaian_id',$tahunpenilaian->id)->get();

        foreach($ambildataposisi as $data){
            // $fisik=[];
            // $teknik=[];
            // $taktik=[];
            $datafisik= new Collection();
            $datateknik= new Collection();
            $datataktik= new Collection();

            $ambilfisik=posisiseleksidetail::with('kriteriadetail')->where('posisiseleksi_id',$data->id)->get();
            foreach($ambilfisik as $item){
                if($item->kriteriadetail!=null){
                    if($item->kriteriadetail->kriteria_id==$kodefisik_id){
                        $datafisik->push((object)[
                           'id' => $item->id,
                           'nama' => $item->kriteriadetail!=null?$item->kriteriadetail->nama:'Data tidak ditemukan',
                       ]);
                        // array_push($fisik,$item->kriteriadetail->nama);
                    }elseif($item->kriteriadetail->kriteria_id==$kodetaktik_id){

                        $datataktik->push((object)[
                            'id' => $item->id,
                            'nama' => $item->kriteriadetail!=null?$item->kriteriadetail->nama:'Data tidak ditemukan',
                        ]);

                        // array_push($taktik,$item->kriteriadetail->nama);
                    }elseif($item->kriteriadetail->kriteria_id==$kodeteknik_id){

                        $datateknik->push((object)[
                            'id' => $item->id,
                            'nama' => $item->kriteriadetail!=null?$item->kriteriadetail->nama:'Data tidak ditemukan',
                        ]);

                        // array_push($teknik,$item->kriteriadetail->nama);
                    }
                }
            }
            // dd($ambilfisik,$kodefisik_id,$fisik,$taktik,$teknik);
            // dd($ambilfisik,$kodefisik_id,$datafisik,$datataktik,$datateknik);


             $dataakhir->push((object)[
                'id' => $data->id,
                'nama' => $data->posisipemain!=null?$data->posisipemain->nama:'Data tidak ditemukan',
                'fisik' => $datafisik,
                'teknik' => $datateknik,
                'taktik' => $datataktik,
            ]);

        }


        $kriteriadetail=kriteriadetail::select('*')
        ->whereIn('kriteria_id',function($query) {
            $query->select('id')->from('kriteria')->where('deleted_at',null)->where('tahunpenilaian_id',$this->th);
        })
        ->get();

        $datakriteria=kriteria::where('tahunpenilaian_id',$tahunpenilaian->id)->get();
        // dd($kriteriadetail,$dataakhir);

        return view('pages.admin.tahunpenilaiandetail.index',compact('datas','request','pages','tahunpenilaian','jmlkriteria','jmlkriteriadetail','dataakhir','jmlposisi','jmlpemain','kriteriadetail','datakriteria'));
    }
}
