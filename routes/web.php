<?php

use App\Http\Controllers\adminapicontroller;
use App\Http\Controllers\admincetakcontroller;
use App\Http\Controllers\admindashboardcontroller;
use App\Http\Controllers\adminkriteriacontroller;
use App\Http\Controllers\adminkriteriadetailcontroller;
use App\Http\Controllers\adminpelatihcontroller;
use App\Http\Controllers\adminpemaincontroller;
use App\Http\Controllers\adminpemainseleksicontroller;
use App\Http\Controllers\adminpenilaiancontroller;
use App\Http\Controllers\adminpenilaiandetailcontroller;
use App\Http\Controllers\adminposisipemaincontroller;
use App\Http\Controllers\adminposisiseleksicontroller;
use App\Http\Controllers\adminprosesperhitungancontroller;
use App\Http\Controllers\adminseedercontroller;
use App\Http\Controllers\adminseederthcontroller;
use App\Http\Controllers\adminsettingscontroller;
use App\Http\Controllers\admintahunpenilaiancontroller;
use App\Http\Controllers\admintahunpenilaiandetailcontroller;
use App\Http\Controllers\adminuserscontroller;
use App\Http\Controllers\landingcontroller;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
// use Facades\Yugo\SMSGateway\Interfaces\SMS;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


Route::get('/', [landingcontroller::class, 'index']);


//halaman admin fixed
Route::group(['middleware' => ['auth:web', 'verified']], function() {

    //DASHBOARD-MENU
    Route::get('/dashboard', [admindashboardcontroller::class, 'index'])->name('dashboard');
    //settings
    Route::get('/admin/settings', [adminsettingscontroller::class, 'index'])->name('settings');
    Route::put('/admin/settings/{id}', [adminsettingscontroller::class, 'update'])->name('settings.update');

    //MASTERING
    //USER
    Route::get('/admin/users', [adminuserscontroller::class, 'index'])->name('users');
    Route::get('/admin/users/{id}', [adminuserscontroller::class, 'edit'])->name('users.edit');
    Route::put('/admin/users/{id}', [adminuserscontroller::class, 'update'])->name('users.update');
    Route::delete('/admin/users/{id}', [adminuserscontroller::class, 'destroy'])->name('users.destroy');
    Route::get('/admin/datausers/cari', [adminuserscontroller::class, 'cari'])->name('users.cari');
    Route::get('/admin/datausers/create', [adminuserscontroller::class, 'create'])->name('users.create');
    Route::post('/admin/datausers', [adminuserscontroller::class, 'store'])->name('users.store');
    Route::delete('/admin/datausers/multidel', [adminuserscontroller::class, 'multidel'])->name('users.multidel');


    //pemain
    Route::get('/admin/pemain', [adminpemaincontroller::class, 'index'])->name('pemain');
    Route::get('/admin/pemain/{id}', [adminpemaincontroller::class, 'edit'])->name('pemain.edit');
    Route::put('/admin/pemain/{id}', [adminpemaincontroller::class, 'update'])->name('pemain.update');
    Route::delete('/admin/pemain/{id}', [adminpemaincontroller::class, 'destroy'])->name('pemain.destroy');
    Route::get('/admin/datapemain/cari', [adminpemaincontroller::class, 'cari'])->name('pemain.cari');
    Route::get('/admin/datapemain/create', [adminpemaincontroller::class, 'create'])->name('pemain.create');
    Route::post('/admin/datapemain', [adminpemaincontroller::class, 'store'])->name('pemain.store');
    Route::delete('/admin/datapemain/multidel', [adminpemaincontroller::class, 'multidel'])->name('pemain.multidel');


    //pemainseleksi
    Route::get('/admin/pemainseleksi/{tahunpenilaian}', [adminpemainseleksicontroller::class, 'index'])->name('pemainseleksi');
    // Route::get('/admin/pemainseleksi/{tahunpenilaian}/{id}', [adminpemainseleksicontroller::class, 'edit'])->name('pemainseleksi.edit');
    Route::put('/admin/pemainseleksi/{tahunpenilaian}/{id}', [adminpemainseleksicontroller::class, 'update'])->name('pemainseleksi.update');
    Route::delete('/admin/pemainseleksi/{tahunpenilaian}/{id}', [adminpemainseleksicontroller::class, 'destroy'])->name('pemainseleksi.destroy');
    Route::get('/admin/datapemainseleksi/{tahunpenilaian}/cari', [adminpemainseleksicontroller::class, 'cari'])->name('pemainseleksi.cari');
    Route::get('/admin/datapemainseleksi/{tahunpenilaian}/create', [adminpemainseleksicontroller::class, 'create'])->name('pemainseleksi.create');
    Route::post('/admin/datapemainseleksi/{tahunpenilaian}', [adminpemainseleksicontroller::class, 'store'])->name('pemainseleksi.store');
    Route::delete('/admin/datapemainseleksi/{tahunpenilaian}/multidel', [adminpemainseleksicontroller::class, 'multidel'])->name('pemainseleksi.multidel');
    Route::delete('/admin/datapemainseleksi/{tahunpenilaian}/detail/{id}', [adminpemainseleksicontroller::class, 'detail'])->name('pemainseleksi.detail
    detail');


//prosesperhitungan
    Route::get('/admin/prosesperhitungan/{tahunpenilaian}', [adminprosesperhitungancontroller::class, 'index'])->name('prosesperhitungan');
    Route::get('/admin/prosesperhitungan/{tahunpenilaian}/tampil', [adminprosesperhitungancontroller::class, 'tampil'])->name('prosesperhitungan.tampil');
    Route::get('/admin/prosesperhitungan/{tahunpenilaian}/selesai', [adminprosesperhitungancontroller::class, 'selesai'])->name('prosesperhitungan.selesai');
    Route::get('/admin/prosesperhitungan/{tahunpenilaian}/cetakhasilpenilaian', [admincetakcontroller::class, 'cetakhasilpenilaian'])->name('prosesperhitungan.cetakhasilpenilaian');


    Route::get('/admin/prosespenilaian/{tahunpenilaian}', [adminpenilaiancontroller::class, 'prosespenilaian'])->name('prosespenilaian');
    Route::get('/admin/prosespenilaian/{tahunpenilaian}/{id}', [adminpenilaiancontroller::class, 'edit'])->name('prosespenilaian.edit');
    Route::get('/admin/prosespenilaian/{tahunpenilaian}', [adminpenilaiancontroller::class, 'prosespenilaian'])->name('prosespenilaian');
    Route::put('/admin/prosespenilaian/{tahunpenilaian}/{id}', [adminpenilaiancontroller::class, 'update'])->name('prosespenilaian.update');
    Route::delete('/admin/prosespenilaian/{tahunpenilaian}/{id}', [adminpenilaiancontroller::class, 'destroy'])->name('prosespenilaian.destroy');
    Route::get('/admin/dataprosespenilaian/{tahunpenilaian}/create', [adminpenilaiancontroller::class, 'create'])->name('prosespenilaian.create');
    Route::post('/admin/dataprosespenilaian/{tahunpenilaian}', [adminpenilaiancontroller::class, 'store'])->name('prosespenilaian.store');
    Route::delete('/admin/dataprosespenilaian/{tahunpenilaian}/multidel', [adminpenilaiancontroller::class, 'multidel'])->name('prosespenilaian.multidel');


    //inputnilai
    Route::get('/admin/penilaiandetail/{tahunpenilaian}/{prosespenilaian}', [adminpenilaiandetailcontroller::class, 'index'])->name('penilaiandetail');

    Route::get('/admin/api/penilaiandetail/inputnilai/{tahunpenilaian}/{prosespenilaian}', [adminapicontroller::class, 'penilaiandetail_inputnilai'])->name('api.penilaiandetail.inputnilai');


    //posisiseleksi
    Route::get('/admin/posisiseleksi/{tahunpenilaian}', [adminposisiseleksicontroller::class, 'index'])->name('posisiseleksi');
    // Route::get('/admin/posisiseleksi/{tahunpenilaian}/{id}', [adminposisiseleksicontroller::class, 'edit'])->name('posisiseleksi.edit');
    Route::put('/admin/posisiseleksi/{tahunpenilaian}/{id}', [adminposisiseleksicontroller::class, 'update'])->name('posisiseleksi.update');
    Route::delete('/admin/posisiseleksi/{tahunpenilaian}/{id}', [adminposisiseleksicontroller::class, 'destroy'])->name('posisiseleksi.destroy');
    Route::get('/admin/dataposisiseleksi/{tahunpenilaian}/cari', [adminposisiseleksicontroller::class, 'cari'])->name('posisiseleksi.cari');
    Route::get('/admin/dataposisiseleksi/{tahunpenilaian}/create', [adminposisiseleksicontroller::class, 'create'])->name('posisiseleksi.create');
    Route::post('/admin/dataposisiseleksi/{tahunpenilaian}', [adminposisiseleksicontroller::class, 'store'])->name('posisiseleksi.store');
    Route::delete('/admin/dataposisiseleksi/{tahunpenilaian}/multidel', [adminposisiseleksicontroller::class, 'multidel'])->name('posisiseleksi.multidel');
    Route::delete('/admin/dataposisiseleksi/{tahunpenilaian}/detail/{id}', [adminposisiseleksicontroller::class, 'detail'])->name('posisiseleksi.detail
    detail');


    //posisipemain
    Route::get('/admin/posisipemain', [adminposisipemaincontroller::class, 'index'])->name('posisipemain');
    Route::get('/admin/posisipemain/{id}', [adminposisipemaincontroller::class, 'edit'])->name('posisipemain.edit');
    Route::put('/admin/posisipemain/{id}', [adminposisipemaincontroller::class, 'update'])->name('posisipemain.update');
    Route::delete('/admin/posisipemain/{id}', [adminposisipemaincontroller::class, 'destroy'])->name('posisipemain.destroy');
    Route::get('/admin/dataposisipemain/cari', [adminposisipemaincontroller::class, 'cari'])->name('posisipemain.cari');
    Route::get('/admin/dataposisipemain/create', [adminposisipemaincontroller::class, 'create'])->name('posisipemain.create');
    Route::post('/admin/dataposisipemain', [adminposisipemaincontroller::class, 'store'])->name('posisipemain.store');
    Route::delete('/admin/dataposisipemain/multidel', [adminposisipemaincontroller::class, 'multidel'])->name('posisipemain.multidel');



    //pelatih
    Route::get('/admin/pelatih', [adminpelatihcontroller::class, 'index'])->name('pelatih');
    Route::get('/admin/pelatih/{id}', [adminpelatihcontroller::class, 'edit'])->name('pelatih.edit');
    Route::put('/admin/pelatih/{id}', [adminpelatihcontroller::class, 'update'])->name('pelatih.update');
    Route::delete('/admin/pelatih/{id}', [adminpelatihcontroller::class, 'destroy'])->name('pelatih.destroy');
    Route::get('/admin/datapelatih/cari', [adminpelatihcontroller::class, 'cari'])->name('pelatih.cari');
    Route::get('/admin/datapelatih/create', [adminpelatihcontroller::class, 'create'])->name('pelatih.create');
    Route::post('/admin/datapelatih', [adminpelatihcontroller::class, 'store'])->name('pelatih.store');
    Route::delete('/admin/datapelatih/multidel', [adminpelatihcontroller::class, 'multidel'])->name('pelatih.multidel');


    //tahunpenilaian
    Route::get('/admin/tahunpenilaian', [admintahunpenilaiancontroller::class, 'index'])->name('tahunpenilaian');
    Route::get('/admin/tahunpenilaian/{id}', [admintahunpenilaiancontroller::class, 'edit'])->name('tahunpenilaian.edit');
    Route::put('/admin/tahunpenilaian/{id}', [admintahunpenilaiancontroller::class, 'update'])->name('tahunpenilaian.update');
    Route::delete('/admin/tahunpenilaian/{id}', [admintahunpenilaiancontroller::class, 'destroy'])->name('tahunpenilaian.destroy');
    Route::get('/admin/datatahunpenilaian/cari', [admintahunpenilaiancontroller::class, 'cari'])->name('tahunpenilaian.cari');
    Route::get('/admin/datatahunpenilaian/create', [admintahunpenilaiancontroller::class, 'create'])->name('tahunpenilaian.create');
    Route::post('/admin/datatahunpenilaian', [admintahunpenilaiancontroller::class, 'store'])->name('tahunpenilaian.store');
    Route::delete('/admin/datatahunpenilaian/multidel', [admintahunpenilaiancontroller::class, 'multidel'])->name('tahunpenilaian.multidel');
    Route::get('/admin/datatahunpenilaian/{tahunpenilaian}', [admintahunpenilaiandetailcontroller::class, 'index'])->name('tahunpenilaian.detail');

    Route::post('/admin/datatahunpenilaian/{tahunpenilaian}', [admintahunpenilaiandetailcontroller::class, 'store'])->name('tahunpenilaian.detail.store');
    Route::post('/admin/datatahunpenilaian/{tahunpenilaian}/updatekuota', [admintahunpenilaiandetailcontroller::class, 'updatekuota'])->name('tahunpenilaiandetail.updatekuota');
    Route::delete('/admin/datatahunpenilaian/{tahunpenilaian}/{id}', [admintahunpenilaiandetailcontroller::class, 'destroy'])->name('tahunpenilaian.detail.destroy');

    //API
    Route::get('/admin/api/kriteriadetail/{tahunpenilaian}', [admintahunpenilaiandetailcontroller::class, 'apikriteriadetail'])->name('api.kriteriadetail');
    Route::get('/admin/api/periksaminimum/{tahunpenilaian}', [admintahunpenilaiandetailcontroller::class, 'apiperiksaminimum'])->name('api.periksaminimum');
    Route::get('/admin/api/pemainseleksi/inputnilai/{tahunpenilaian}', [adminapicontroller::class, 'pemainseleksi_inputnilai'])->name('api.pemainseleksi.inputnilai');




    //kriteria
    Route::get('/admin/kriteria/{tahunpenilaian}', [adminkriteriacontroller::class, 'index'])->name('kriteria');
    Route::get('/admin/kriteria/{tahunpenilaian}/{id}', [adminkriteriacontroller::class, 'edit'])->name('kriteria.edit');
    Route::put('/admin/kriteria/{tahunpenilaian}/{id}', [adminkriteriacontroller::class, 'update'])->name('kriteria.update');
    Route::delete('/admin/kriteria/{tahunpenilaian}/{id}', [adminkriteriacontroller::class, 'destroy'])->name('kriteria.destroy');
    Route::get('/admin/datakriteria/{tahunpenilaian}/cari', [adminkriteriacontroller::class, 'cari'])->name('kriteria.cari');
    Route::get('/admin/datakriteria/{tahunpenilaian}/create', [adminkriteriacontroller::class, 'create'])->name('kriteria.create');
    Route::post('/admin/datakriteria/{tahunpenilaian}', [adminkriteriacontroller::class, 'store'])->name('kriteria.store');
    Route::delete('/admin/datakriteria/{tahunpenilaian}/multidel', [adminkriteriacontroller::class, 'multidel'])->name('kriteria.multidel');

    //kriteriadetail
    Route::get('/admin/kriteriadetail/{kriteria}', [adminkriteriadetailcontroller::class, 'index'])->name('kriteriadetail');
    Route::get('/admin/kriteriadetail/{kriteria}/{id}', [adminkriteriadetailcontroller::class, 'edit'])->name('kriteriadetail.edit');
    Route::put('/admin/kriteriadetail/{kriteria}/{id}', [adminkriteriadetailcontroller::class, 'update'])->name('kriteriadetail.update');
    Route::delete('/admin/kriteriadetail/{kriteria}/{id}', [adminkriteriadetailcontroller::class, 'destroy'])->name('kriteriadetail.destroy');
    Route::get('/admin/datakriteriadetail/cari/{kriteria}', [adminkriteriadetailcontroller::class, 'cari'])->name('kriteriadetail.cari');
    Route::get('/admin/datakriteriadetail/create/{kriteria}', [adminkriteriadetailcontroller::class, 'create'])->name('kriteriadetail.create');
    Route::post('/admin/datakriteriadetail/{kriteria}', [adminkriteriadetailcontroller::class, 'store'])->name('kriteriadetail.store');
    Route::delete('/admin/datakriteriadetail/multidel/{kriteria}', [adminkriteriadetailcontroller::class, 'multidel'])->name('kriteriadetail.multidel');

    //seeder
    Route::post('/admin/seeder/pemain', [adminseedercontroller::class, 'pemain'])->name('seeder.pemain');
    Route::post('/admin/seeder/tahunpenilaian', [adminseedercontroller::class, 'tahunpenilaian'])->name('seeder.tahunpenilaian');
    Route::post('/admin/seeder/pelatih', [adminseedercontroller::class, 'pelatih'])->name('seeder.pelatih');
    Route::post('/admin/seeder/kriteria', [adminseedercontroller::class, 'kriteria'])->name('seeder.kriteria');
    Route::post('/admin/seeder/kriteriadetail', [adminseedercontroller::class, 'kriteriadetail'])->name('seeder.kriteriadetail');
    Route::post('/admin/seeder/posisi', [adminseedercontroller::class, 'posisi'])->name('seeder.posisi');
    Route::post('/admin/seeder/hard', [adminseedercontroller::class, 'hard'])->name('seeder.hard');


    //seder dalam tahunpenilaian
    Route::get('/admin/seeder/th/{tahunpenilaian}/pemain', [adminseederthcontroller::class, 'pemain'])->name('seeder.pemain.th');
    Route::get('/admin/seeder/th/{tahunpenilaian}/kriteria', [adminseederthcontroller::class, 'kriteria'])->name('seeder.kriteria.th');
    Route::get('/admin/seeder/th/{tahunpenilaian}/kriteriadetail', [adminseederthcontroller::class, 'kriteriadetail'])->name('seeder.kriteriadetail.th');
    Route::get('/admin/seeder/th/{tahunpenilaian}/posisi', [adminseederthcontroller::class, 'posisi'])->name('seeder.posisi.th');
    Route::get('/admin/seeder/th/{tahunpenilaian}/prosespenilaian', [adminseederthcontroller::class, 'prosespenilaian'])->name('seeder.prosespenilaian.th');
    Route::get('/admin/seeder/th/{tahunpenilaian}/randomnilaipemain', [adminseederthcontroller::class, 'randomnilaipemain'])->name('seeder.randomnilaipemain.th');
    Route::get('/admin/seeder/th/{tahunpenilaian}/parameter', [adminseederthcontroller::class, 'parameter'])->name('seeder.parameter.th');

    //proseslainlain
    Route::post('/admin/proses/cleartemp', [adminprosescontroller::class, 'cleartemp'])->name('cleartemp');

});

