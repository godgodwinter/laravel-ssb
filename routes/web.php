<?php

use App\Http\Controllers\admindashboardcontroller;
use App\Http\Controllers\adminkriteriacontroller;
use App\Http\Controllers\adminpelatihcontroller;
use App\Http\Controllers\adminpemaincontroller;
use App\Http\Controllers\adminposisipemaincontroller;
use App\Http\Controllers\adminsettingscontroller;
use App\Http\Controllers\admintahunpenilaiancontroller;
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


    //kriteria
    Route::get('/admin/kriteria', [adminkriteriacontroller::class, 'index'])->name('kriteria');
    Route::get('/admin/kriteria/{id}', [adminkriteriacontroller::class, 'edit'])->name('kriteria.edit');
    Route::put('/admin/kriteria/{id}', [adminkriteriacontroller::class, 'update'])->name('kriteria.update');
    Route::delete('/admin/kriteria/{id}', [adminkriteriacontroller::class, 'destroy'])->name('kriteria.destroy');
    Route::get('/admin/datakriteria/cari', [adminkriteriacontroller::class, 'cari'])->name('kriteria.cari');
    Route::get('/admin/datakriteria/create', [adminkriteriacontroller::class, 'create'])->name('kriteria.create');
    Route::post('/admin/datakriteria', [adminkriteriacontroller::class, 'store'])->name('kriteria.store');
    Route::delete('/admin/datakriteria/multidel', [adminkriteriacontroller::class, 'multidel'])->name('kriteria.multidel');


    //seeder
    Route::post('/admin/seeder/pemain', [adminseedercontroller::class, 'pemain'])->name('seeder.pemain');
    Route::post('/admin/seeder/pelatih', [adminseedercontroller::class, 'pelatih'])->name('seeder.pelatih');
    Route::post('/admin/seeder/kriteria', [adminseedercontroller::class, 'kriteria'])->name('seeder.kriteria');
    Route::post('/admin/seeder/hard', [adminseedercontroller::class, 'hard'])->name('seeder.hard');
    //proseslainlain
    Route::post('/admin/proses/cleartemp', [adminprosescontroller::class, 'cleartemp'])->name('cleartemp');

});

