<?php

namespace App\Http\Controllers\Pelaksanaan\LaporanAkhir;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Proposal;
use App\Periode;
use App\Penelitian;
use App\Keanggotaan;
use App\LaporanAkhir;
use App\AnggaranAkhir;
use App\Anggaran;
use App\LuaranAkhir;
use App\Peneliti;
use App\Skema;
use App\Mataanggaran;

use Auth;
use Redirect;

class ValidasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    protected function countPersonil()
    {
        
       $personil = Keanggotaan::select('tb_proposal.id', 'anggotaid', 'jenis', 'nama', 'foto', 'tb_keanggota.created_at')
                        ->leftJoin('tb_penelitian', 'tb_keanggota.idpenelitian', 'tb_penelitian.prosalid')
                        ->leftJoin('tb_proposal', 'tb_penelitian.prosalid', 'tb_proposal.id')
                        ->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
                        ->where('tb_keanggota.anggotaid', Auth::user()->id)
                        ->where('tb_keanggota.setuju', 0)
                        ->where('tb_penelitian.status', '>', 0)
                        ->where('tb_proposal.aktif', '1')
                        ->get();
        return $personil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $person = ValidasiController::countPersonil();

        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 2, strlen($temp));
      //  $idprop = ($idprop - 29) / 2;

        $err = 0;
        $err2 = 0;
        $err3 = 0;
        $err4 = 0;
        $err5 = 0;
        $proposal = Proposal::find($idprop);
        $periode  = Periode::where('id', $proposal->periodeusul)->first();
        $penelitian = Penelitian::find($idprop);
       
        $dsn = Peneliti::select('id','nama')->find(Auth::user()->id);
        if($proposal) {
            $judul = Proposal::select('judul')->where('judul', $proposal->judul)->count();
          
            $luaranlainnya = LuaranAkhir::where('idpenelitian', $proposal->id)->where('kategori',3)->get();
            $luaranwajib = LuaranAkhir::where('idpenelitian', $proposal->id)->where('kategori',1)->get();
            $luarantambahan = LuaranAkhir::where('idpenelitian', $proposal->id)->where('kategori',2)->get();
            $err = count($luaranlainnya);
            $err2 = count($luaranwajib);
            $err3 = count($luarantambahan);
            $laporanakhir = LaporanAkhir::where('prosalid', $proposal->id)->first();
            if($laporanakhir != null ){
                $err4 = 1;
            }
          
            $anggaranakhir = AnggaranAkhir::where('prosalid', $proposal->id)->first();
            if($anggaranakhir != null){
                $err5 = 1;
            }
          



            return view('pelaksanaan.laporanakhir.validasi', compact('person','laporanakhir','anggaranakhir', 'dsn','luaranlainnya','luaranwajib','luarantambahan', 'proposal','penelitian','periode', 'err','judul','mtkt', 'err2','tim','ttim','skema', 'err3', 'err4','luar','wajib','data', 'err5','hnr','bhn','jln','brg','pagu', 'err6'));
        } 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function edit($id)
    {
        $person = ValidasiController::countPersonil();

        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 2, strlen($temp));

        $proposal = Proposal::select('id','pengesahan','usulan')->find($idprop);
        if ($proposal) {

            return view ('penelitianng.unggahan', compact('person','proposal'));
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $idprop = $id;

        $proposal = Proposal::find($idprop);
        if ($proposal) {

            if ($request->hasFile('filepengesahan')) {
            
                $file  = $request->file('filepengesahan');
                if ($file->getClientMimeType() !== 'application/pdf' ) {

                }
                else {
                    if ($file->getSize() < 716800) {
                        $nama_file = "docs-1".mt_rand(100,999).$proposal->id.mt_rand(10,99)."-".$proposal->idketua.".".$file->getClientOriginalExtension();

                        $lokasi = public_path('docs/periode2/pengesahan');

                        $file->move($lokasi, $nama_file);

                        $proposal->pengesahan = $nama_file; 
                    }
                    else {
                        return Redirect::back()->withInput()->withErrors(array('error' => 'error'));


                    }
                } 
            }else{
                return Redirect::back()->withInput()->withErrors(array('error' => 'error'));
            }

            if ($request->hasFile('fileproposal')) {
            
                $file  = $request->file('fileproposal');
                if ($file->getClientMimeType() !== 'application/pdf' ) {

                }
                else {
                    if ($file->getSize() < 5644288) {

                        $nama_file = "docs-2".mt_rand(100,999).$proposal->id.mt_rand(10,99)."-".$proposal->idketua.".".$file->getClientOriginalExtension();

                        $lokasi = public_path('docs/periode2/proposal');

                        $file->move($lokasi, $nama_file);

                        $proposal->usulan = $nama_file; 
                    }
                    else {
                        return Redirect::back()->withInput()->withErrors(array('error' => 'error'));
                    }
                } 
            }

            if ($proposal){
                $proposal->update();
                return Redirect::route('validasipenelitian.show', base64_encode(mt_rand(10,99).($idprop*2+29)))->withInput()->withErrors(array('success' => 'komentar'));

            }else{
                return Redirect::back()->withInput()->withErrors(array('error' => 'error'));
            }

        }else{
            return Redirect::back()->withInput()->withErrors(array('error' => 'error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $idprop = $id;

        $penelitian = Penelitian::where('prosalid', $idprop)->first();

        if ($penelitian) {
            //ubah ke 3 untuk default
            $penelitian->status = 4;

            $penelitian->update();
        }
        return Redirect::route('penelitianng.index');
    }

    public function bacalaporan($id)
    {
        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 2, strlen($temp));


        $penelitian = LaporanAkhir::where('id', $idprop)->first();
        $file_path = public_path('docs/pelaksanaan/laporanakhir/').$penelitian->upload;
        if($penelitian){
            $headers = array(
                'Content-Type: pdf',
                'Content-Disposition: attachment; filename='.$penelitian->upload,
            );
            if ( file_exists( $file_path ) ) {
                // Show pdf
                return response()->file( $file_path, $headers );
            } else {
                // Error
                return Redirect::back()->withInput()->withErrors(array('errornf' => 'errornf'));
            }
        }

    }
    public function bacaanggaran($id)
    {
        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 2, strlen($temp));


        $penelitian = AnggaranAkhir::where('id', $idprop)->first();
        $file_path = public_path('docs/pelaksanaan/laporanakhir/').$penelitian->upload;
        if($penelitian){
            $headers = array(
                'Content-Type: pdf',
                'Content-Disposition: attachment; filename='.$penelitian->upload,
            );
            if ( file_exists( $file_path ) ) {
                // Show pdf
                return response()->file( $file_path, $headers );
            } else {
                // Error
                return Redirect::back()->withInput()->withErrors(array('errornf' => 'errornf'));
            }
        }

    }
}
