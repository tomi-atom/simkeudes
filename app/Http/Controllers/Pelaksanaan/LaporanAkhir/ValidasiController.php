<?php

namespace App\Http\Controllers\Pelaksanaan\LaporanAkhir;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Proposal;
use App\Periode;
use App\Penelitian;
use App\Keanggotaan;
use App\Substansi;
use App\Luaran;
use App\Anggaran;

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
        $idprop = ($idprop - 29) / 2;

        $err = 0;
        $proposal = Proposal::find($idprop);
        $periode  = Periode::where('id', $proposal->periodeusul)->first();
        $penelitian = Penelitian::find($idprop);
        if($proposal) {
            $judul = Proposal::select('judul')->where('judul', $proposal->judul)->count();
            if($judul-1 > 0)
                $err = 5;
            $mtkt = 100;
            $skema = Skema::select('minpeserta','maxpeserta','mintkt','minluaran','dana')->find($proposal->idskema);

            if($proposal->tktawal < $skema->mintkt) {
                $err++;
                $mtkt = round($proposal->tktawal / $skema->mintkt * 100);
            }

            $err2 = 0;
            $ttim = Keanggotaan::where('idpenelitian', $proposal->id)->where('setuju', '!=', 1)->count();
            if ($ttim) {
                $err2++;
            }

            $tim  = Keanggotaan::select('nama','setuju')
                                ->join('tb_peneliti','tb_keanggota.anggotaid', 'tb_peneliti.id')
                                ->where('tb_keanggota.idpenelitian', $proposal->id)
                                ->orderBy('tb_keanggota.peran', 'asc')
                                ->get();
            if (count($tim) == 0)
                $err2 = 99;

            $err3 = 0;
            $sub = Substansi::where('proposalid', $proposal->id)->first();
            if (count($sub)== 0)
                $err3 = 99;

            $err4 = 0;
            $wajib = 0;
            $data = explode('/', $skema->minluaran);
            $luar = Luaran::select('kategori')->where('idpenelitian', $proposal->id)->get();
            if (count($luar) == 0){
                $err4 = 99;
            }
            else {
                foreach($luar as $list){
                    if($list->kategori == 1)
                        $wajib++;
                }
                if ($wajib < count($data))
                    $err4++;
            }

            $hnr = 0;
            $bhn = 0;
            $jln = 0;
            $brg = 0;
            $biaya = Anggaran::where('proposalid', $proposal->id)
                                ->orderBy('anggaranid', 'asc')
                                ->orderBy('id', 'asc')
                                ->get();
            $err5 = 0;
            if (count($biaya) == 0) {
                $err5 = 99;
            }

            foreach($biaya as $list) {
                if ($list->anggaranid == 1) 
                    $hnr += $list->volume * $list->biaya;
                elseif ($list->anggaranid == 2) 
                    $bhn += $list->volume * $list->biaya;
                elseif ($list->anggaranid == 3) 
                    $jln += $list->volume * $list->biaya;
                else
                    $brg += $list->volume * $list->biaya;
            }

            $pagu = Mataanggaran::select('batas')->get();

            $dsn = Peneliti::select('id','nama')->find(Auth::user()->id);

            $err6 = 0;
            if($proposal->pengesahan && $proposal->usulan)
                $err6 = 0;
            else if ($proposal->pengesahan || $proposal->usulan) 
                $err6++;
            else
                $err6 = 99;


            return view('pelaksanaan.laporanakhir.validasi', compact('person', 'dsn', 'proposal','penelitian','periode', 'err','judul','mtkt', 'err2','tim','ttim','skema', 'err3', 'err4','luar','wajib','data', 'err5','hnr','bhn','jln','brg','pagu', 'err6'));
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
}
