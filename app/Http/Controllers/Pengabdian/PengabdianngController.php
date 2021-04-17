<?php

namespace App\Http\Controllers\Pengabdian;

use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Proposal;
use App\Penelitian;
use App\Keanggotaan;
use App\Substansi;
use App\Luaran;
use App\Anggaran;

use App\Peneliti;
use App\Mataanggaran;

use App\Pengukuran;
use App\Program;
use App\Periode;
use App\Posisi;


use Auth;
use Redirect;

class PengabdianngController extends Controller
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
    public function index()
    {
        $person = PengabdianngController::countPersonil();

        $peneliti = Peneliti::select('id','hindex','sinta','status','tanggungan')->find(Auth::user()->id);
        $periode  = Periode::where('aktif', '1')->where('jenis','2')->orderBy('tahun', 'desc')->orderBy('sesi', 'desc')->get();
        $periodeterbaru  = Periode::orderBy('tahun', 'desc')->where('jenis','2')->orderBy('sesi', 'desc')->first();
        $periodetahun  = Periode::where('jenis',2)
            ->where('aktif','1')
            ->where('tahun',$periodeterbaru->tahun)
            ->pluck('id')->toArray();


        $proposal = Proposal::select('judul','idprogram','idskema','periodeusul','idfokus','aktif','thnkerja','status','dana','prosalid')
            ->join('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
            ->whereIn('tb_proposal.periodeusul',$periodetahun)
            ->where('tb_penelitian.ketuaid', $peneliti->id)
            ->where('tb_penelitian.status', '>', 0)
            ->where('tb_proposal.jenis', 2)
            ->get();
  
        $proposalditerima = Proposal::select('judul','idprogram','idskema','periodeusul','idfokus','aktif','thnkerja','status','dana','prosalid')
            ->join('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
            ->whereIn('tb_proposal.periodeusul',$periodetahun)
            ->where('tb_penelitian.ketuaid', $peneliti->id)
            ->where('tb_penelitian.status', 4)
            ->where('tb_proposal.jenis', 2)
            ->get();
  
  
        $peserta = Proposal::select('judul','idprogram','idskema','periodeusul','idfokus','thnkerja','status','prosalid','peran','setuju')
            ->join('tb_keanggota', 'tb_proposal.id', 'tb_keanggota.idpenelitian')
            ->join('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
                ->whereIn('tb_proposal.periodeusul',$periodetahun)
                ->where('tb_keanggota.anggotaid', $peneliti->id)
                ->where('tb_penelitian.status', '>', 0)
                ->where('tb_keanggota.setuju', '<', 2)
                ->where('tb_proposal.jenis', 2)
                ->where('tb_proposal.aktif', '1')
                ->orderBy('tb_keanggota.peran', 'asc')
                ->get(); 

        $minat =  Proposal::join('tb_keanggota', 'tb_proposal.id', 'tb_keanggota.idpenelitian')
            ->join('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
           ->whereIn('tb_proposal.periodeusul',$periodetahun)
            ->where('tb_penelitian.ketuaid', $peneliti->id)
            ->where('tb_penelitian.status', '>', 0)
            ->where('tb_keanggota.setuju', 0)
            ->where('tb_proposal.jenis', 2)
            ->where('tb_proposal.aktif', '1')
            ->count(); 

        $status = Posisi::select('jenis')->where('aktif', '1')->orderBy('id','asc')->get(); //*temp

        $member = Keanggotaan::leftJoin('tb_proposal', 'tb_keanggota.idpenelitian', 'tb_proposal.id')
                        ->where('tb_keanggota.anggotaid', Auth::user()->id)
                        ->where('tb_keanggota.setuju', 1)
                       ->whereIn('tb_proposal.periodeusul',$periodetahun)
                        ->where('tb_proposal.jenis', 2)
                        ->count(); 

        $ketua   = count($proposal);
         $ketuaditerima   = count($proposalditerima);
        $total   = $ketua + count($peserta);
        $waktu = Carbon::now('Asia/Jakarta');

        return view('pengabdianng.index', compact('person', 'peneliti', 'periode', 'periodeterbaru','proposal', 'total','ketua','ketuaditerima','peserta','member', 'status', 'minat', 'waktu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        /* error validator, jalan dengan penelitan index
        $data = $request->all();

        $validator = Validator::make($data, [
            'idtahun' => 'required',
            'buka' => 'required|string|min:5'
        ]);

        if ($validator->fails()) {
            return redirect()->route('pengabdianng.index')
                        ->withErrors($validator)
                        ->withInput();
        }
        */
        $periode = $request['idtahun'];

        $person = PengabdianngController::countPersonil();
        $peneliti = Peneliti::find(Auth::user()->id);

        $periode = $request['idtahun'];
        $waktu = Carbon::now('Asia/Jakarta');
        $periodeterbaru  = Periode::where('jenis',2)
            ->where('aktif','1')
            ->where('tanggal_mulai','<',$waktu)
            ->where('tanggal_akhir','>',$waktu) ->pluck('program')->toArray();


        $program = Program::where('kategori', 2)->where('aktif', '1')
            ->whereIn('id', $periodeterbaru)->get();
        return view('pengabdianng.create', compact('person', 'peneliti', 'program', 'periode'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $idprop = base64_decode($id);

        $proposal = Proposal::find($idprop);

        $proposal->aktif = '1';
        $proposal->update();

        $penelitian = Penelitian::where('prosalid', $idprop)
                                ->where('ketuaid', Auth::user()->id)
                                ->where('status', 1)
                                ->first();
        if ($penelitian) {
            $penelitian->status = 2;
            $penelitian->update();
            return Redirect::route('pengabdianng.index')->withInput()->withErrors(array('success' => 'komentar'));

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
        $temp = $id;
        $idprop = (Integer)substr($temp, 2, strlen($temp));
        $idprop /= 3;

        $proposal = Proposal::find($idprop);
        $proposal->delete();

        /* //error tambah tkt jika dihapus..
        $tkt = Pengukuran::select('teknologi', 'tb_ukurtkt.created_at')
                        ->leftJoin('tb_proposal', 'tb_ukurtkt.id', 'tb_proposal.idtkt') 
                        ->whereNull('tb_proposal.id')
                        ->where('tb_ukurtkt.id', 'LIKE', Auth::user()->email.'%')
                        ->get();
        
        foreach($tkt as $list) {
            $temp = Pengukuran::where('teknologi', $list->teknologi)->where('created_at', $list->created_at)->first();
            $temp->delete();
        }
        */
        
        $penelitian = Penelitian::where('prosalid', $proposal->id)->first();
        if (count($penelitian))
            $penelitian->delete();
        
        $anggota = Keanggotaan::where('idpenelitian', $proposal->id)->get();
        foreach ($anggota as $list)
            $list->delete();
        
        $subtansi = Substansi::where('proposalid', $proposal->id)->first();
        if (count($subtansi))
            $subtansi->delete();

        $luaran = Luaran::where('idpenelitian', $proposal->id)->get();
        foreach ($luaran as $list)
            $list->delete();
        
        $anggaran = Anggaran::where('proposalid', $proposal->id)->get();
        foreach ($anggaran as $list)
            $list->delete();
      
    }

    public function resume($id) 
    {
        $person = PengabdianngController::countPersonil();

        $temp = base64_decode($id);
        $stat = (Integer)substr($temp, 0, 1);
        $idprop = (Integer)substr($temp, 2, strlen($temp));
        $idprop /= 2;

        $prop = Proposal::find($idprop);
        //$prop  = Proposal::where('id', $idprop)->Where('iddosen', Auth::user()->id)->orWhere('iddosen', 0)->first();

        $peneliti = Penelitian::where('prosalid', $idprop)->first();
        $thn = $peneliti->tahun_ke;

        $ketua = Peneliti::select('sinta','nama','idpt','idfakultas','idprodi','hindex')->find($peneliti->ketuaid);
        $peserta = Peneliti::leftJoin('tb_keanggota', 'tb_keanggota.anggotaid', '=', 'tb_peneliti.id')
            ->where('tb_keanggota.idpenelitian', '=', $idprop)
            ->where('tb_keanggota.setuju', '<', 2)
            ->orderBy('peran', 'asc')
            ->get();

        $luar = Luaran::select('kategori','idluaran','publish','urllink')
            ->where('idpenelitian', $idprop)
            ->orderBy('kategori', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $biaya = Anggaran::where('proposalid', $idprop)->orderBy('anggaranid','asc')->orderBy('id','asc')->get();

        $thnr = 0;
        $tbhn = 0;
        $tjln = 0;
        $tbrg = 0;
        foreach ($biaya as $list) 
        {
            if ($list->anggaranid == 1) {
                $thnr += $list->volume * $list->biaya;
            } 
            else if ($list->anggaranid == 2) {
                $tbhn += $list->volume * $list->biaya;
            }
            else if ($list->anggaranid == 3) {
                $tjln += $list->volume * $list->biaya;
            }
            else if ($list->anggaranid == 4) {
                $tbrg += $list->volume * $list->biaya;
            }

        }

        $mata = Mataanggaran::select('batas')->get();

        return view('pengabdianng.resume', compact('person','idprop','prop','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata','stat'));
    }

    public function unduh($id)
    {

        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 2, strlen($temp));
        $idprop /= 2;
         

        $penelitian = Proposal::find($idprop);
        $file_path = public_path('docs/periode2/proposal/').$penelitian->usulan;
        if($penelitian){
            $headers = array(
                'Content-Type: pdf',
                'Content-Disposition: attachment; filename='.$penelitian->usulan,
            );
            if ( $file_path  ) {
                // Show pdf
                return response()->file( $file_path, $headers );
            } else {
                
                $message = 'Dokumen Tidak Ditemukan..';
                return Redirect::back()->withInput()->withErrors(array('kesalahan' => $message));
            }
        }
    }
    public function setuju($id) {
        $person = PengabdianngController::countPersonil();

        $temp = base64_decode($id);
        
        $idprop = (Integer)substr($temp, 1, strlen($temp));
        $idprop -= Auth::user()->id*3;

        $dosen = Peneliti::select('nama')->find(Auth::user()->id);

        $peneliti = Peneliti::select('tb_peneliti.id as dsn','nama','idfakultas','hindex','foto','tb_keanggota.id','anggotaid','peran','tugas')
                        ->leftJoin('tb_penelitian', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
                        ->leftJoin('tb_keanggota', 'tb_penelitian.prosalid', 'tb_keanggota.idpenelitian')
                        ->where('tb_penelitian.prosalid', $idprop)
                        ->where('tb_keanggota.anggotaid', Auth::user()->id)
                        ->first();

        $proposal = Proposal::select('judul','idskema','idilmu')
                        ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
                        ->where('tb_penelitian.prosalid', $idprop)
                        ->first();

        $toteliti = Penelitian::leftJoin('tb_proposal', 'tb_penelitian.prosalid', 'tb_proposal.id')
                        ->where('tb_penelitian.ketuaid', $peneliti->dsn)
                        ->where('tb_penelitian.status', '>', 0)
                        ->where('tb_proposal.jenis', '1')
                        ->count();

        $tempory  = Keanggotaan::leftJoin('tb_penelitian', 'tb_keanggota.idpenelitian', 'tb_penelitian.id')
                        ->leftJoin('tb_proposal', 'tb_penelitian.prosalid', 'tb_proposal.id')
                        ->where('tb_keanggota.anggotaid', $peneliti->dsn)
                        ->where('tb_proposal.jenis', '1')
                        ->count();
        $toteliti += $tempory;

        $totabdi  = Penelitian::leftJoin('tb_proposal', 'tb_penelitian.prosalid', 'tb_proposal.id')
                        ->where('tb_penelitian.ketuaid', $peneliti->dsn)
                        ->where('tb_penelitian.status', '>', 0)
                        ->where('tb_proposal.jenis', '2')
                        ->count();
        $tempory  = Keanggotaan::leftJoin('tb_penelitian', 'tb_keanggota.idpenelitian', 'tb_penelitian.id')
                        ->leftJoin('tb_proposal', 'tb_penelitian.prosalid', 'tb_proposal.id')
                        ->where('tb_keanggota.anggotaid', $peneliti->dsn)
                        ->where('tb_proposal.jenis', '2')
                        ->count();
        $totabdi  += $tempory;
        
        return view('pengabdianng.persetujuan', compact('person','proposal','toteliti','totabdi','peneliti','dosen'));
    }

    public function response(Request $request, $id) 
    {
        $temp = base64_decode($id) - Auth::user()->id;

        $stat = (Integer)substr($temp, 0, 1);
        $idprog = (Integer)substr($temp, 2, strlen($temp));

        $periode  = Periode::select('id')->where('aktif', '1')->orderBy('tahun','desc')->orderBy('sesi','desc')->first();
        $ketua  = Penelitian::leftJoin('tb_proposal', 'tb_penelitian.prosalid', 'tb_proposal.id')
                           ->where('tb_penelitian.ketuaid', Auth::user()->id)
                           ->where('tb_proposal.periodeusul', $periode->id)
                           ->where('tb_proposal.jenis', '2')
                           ->count();

        //$member = Keanggotaan::where('anggotaid', Auth::user()->id)->where('setuju', 1)->count();
        $member = Keanggotaan::select('tb_keanggota.id')->leftJoin('tb_proposal', 'tb_keanggota.idpenelitian', 'tb_proposal.id')
                        ->where('tb_keanggota.anggotaid', Auth::user()->id)
                        ->where('tb_proposal.periodeusul', $periode->id)
                        ->where('tb_keanggota.setuju', 1)
                        ->where('tb_proposal.jenis', 2)
                        ->count();

        $proposal = Proposal::select('idskema', 'periodeusul')
            ->leftJoin('tb_keanggota', 'tb_proposal.id', 'tb_keanggota.idpenelitian')
            ->where('tb_keanggota.anggotaid', Auth::user()->id)
            ->where('tb_keanggota.id', $idprog)
            ->first();


        $bataspeserta = Keanggotaan::select('anggotaid')
            ->leftJoin('tb_proposal', 'tb_proposal.id', 'tb_keanggota.idpenelitian')
            ->where('tb_keanggota.anggotaid', Auth::user()->id)
            ->where('tb_keanggota.setuju', 1)
            ->where('tb_proposal.periodeusul',$proposal->periodeusul)
            ->where('tb_proposal.idskema', $proposal->idskema)
            ->where('tb_proposal.aktif', '1')
            ->count();

        if (($ketua + $member) < 2) {
            if ($bataspeserta ) {
                $stat = 3;
            }
            $anggota = Keanggotaan::find($idprog);

            $anggota->setuju = $stat;
            $anggota->update();
            if ($stat == 1){
                return Redirect::route('pengabdianng.index')->withInput()->withErrors(array('bersedia' => 'bersedia'));

            }else if ($stat == 2) {
                return Redirect::route('pengabdianng.index')->withInput()->withErrors(array('tolak' => 'tolak'));

            }
            else{
                return Redirect::route('pengabdianng.index')->withInput()->withErrors(array('sistemtolak' => 'sistemtolak'));

            }
        }else{
            return Redirect::back()->withInput()->withErrors(array('error' => 'error'));
        }

        $member++;

        if (($ketua + $member) >= 2) {
            $anggota = Keanggotaan::where('anggotaid', Auth::user()->id)->where('setuju', 0)->get();
            foreach($anggota as $data) {
                $data->setuju = 3;
                $data->update();
            }
            return Redirect::route('pengabdianng.index');
        }else{
            return Redirect::back()->withInput()->withErrors(array('error' => 'error'));
        }


    }

    public function baca($id)
    {
        $person = PengabdianngController::countPersonil();

        $temp = base64_decode($id);

        $idprop = (Integer)substr($temp, 1, strlen($temp));
        $idprop = ($idprop - Auth::user()->id) / 9;

        $prop = Proposal::find($idprop);
        $peneliti = Penelitian::where('prosalid', $idprop)->first();
        $thn = $peneliti->tahun_ke;
        $ketua = Peneliti::select('sinta','nama','idpt','idfakultas','idprodi','hindex')->find($peneliti->ketuaid);

        $peserta = Peneliti::leftJoin('tb_keanggota', 'tb_keanggota.anggotaid', '=', 'tb_peneliti.id')
            ->where('tb_keanggota.idpenelitian', '=', $idprop)
            ->where('tb_keanggota.setuju', '<', 2)
            ->orderBy('peran', 'asc')
            ->get();

        $luar = Luaran::select('kategori','idluaran','publish','urllink')
            ->where('idpenelitian', $idprop)
            ->orderBy('kategori', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $biaya = Anggaran::where('proposalid', $idprop)->orderBy('anggaranid','asc')->get();

        $thnr = 0;
        $tbhn = 0;
        $tjln = 0;
        $tbrg = 0;
        foreach ($biaya as $list) 
        {
            if ($list->anggaranid == 1) {
                $thnr += $list->volume * $list->biaya;
            } 
            else if ($list->anggaranid == 2) {
                $tbhn += $list->volume * $list->biaya;
            }
            else if ($list->anggaranid == 3) {
                $tjln += $list->volume * $list->biaya;
            }
            else if ($list->anggaranid == 4) {
                $tbrg += $list->volume * $list->biaya;
            }

        }

        $mata = Mataanggaran::select('batas')->get();

        return view('pengabdianng.baca', compact('person','idprop','prop','thn','ketua','peserta','luar','thnr','tbhn','tjln','tbrg','mata'));

    }
}
