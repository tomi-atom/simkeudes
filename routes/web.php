<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});
*/
if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}

Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => ['web', 'cekuser:1']], function(){
	Route::get('admin', function() {
		echo "Selamat Datang admin";

	});
});

Route::resource('bidang', 'BidangtktController');

Route::resource('indikator', 'IndikatortktController');

Route::group(['middleware' => ['web', 'cekuser:1']], function() {
   Route::RESOURCE('penelitianng', 'Penelitian\PenelitianngController');
   Route::RESOURCE('penelitianngperbaikan', 'Penelitian\PenelitianngPerbaikanController');
   Route::GET('penelitianng/resume/{id}','Penelitian\PenelitianngController@resume')->name('penelitianng.resume');
   Route::GET('penelitianng/unduh/{id}','Penelitian\PenelitianngController@unduh')->name('penelitianng.unduh');
   Route::GET('penelitianng/penyetujuan/{id}', 'Penelitian\PenelitianngController@setuju')->name('penelitianng.setuju');
   Route::GET('penelitianng/response/{id}','Penelitian\PenelitianngController@response')->name('penelitianng.response');
   Route::GET('penelitianng/catatan/{id}','Penelitian\PenelitianngController@baca')->name('penelitianng.baca');

   Route::RESOURCE('penelitianng.proposal',   'Penelitian\ProposalController');
   Route::POST('penelitianng.proposal/fetch','Penelitian\ProposalController@fetchilmu')->name('penelitianng.fetch');
   Route::POST('penelitianng.proposal/tkt',   'Penelitian\ProposalController@loadtkt')->name('penelitianng.reloadtkt');
   Route::POST('penelitianng.proposal/topik','Penelitian\ProposalController@loadtpk') ->name('penelitianng.reloadtpk');
   Route::POST('penelitianng.proposal/bidang','Penelitian\ProposalController@loadbdg')->name('penelitianng.reloadbdg');

   Route::RESOURCE('penelitianng.anggota', 'Penelitian\AnggotaController');
   Route::POST('penelitianng.anggota/data/{id}','Penelitian\AnggotaController@loadanggota')->name('penelitianng.list');
   Route::POST('penelitianng.anggota/peserta','Penelitian\AnggotaController@reloadpeserta')->name('penelitianng.data');
   Route::POST('penelitianng.anggota/rincian','Penelitian\AnggotaController@rincipeserta')->name('penelitianng.detail');

   Route::RESOURCE('penelitianng.subtansi', 'Penelitian\SubtansiController');
   Route::POST('penelitianng.subtansi/get/{id}','Penelitian\SubtansiController@getusulan')->name('penelitianng.usulan');
   Route::POST('penelitianng.subtansi/update/{id}','Penelitian\SubtansiController@perbaru')->name('penelitianng.ganti');

   Route::RESOURCE('penelitianng.luaran', 'Penelitian\LuaranController');
   Route::POST('penelitianng.luaran/wajib','Penelitian\LuaranController@luaranwajib')->name('penelitianng.wajib');
   Route::POST('penelitianng.luaran/tambah','Penelitian\LuaranController@luarantambah')->name('penelitianng.tambah');
   Route::POST('penelitianng.luaran/target','Penelitian\LuaranController@loadtarget')->name('penelitianng.target');

   Route::RESOURCE('penelitianng.anggaran',   'Penelitian\AnggaranController');
    Route::GET('penelitianng.anggaran/edit/{id}','Penelitian\AnggaranController@edit')->name('penelitiananggaran.edit');
    Route::POST('penelitianng.anggaran/total', 'Penelitian\AnggaranController@showtotal')->name('penelitianng.showtotal');
   Route::POST('penelitianng.anggaran/honor', 'Penelitian\AnggaranController@showhonor')->name('penelitianng.showhonor');
   Route::POST('penelitianng.anggaran/bahan', 'Penelitian\AnggaranController@showbahan')->name('penelitianng.showbahan');
   Route::POST('penelitianng.anggaran/jalan', 'Penelitian\AnggaranController@showjalan')->name('penelitianng.showjalan');
   Route::POST('penelitianng.anggaran/barang','Penelitian\AnggaranController@showbrng')->name('penelitianng.showbarang');

   Route::RESOURCE('validasipenelitian', 'Penelitian\ValidasiController');


   Route::RESOURCE('pengabdianng', 'Pengabdian\PengabdianngController');
   Route::RESOURCE('pengabdianngperbaikan', 'Pengabdian\PengabdianngPerbaikanController');
   Route::GET('pengabdianng/resume/{id}','Pengabdian\PengabdianngController@resume')->name('pengabdianng.resume');
   Route::GET('pengabdianng/unduh/{id}','Pengabdian\PengabdianngController@unduh')->name('pengabdianng.unduh');
   Route::GET('pengabdianng/penyetujuan/{id}', 'Pengabdian\PengabdianngController@setuju')->name('pengabdianng.setuju');
   Route::GET('pengabdianng/response/{id}','Pengabdian\PengabdianngController@response')->name('pengabdianng.response');
   Route::GET('pengabdianng/catatan/{id}','Pengabdian\PengabdianngController@baca')->name('pengabdianng.baca');

   Route::RESOURCE('pengabdianng.proposal',   'Pengabdian\ProposalController');
   Route::POST('pengabdianng.proposal/fetch','Pengabdian\ProposalController@fetchilmu')->name('pengabdianng.fetch');
   Route::POST('pengabdianng.proposal/topik','Pengabdian\ProposalController@loadtpk') ->name('pengabdianng.reloadtpk');
   Route::POST('pengabdianng.proposal/bidang','Pengabdian\ProposalController@loadbdg')->name('pengabdianng.reloadbdg');

   Route::RESOURCE('pengabdianng.anggota', 'Pengabdian\AnggotaController');
   Route::POST('pengabdianng.anggota/data/{id}','Pengabdian\AnggotaController@loadanggota')->name('pengabdianng.list');
   Route::POST('pengabdianng.anggota/peserta','Pengabdian\AnggotaController@reloadpeserta')->name('pengabdianng.data');
   Route::POST('pengabdianng.anggota/rincian','Pengabdian\AnggotaController@rincipeserta')->name('pengabdianng.detail');

   Route::RESOURCE('pengabdianng.subtansi', 'Pengabdian\SubtansiController');
   Route::POST('pengabdianng.subtansi/get/{id}','Pengabdian\SubtansiController@getusulan')->name('pengabdianng.usulan');
   Route::POST('pengabdianng.subtansi/update/{id}','Pengabdian\SubtansiController@perbaru')->name('pengabdianng.ganti');

   Route::RESOURCE('pengabdianng.luaran', 'Pengabdian\LuaranController');
   Route::POST('pengabdianng.luaran/wajib','Pengabdian\LuaranController@luaranwajib')->name('pengabdianng.wajib');
   Route::POST('pengabdianng.luaran/tambah','Pengabdian\LuaranController@luarantambah')->name('pengabdianng.tambah');
   Route::POST('pengabdianng.luaran/target','Pengabdian\LuaranController@loadtarget')->name('pengabdianng.target');

   Route::RESOURCE('pengabdianng.anggaran',   'Pengabdian\AnggaranController');
    Route::GET('pengabdianng.anggaran/edit/{id}', 'Pengabdian\AnggaranController@edit')->name('pengabdiananggaran.edit');
   Route::POST('pengabdianng.anggaran/total','Pengabdian\AnggaranController@showtotal')->name('pengabdianng.showtotal');
   Route::POST('pengabdianng.anggaran/honor','Pengabdian\AnggaranController@showhonor')->name('pengabdianng.showhonor');
   Route::POST('pengabdianng.anggaran/bahan','Pengabdian\AnggaranController@showbahan')->name('pengabdianng.showbahan');
   Route::POST('pengabdianng.anggaran/jalan','Pengabdian\AnggaranController@showjalan')->name('pengabdianng.showjalan');
   Route::POST('pengabdianng.anggaran/barang','Pengabdian\AnggaranController@showbrng')->name('pengabdianng.showbarang');

   Route::RESOURCE('validasipengabdian', 'Pengabdian\ValidasiController');

////Perbaikan
Route::RESOURCE('perbaikanpenelitianng', 'PerbaikanPenelitian\PenelitianngController');
   Route::GET('perbaikanpenelitianng/resume/{id}','PerbaikanPenelitian\PenelitianngController@resume')->name('perbaikanpenelitianng.resume');
   Route::GET('perbaikanpenelitianng/unduh/{id}','PerbaikanPenelitian\PenelitianngController@unduh')->name('perbaikanpenelitianng.unduh');
   Route::GET('perbaikanpenelitianng/penyetujuan/{id}', 'PerbaikanPenelitian\PenelitianngController@setuju')->name('perbaikanpenelitianng.setuju');
   Route::GET('perbaikanpenelitianng/response/{id}','PerbaikanPenelitian\PenelitianngController@response')->name('perbaikanpenelitianng.response');
   Route::GET('perbaikanpenelitianng/catatan/{id}','PerbaikanPenelitian\PenelitianngController@baca')->name('perbaikanpenelitianng.baca');

   Route::RESOURCE('perbaikanpenelitianng.proposal',   'PerbaikanPenelitian\ProposalController');
   Route::POST('perbaikanpenelitianng.proposal/fetch','PerbaikanPenelitian\ProposalController@fetchilmu')->name('perbaikanpenelitianng.fetch');
   Route::POST('perbaikanpenelitianng.proposal/tkt',   'PerbaikanPenelitian\ProposalController@loadtkt')->name('perbaikanpenelitianng.reloadtkt');
   Route::POST('perbaikanpenelitianng.proposal/topik','PerbaikanPenelitian\ProposalController@loadtpk') ->name('perbaikanpenelitianng.reloadtpk');
   Route::POST('perbaikanpenelitianng.proposal/bidang','PerbaikanPenelitian\ProposalController@loadbdg')->name('perbaikanpenelitianng.reloadbdg');

   Route::RESOURCE('perbaikanpenelitianng.anggota', 'PerbaikanPenelitian\AnggotaController');
   Route::POST('perbaikanpenelitianng.anggota/data/{id}','PerbaikanPenelitian\AnggotaController@loadanggota')->name('perbaikanpenelitianng.list');
   Route::POST('perbaikanpenelitianng.anggota/peserta','PerbaikanPenelitian\AnggotaController@reloadpeserta')->name('perbaikanpenelitianng.data');
   Route::POST('perbaikanpenelitianng.anggota/rincian','PerbaikanPenelitian\AnggotaController@rincipeserta')->name('perbaikanpenelitianng.detail');

   Route::RESOURCE('perbaikanpenelitianng.subtansi', 'PerbaikanPenelitian\SubtansiController');
   Route::POST('perbaikanpenelitianng.subtansi/get/{id}','PerbaikanPenelitian\SubtansiController@getusulan')->name('perbaikanpenelitianng.usulan');
   Route::POST('perbaikanpenelitianng.subtansi/update/{id}','PerbaikanPenelitian\SubtansiController@perbaru')->name('perbaikanpenelitianng.ganti');

   Route::RESOURCE('perbaikanpenelitianng.luaran', 'PerbaikanPenelitian\LuaranController');
   Route::POST('perbaikanpenelitianng.luaran/wajib','PerbaikanPenelitian\LuaranController@luaranwajib')->name('perbaikanpenelitianng.wajib');
   Route::POST('perbaikanpenelitianng.luaran/tambah','PerbaikanPenelitian\LuaranController@luarantambah')->name('perbaikanpenelitianng.tambah');
   Route::POST('perbaikanpenelitianng.luaran/target','PerbaikanPenelitian\LuaranController@loadtarget')->name('perbaikanpenelitianng.target');

   Route::RESOURCE('perbaikanpenelitianng.anggaran',   'PerbaikanPenelitian\AnggaranController');
    Route::GET('perbaikanpenelitianng.anggaran/edit/{id}','PerbaikanPenelitian\AnggaranController@edit')->name('penelitiananggaran.edit');
    Route::POST('perbaikanpenelitianng.anggaran/total', 'PerbaikanPenelitian\AnggaranController@showtotal')->name('perbaikanpenelitianng.showtotal');
   Route::POST('perbaikanpenelitianng.anggaran/honor', 'PerbaikanPenelitian\AnggaranController@showhonor')->name('perbaikanpenelitianng.showhonor');
   Route::POST('perbaikanpenelitianng.anggaran/bahan', 'PerbaikanPenelitian\AnggaranController@showbahan')->name('perbaikanpenelitianng.showbahan');
   Route::POST('perbaikanpenelitianng.anggaran/jalan', 'PerbaikanPenelitian\AnggaranController@showjalan')->name('perbaikanpenelitianng.showjalan');
   Route::POST('perbaikanpenelitianng.anggaran/barang','PerbaikanPenelitian\AnggaranController@showbrng')->name('perbaikanpenelitianng.showbarang');

   Route::RESOURCE('validasiperbaikanpenelitian', 'PerbaikanPenelitian\ValidasiController');


   Route::RESOURCE('perbaikanpengabdianng', 'PerbaikanPengabdian\PengabdianngController');
   Route::GET('perbaikanpengabdianng/resume/{id}','PerbaikanPengabdian\PengabdianngController@resume')->name('perbaikanpengabdianng.resume');
   Route::GET('perbaikanpengabdianng/unduh/{id}','PerbaikanPengabdian\PengabdianngController@unduh')->name('perbaikanpengabdianng.unduh');
   Route::GET('perbaikanpengabdianng/penyetujuan/{id}', 'PerbaikanPengabdian\PengabdianngController@setuju')->name('perbaikanpengabdianng.setuju');
   Route::GET('perbaikanpengabdianng/response/{id}','PerbaikanPengabdian\PengabdianngController@response')->name('perbaikanpengabdianng.response');
   Route::GET('perbaikanpengabdianng/catatan/{id}','PerbaikanPengabdian\PengabdianngController@baca')->name('perbaikanpengabdianng.baca');

   Route::RESOURCE('perbaikanpengabdianng.proposal',   'PerbaikanPengabdian\ProposalController');
   Route::POST('perbaikanpengabdianng.proposal/fetch','PerbaikanPengabdian\ProposalController@fetchilmu')->name('perbaikanpengabdianng.fetch');
   Route::POST('perbaikanpengabdianng.proposal/topik','PerbaikanPengabdian\ProposalController@loadtpk') ->name('perbaikanpengabdianng.reloadtpk');
   Route::POST('perbaikanpengabdianng.proposal/bidang','PerbaikanPengabdian\ProposalController@loadbdg')->name('perbaikanpengabdianng.reloadbdg');

   Route::RESOURCE('perbaikanpengabdianng.anggota', 'PerbaikanPengabdian\AnggotaController');
   Route::POST('perbaikanpengabdianng.anggota/data/{id}','PerbaikanPengabdian\AnggotaController@loadanggota')->name('perbaikanpengabdianng.list');
   Route::POST('perbaikanpengabdianng.anggota/peserta','PerbaikanPengabdian\AnggotaController@reloadpeserta')->name('perbaikanpengabdianng.data');
   Route::POST('perbaikanpengabdianng.anggota/rincian','PerbaikanPengabdian\AnggotaController@rincipeserta')->name('perbaikanpengabdianng.detail');

   Route::RESOURCE('perbaikanpengabdianng.subtansi', 'PerbaikanPengabdian\SubtansiController');
   Route::POST('perbaikanpengabdianng.subtansi/get/{id}','PerbaikanPengabdian\SubtansiController@getusulan')->name('perbaikanpengabdianng.usulan');
   Route::POST('perbaikanpengabdianng.subtansi/update/{id}','PerbaikanPengabdian\SubtansiController@perbaru')->name('perbaikanpengabdianng.ganti');

   Route::RESOURCE('perbaikanpengabdianng.luaran', 'PerbaikanPengabdian\LuaranController');
   Route::POST('perbaikanpengabdianng.luaran/wajib','PerbaikanPengabdian\LuaranController@luaranwajib')->name('perbaikanpengabdianng.wajib');
   Route::POST('perbaikanpengabdianng.luaran/tambah','PerbaikanPengabdian\LuaranController@luarantambah')->name('perbaikanpengabdianng.tambah');
   Route::POST('perbaikanpengabdianng.luaran/target','PerbaikanPengabdian\LuaranController@loadtarget')->name('perbaikanpengabdianng.target');

   Route::RESOURCE('perbaikanpengabdianng.anggaran',   'PerbaikanPengabdian\AnggaranController');
    Route::GET('perbaikanpengabdianng.anggaran/edit/{id}', 'PerbaikanPengabdian\AnggaranController@edit')->name('pengabdiananggaran.edit');
   Route::POST('perbaikanpengabdianng.anggaran/total','PerbaikanPengabdian\AnggaranController@showtotal')->name('perbaikanpengabdianng.showtotal');
   Route::POST('perbaikanpengabdianng.anggaran/honor','PerbaikanPengabdian\AnggaranController@showhonor')->name('perbaikanpengabdianng.showhonor');
   Route::POST('perbaikanpengabdianng.anggaran/bahan','PerbaikanPengabdian\AnggaranController@showbahan')->name('perbaikanpengabdianng.showbahan');
   Route::POST('perbaikanpengabdianng.anggaran/jalan','PerbaikanPengabdian\AnggaranController@showjalan')->name('perbaikanpengabdianng.showjalan');
   Route::POST('perbaikanpengabdianng.anggaran/barang','PerbaikanPengabdian\AnggaranController@showbrng')->name('perbaikanpengabdianng.showbarang');

   Route::RESOURCE('validasiperbaikanpengabdian', 'PerbaikanPengabdian\ValidasiController');





    Route::GET('rancangan/resume/{id}','Pelaksanaan\RancanganController@resume')->name('rancangan.resume');
    Route::GET('rancangan/penyetujuan/{id}', 'Pelaksanaan\RancanganController@setuju')->name('rancangan.setuju');
    Route::GET('rancangan/response/{id}','Pelaksanaan\RancanganController@response')->name('rancangan.response');
    Route::GET('rancangan/catatan/{id}','Pelaksanaan\RancanganController@baca')->name('rancangan.baca');

    Route::RESOURCE('rancangan', 'Pelaksanaan\RancanganController');
    Route::RESOURCE('catatanharian', 'Pelaksanaan\CatatanHarianController');
    Route::resource('catatanharian.catatan', 'Pelaksanaan\CatatanController');
     Route::GET('catatanharian/resume/{id}','Pelaksanaan\CatatanController@resume')->name('catatanharian.resume');

    Route::get('catatanharian_data/get_data', 'PelaksanaanCatatanController@show');

    Route::RESOURCE('catatanharian.subtansi', 'Pelaksanaan\SubtansiController');
    Route::RESOURCE('catatanharian_subtansi', 'Pelaksanaan\SubtansiController');
    Route::POST('catatanharian.subtansi/update/{id}','Pelaksanaan\SubtansiController@update')->name('catatanharian.ganti');
    Route::GET('catatanharian/show/{id}','Pelaksanaan\SubtansiController@show')->name('catatanharian.show');
    Route::GET('catatanharian/destroy/{id}','Pelaksanaan\CatatanController@destroy')->name('catatanharian.destroy');
    Route::POST('catatanharian.subtansi/get/{id}','Pelaksanaan\SubtansiController@getusulan')->name('catatanharian.usulan');

    Route::resource('unggahcatatan', 'Pelaksanaan\UnggahCatatan');
    Route::get('unggahcatatan_data/get_data', 'Pelaksanaan\UnggahCatatan@show');
    Route::get('unggahcatatan_data/get_data', 'Pelaksanaan\CatatanHarianController@show');
    Route::RESOURCE('laporankemajuan', 'Pelaksanaan\LaporanKemajuanController');
    
    Route::RESOURCE('luarankemajuan', 'Pelaksanaan\LuaranKemajuanController');
   Route::POST('luarankemajuan/wajib','Pelaksanaan\LuaranKemajuanController@luaranwajib')->name('luarankemajuan.wajib');
   Route::POST('luarankemajuan/tambah','Pelaksanaan\LuaranKemajuanController@luarantambah')->name('luarankemajuan.tambah');
   Route::POST('luarankemajuan/target','Pelaksanaan\LuaranKemajuanController@loadtarget')->name('luarankemajuan.target');
   Route::GET('luarankemajuan/baca/{id}','Pelaksanaan\LuaranKemajuanController@baca')->name('luarankemajuan.baca');


    
    Route::RESOURCE('laporanakhir', 'Pelaksanaan\LaporanAkhirController');
    Route::RESOURCE('validasilaporanakhir', 'Pelaksanaan\LaporanAkhir\ValidasiController');
    Route::GET('validasilaporanakhir/bacalaporan/{id}','Pelaksanaan\LaporanAkhir\ValidasiController@bacalaporan')->name('validasilaporanakhir.bacalaporan');
    Route::GET('validasilaporanakhir/bacaanggaran/{id}','Pelaksanaan\LaporanAkhir\ValidasiController@bacaanggaran')->name('validasilaporanakhir.bacaanggaran');
   
 
    Route::RESOURCE('luaranakhir', 'Pelaksanaan\LaporanAkhir\LuaranAkhirController');
   Route::GET('luaranakhir/showlainnya/{id}','Pelaksanaan\LaporanAkhir\LuaranAkhirController@showlainnya')->name('luaranakhir.showlainnya');
   Route::POST('luaranakhir/datalainnya','Pelaksanaan\LaporanAkhir\LuaranAkhirController@datalainnya')->name('luaranakhir.datalainnya');

   Route::GET('luaranakhir/showwajib/{id}','Pelaksanaan\LaporanAkhir\LuaranAkhirController@showwajib')->name('luaranakhir.showwajib');
   Route::POST('luaranakhir/datawajib','Pelaksanaan\LaporanAkhir\LuaranAkhirController@datawajib')->name('luaranakhir.datawajib');

   Route::GET('luaranakhir/showtambahan/{id}','Pelaksanaan\LaporanAkhir\LuaranAkhirController@showtambahan')->name('luaranakhir.showtambahan');
   Route::POST('luaranakhir/datatambahan','Pelaksanaan\LaporanAkhir\LuaranAkhirController@datatambahan')->name('luaranakhir.datatambahan');
   Route::RESOURCE('penggunaananggaranakhir', 'Pelaksanaan\LaporanAkhir\PenggunaanAnggaranAkhirController');


   Route::POST('luaranakhir/wajib','Pelaksanaan\LaporanAkhir\LuaranAkhirController@luaranwajib')->name('luaranakhir.wajib');
   Route::POST('luaranakhir/tambah','Pelaksanaan\LaporanAkhir\LuaranAkhirController@luarantambah')->name('luaranakhir.tambah');
   Route::POST('luaranakhir/target','Pelaksanaan\LaporanAkhir\LuaranAkhirController@loadtarget')->name('luaranakhir.target');
   Route::GET('luaranakhir/baca/{id}','Pelaksanaan\LaporanAkhir\LuaranAkhirController@baca')->name('luaranakhir.baca');



    Route::RESOURCE('penggunaananggaran', 'Pelaksanaan\PenggunaanAnggaranController');
    Route::RESOURCE('tanggungjawab', 'Pelaksanaan\TanggungJawabController');
    Route::RESOURCE('berkasseminar', 'Pelaksanaan\BerkasSeminarController');
    Route::RESOURCE('hasilpenilaian', 'Pelaksanaan\HasilPenilaianController');
    Route::RESOURCE('skseminar', 'Pelaksanaan\SkSeminarController');
    Route::RESOURCE('pengembaliandana', 'Pelaksanaan\PengembalianDanaController');



  //  Route::get('file-upload', 'FileUploadController@index');

    //Route::post('file-upload/upload', 'FileUploadController@upload')->name('upload');


});


Route::group(['middleware' => ['web', 'cekuser:2']], function(){

    //Seleksi
 
    Route::resource('penelitianr', 'Reviewer\Seleksi\PenelitianReviewerController');
    Route::get('penelitianr/get_data', 'Reviewer\Seleksi\PenelitianReviewerController@show');
    Route::get('penelitianrlama/get_data', 'Reviewer\Seleksi\PenelitianReviewerController@showlama');
    Route::GET('penelitianr/resume/{id}','Reviewer\Seleksi\PenelitianReviewerController@resume')->name('penelitianr.resume');
     Route::GET('penelitianr/resumenilai/{id}','Reviewer\Seleksi\PenelitianReviewerController@resumenilai')->name('penelitianr.resumenilai');
    Route::GET('penelitianr/resumeberkas/{id}','Reviewer\Seleksi\PenelitianReviewerController@resumeberkas')->name('penelitianr.resumeberkas');
     Route::POST('penelitianr/get/{id}','Reviewer\Seleksi\PenelitianReviewerController@getnilai')->name('penelitianr.nilai');



    Route::resource('pengabdianr', 'Reviewer\Seleksi\PengabdianReviewerController');
    Route::get('pengabdianr/get_data', 'Reviewer\Seleksi\PengabdianReviewerController@show');
    Route::get('pengabdianrlama/get_data', 'Reviewer\Seleksi\PengabdianReviewerController@showlama');
    Route::GET('pengabdianr/resume/{id}','Reviewer\Seleksi\PengabdianReviewerController@resume')->name('pengabdianr.resume');
    Route::GET('pengabdianr/resumenilai/{id}','Reviewer\Seleksi\PengabdianReviewerController@resumenilai')->name('pengabdianr.resumenilai');
    Route::GET('pengabdianr/resumeberkas/{id}','Reviewer\Seleksi\PengabdianReviewerController@resumeberkas')->name('pengabdianr.resumeberkas');
    Route::POST('pengabdianr/get/{id}','Reviewer\Seleksi\PengabdianReviewerController@getnilai')->name('pengabdianr.nilai');


    //Pelaksanaan
    Route::resource('r_rancangan', 'Reviewer\Pelaksanaan\RancanganController');
    Route::get('r_rancangan/get_data', 'Reviewer\Pelaksanaan\RancanganController@showtambah');
    Route::GET('r_rancangan/resume/{id}','Reviewer\Pelaksanaan\RancanganController@resume')->name('r_rancangan.resume');
    Route::GET('r_rancangan/resumeberkas/{id}','Reviewer\Pelaksanaan\RancanganController@resumeberkas')->name('r_rancangan.resumeberkas');

    Route::resource('r_catatan', 'Reviewer\Pelaksanaan\CatatanHarianController');
    Route::get('r_catatan/get_data', 'Reviewer\Pelaksanaan\CatatanHarianController@show');
    Route::GET('r_catatan/resume/{id}','Reviewer\Pelaksanaan\CatatanHarianController@resume')->name('r_catatan.resume');
    Route::DELETE('r_catatan/verifikasi/{id}','Reviewer\Pelaksanaan\CatatanHarianController@verifikasi')->name('r_catatan.verifikasi');

    Route::RESOURCE('r_catatanharian', 'Reviewer\Pelaksanaan\CatatanHarianController');
    Route::resource('r_catatanharian.r_catatan', 'Reviewer\Pelaksanaan\CatatanController');
    Route::get('r_catatanharian_data/get_data', 'Reviewer\Pelaksanaan\CatatanController@show');

    Route::RESOURCE('r_catatanharian.subtansi', 'Reviewer\Pelaksanaan\SubtansiController');
    Route::RESOURCE('r_catatanharian_subtansi', 'Reviewer\Pelaksanaan\SubtansiController');
    Route::POST('r_catatanharian.subtansi/update/{id}','Reviewer\Pelaksanaan\SubtansiController@update')->name('r_catatanharian.ganti');
    Route::GET('r_catatanharian/show/{id}','Reviewer\Pelaksanaan\SubtansiController@show')->name('r_catatanharian.show');
    Route::GET('r_catatanharian/destroy/{id}','Reviewer\Pelaksanaan\CatatanController@destroy')->name('r_catatanharian.destroy');
    Route::POST('r_catatanharian.subtansi/get/{id}','Reviewer\Pelaksanaan\SubtansiController@getusulan')->name('r_catatanharian.usulan');
    Route::GET('r_catatanharian/resume/{id}','Reviewer\Pelaksanaan\CatatanController@resume')->name('r_catatanharian.resume');


    Route::resource('r_laporankemajuan', 'Reviewer\Pelaksanaan\LaporanKemajuanController');
    Route::get('r_laporankemajuan/get_data', 'Reviewer\Pelaksanaan\LaporanKemajuanController@show');
    Route::GET('r_laporankemajuan/resume/{id}','Reviewer\Pelaksanaan\LaporanKemajuanController@resume')->name('r_laporankemajuan.resume');

    Route::resource('r_laporanakhir', 'Reviewer\Pelaksanaan\LaporanAkhirController');
    Route::get('r_laporanakhir/get_data', 'Reviewer\Pelaksanaan\LaporanAkhirController@show');
    Route::GET('r_laporanakhir/resume/{id}','Reviewer\Pelaksanaan\LaporanAkhirController@resume')->name('r_laporanakhir.resume');

    Route::resource('r_anggaran', 'Reviewer\Pelaksanaan\PenggunaanAnggaranController');
    Route::get('r_anggaran/get_data', 'Reviewer\Pelaksanaan\PenggunaanAnggaranController@show');
    Route::GET('r_anggaran/resume/{id}','Reviewer\Pelaksanaan\PenggunaanAnggaranController@resume')->name('r_anggaran.resume');

    Route::resource('r_tanggungjawab', 'Reviewer\Pelaksanaan\TanggungJawabController');
    Route::get('r_tanggungjawab/get_data', 'Reviewer\Pelaksanaan\TanggungJawabController@show');
    Route::GET('r_tanggungjawab/resume/{id}','Reviewer\Pelaksanaan\TanggungJawabController@resume')->name('r_tanggungjawab.resume');

    Route::resource('r_berkasseminar', 'Reviewer\Pelaksanaan\BerkasSeminarController');
    Route::get('r_berkasseminar/get_data', 'Reviewer\Pelaksanaan\BerkasSeminarController@show');
    Route::GET('r_berkasseminar/resume/{id}','Reviewer\Pelaksanaan\BerkasSeminarController@resume')->name('r_berkasseminar.resume');

    Route::resource('r_hasilpenilaian', 'Reviewer\Pelaksanaan\HasilPenilaianController');
    Route::get('r_hasilpenilaian/get_data', 'Reviewer\Pelaksanaan\HasilPenilaianController@show');
    Route::GET('r_hasilpenilaian/resume/{id}','Reviewer\Pelaksanaan\HasilPenilaianController@resume')->name('r_hasilpenilaian.resume');

    Route::resource('r_skseminar', 'Reviewer\Pelaksanaan\SkSeminarController');
    Route::get('r_skseminar/get_data', 'Reviewer\Pelaksanaan\SkSeminarController@show');
    Route::GET('r_skseminar/resume/{id}','Reviewer\Pelaksanaan\SkSeminarController@resume')->name('r_skseminar.resume');

    Route::resource('r_pengembaliandana', 'Reviewer\Pelaksanaan\PengembalianDanaController');
    Route::get('r_pengembaliandana/get_data', 'Reviewer\Pelaksanaan\PengembalianDanaController@show');
    Route::GET('r_pengembaliandana/resume/{id}','Reviewer\Pelaksanaan\PengembalianDanaController@resume')->name('r_pengembaliandana.resume');
    
    Route::resource('rn_laporankemajuan', 'Reviewer\Penilaian\PenilaianLaporanKemajuanController');
    Route::get('rn_laporankemajuan/get_data', 'Reviewer\Penilaian\PenilaianLaporanKemajuanController@show');
    Route::GET('rn_laporankemajuan/resume/{id}','Reviewer\Penilaian\PenilaianLaporanKemajuanController@resume')->name('rn_laporankemajuan.resume');
    Route::GET('rn_laporankemajuan/resumenilai/{id}','Reviewer\Penilaian\PenilaianLaporanKemajuanController@resumenilai')->name('rn_laporankemajuan.resumenilai');
    Route::GET('rn_laporankemajuan/resumenilai2/{id}','Reviewer\Penilaian\PenilaianLaporanKemajuanController@resumenilai2')->name('rn_laporankemajuan.resumenilai2');
    Route::GET('rn_laporankemajuan/resumeberkas/{id}','Reviewer\Penilaian\PenilaianLaporanKemajuanController@resumeberkas')->name('rn_laporankemajuan.resumeberkas');
    Route::POST('rn_laporankemajuan/get/{id}','Reviewer\Penilaian\PenilaianLaporanKemajuanController@getnilai')->name('rn_laporankemajuan.nilai');
    Route::GET('rn_laporankemajuan/baca/{id}','Reviewer\Penilaian\PenilaianLaporanKemajuanController@baca')->name('rn_luarankemajuan.baca');
    Route::resource('rn2_laporankemajuan', 'Reviewer\Penilaian\Penilaian2LaporanKemajuanController');
    Route::POST('rn2_laporankemajuan/get/{id}','Reviewer\Penilaian\Penilaian2LaporanKemajuanController@getnilai')->name('rn2_laporankemajuan.nilai');


    Route::resource('rn_laporanakhir', 'Reviewer\Penilaian\PenilaianLaporanAkhirController');
    Route::get('rn_laporanakhir/get_data', 'Reviewer\Penilaian\PenilaianLaporanAkhirController@show');
    Route::GET('rn_laporanakhir/resume/{id}','Reviewer\Penilaian\PenilaianLaporanAkhirController@resume')->name('rn_laporanakhir.resume');
    Route::GET('rn_laporanakhir/resumenilai/{id}','Reviewer\Penilaian\PenilaianLaporanAkhirController@resumenilai')->name('rn_laporanakhir.resumenilai');
    Route::GET('rn_laporanakhir/resumenilai2/{id}','Reviewer\Penilaian\PenilaianLaporanAkhirController@resumenilai2')->name('rn_laporanakhir.resumenilai2');
    Route::GET('rn_laporanakhir/resumeberkas/{id}','Reviewer\Penilaian\PenilaianLaporanAkhirController@resumeberkas')->name('rn_laporanakhir.resumeberkas');
    Route::POST('rn_laporanakhir/get/{id}','Reviewer\Penilaian\PenilaianLaporanAkhirController@getnilai')->name('rn_laporanakhir.nilai');
    Route::GET('rn_laporanakhir/baca/{id}','Reviewer\Penilaian\PenilaianLaporanAkhirController@baca')->name('rn_luaranakhir.baca');
    Route::GET('rn_laporanakhir/bacalaporan/{id}','Reviewer\Penilaian\PenilaianLaporanAkhirController@bacalaporan')->name('rn_laporanakhir.bacalaporan');
    Route::GET('rn_laporanakhir/bacaangaran/{id}','Reviewer\Penilaian\PenilaianLaporanAkhirController@bacaanggaran')->name('rn_laporanakhir.bacaanggaran');
    Route::GET('rn_laporanakhir/bacaproposal/{id}','Reviewer\Penilaian\PenilaianLaporanAkhirController@bacaproposal')->name('rn_laporanakhir.bacaproposal');
    Route::resource('rn2_laporanakhir', 'Reviewer\Penilaian\Penilaian2LaporanAkhirController');
    Route::POST('rn2_laporanakhir/get/{id}','Reviewer\Penilaian\Penilaian2LaporanAkhirController@getnilai')->name('rn2_laporanakhir.nilai');

    Route::resource('rn_luaranlainnya', 'Reviewer\Penilaian\PenilaianAkhirLuaranLainnyaController');
    Route::get('rn_luaranlainnya/get_data', 'Reviewer\Penilaian\PenilaianAkhirLuaranLainnyaController@show');
    Route::GET('rn_luaranlainnya/resume/{id}','Reviewer\Penilaian\PenilaianAkhirLuaranLainnyaController@resume')->name('rn_luaranlainnya.resume');
    Route::GET('rn_luaranlainnya/resumenilai/{id}','Reviewer\Penilaian\PenilaianAkhirLuaranLainnyaController@resumenilai')->name('rn_luaranlainnya.resumenilai');
    Route::GET('rn_luaranlainnya/resumenilai2/{id}','Reviewer\Penilaian\PenilaianAkhirLuaranLainnyaController@resumenilai2')->name('rn_luaranlainnya.resumenilai2');
    Route::GET('rn_luaranlainnya/resumeberkas/{id}','Reviewer\Penilaian\PenilaianAkhirLuaranLainnyaController@resumeberkas')->name('rn_luaranlainnya.resumeberkas');
    Route::POST('rn_luaranlainnya/get/{id}','Reviewer\Penilaian\PenilaianAkhirLuaranLainnyaController@getnilai')->name('rn_luaranlainnya.nilai');
    Route::GET('rn_luaranlainnya/baca/{id}','Reviewer\Penilaian\PenilaianAkhirLuaranLainnyaController@baca')->name('rn_luaranakhir.baca');
    Route::GET('rn_luaranlainnya/bacalaporan/{id}','Reviewer\Penilaian\PenilaianAkhirLuaranLainnyaController@bacalaporan')->name('rn_luaranlainnya.bacalaporan');
    Route::GET('rn_luaranlainnya/bacaangaran/{id}','Reviewer\Penilaian\PenilaianAkhirLuaranLainnyaController@bacaanggaran')->name('rn_luaranlainnya.bacaanggaran');
    Route::GET('rn_luaranlainnya/bacaproposal/{id}','Reviewer\Penilaian\PenilaianAkhirLuaranLainnyaController@bacaproposal')->name('rn_luaranlainnya.bacaproposal');
  


});

Route::group(['middleware' => ['cekuser:3']], function(){

    //PENILAIAN
    Route::resource('p_reviewer', 'Admin\Penilaian\ReviewerController');
    Route::get('p_reviewer/get_data', 'Admin\Penilaian\ReviewerController@show');
    Route::get('p_reviewer1/get_data', 'Admin\Penilaian\ReviewerController@show1');
    Route::get('p_reviewer2/get_data', 'Admin\Penilaian\ReviewerController@show2');
    Route::GET('p_reviewer/resume/{id}','Admin\Penilaian\ReviewerController@resume')->name('p_reviewer.resume');
    Route::GET('p_reviewer/destroyreviewer/{id}','Admin\Penilaian\ReviewerController@destroyreviewer')->name('p_reviewer.destroyreviewer');
    Route::get('changeStatus', 'Admin\Penilaian\ReviewerController@changeStatus');
    Route::GET('p_reviewer/tambah/{id}','Admin\Penilaian\ReviewerController@tambah')->name('p_reviewer.tambah');



    Route::resource('plotingreviewer', 'Admin\Penilaian\PlotingReviewerController');
    Route::get('plotingreviewer/get_data', 'Admin\Penilaian\PlotingReviewerController@show');
    Route::get('plotingpenelitian/get_data', 'Admin\Penilaian\PlotingReviewerController@showpenelitian');
    Route::get('plotingpengabdian/get_data', 'Admin\Penilaian\PlotingReviewerController@showpengabdian');
    Route::get('reviewerpenelitian/get_data', 'Admin\Penilaian\PlotingReviewerController@reviewerpenelitian');
    Route::get('reviewerpengabdian/get_data', 'Admin\Penilaian\PlotingReviewerController@reviewerpengabdian');
    Route::GET('plotingreviewer/resume/{id}','Admin\Penilaian\PlotingReviewerController@resume')->name('plotingreviewer.resume');
    Route::delete('plotingreviewer/{id}', 'Admin\Penilaian\PlotingReviewerController@destroy');
    Route::delete('plotingreviewerDeleteAll', 'Admin\Penilaian\PlotingReviewerController@deleteAll');
    Route::GET('plotingreviewer/destroyreviewer/{id}','Admin\Penilaian\PlotingReviewerController@destroyreviewer')->name('plotingreviewer.destroyreviewer');

 


    //USULAN
    Route::resource('usulan', 'Admin\UsulanController');
    Route::GET('usulan/resume/{id}','Admin\UsulanController@resume')->name('usulan.resume');
    Route::GET('usulan/unduh/{id}','Admin\UsulanController@unduh')->name('usulan.unduh');
     Route::GET('usulan/resumeberkas/{id}','Admin\UsulanController@resumeberkas')->name('usulan.resumeberkas');


    Route::get('usulan/get_data', 'Admin\UsulanController@show');
    Route::get('get_detail_usulan', 'Admin\UsulanController@showdetail');

    Route::resource('penelitianbaru', 'Admin\PenelitianBaruController');
    Route::get('penelitianbaru/get_data', 'Admin\PenelitianBaruController@show');
    Route::GET('penelitianbaru/resume/{id}','Admin\PenelitianBaruController@resume')->name('penelitianbaru.resume');
    Route::GET('penelitianbaru/setuju/{id}','Admin\PenelitianBaruController@setuju')->name('penelitianbaru.setuju');
    Route::RESOURCE('penelitianbaru.subtansi', 'Admin\SubtansiController');
    Route::POST('penelitianbaru.subtansi/get/{id}','Admin\SubtansiController@getusulan')->name('penelitianbaru.usulan');

    Route::resource('pengabdianbaru', 'Admin\PengabdianBaruController');
    Route::get('pengabdianbaru/get_data', 'Admin\PengabdianBaruController@show');
    Route::GET('pengabdianbaru/resume/{id}','Admin\PengabdianBaruController@resume')->name('pengabdianbaru.resume');
    Route::GET('pengabdianbaru/setuju/{id}','Admin\PengabdianBaruController@setuju')->name('pengabdianbaru.setuju');
    Route::RESOURCE('pengabdianbaru.subtansi', 'Admin\SubtansiController');
    Route::POST('pengabdianbaru.subtansi/get/{id}','Admin\SubtansiController@getusulan')->name('pengabdianbaru.usulan');
    
    //Usulan Didanai

    Route::resource('usulandana', 'Admin\UsulanDana\UsulanController');
    Route::GET('usulandana/resume/{id}','Admin\UsulanDana\UsulanController@resume')->name('usulandana.resume');
    Route::GET('usulandana/unduh/{id}','Admin\UsulanDana\UsulanController@unduh')->name('usulandana.unduh');
     Route::GET('usulandana/resumeberkas/{id}','Admin\UsulanDana\UsulanController@resumeberkas')->name('usulandana.resumeberkas');


    Route::get('usulandana/get_data', 'Admin\UsulanDana\UsulanController@show');
    Route::get('get_detail_usulandana', 'Admin\UsulanDana\UsulanController@showdetail');

    Route::resource('penelitianbarudana', 'Admin\UsulanDana\PenelitianBaruController');
    Route::get('penelitianbarudana/get_data', 'Admin\UsulanDana\PenelitianBaruController@show');
    Route::GET('penelitianbarudana/resume/{id}','Admin\UsulanDana\PenelitianBaruController@resume')->name('penelitianbarudana.resume');
    Route::GET('penelitianbarudana/setuju/{id}','Admin\UsulanDana\PenelitianBaruController@setuju')->name('penelitianbarudana.setuju');
    Route::RESOURCE('penelitianbarudana.subtansi', 'Admin\UsulanDana\SubtansiController');
    Route::POST('penelitianbarudana.subtansi/get/{id}','Admin\SubtansiController@getusulan')->name('penelitianbarudana.usulan');

    Route::resource('pengabdianbarudana', 'Admin\UsulanDana\PengabdianBaruController');
    Route::get('pengabdianbarudana/get_data', 'Admin\UsulanDana\PengabdianBaruController@show');
    Route::GET('pengabdianbarudana/resume/{id}','Admin\UsulanDana\PengabdianBaruController@resume')->name('pengabdianbarudana.resume');
    Route::GET('pengabdianbarudana/setuju/{id}','Admin\UsulanDana\PengabdianBaruController@setuju')->name('pengabdianbarudana.setuju');
    Route::RESOURCE('pengabdianbarudana.subtansi', 'Admin\UsulanDana\SubtansiController');
    Route::POST('pengabdianbarudana.subtansi/get/{id}','Admin\UsulanDana\SubtansiController@getusulan')->name('pengabdianbarudana.usulan');

    //Data Penelitian
    Route::resource('datapenelitian', 'Admin\Data\DataPenelitianController');
    Route::get('datapenelitian/get_data', 'Admin\Data\DataPenelitianController@show');
    Route::GET('datapenelitian/resume/{id}','Admin\Data\DataPenelitianController@resume')->name('datapenelitian.resume');

    Route::RESOURCE('dataproposal',   'Admin\Data\ProposalController');
    Route::POST('dataproposal/fetch','Admin\Data\ProposalController@fetchilmu')->name('dataproposal.fetch');
    Route::POST('dataproposal/tkt',  'Admin\Data\ProposalController@loadtkt')->name('dataproposal.reloadtkt');
    Route::POST('dataproposal/topik','Admin\Data\ProposalController@loadtpk') ->name('dataproposal.reloadtpk');
    Route::POST('dataproposal/bidang','Admin\Data\ProposalController@loadbdg')->name('dataproposal.reloadbdg');
 


    //DataPendukung
    Route::resource('dp_dokumenrenstra', 'Admin\DataPendukung\DokumenRenstraController');
    Route::get('dp_dokumenrenstra/get_data', 'Admin\DataPendukung\DokumenRenstraController@show');
    Route::resource('dp_bidangunggulan', 'Admin\DataPendukung\BidangUnggulanController');
    Route::get('dp_bidangunggulan/get_data', 'Admin\DataPendukung\BidangUnggulanController@show');
    Route::resource('dp_topikunggulan', 'Admin\DataPendukung\TopikUnggulanController');
    Route::get('dp_topikunggulan/get_data', 'Admin\DataPendukung\TopikUnggulanController@show');


    // MASTER
    Route::resource('dosen', 'Master\DosenController');
    Route::get('dosen_data/get_data', 'Master\DosenController@show');
    Route::GET('dosen/resume/{id}','Master\DosenController@resume')->name('dosen.resume');
    Route::GET('dosen/reset/{id}','Master\DosenController@reset')->name('dosen.reset');


    Route::resource('bidangtkt', 'Master\BidangtktController');
    Route::get('bidangtkt_data/get_data', 'Master\BidangtktController@show');
    // admin
    Route::RESOURCE('mataanggaran',   'Master\MataAnggaranController');
    Route::get('mataanggaran/get_data', 'Master\MataAnggaranController@show');
    Route::POST('changeStatus', array('as' => 'changeStatus', 'uses' => 'Master\MataAnggaranController@changeStatus'));

    //
    Route::RESOURCE('fakultas',   'Master\FakultasController');
    Route::get('fakultas/get_data', 'Master\FakultasController@show');

    //
    Route::RESOURCE('fokus',   'Master\FokusController');
    Route::get('fokus/get_data', 'Master\FokusController@show');
    //
    Route::RESOURCE('fungsional',   'Master\FungsionalController');
    Route::get('fungsional/get_data', 'Master\FungsionalController@show');
    //
    Route::RESOURCE('indikatortkt',   'Master\IndikatortktController');
    Route::get('indikatortkt/get_data', 'Master\IndikatortktController@show');
    //
    Route::RESOURCE('keluaran',   'Master\KeluaranController');
    Route::get('keluaran/get_data', 'Master\KeluaranController@show');

       //
    Route::RESOURCE('pendidikan',   'Master\PendidikanController');
    Route::get('pendidikan/get_data', 'Master\PendidikanController@show');

    //
    Route::RESOURCE('periode',   'Master\PeriodeController');
    Route::get('periode/get_data', 'Master\PeriodeController@show');

    //
    Route::RESOURCE('prodi',   'Master\ProdiController');
    Route::get('prodi/get_data', 'Master\ProdiController@show');

    //
    Route::RESOURCE('program',   'Master\ProgramController');
    Route::get('program/get_data', 'Master\ProgramController@show');

    //
    Route::RESOURCE('rumpun',   'Master\RumpunController');
    Route::get('rumpun/get_data', 'Master\RumpunController@show');


    //
    Route::RESOURCE('skema',   'Master\SkemaController');
    Route::get('skema/get_data', 'Master\SkemaController@show');

    //
    //Route::RESOURCE('status',   'Master\StatusController');
    //Route::get('status/get_data', 'Master\StatusController@show');

    //
    Route::RESOURCE('struktural',   'Master\StrukturalController');
    Route::get('struktural/get_data', 'Master\StrukturalController@show');

    //
    Route::RESOURCE('tema',   'Master\TemaController');
    Route::get('tema/get_data', 'Master\TemaController@show');

    //
    Route::RESOURCE('topik',   'Master\TopikController');
    Route::get('topik/get_data', 'Master\TopikController@show');





});
Route::group(['middleware' => ['cekuser:3' OR'cekuser:4']], function(){

    Route::resource('hasilreviewer', 'Admin\Penilaian\HasilReviewerController');
    Route::get('hasilreviewer/get_data', 'Admin\Penilaian\HasilReviewerController@show');
    Route::get('hasilpenelitian/get_data', 'Admin\Penilaian\HasilReviewerController@showpenelitian');
    Route::get('hasilpengabdian/get_data', 'Admin\Penilaian\HasilReviewerController@showpengabdian');
    Route::GET('hasilreviewer/resume/{id}','Admin\Penilaian\HasilReviewerController@resume')->name('hasilreviewer.resume');
    Route::GET('hasilreviewer/resumenilai/{id}','Admin\Penilaian\HasilReviewerController@resumenilai')->name('hasilreviewer.resumenilai');
    Route::GET('hasilreviewer/resumeberkas/{id}','Admin\Penilaian\HasilReviewerController@resumeberkas')->name('hasilreviewer.resumeberkas');
    Route::POST('hasilreviewer/get/{id}','Admin\Penilaian\HasilReviewerController@getnilai')->name('hasilreviewer.nilai');
    
      Route::resource('hasilmonev', 'Admin\Penilaian\HasilMonevController');
    Route::resource('hasilmonev2', 'Admin\Penilaian\HasilMonev2Controller');
    Route::get('hasilmonev/get_data', 'Admin\Penilaian\HasilMonevController@show');
    Route::GET('hasilmonev/resumenilai/{id}','Admin\Penilaian\HasilMonevController@resumenilai')->name('hasilmonev.resumenilai');
    Route::GET('hasilmonev/resumenilai2/{id}','Admin\Penilaian\HasilMonevController@resumenilai2')->name('hasilmonev.resumenilai2');
    Route::GET('hasilmonev/resumeberkas/{id}','Admin\Penilaian\HasilMonevController@resumeberkas')->name('hasilmonev.resumeberkas');
    Route::POST('hasilmonev/get/{id}','Admin\Penilaian\HasilMonevController@getnilai')->name('hasilmonev.nilai');
    Route::POST('hasilmonev2/get/{id}','Admin\Penilaian\HasilMonev2Controller@getnilai')->name('hasilmonev2.nilai');


    Route::resource('hasilakhir', 'Admin\Penilaian\HasilAkhirController');
    Route::resource('hasilakhir2', 'Admin\Penilaian\HasilAkhir2Controller');
    Route::get('hasilakhir/get_data', 'Admin\Penilaian\HasilAkhirController@show');
    Route::GET('hasilakhir/resume/{id}','Admin\Penilaian\HasilAkhirController@resume')->name('hasilakhir.resume');
    Route::GET('hasilakhir/resumenilai/{id}','Admin\Penilaian\HasilAkhirController@resumenilai')->name('hasilakhir.resumenilai');
    Route::GET('hasilakhir/resumenilai2/{id}','Admin\Penilaian\HasilAkhirController@resumenilai2')->name('hasilakhir.resumenilai2');
    Route::GET('hasilakhir/resumeberkas/{id}','Admin\Penilaian\HasilAkhirController@resumeberkas')->name('hasilakhir.resumeberkas');
    Route::POST('hasilakhir/get/{id}','Admin\Penilaian\HasilAkhirController@getnilai')->name('hasilakhir.nilai');
    Route::POST('hasilakhir2/get/{id}','Admin\Penilaian\HasilAkhir2Controller@getnilai')->name('hasilakhir2.nilai');
    Route::GET('rn_laporanakhir/baca/{id}','Reviewer\Penilaian\PenilaianLaporanAkhirController@baca')->name('rn_luaranakhir.baca');
    Route::GET('rn_laporanakhir/bacalaporan/{id}','Reviewer\Penilaian\PenilaianLaporanAkhirController@bacalaporan')->name('rn_laporanakhir.bacalaporan');
    Route::GET('rn_laporanakhir/bacaangaran/{id}','Reviewer\Penilaian\PenilaianLaporanAkhirController@bacaanggaran')->name('rn_laporanakhir.bacaanggaran');
    Route::GET('rn_laporanakhir/bacaproposal/{id}','Reviewer\Penilaian\PenilaianLaporanAkhirController@bacaproposal')->name('rn_laporanakhir.bacaproposal');
    

    Route::resource('hasilakhirluaran', 'Admin\Penilaian\HasilAkhirLuaranController');
    Route::get('hasilakhirluaran/get_data', 'Admin\Penilaian\HasilAkhirLuaranController@show');
    Route::GET('hasilakhirluaran/resume/{id}','Admin\Penilaian\HasilAkhirLuaranController@resume')->name('hasilakhirluaran.resume');
    Route::GET('hasilakhirluaran/resumenilai/{id}','Admin\Penilaian\HasilAkhirLuaranController@resumenilai')->name('hasilakhirluaran.resumenilai');
    Route::GET('hasilakhirluaran/resumeberkas/{id}','Admin\Penilaian\HasilAkhirLuaranController@resumeberkas')->name('hasilakhirluaran.resumeberkas');
    Route::POST('hasilakhirluaran/get/{id}','Admin\Penilaian\HasilAkhirLuaranController@getnilai')->name('hasilakhir.nilai');
   

   

    //PEMANTAUAN
    Route::resource('p_rancangan', 'Admin\Pemantauan\RancanganController');
    Route::get('p_rancangan/get_data', 'Admin\Pemantauan\RancanganController@showtambah');
    Route::GET('p_rancangan/resume/{id}','Admin\Pemantauan\RancanganController@resume')->name('p_rancangan.resume');

    Route::resource('p_catatan', 'Admin\Pemantauan\CatatanHarianController');
    Route::get('p_catatan/get_data', 'Admin\Pemantauan\CatatanHarianController@show');
    Route::GET('p_catatan/resume/{id}','Admin\Pemantauan\CatatanHarianController@resume')->name('p_catatan.resume');
    Route::DELETE('p_catatan/verifikasi/{id}','Admin\Pemantauan\CatatanHarianController@verifikasi')->name('p_catatan.verifikasi');


    Route::resource('p_luarankemajuan', 'Admin\Pemantauan\LuaranKemajuanController');
    Route::get('p_luarankemajuan/get_data', 'Admin\Pemantauan\LuaranKemajuanController@show');
    Route::GET('p_luarankemajuan/resume/{id}','Admin\Pemantauan\LuaranKemajuanController@resume')->name('p_luarankemajuan.resume');

    Route::resource('p_laporankemajuan', 'Admin\Pemantauan\LaporanKemajuanController');
    Route::get('p_laporankemajuan/get_data', 'Admin\Pemantauan\LaporanKemajuanController@show');
    Route::GET('p_laporankemajuan/resume/{id}','Admin\Pemantauan\LaporanKemajuanController@resume')->name('p_laporankemajuan.resume');

    Route::resource('p_laporanakhir', 'Admin\Pemantauan\LaporanAkhirController');
    Route::get('p_laporanakhir/get_data', 'Admin\Pemantauan\LaporanAkhirController@show');
    Route::GET('p_laporanakhir/resume/{id}','Admin\Pemantauan\LaporanAkhirController@resume')->name('p_laporanakhir.resume');

    Route::resource('p_anggaran', 'Admin\Pemantauan\PenggunaanAnggaranController');
    Route::get('p_anggaran/get_data', 'Admin\Pemantauan\PenggunaanAnggaranController@show');
    Route::GET('p_anggaran/resume/{id}','Admin\Pemantauan\PenggunaanAnggaranController@resume')->name('p_anggaran.resume');

    Route::resource('p_tanggungjawab', 'Admin\Pemantauan\TanggungJawabController');
    Route::get('p_tanggungjawab/get_data', 'Admin\Pemantauan\TanggungJawabController@show');
    Route::GET('p_tanggungjawab/resume/{id}','Admin\Pemantauan\TanggungJawabController@resume')->name('p_tanggungjawab.resume');

    Route::resource('p_berkasseminar', 'Admin\Pemantauan\BerkasSeminarController');
    Route::get('p_berkasseminar/get_data', 'Admin\Pemantauan\BerkasSeminarController@show');
    Route::GET('p_berkasseminar/resume/{id}','Admin\Pemantauan\BerkasSeminarController@resume')->name('p_berkasseminar.resume');

    Route::resource('p_hasilpenilaian', 'Admin\Pemantauan\HasilPenilaianController');
    Route::get('p_hasilpenilaian/get_data', 'Admin\Pemantauan\HasilPenilaianController@show');
    Route::GET('p_hasilpenilaian/resume/{id}','Admin\Pemantauan\HasilPenilaianController@resume')->name('p_hasilpenilaian.resume');

    Route::resource('p_skseminar', 'Admin\Pemantauan\SkSeminarController');
    Route::get('p_skseminar/get_data', 'Admin\Pemantauan\SkSeminarController@show');
    Route::GET('p_skseminar/resume/{id}','Admin\Pemantauan\SkSeminarController@resume')->name('p_skseminar.resume');

    Route::resource('p_pengembaliandana', 'Admin\Pemantauan\PengembalianDanaController');
    Route::get('p_pengembaliandana/get_data', 'Admin\Pemantauan\PengembalianDanaController@show');
    Route::GET('p_pengembaliandana/resume/{id}','Admin\Pemantauan\PengembalianDanaController@resume')->name('p_pengembaliandana.resume');



});








Route::resource('penelitianlanjut', 'PenelitianlanjutController');
Route::resource('pengabdianlanjut', 'PengabdianlanjutController');

Route::get('/err123','HomeController@error')->name('error666');

Auth::routes();
Route::RESOURCE('home','HomeController');
Route::get('/home', 'HomeController@index')->name('home');
Route::GET('home/gantiperan/{id}','HomeController@gantiperan')->name('gantiperan');
Route::RESOURCE('profile','ProfilController');