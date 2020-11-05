<?php

namespace App\Http\Controllers\Reviewer\Penilaian;

use App\Anggaran;
use App\AnggaranAkhir;
use App\Luaran;
use App\Mataanggaran;
use App\Peneliti;
use App\PlotingReviwer;
use App\NilaiLaporanAkhir;
use App\NilaiLaporanKemajuan;
use App\Nilai2LaporanAkhir;
use App\Nilai2LaporanKemajuan;
use App\Periode;
use App\Posisi;
use App\LaporanAkhir;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Proposal;
use App\Keanggotaan;
use App\LuaranAkhir;
use App\Penelitian;

use Yajra\DataTables\Facades\DataTables;
use DB;
use App\Quotation;


use Auth;
use Redirect;

class PenilaianLaporanAkhirController extends Controller
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
        $person = PenilaianLaporanAkhirController::countPersonil();

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

            if($skema->idskema == 1 ){//unggulan 9
                $cek = NilaiLaporanAkhir::where('prosalid', $request->prosalid)->where('iddosen',Auth::user()->id)->first();

                if($cek){
                    $cek->kriteria1 = $request->kriteria1; $cek->nilai1 = $request->nilai1;
                    $cek->kriteria2 = $request->kriteria2; $cek->nilai2 = $request->nilai2;
                    $cek->kriteria3 = $request->kriteria3; $cek->nilai3 = $request->nilai3;
                    $cek->kriteria4 = $request->kriteria4; $cek->nilai4 = $request->nilai4;
                    $cek->kriteria5 = $request->kriteria5; $cek->nilai5 = $request->nilai5;
                    $cek->kriteria6 = $request->kriteria6; $cek->nilai6 = $request->nilai6;
                    $cek->kriteria7 = $request->kriteria7; $cek->nilai7 = $request->nilai7;
                    $cek->kriteria8 = $request->kriteria8; $cek->nilai8 = $request->nilai8;
                    $cek->kriteria9 = $request->kriteria9; $cek->nilai9 = $request->nilai9;
                    $cek->komentar  = $request->komentar;
                   // $cek->skema  = $skema->idskema;
                    $cek->update();
    
               
                    return response()->json(['success' ,'data berhasil ditambahkan'], 200);
    
        
                }else{
    
                    $nilai = new NilaiLaporanAkhir();
        
                    $nilai->prosalid = $request->prosalid;
                    $nilai->iddosen = Auth::user()->id;
                    $nilai->jenis = 1;
                    $nilai->kriteria1 = $request->kriteria1; $nilai->nilai1 = $request->nilai1;
                    $nilai->kriteria2 = $request->kriteria2; $nilai->nilai2 = $request->nilai2;
                    $nilai->kriteria3 = $request->kriteria3; $nilai->nilai3 = $request->nilai3;
                    $nilai->kriteria4 = $request->kriteria4; $nilai->nilai4 = $request->nilai4;
                    $nilai->kriteria5 = $request->kriteria5; $nilai->nilai5 = $request->nilai5;
                    $nilai->kriteria6 = $request->kriteria6; $nilai->nilai6 = $request->nilai6;
                    $nilai->kriteria7 = $request->kriteria7; $nilai->nilai7 = $request->nilai7;
                    $nilai->kriteria8 = $request->kriteria8; $nilai->nilai8 = $request->nilai8;
                    $nilai->kriteria9 = $request->kriteria9; $nilai->nilai9 = $request->nilai9;
                    $nilai->komentar  = $request->komentar;
                    $nilai->skema  = $skema->idskema;
                    $nilai->save();
        
                    return response()->json(['success' ,'data berhasil ditambahkan'], 200);
                }
    
            }elseif($skema->idskema==2){//inovasi 11

                $cek = NilaiLaporanAkhir::where('prosalid', $request->prosalid)->where('iddosen',Auth::user()->id)->first();
                if($cek){
                
                    $cek->kriteria1 = $request->kriteria1; $cek->nilai1 = $request->nilai1;
                    $cek->kriteria2 = $request->kriteria2; $cek->nilai2 = $request->nilai2;
                    $cek->kriteria3 = $request->kriteria3; $cek->nilai3 = $request->nilai3;
                    $cek->kriteria4 = $request->kriteria4; $cek->nilai4 = $request->nilai4;
                    $cek->kriteria5 = $request->kriteria5; $cek->nilai5 = $request->nilai5;
                    $cek->kriteria6 = $request->kriteria6; $cek->nilai6 = $request->nilai6;
                    $cek->kriteria7 = $request->kriteria7; $cek->nilai7 = $request->nilai7;
                    $cek->kriteria8 = $request->kriteria8; $cek->nilai8 = $request->nilai8;
                    $cek->kriteria9 = $request->kriteria9; $cek->nilai9 = $request->nilai9;
                    $cek->kriteria10 = $request->kriteria10; $cek->nilai10 = $request->nilai10;
                    $cek->kriteria11 = $request->kriteria11; $cek->nilai11 = $request->nilai11;
                    $cek->komentar  = $request->komentar;
                   // $cek->skema  = $skema->idskema;
                    $cek->update();
    
               
                    return response()->json(['success' ,'data berhasil ditambahkan'], 200);
    
        
                }else{
    
                    $nilai = new NilaiLaporanAkhir();
        
                    $nilai->prosalid = $request->prosalid;
                    $nilai->iddosen = Auth::user()->id;
                    $nilai->jenis = 1;
                    $nilai->kriteria1 = $request->kriteria1; $nilai->nilai1 = $request->nilai1;
                    $nilai->kriteria2 = $request->kriteria2; $nilai->nilai2 = $request->nilai2;
                    $nilai->kriteria3 = $request->kriteria3; $nilai->nilai3 = $request->nilai3;
                    $nilai->kriteria4 = $request->kriteria4; $nilai->nilai4 = $request->nilai4;
                    $nilai->kriteria5 = $request->kriteria5; $nilai->nilai5 = $request->nilai5;
                    $nilai->kriteria6 = $request->kriteria6; $nilai->nilai6 = $request->nilai6;
                    $nilai->kriteria7 = $request->kriteria7; $nilai->nilai7 = $request->nilai7;
                    $nilai->kriteria8 = $request->kriteria8; $nilai->nilai8 = $request->nilai8;
                    $nilai->kriteria9 = $request->kriteria9; $nilai->nilai9 = $request->nilai9;
                    $nilai->kriteria10 = $request->kriteria10; $nilai->nilai10 = $request->nilai10;
                    $nilai->kriteria11 = $request->kriteria11; $nilai->nilai11 = $request->nilai11;
                    $nilai->komentar  = $request->komentar;
                    $nilai->skema  = $skema->idskema;
                    $nilai->save();
        
                    return response()->json(['success' ,'data berhasil ditambahkan'], 200);
                }
            }elseif($skema->idskema==3){//bidangilmu 10
                $cek = NilaiLaporanAkhir::where('prosalid', $request->prosalid)->where('iddosen',Auth::user()->id)->first();

                if($cek){
                    $cek->kriteria1 = $request->kriteria1; $cek->nilai1 = $request->nilai1;
                    $cek->kriteria2 = $request->kriteria2; $cek->nilai2 = $request->nilai2;
                    $cek->kriteria3 = $request->kriteria3; $cek->nilai3 = $request->nilai3;
                    $cek->kriteria4 = $request->kriteria4; $cek->nilai4 = $request->nilai4;
                    $cek->kriteria5 = $request->kriteria5; $cek->nilai5 = $request->nilai5;
                    $cek->kriteria6 = $request->kriteria6; $cek->nilai6 = $request->nilai6;
                    $cek->kriteria7 = $request->kriteria7; $cek->nilai7 = $request->nilai7;
                    $cek->kriteria8 = $request->kriteria8; $cek->nilai8 = $request->nilai8;
                    $cek->kriteria9 = $request->kriteria9; $cek->nilai9 = $request->nilai9;
                    $cek->kriteria10 = $request->kriteria10; $cek->nilai10 = $request->nilai10;
                    $cek->komentar  = $request->komentar;
                   // $cek->skema  = $skema->idskema;
                    $cek->update();
                    
                    return response()->json(['success' ,'data berhasil ditambahkan'], 200);
    
        
                }else{
    
                    $nilai = new NilaiLaporanAkhir();
        
                    $nilai->prosalid = $request->prosalid;
                    $nilai->iddosen = Auth::user()->id;
                    $nilai->jenis = 1;
                    $nilai->kriteria1 = $request->kriteria1; $nilai->nilai1 = $request->nilai1;
                    $nilai->kriteria2 = $request->kriteria2; $nilai->nilai2 = $request->nilai2;
                    $nilai->kriteria3 = $request->kriteria3; $nilai->nilai3 = $request->nilai3;
                    $nilai->kriteria4 = $request->kriteria4; $nilai->nilai4 = $request->nilai4;
                    $nilai->kriteria5 = $request->kriteria5; $nilai->nilai5 = $request->nilai5;
                    $nilai->kriteria6 = $request->kriteria6; $nilai->nilai6 = $request->nilai6;
                    $nilai->kriteria7 = $request->kriteria7; $nilai->nilai7 = $request->nilai7;
                    $nilai->kriteria8 = $request->kriteria8; $nilai->nilai8 = $request->nilai8;
                    $nilai->kriteria9 = $request->kriteria9; $nilai->nilai9 = $request->nilai9;
                    $nilai->kriteria10 = $request->kriteria10; $nilai->nilai10 = $request->nilai10;
                    $nilai->komentar  = $request->komentar;
                    $nilai->skema  = $skema->idskema;
                    $nilai->save();
        
                    return response()->json(['success' ,'data berhasil ditambahkan'], 200);
                }
            }elseif($skema->idskema==4){//guru 9
                $cek = NilaiLaporanAkhir::where('prosalid', $request->prosalid)->where('iddosen',Auth::user()->id)->first();

                
                if($cek){
                    $cek->kriteria1 = $request->kriteria1; $cek->nilai1 = $request->nilai1;
                    $cek->kriteria2 = $request->kriteria2; $cek->nilai2 = $request->nilai2;
                    $cek->kriteria3 = $request->kriteria3; $cek->nilai3 = $request->nilai3;
                    $cek->kriteria4 = $request->kriteria4; $cek->nilai4 = $request->nilai4;
                    $cek->kriteria5 = $request->kriteria5; $cek->nilai5 = $request->nilai5;
                    $cek->kriteria6 = $request->kriteria6; $cek->nilai6 = $request->nilai6;
                    $cek->kriteria7 = $request->kriteria7; $cek->nilai7 = $request->nilai7;
                    $cek->kriteria8 = $request->kriteria8; $cek->nilai8 = $request->nilai8;
                    $cek->kriteria9 = $request->kriteria9; $cek->nilai9 = $request->nilai9;
                    $cek->komentar  = $request->komentar;
                   // $cek->skema  = $skema->idskema;
                    $cek->update();
    
               
                    return response()->json(['success' ,'data berhasil ditambahkan'], 200);
    
        
                }else{
    
                    $nilai = new NilaiLaporanAkhir();
        
                    $nilai->prosalid = $request->prosalid;
                    $nilai->iddosen = Auth::user()->id;
                    $nilai->jenis = 1;
                    $nilai->kriteria1 = $request->kriteria1; $nilai->nilai1 = $request->nilai1;
                    $nilai->kriteria2 = $request->kriteria2; $nilai->nilai2 = $request->nilai2;
                    $nilai->kriteria3 = $request->kriteria3; $nilai->nilai3 = $request->nilai3;
                    $nilai->kriteria4 = $request->kriteria4; $nilai->nilai4 = $request->nilai4;
                    $nilai->kriteria5 = $request->kriteria5; $nilai->nilai5 = $request->nilai5;
                    $nilai->kriteria6 = $request->kriteria6; $nilai->nilai6 = $request->nilai6;
                    $nilai->kriteria7 = $request->kriteria7; $nilai->nilai7 = $request->nilai7;
                    $nilai->kriteria8 = $request->kriteria8; $nilai->nilai8 = $request->nilai8;
                    $nilai->kriteria9 = $request->kriteria9; $nilai->nilai9 = $request->nilai9;
                    $nilai->komentar  = $request->komentar;
                    $nilai->skema  = $skema->idskema;
                    $nilai->save();
        
                    return response()->json(['success' ,'data berhasil ditambahkan'], 200);
                }
            }  elseif($skema->idskema == 5 ){//masyarakat
                $cek = NilaiLaporanAkhir::where('prosalid', $request->prosalid)->where('iddosen',Auth::user()->id)->where('jenis',2)->first();

               if($cek){
                   $cek->kriteria1 = $request->kriteria1; $cek->nilai1 = $request->nilai1;
                   $cek->kriteria2 = $request->kriteria2; $cek->nilai2 = $request->nilai2;
                   $cek->kriteria3 = $request->kriteria3; $cek->nilai3 = $request->nilai3;
                   $cek->kriteria4 = $request->kriteria4; $cek->nilai4 = $request->nilai4;
                   $cek->kriteria5 = $request->kriteria5; $cek->nilai5 = $request->nilai5;
                   $cek->kriteria6 = $request->kriteria6; $cek->nilai6 = $request->nilai6;
                   $cek->kriteria7 = $request->kriteria7; $cek->nilai7 = $request->nilai7;
                   $cek->kriteria8 = $request->kriteria8; $cek->nilai8 = $request->nilai8;
                   $cek->kriteria9 = $request->kriteria9; $cek->nilai9 = $request->nilai9;
                   $cek->komentar  = $request->komentar;
                  // $cek->skema  = $skema->idskema;
                   $cek->update();
   
              
                   return response()->json(['success' ,'data berhasil ditambahkan'], 200);
   
       
               }else{
   
                   $nilai = new NilaiLaporanAkhir();
       
                   $nilai->prosalid = $request->prosalid;
                   $nilai->iddosen = Auth::user()->id;
                   $nilai->jenis = 2;
                   $nilai->kriteria1 = $request->kriteria1; $nilai->nilai1 = $request->nilai1;
                   $nilai->kriteria2 = $request->kriteria2; $nilai->nilai2 = $request->nilai2;
                   $nilai->kriteria3 = $request->kriteria3; $nilai->nilai3 = $request->nilai3;
                   $nilai->kriteria4 = $request->kriteria4; $nilai->nilai4 = $request->nilai4;
                   $nilai->kriteria5 = $request->kriteria5; $nilai->nilai5 = $request->nilai5;
                   $nilai->kriteria6 = $request->kriteria6; $nilai->nilai6 = $request->nilai6;
                   $nilai->kriteria7 = $request->kriteria7; $nilai->nilai7 = $request->nilai7;
                   $nilai->kriteria8 = $request->kriteria8; $nilai->nilai8 = $request->nilai8;
                   $nilai->kriteria9 = $request->kriteria9; $nilai->nilai9 = $request->nilai9;
                   $nilai->komentar  = $request->komentar;
                   $nilai->skema  = $skema->idskema;
                   $nilai->save();
       
                   return response()->json(['success' ,'data berhasil ditambahkan'], 200);
               }
   
           }
            elseif($skema->idskema == 6 ){//desa 9
                $cek = NilaiLaporanAkhir::where('prosalid', $request->prosalid)->where('iddosen',Auth::user()->id)->where('jenis',2)->first();

               if($cek){
                   $cek->kriteria1 = $request->kriteria1; $cek->nilai1 = $request->nilai1;
                   $cek->kriteria2 = $request->kriteria2; $cek->nilai2 = $request->nilai2;
                   $cek->kriteria3 = $request->kriteria3; $cek->nilai3 = $request->nilai3;
                   $cek->kriteria4 = $request->kriteria4; $cek->nilai4 = $request->nilai4;
                   $cek->kriteria5 = $request->kriteria5; $cek->nilai5 = $request->nilai5;
                   $cek->kriteria6 = $request->kriteria6; $cek->nilai6 = $request->nilai6;
                   $cek->kriteria7 = $request->kriteria7; $cek->nilai7 = $request->nilai7;
                   $cek->kriteria8 = $request->kriteria8; $cek->nilai8 = $request->nilai8;
                   $cek->kriteria9 = $request->kriteria9; $cek->nilai9 = $request->nilai9;
                   $cek->kriteria10 = $request->kriteria10; $cek->nilai10 = $request->nilai10;
                   $cek->komentar  = $request->komentar;
                  // $cek->skema  = $skema->idskema;
                   $cek->update();
   
              
                   return response()->json(['success' ,'data berhasil ditambahkan'], 200);
   
       
               }else{
   
                   $nilai = new NilaiLaporanAkhir();
       
                   $nilai->prosalid = $request->prosalid;
                   $nilai->iddosen = Auth::user()->id;
                   $nilai->jenis = 2;
                   $nilai->kriteria1 = $request->kriteria1; $nilai->nilai1 = $request->nilai1;
                   $nilai->kriteria2 = $request->kriteria2; $nilai->nilai2 = $request->nilai2;
                   $nilai->kriteria3 = $request->kriteria3; $nilai->nilai3 = $request->nilai3;
                   $nilai->kriteria4 = $request->kriteria4; $nilai->nilai4 = $request->nilai4;
                   $nilai->kriteria5 = $request->kriteria5; $nilai->nilai5 = $request->nilai5;
                   $nilai->kriteria6 = $request->kriteria6; $nilai->nilai6 = $request->nilai6;
                   $nilai->kriteria7 = $request->kriteria7; $nilai->nilai7 = $request->nilai7;
                   $nilai->kriteria8 = $request->kriteria8; $nilai->nilai8 = $request->nilai8;
                   $nilai->kriteria9 = $request->kriteria9; $nilai->nilai9 = $request->nilai9;
                   $nilai->kriteria10 = $request->kriteria10; $nilai->nilai10 = $request->nilai10;
                   $nilai->komentar  = $request->komentar;
                   $nilai->skema  = $skema->idskema;
                   $nilai->save();
       
                   return response()->json(['success' ,'data berhasil ditambahkan'], 200);
               }
   
           }
           elseif($skema->idskema == 7 ){//masyarakat
            $cek = NilaiLaporanAkhir::where('prosalid', $request->prosalid)->where('iddosen',Auth::user()->id)->where('jenis',1)->first();

           if($cek){
               $cek->kriteria1 = $request->kriteria1; $cek->nilai1 = $request->nilai1;
               $cek->kriteria2 = $request->kriteria2; $cek->nilai2 = $request->nilai2;
               $cek->kriteria3 = $request->kriteria3; $cek->nilai3 = $request->nilai3;
               $cek->kriteria4 = $request->kriteria4; $cek->nilai4 = $request->nilai4;
               $cek->kriteria5 = $request->kriteria5; $cek->nilai5 = $request->nilai5;
               $cek->kriteria6 = $request->kriteria6; $cek->nilai6 = $request->nilai6;
               $cek->kriteria7 = $request->kriteria7; $cek->nilai7 = $request->nilai7;
               $cek->kriteria8 = $request->kriteria8; $cek->nilai8 = $request->nilai8;
               $cek->komentar  = $request->komentar;
              // $cek->skema  = $skema->idskema;
               $cek->update();

          
               return response()->json(['success' ,'data berhasil ditambahkan'], 200);

   
           }else{

               $nilai = new NilaiLaporanAkhir();
   
               $nilai->prosalid = $request->prosalid;
               $nilai->iddosen = Auth::user()->id;
               $nilai->jenis = 1;
               $nilai->kriteria1 = $request->kriteria1; $nilai->nilai1 = $request->nilai1;
               $nilai->kriteria2 = $request->kriteria2; $nilai->nilai2 = $request->nilai2;
               $nilai->kriteria3 = $request->kriteria3; $nilai->nilai3 = $request->nilai3;
               $nilai->kriteria4 = $request->kriteria4; $nilai->nilai4 = $request->nilai4;
               $nilai->kriteria5 = $request->kriteria5; $nilai->nilai5 = $request->nilai5;
               $nilai->kriteria6 = $request->kriteria6; $nilai->nilai6 = $request->nilai6;
               $nilai->kriteria7 = $request->kriteria7; $nilai->nilai7 = $request->nilai7;
               $nilai->kriteria8 = $request->kriteria8; $nilai->nilai8 = $request->nilai8;
               $nilai->komentar  = $request->komentar;
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
        $nilai = NilaiLaporanAkhir::where('prosalid', $id)->where('iddosen',Auth::user()->id)->first();

        if($nilai) {
            $output = array();

            $output[] = $nilai->komentar;
            $output[] = $nilai->kriteria1;
            $output[] = $nilai->kriteria2;
            $output[] = $nilai->kriteria3;
            $output[] = $nilai->kriteria4;
            $output[] = $nilai->kriteria5;
            $output[] = $nilai->kriteria6;
            $output[] = $nilai->kriteria7;
            $output[] = $nilai->kriteria8;
            $output[] = $nilai->kriteria9;
            $output[] = $nilai->kriteria10;
            $output[] = $nilai->kriteria11;
            
            $output[] = $nilai->nilai1; //12
            $output[] = $nilai->nilai2; //13
            $output[] = $nilai->nilai3; //14
            $output[] = $nilai->nilai4; //15
            $output[] = $nilai->nilai5; //16
            $output[] = $nilai->nilai6; //17
            $output[] = $nilai->nilai7; //18
            $output[] = $nilai->nilai8; //19
            $output[] = $nilai->nilai9; //20
            $output[] = $nilai->nilai10; //21
            $output[] = $nilai->nilai11; //22
            $output[] = $nilai->rekomdana; //23
            
        
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
         try
        {
            DB::statement(DB::raw('set @rownum=0'));

            $proposal = Proposal::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'tb_proposal.id','tb_proposal.idskema','ketuaid','tb_peneliti.nidn','tb_peneliti.nama','judul','tb_penelitian.prosalid','tb_proposal.jenis','tb_laporan_akhir.status','adm_status.jenis as jenisstatus','upload'])
                ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
                ->leftJoin('tb_ploting_reviewer', 'tb_ploting_reviewer.prosalid', 'tb_proposal.id')
                ->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
                ->leftJoin('tb_laporan_akhir', 'tb_laporan_akhir.prosalid', 'tb_proposal.id')
                ->leftJoin('adm_status', 'tb_laporan_akhir.status', 'adm_status.id')
                ->where('tb_ploting_reviewer.iddosen', Auth::user()->id)
                ->where('tb_ploting_reviewer.jenis', 53)
                ->where('tb_penelitian.status', 4)
                // ->where('tb_proposal.jenis', 1)
                ->groupBy('tb_proposal.id')
            ;

            return DataTables::of($proposal)

                ->addColumn('judul', function($proposal) {
                    $anggota = Keanggotaan::select('nama')
                        ->leftJoin('tb_peneliti','tb_keanggota.anggotaid', 'tb_peneliti.id')
                        ->where('idpenelitian',$proposal->prosalid)
                        ->get();
                    $data = '';
                    // here we prepare the options
                    foreach ($anggota as $list) {
                        $data .= '<strong><td class="text-left">-'. $list->nama. '</td></strong><br>'
                        ;
                    }
                    $return =
                        '<td class="text-left">' .$proposal->judul . '</td><br>
                        <td class="text-left">' .$data . '</td>
                   ';
                    return $return;
                })
                ->addColumn('jenis', function ($proposal) {
                    if ($proposal->jenis == 1){
                        return ' <small class="label label-info">Penelitian</small>';
                    }else{
                        return '<small class="label label-warning">Pengabdian</small>';

                    }
                })
                ->addColumn('skema', function ($proposal) {
                    $skema = DB::table('adm_skema')
                       ->select('id','skema')
                       ->groupBy('skema')
                       ->where('id', $proposal->idskema)
                       ->first();
                  
                       return $skema->skema;
                  
               })
               ->addColumn('reviewer', function($proposal) {
                $ploting = PlotingReviwer::select('tb_ploting_reviewer.id','tb_ploting_reviewer.iddosen','nama','adm_status.jenis')
                    ->leftJoin('tb_peneliti','tb_peneliti.id','tb_ploting_reviewer.iddosen' )
                    ->leftJoin('adm_status','adm_status.id','tb_ploting_reviewer.jenis' )
                    ->where('tb_ploting_reviewer.prosalid',$proposal->prosalid)
                    ->where('tb_ploting_reviewer.jenis', 52)
                    ->orderBy('tb_ploting_reviewer.iddosen','ASC')
                    ->orderBy('tb_ploting_reviewer.jenis','ASC')
                    ->get();
                $data = '';
                $temp = '';
                $rata = array();
                // here we prepare the options
                 foreach ($ploting as $list) {
                    $nilai = NilaiLaporanKemajuan::where('prosalid',$proposal->id)
                    ->where('iddosen',$list->iddosen)->first();
                   
                    $nilai2 = Nilai2LaporanKemajuan::where('prosalid',$proposal->id)
                    ->where('iddosen',$list->iddosen)->first();
                    $totalnilai = $nilai->nilai1 + $nilai->nilai2 + $nilai->nilai3 + $nilai->nilai4 + $nilai->nilai5 + $nilai->nilai6 + $nilai->nilai7 + $nilai->nilai8 + $nilai->nilai9 + $nilai->nilai10 + $nilai->nilai11  ;
                    
                    $rata[] = $totalnilai;
                     if ($temp != $list->nama){
                        $data .= '
                        '
                        ;
                        $temp = $list->nama;
                    }else{
                        $data .= '<small class="label label-success">' . $totalnilai . '</small><br>
                        '
                        ;
                    }

                }
                $return =
                    '<td class="text-left">' .$data . '</td><br>
                    <td class="text-left">Rata-Rata : <small class="label label-primary"> '  . array_sum($rata)/count($rata) . '</small></td>
                       ';
                if ($data == null){
                    return '<td class="text-left">Reviewer Belum Di tambahkan</td>';
                }else{
                    return $return;
                }


            })
                ->addColumn('status', function ($proposal) {
                    $ploting = PlotingReviwer::select('tb_ploting_reviewer.iddosen','nama')
                    ->leftJoin('tb_peneliti','tb_peneliti.id','tb_ploting_reviewer.iddosen' )
                    ->where('tb_ploting_reviewer.prosalid',$proposal->prosalid)
                    ->get();
                $data = '';
                // here we prepare the options
                foreach ($ploting as $list) {
                    $nilai = NilaiLaporanAkhir::where('prosalid',$proposal->id)->where('iddosen',Auth::user()->id)->first();
                    $nilai2 = Nilai2LaporanAkhir::where('prosalid',$proposal->id)->where('iddosen',Auth::user()->id)->first();
                    if ($nilai && $nilai2){
                        $data = '<span class="label label-success">Penilaian Monev Hasil Selesai</span><br><span class="label label-success">Tanggapan Reviewer Selesai</span>'
                        ;
                    }
                    else if ($nilai){
                        $data = '<span class="label label-success">Penilaian Monev Hasil Selesai </span><br> <span class="label label-danger">Lanjutkan Tanggapan Reviewer </span>'
                        ;
                    }
                    else if ($nilai2){
                        $data = '<span class="label label-success">Tanggapan Reviewer Selesai </span><br> <span class="label label-danger">Lanjutkan Penilaian Monev Hasil</span>'
                        ;
                    }
                    else{
                        $data = '<span class="label label-danger">Belum di Nilai</span>'
                        ;
                      
                    }
                  
                }
                $return =
                    '<td class="text-left">' .$data . '</td>
                       ';
                if ($data == null){
                    return '<td class="text-left">Reviewer Belum Di tambahkan</td>';
                }else{
                    return $return;
                }

                })
                ->addColumn('upload', function ($proposal) {
                    $luaranlainnya = LuaranAkhir::where('idpenelitian', $proposal->id)->where('kategori',3)->first();
                    $luaranwajib = LuaranAkhir::where('idpenelitian', $proposal->id)->where('kategori',1)->first();
                    $luarantambahan = LuaranAkhir::where('idpenelitian', $proposal->id)->where('kategori',2)->first();
                    $laporanakhir = LaporanAkhir::where('prosalid', $proposal->id)->first();
                    $anggaranakhir = AnggaranAkhir::where('prosalid', $proposal->id)->first();
                    
                    $data = '';
                    if ($luaranlainnya){
                        $data .= ' <small class="label label-primary">Luaran Lainnya </small>:<small class="label label-success">sudah</small><br>';
                    }
                    else{
                        $data .= ' <small class="label label-primary">Luaran Lainnya </small>:<small class="label label-danger">belum </small><br>';
                       

                    }
                    if ($luaranwajib){
                        $data .= ' <small class="label label-primary">Luaran Wajib </small>:<small class="label label-success">sudah</small><br>';
                    }
                    else{
                        $data .= ' <small class="label label-primary">Luaran Wajib </small>:<small class="label label-danger">belum </small><br>';
                       

                    }
                    if ($luarantambahan){
                        $data .= ' <small class="label label-primary">Luaran Tambahan </small>:<small class="label label-success">sudah</small><br>';
                    }
                    else{
                        $data .= ' <small class="label label-primary">Luaran Tambahan </small>:<small class="label label-danger">belum </small><br>';
                       

                    }
                    if ($laporanakhir){
                        $data .= ' <small class="label label-primary">Laporan Akhir </small>:<small class="label label-success">sudah</small><br>';
                    }
                    else{
                        $data .= ' <small class="label label-primary">Laporan Akhir </small>:<small class="label label-danger">belum </small><br>';
                       

                    }
                    if ($anggaranakhir){
                        $data .= ' <small class="label label-primary">Penggunaan Anggaran</small>:<small class="label label-success">sudah</small><br>';
                    }
                    else{
                        $data .= ' <small class="label label-primary">Penggunaan Anggaran</small>:<small class="label label-danger">belum </small><br>';
                       

                    }
                    return $data;
                })
                ->addColumn('action', function ($proposal) {
                    if ($proposal->upload == null){
                        return '';
                    }
                    else {
                        return '
                        <a  href="' . route('rn_laporanakhir.resume', base64_encode(mt_rand(10, 99) . $proposal->prosalid)) . '" class="btn btn-xs edit btn-warning" title="Luaran Penelitian"><i class="glyphicon glyphicon-file"></i> </a>
                        <a  href="'. route('rn_laporanakhir.resumenilai',base64_encode(mt_rand(10,99).$proposal->prosalid) ).'" class="btn btn-xs edit btn-warning" title="Penilaian Monev"><i class="glyphicon glyphicon-edit"></i> </a>
                        <a  href="'. route('rn_laporanakhir.resumenilai2',base64_encode(mt_rand(10,99).$proposal->prosalid) ).'" class="btn btn-xs edit btn-primary" title="Tanggapan Reviewer"><i class="glyphicon glyphicon-edit"></i> </a>
                        ';
                    }
                })
                ->rawColumns(['judul','jenis','skema','status','reviewer','upload', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function resume($id)
    {
        $person = PenilaianLaporanAkhirController::countPersonil();
        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 2, strlen($temp));

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
            $luarkemajuan = LuaranAkhir::select('id','judul','kategori','idluaran','publish','urllink','upload')
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
        $laporanakhir = LaporanAkhir::where('prosalid', $prop->id)->first();
        $anggaranakhir = AnggaranAkhir::where('prosalid', $prop->id)->first();


        return view('reviewer.penilaianpelaksanaan.laporanakhir.resume', compact('person','idprop','prop','thn','ketua','peserta','luar','luarkemajuan','biaya','thnr','tbhn','tjln','tbrg','mata','laporanakhir','anggaranakhir'));
    }
     public function baca($id)
    {
        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 2, strlen($temp));


        $penelitian = LuaranAkhir::where('id', $idprop)->first();
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
                return Redirect::back()->withInput()->withErrors(array('error' => 'error'));
            }
        }

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
                return Redirect::back()->withInput()->withErrors(array('error' => 'error'));
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
                return Redirect::back()->withInput()->withErrors(array('error' => 'error'));
            }
        }

    }
    public function bacaproposal($id)
    {
        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 2, strlen($temp));


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
    public function resumenilai($id)
    {
        $person = PenilaianLaporanAkhirController::countPersonil();
        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 2, strlen($temp));

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

        if($prop->idskema == 1 ){
            return view('reviewer.penilaianpelaksanaan.laporanakhir.resumeunggulan', compact('person','idprop','prop','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata'));
        }elseif($prop->idskema==2){
            return view('reviewer.penilaianpelaksanaan.laporanakhir.resumeinovasi', compact('person','idprop','prop','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata'));
        }elseif($prop->idskema==3){
            return view('reviewer.penilaianpelaksanaan.laporanakhir.resumebidangilmu', compact('person','idprop','prop','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata'));
        }elseif($prop->idskema==4){
            return view('reviewer.penilaianpelaksanaan.laporanakhir.resumeguru', compact('person','idprop','prop','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata'));
        }elseif($prop->idskema == 6 ){
            return view('reviewer.penilaianpelaksanaan.laporanakhir.resumedesa', compact('person','idprop','prop','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata'));
        }elseif($prop->idskema==5){
            return view('reviewer.penilaianpelaksanaan.laporanakhir.resumemasyarakat', compact('person','idprop','prop','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata'));
        }elseif($prop->idskema==7){
            return view('reviewer.penilaianpelaksanaan.laporanakhir.resumedosenmuda', compact('person','idprop','prop','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata'));
        }

    }
    public function resumenilai2($id)
    {
        $person = PenilaianLaporanAkhirController::countPersonil();
        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 2, strlen($temp));

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

        if($prop->jenis == 1 ){
            return view('reviewer.penilaianpelaksanaan.laporanakhir.resumepenelitian', compact('person','idprop','prop','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata'));
        }elseif($prop->jenis==2){
            return view('reviewer.penilaianpelaksanaan.laporanakhir.resumepengabdian', compact('person','idprop','prop','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata'));
        }

    }
    public function resumeberkas($id)
    {
        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 2, strlen($temp));


        $penelitian = LaporanAkhir::where('prosalid', $idprop)->first();
        $file_path = public_path('docs/periode2/rancangan/').$penelitian->upload;
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
                $message = 'Dokumen Tidak Ditemukan..';
                return Redirect::back()->withInput()->withErrors(array('kesalahan' => $message));
            }
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
                    $cek->kriteria1 = $request->kriteria1; 
                    $cek->kriteria2 = $request->kriteria2; 
                    $cek->kriteria3 = $request->kriteria3; 
                    $cek->kriteria4 = $request->kriteria4; 
                    $cek->kriteria5 = $request->kriteria5; 
                    $cek->kriteria6 = $request->kriteria6; 
                   // $cek->skema  = $skema->idskema;
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
                   // $cek->skema  = $skema->idskema;
                   // $cek->skema  = $skema->idskema;
                    $cek->update();
    
               
                    return response()->json(['success' ,'data berhasil ditambahkan'], 200);
    
        
                }else{
    
                    $nilai = new Nilai2LaporanAkhir();
        
                    $nilai->prosalid = $request->prosalid;
                    $nilai->iddosen = Auth::user()->id;
                    $nilai->jenis = 2;
                    $cek->kriteria1 = $request->kriteria1; 
                    $cek->kriteria2 = $request->kriteria2; 
                    $cek->kriteria3 = $request->kriteria3; 
                    $cek->kriteria4 = $request->kriteria4; 
                    $cek->kriteria5 = $request->kriteria5; 
                    $cek->kriteria6 = $request->kriteria6; 
                    $cek->kriteria7 = $request->kriteria7; 
                    $nilai->skema  = $skema->idskema;
                    $nilai->save();
        
                    return response()->json(['success' ,'data berhasil ditambahkan'], 200);
                }
            }
            
                 } catch (\Exception $e) {
            dd($e->getMessage());
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
