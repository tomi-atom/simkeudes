<?php

namespace App\Http\Controllers\Pelaksanaan;

use App\Bidangtkt;
use App\CatatanHarian;
use App\Substansi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Proposal;
use App\Keanggotaan;
use App\Peneliti;
use App\Program;
use App\Periode;
use App\Posisi;
use File;
use PDF;

use Auth;
use Redirect;
use Yajra\DataTables\Facades\DataTables;


class CatatanHarianController extends Controller
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
        $person = CatatanHarianController::countPersonil();

        $peneliti = Peneliti::select('id','hindex','sinta','status','tanggungan')->find(Auth::user()->id);
        $periode  = Periode::where('aktif', '1')->orderBy('tahun', 'desc')->orderBy('sesi', 'desc')->get();
        $periodeterbaru  = Periode::orderBy('tahun', 'desc')->orderBy('sesi', 'desc')->first();

        $proposal = Proposal::select('judul','idprogram','idskema','periodeusul','idfokus','aktif','thnkerja','tb_penelitian.prosalid','jenis')
            ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
           // ->leftJoin('tb_catatan_harian', 'tb_catatan_harian.prosalid', 'tb_proposal.id')
           // ->where('tb_proposal.periodeusul',$periode[0]->id)
            ->where('tb_penelitian.ketuaid', $peneliti->id)
            ->where('tb_penelitian.status',  4)
            // ->where('tb_proposal.jenis', 1)
            ->get();
        $catatan = CatatanHarian::select('status','upload')
            ->where('prosalid', $proposal[0]->prosalid)
            ->get();

        $peserta = Proposal::select('judul','idprogram','idskema','periodeusul','idfokus','thnkerja','status','prosalid','peran','setuju')
            ->leftJoin('tb_keanggota', 'tb_proposal.id', 'tb_keanggota.idpenelitian')
            ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
            //->where('tb_proposal.periodeusul',$periode[0]->id)
            ->where('tb_keanggota.anggotaid', $peneliti->id)
            ->where('tb_penelitian.status',  4)
            ->where('tb_keanggota.setuju', '<', 2)
            ->where('tb_proposal.jenis', 1)
            ->where('tb_proposal.aktif', '1')
            ->orderBy('tb_keanggota.peran', 'asc')
            ->get();

        $minat =  Proposal::leftJoin('tb_keanggota', 'tb_proposal.id', 'tb_keanggota.idpenelitian')
            ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
           // ->where('tb_proposal.periodeusul',$periode[0]->id)
            ->where('tb_penelitian.ketuaid', $peneliti->id)
            ->where('tb_penelitian.status', '>', 0)
            ->where('tb_keanggota.setuju', 0)
            ->where('tb_proposal.jenis', 1)
            ->where('tb_proposal.aktif', '1')
            ->count(); 

        $status = Posisi::select('jenis')->where('aktif', '1')->orderBy('id','asc')->get(); //*temp

        $member = Keanggotaan::leftJoin('tb_proposal', 'tb_keanggota.idpenelitian', 'tb_proposal.id')
                        ->where('tb_keanggota.anggotaid', Auth::user()->id)
                        ->where('tb_keanggota.setuju', 1)
                        ->where('tb_proposal.jenis', 1)
                        ->count();

        $ketua   = count($proposal);
        $total   = $ketua + count($peserta);
        $waktu = Carbon::now('Asia/Jakarta');

        return view('pelaksanaan.catatanharian.index', compact('person', 'peneliti', 'periode','catatan','waktu','periodeterbaru', 'proposal', 'total','ketua','peserta','member', 'status', 'minat','upload'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $periode = $request['idtahun'];

        $person = CatatanHarianController::countPersonil();
        $peneliti = Peneliti::find(Auth::user()->id);
       
        $program = Program::where('kategori', 1)->where('aktif', '1')->get();

        return view('pelaksanaan.catatanharian.create', compact('person', 'peneliti', 'program', 'periode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
     {
 
         $idprop = $request['id'];
 
         $proposal = Proposal::find($idprop);
         if ($proposal) {
 
             if ($request->hasFile('upload')) {
 
                 $file  = $request->file('upload');
                 if ($file->getClientMimeType() !== 'application/pdf' ) {
                   
                 }
                 else {
                     if ($file->getSize() < 5147152) {
                         $nama_file = "docs-catatan".$request->get('tanggal').mt_rand(100,999).$proposal->id.mt_rand(10,99)."-".$proposal->idketua.".".$file->getClientOriginalExtension();
 
                         $lokasi = public_path('docs/periode2/rancangan');
 
                         $file->move($lokasi, $nama_file);
                     }
                     else {
                         $message = 'Gagal mengunggah, ukuran dokumen melebihi aturan..';
                         return Redirect::back()->withInput()->withErrors(array('kesalahan' => $message));
                     }
                 }
             }else{
                  $nama_file = "0";
             }
         }
         $keterangan  = $request['keterangan'] ? $request['keteranngan'] : '';
         
         
         $catatanharian = new CatatanHarian();
 
         $catatanharian->prosalid    = $idprop;
         $catatanharian->tanggal     = $request->get('tanggal');
         $catatanharian->keterangan  =  $request->get('keterangan');
         $catatanharian->status      = 4;
         $catatanharian->upload      = $nama_file;
         
         $catatanharian->save();
         
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getRowNum()
    {
        return view('datatables.eloquent.rownum');
    }
    public function show()
    {
        // return DataTables::eloquent(Bidangtkt::query())->make(true);
        try
        {
            DB::statement(DB::raw('set @rownum=0'));
            $bidangtkts = Bidangtkt::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'id', 'bidang', 'aktif']);

            return DataTables::of($bidangtkts)
                ->addColumn('action', function ($bidangtkts) {
                    return '
                    <button id="' . $bidangtkts->id . '" class="btn btn-xs edit"><i class="glyphicon glyphicon-edit"></i></button>
                    <button id="' . $bidangtkts->id . '" class="btn btn-xs  delete" ><i class="glyphicon glyphicon-trash"></i> </button>';
                })
                ->make(true);
        } catch (\Exception $e) {
            dd($e->getMessage());
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
        $person = CatatanHarianController::countPersonil();

        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 2, strlen($temp));

        $proposal = Proposal::select('tb_penelitian.prosalid','judul','idprogram','idskema','periodeusul','idfokus','aktif','thnkerja','tb_penelitian.status','jenis','upload')
            ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
            ->leftJoin('tb_catatan_harian', 'tb_catatan_harian.prosalid', 'tb_proposal.id')
            // ->where('tb_proposal.jenis', 1)
            ->find($idprop);
        if ($proposal) {

            return view ('pelaksanaan.catatanharian.unggahan', compact('person','proposal'));
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



            $catatanharian = new CatatanHarian();

            $catatanharian->prosalid = $idprop;
            $catatanharian->upload  = $request->get('upload');
            $catatanharian->status     = '7';

            $catatanharian->save();
            //$proposal->update();
            return Redirect::route('catatanharian.index', base64_encode(mt_rand(10,99).($idprop*2+29)));
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

        $penelitian = CatatanHarian::where('prosalid', $idprop)->first();
        $filename = public_path('docs/periode2/rancangan/').$penelitian->upload;
        if ($penelitian) {
            $penelitian->delete();
            File::delete($filename);
        }
    }
    public function getusulan($id)
    {
        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 1, strlen($temp)) - Auth::user()->id;

        $usulan = Substansi::where('proposalid', $idprop)->first();

        if(count($usulan) == 1) {
            $output = array();

            $output[] = $usulan->ringkasan;
            $output[] = $usulan->katakunci;
            $output[] = $usulan->lbelakang;
            $output[] = $usulan->literatur;
            $output[] = $usulan->metode;
            $output[] = $usulan->jadwal;
            $output[] = $usulan->pustaka;

            return json_encode($output);
        }
        else
            return json_encode(0);
    }

    function perbaru(Request $request, $id)
    {
        $_token= $request['_token'];

        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 1, strlen($temp)) - Auth::user()->id;

        $catatanharian = Substansi::where('proposalid', $idprop)->first();

        if ($catatanharian) {
            $catatanharian->ringkasan  = $request['ringkasan'];
            $catatanharian->katakunci  = $request['katakunci'];
            $catatanharian->lbelakang  = $request['lbelakang'];
            $catatanharian->literatur  = $request['literatur'];
            $catatanharian->metode     = $request['metode'];
            $catatanharian->jadwal     = $request['jadwal'];
            $catatanharian->pustaka    = $request['pustaka'];

            $catatanharian->update();
        }
    }
}
