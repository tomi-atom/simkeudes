<?php

namespace App\Http\Controllers\Reviewer\Penilaian;

use App\Anggaran;
use App\Luaran;
use App\Mataanggaran;
use App\Peneliti;
use App\PlotingReviwer;
use App\Nilai2LaporanAkhir;
use App\Periode;
use App\Posisi;
use App\LaporanAkhir;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Proposal;
use App\Keanggotaan;
use App\Penelitian;

use Yajra\DataTables\Facades\DataTables;
use DB;
use App\Quotation;


use Auth;
use Redirect;

class Penilaian2LaporanAkhirController extends Controller
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
        // return DataTables::eloquent(Penelitian::query())->make(true);
        $person = Penilaian2LaporanAkhirController::countPersonil();

        $peneliti = Peneliti::select('id','hindex','sinta','status','tanggungan')->find(Auth::user()->id);
        $periode  = Periode::orderBy('tahun', 'desc')->orderBy('sesi', 'desc')->where('aktif','1')->get();

        $proposal = Proposal::select('judul','idprogram','idskema','periodeusul','idfokus','aktif','thnkerja','status','prosalid')
            ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
           // ->where('tb_proposal.periodeusul',$periode[0]->id)
            ->where('tb_penelitian.ketuaid', $peneliti->id)
            ->where('tb_penelitian.status', '>', 0)
            ->where('tb_proposal.jenis', 1)
            ->get();

        $peserta = Proposal::select('judul','idprogram','idskema','periodeusul','idfokus','thnkerja','status','prosalid','peran','setuju')
            ->leftJoin('tb_keanggota', 'tb_proposal.id', 'tb_keanggota.idpenelitian')
            ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
           // ->where('tb_proposal.periodeusul',$periode[0]->id)
            ->where('tb_keanggota.anggotaid', $peneliti->id)
            ->where('tb_penelitian.status', '>', 0)
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


        $skema = DB::table('adm_skema')
            ->select('id','skema')
            ->groupBy('skema')
            ->orderBy('id', 'ASC')
            ->get();


        return view('reviewer.penilaianpelaksanaan.laporanakhir.index', compact('skema','person', 'peneliti', 'periode', 'proposal', 'total','ketua','peserta','member', 'status', 'minat'));

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
        $_token = $request->get('_token');
        try
         {
             $skema = Proposal::find( $request->prosalid);
 
             if($skema->jenis == 1 ){//unggulan 9
                 $cek = Nilai2LaporanAkhir::where('prosalid', $request->prosalid)->where('iddosen',Auth::user()->id)->first();
 
                 if($cek){
                     $cek->kriteria1 = $request->kriteria1; 
                     $cek->kriteria2 = $request->kriteria2; 
                     $cek->kriteria3 = $request->kriteria3; 
                     $cek->kriteria4 = $request->kriteria4; 
                     $cek->kriteria5 = $request->kriteria5; 
                     $cek->kriteria6 = $request->kriteria6; 
                     $cek->kriteria7 = $request->kriteria7; 
                    // $cek->skema  = $skema->idskema;
                     $cek->update();
     
                
                     return response()->json(['success' ,'data berhasil ditambahkan'], 200);
     
         
                 }else{
     
                     $nilai = new Nilai2LaporanAkhir();
         
                     $nilai->prosalid = $request->prosalid;
                     $nilai->iddosen = Auth::user()->id;
                     $nilai->jenis = 1;
                     $nilai->kriteria1 = $request->kriteria1; 
                     $nilai->kriteria2 = $request->kriteria2; 
                     $nilai->kriteria3 = $request->kriteria3; 
                     $nilai->kriteria4 = $request->kriteria4; 
                     $nilai->kriteria5 = $request->kriteria5; 
                     $nilai->kriteria6 = $request->kriteria6;
                     $nilai->kriteria7 = $request->kriteria7;  
                     $nilai->skema  = $skema->idskema;
                     $nilai->save();
         
                     return response()->json(['success' ,'data berhasil ditambahkan'], 200);
                 }
     
             }elseif($skema->jenis==2){//pengabdian
 
                 $cek = Nilai2LaporanAkhir::where('prosalid', $request->prosalid)->where('iddosen',Auth::user()->id)->first();
                 if($cek){
                 
                     $cek->kriteria1 = $request->kriteria1; 
                     $cek->kriteria2 = $request->kriteria2; 
                     $cek->kriteria3 = $request->kriteria3; 
                     $cek->kriteria4 = $request->kriteria4; 
                     $cek->kriteria5 = $request->kriteria5; 
                     $cek->kriteria6 = $request->kriteria6; 
                     $cek->kriteria7 = $request->kriteria7; 
                  
                     $cek->update();
     
                
                     return response()->json(['success' ,'data berhasil ditambahkan'], 200);
     
         
                 }else{
     
                     $nilai = new Nilai2LaporanAkhir();
         
                     $nilai->prosalid = $request->prosalid;
                     $nilai->iddosen = Auth::user()->id;
                     $nilai->jenis = 2;
                     $nilai->kriteria1 = $request->kriteria1; 
                     $nilai->kriteria2 = $request->kriteria2; 
                     $nilai->kriteria3 = $request->kriteria3; 
                     $nilai->kriteria4 = $request->kriteria4; 
                     $nilai->kriteria5 = $request->kriteria5; 
                     $nilai->kriteria6 = $request->kriteria6; 
                     $nilai->kriteria7 = $request->kriteria7; 
                     $nilai->skema  = $skema->idskema;
                     $nilai->save();
         
                     return response()->json(['success' ,'data berhasil ditambahkan'], 200);
                 }
             }
             
                  } catch (\Exception $e) {
             dd($e->getMessage());
         }
    }
    public function getnilai($id)
    {
        $nilai = Nilai2LaporanAkhir::where('prosalid', $id)->where('iddosen',Auth::user()->id)->first();

        if($nilai) {
            $output = array();

            $output[] = $nilai->kriteria1;
            $output[] = $nilai->kriteria2;
            $output[] = $nilai->kriteria3;
            $output[] = $nilai->kriteria4;
            $output[] = $nilai->kriteria5;
            $output[] = $nilai->kriteria6;
            $output[] = $nilai->kriteria7;
           
            
        
            return json_encode($output);
        }
        else
            return json_encode(0);
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
    public function show(Request $request)
    {
        
    }
  
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $periode = Periode::all()
            ->where('id', $id)
            ->first();
        try
        {
            return response()->json(['success' => 'successfull retrieve data', 'data' => $periode->toJson()], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function update(Request $request)
    {
        
    }
   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proposal = Proposal::find($id);
        $data = LaporanAkhir::select('id','status','upload')
            ->where('prosalid',$proposal->id)
            ->first();
        try
        {
            if($data){
                $data->status = '6';
                $data->update();
                return response()->json(['success' => 'success verifikasi data'], 200);
            }else {
                // Error
                $message = 'Data Tidak bisa diverifikasi..';
                return Redirect::back()->withInput()->withErrors(array('kesalahan' => $message));
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

}
