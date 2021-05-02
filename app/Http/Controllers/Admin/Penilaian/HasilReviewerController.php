<?php

namespace App\Http\Controllers\Admin\Penilaian;

use App\Anggaran;
use App\Luaran;
use App\Nilai;
use App\Mataanggaran;
use App\Peneliti;
use App\Periode;
use App\PlotingReviwer;
use App\Posisi;
use App\RancanganPenelitian;
use App\Reviewer;
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

class HasilReviewerController extends Controller
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
        $person = HasilReviewerController::countPersonil();

        $peneliti = Peneliti::select('id','hindex','sinta','status','tanggungan')->find(Auth::user()->id);
        $periode  = Periode::orderBy('tahun', 'desc')->orderBy('sesi', 'desc')
        ->get();
        $aperiode  = Periode::where('aktif','0')->orderBy('tahun', 'desc')->orderBy('sesi', 'desc')
        ->get();
        $proposal = Proposal::select('judul','idprogram','idskema','periodeusul','idfokus','aktif','thnkerja','status','prosalid')
            ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
            ->where('tb_proposal.periodeusul',$periode[0]->id)
            ->where('tb_penelitian.ketuaid', $peneliti->id)
            ->where('tb_penelitian.status', '>', 0)
            ->where('tb_proposal.jenis', 1)
            ->get();

        $peserta = Proposal::select('judul','idprogram','idskema','periodeusul','idfokus','thnkerja','status','prosalid','peran','setuju')
            ->leftJoin('tb_keanggota', 'tb_proposal.id', 'tb_keanggota.idpenelitian')
            ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
            ->where('tb_proposal.periodeusul',$periode[0]->id)
            ->where('tb_keanggota.anggotaid', $peneliti->id)
            ->where('tb_penelitian.status', '>', 0)
            ->where('tb_keanggota.setuju', '<', 2)
            ->where('tb_proposal.jenis', 1)
            ->where('tb_proposal.aktif', '1')
            ->orderBy('tb_keanggota.peran', 'asc')
            ->get();

        $minat =  Proposal::leftJoin('tb_keanggota', 'tb_proposal.id', 'tb_keanggota.idpenelitian')
            ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
            ->where('tb_proposal.periodeusul',$periode[0]->id)
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
        $reviewerpengabdian = Reviewer::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'tb_reviewer.id', 'name','nidn','periode','jenis'])
            ->leftJoin('users', 'tb_reviewer.iddosen', 'users.id')
            ->where('jenis','2')
            ->where('users.level', '!=','3')
            ->get();

        $reviewerpenelitian = Reviewer::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'tb_reviewer.id', 'name','nidn','periode','jenis'])
            ->leftJoin('users', 'tb_reviewer.iddosen', 'users.id')
            ->where('jenis','1')
            ->where('users.level', '!=','3')
            ->get();



        return view('admin.penilaian.hasil.index', compact('skema','person', 'peneliti','reviewerpenelitian','reviewerpengabdian',  'periode','aperiode', 'proposal', 'total','ketua','peserta','member', 'status', 'minat'));
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
        try
        {
            PlotingReviwer::create($request->all());

            return response()->json(['success' => 'data berhasil ditambahkan'], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
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
        // return DataTables::eloquent(Mataanggaran::query())->make(true);
        try
        {
            DB::statement(DB::raw('set @rownum=0'));
            $mataanggaran = Mataanggaran::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'id', 'jenis','batas', 'aktif']);

            return DataTables::of($mataanggaran)
                ->addColumn('action', function ($mataanggaran) {
                    return '<button id="' . $mataanggaran->id . '" class="btn btn-xs edit"><i class="glyphicon glyphicon-edit"></i></button>
                    <button id="' . $mataanggaran->id . '" class="btn btn-xs  delete" ><i class="glyphicon glyphicon-trash"></i> </button>';
                })
                ->make(true);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }
     public function reviewerpenelitian()
    {
        try
        {
            DB::statement(DB::raw('set @rownum=0'));
            /*$peneliti = Reviewer::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'tb_reviewer.iddosen as id', 'tb_peneliti.nama','tb_peneliti.nidn','tb_reviewer.periode','tb_reviewer.jenis'])
                ->leftJoin('tb_peneliti', 'tb_reviewer.iddosen', 'tb_peneliti.id')
                ->leftJoin('adm_periode', 'tb_reviewer.periode', 'adm_periode.id')
                ->where('adm_periode.aktif','1')
                ->where('tb_reviewer.jenis','!=','2')
                //->orderBy('level','DESC')
            ;*/
            $peneliti = Reviewer::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'tb_reviewer.iddosen as id', 'tb_peneliti.nama','tb_peneliti.nidn','tb_reviewer.periode','tb_reviewer.jenis'])
                ->leftJoin('tb_peneliti', 'tb_reviewer.iddosen', 'tb_peneliti.id')
                ->leftJoin('adm_periode', 'tb_reviewer.periode', 'adm_periode.id')
              //  ->where('adm_periode.aktif','1')
                ->where('tb_reviewer.jenis','!=','2')
                //->orderBy('level','DESC')
            ;

            return DataTables::of($peneliti)

                ->addColumn('periode', function($peneliti) {
                    $tempid = $_GET['id'];
                    $periode = Periode::where('id', $peneliti->periode)->first();
                    return '<td class="text-left">' .$periode->tahun. ' sesi ' .$periode->sesi. '</td>';

                })
                ->addColumn('jenis', function ($peneliti) {
                    if ($peneliti->jenis == 1){
                        return ' <small class="label label-info">Penelitian</small>';
                    }elseif ($peneliti->jenis == 2){
                        return '<small class="label label-warning">Pengabdian</small>';
                    }
                    else{
                        return '<small class="label label-info">Penelitian</small>
                                <br>
                                <small class="label label-warning">Pengabdian</small>';

                    }
                })

                ->addColumn('action', function ($peneliti) {
                    $tempid = $_GET['id'];
                    $status = Posisi::select('id','jenis')
                        ->where('id','>=',50)
                        ->get();
                    $data = '';
                    // here we prepare the options
                    foreach ($status as $list) {
                        $rev = PlotingReviwer::select('iddosen','prosalid','jenis')->where('iddosen',$peneliti->id)->where('prosalid',$tempid)->where('jenis',$list->id)->first();
                        $countrev = PlotingReviwer::select('iddosen')
                            ->leftjoin('tb_proposal','tb_proposal.id','tb_ploting_reviewer.prosalid')
                            ->leftjoin('adm_periode','adm_periode.id','tb_proposal.periodeusul')
                            ->where('adm_periode.aktif','1')
                            ->where('tb_proposal.jenis','1')
                            ->where('tb_ploting_reviewer.jenis',$list->id)->where('iddosen',$peneliti->id)->get();
                        $total = count($countrev);
                        if ($rev->iddosen == null && $rev->jenis == null && $rev->prosalid == null){
                            $data .= '<button id="' . $list->id . '' . $peneliti->id . '" class="btn btn-xs btn-success tambahreviewerpenelitian" title="Tambah Reviewer"><i class="glyphicon glyphicon-plus"></i> ' . $list->jenis . ' : <span class="label label-danger">'.$total.'</span></button> <div style="line-height:15%;"><br></div>'                        ;

                        }elseif ($rev->iddosen != null && $rev->jenis != null  ){
                            $data .= '<button class="btn btn-xs btn-default " title="Tambah Reviewer" disabled><i class="glyphicon glyphicon-plus"></i> ' . $list->jenis . ' : <span class="label label-danger">'.$total.'</span></button> <div style="line-height:15%;"><br></div>'                        ;

                        }


                    }
                    return $data;

                })
                ->rawColumns(['jenis','periode','action'])
                ->make(true);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }
     public function reviewerpengabdian()
    {
        try
        {
            DB::statement(DB::raw('set @rownum=0'));
            $peneliti = Reviewer::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'tb_reviewer.iddosen as id', 'tb_peneliti.nama','tb_peneliti.nidn','tb_reviewer.periode','tb_reviewer.jenis'])
                ->leftJoin('tb_peneliti', 'tb_reviewer.iddosen', 'tb_peneliti.id')
                ->leftJoin('adm_periode', 'tb_reviewer.periode', 'adm_periode.id')
                ->where('adm_periode.aktif','1')
                ->where('tb_reviewer.jenis','!=','1')
                
                //->where('users.level', '!=','3')
                //->orderBy('level','DESC')
            ;


            return DataTables::of($peneliti)

                ->addColumn('periode', function($peneliti) {
                    $periode = Periode::where('id', $peneliti->periode)->first();
                    return '<td class="text-left">' .$periode->tahun. ' sesi ' .$periode->sesi. '</td>';

                })
                ->addColumn('jenis', function ($peneliti) {
                    if ($peneliti->jenis == 1){
                        return ' <small class="label label-info">Penelitian</small>';
                    }elseif ($peneliti->jenis == 2){
                        return '<small class="label label-warning">Pengabdian</small>';
                    }
                    else{
                        return '<small class="label label-info">Penelitian</small>
                                <br> <small class="label label-warning">Pengabdian</small>';

                    }
                })
                ->addColumn('action', function ($peneliti) {
                    $tempid = $_GET['id'];
                    $status = Posisi::select('id','jenis')
                        ->where('id','>=',50)
                        ->get();
                    $data = '';
                    // here we prepare the options
                    foreach ($status as $list) {
                        $rev = PlotingReviwer::select('iddosen','prosalid','jenis')->where('iddosen',$peneliti->id)->where('prosalid',$tempid)->where('jenis',$list->id)->first();
                        $countrev = PlotingReviwer::select('iddosen')
                            ->leftjoin('tb_proposal','tb_proposal.id','tb_ploting_reviewer.prosalid')
                            ->leftjoin('adm_periode','adm_periode.id','tb_proposal.periodeusul')
                            ->where('adm_periode.aktif','1')
                            ->where('tb_proposal.jenis','2')
                            ->where('tb_ploting_reviewer.jenis',$list->id)->where('iddosen',$peneliti->id)->get();
                        $total = count($countrev);
                        if ($rev->iddosen == null && $rev->jenis == null && $rev->prosalid == null){
                            $data .= '<button id="' . $list->id . '' . $peneliti->id . '" class="btn btn-xs btn-success tambahreviewerpengabdian" title="Tambah Reviewer"><i class="glyphicon glyphicon-plus"></i> ' . $list->jenis . '</button> <span class="label label-danger">'.$total.'</span><div style="line-height:15%;"><br></div>'                        ;

                        }elseif ($rev->iddosen != null && $rev->jenis != null  ){
                            $data .= '<button class="btn btn-xs btn-default " title="Tambah Reviewer" disabled><i class="glyphicon glyphicon-plus"></i> ' . $list->jenis . '</button><span class="label label-danger">'.$total.'</span><div style="line-height:15%;"><br></div>'                        ;

                        }


                    }
                    return $data;

                })
                ->rawColumns(['jenis','periode','action'])
                ->make(true);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }
    public function showpenelitian(Request $request)
    {
        if(request()->ajax())
        {

            if(!empty($request->filter_thn))
            {
                try
                {
                    DB::statement(DB::raw('set @rownum=0'));

                 
                    $proposal = Proposal::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'tb_proposal.id','tb_proposal.idskema','tb_proposal.idtkt','ketuaid','tb_peneliti.nidn','tb_peneliti.nama','judul','tb_penelitian.prosalid','tb_penelitian.dana','tb_penelitian.status','tb_proposal.jenis'])
                        ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
                        ->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
                        ->leftJoin('tb_ploting_reviewer', 'tb_proposal.id', 'tb_ploting_reviewer.prosalid')
                        // ->leftJoin('tb_plotingreviewer', 'tb_plotingreviewer.prosalid', 'tb_proposal.id')
                        ->where('tb_proposal.periodeusul', $request->filter_thn)
                    //->where('tb_penelitian.status', 4)
                        //->where('tb_proposal.jenis', 1)
                        ->where('tb_ploting_reviewer.jenis', 50)
                            ->whereIn('tb_penelitian.status',[4,6])
                            ->orderBy('tb_proposal.idskema', 'desc')
                        // ->orwhere('tb_penelitian.status', 6)
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
                                    //$data .= '<strong><td class="text-left">-'. $list->nama. '</td></strong><br>'
                                    $data .= '<small class="label label-primary">'. $list->nama. '</small><div style="line-height:15%;"><br></div>'
                                        ;
                                }
                                $return =
                                    '<td class="text-left">' .$proposal->judul . '</td><br>
                                        <td class="text-left">' .$data . '</td>
                                ';
                                return $return;
                        })
                        ->addColumn('reviewer', function($proposal) {
                            $ploting = PlotingReviwer::select('tb_ploting_reviewer.id','tb_ploting_reviewer.iddosen','nama','adm_status.jenis')
                                ->leftJoin('tb_peneliti','tb_peneliti.id','tb_ploting_reviewer.iddosen' )
                                ->leftJoin('adm_status','adm_status.id','tb_ploting_reviewer.jenis' )
                                ->where('tb_ploting_reviewer.prosalid',$proposal->prosalid)
                                ->orderBy('tb_ploting_reviewer.iddosen','ASC')
                                ->orderBy('tb_ploting_reviewer.jenis','ASC')
                                ->get();
                            $data = '';
                            $temp = '';
                            $rata = array();
                           
                            // here we prepare the options
                            foreach ($ploting as $list) {
                                $nilai = Nilai::select('nilai1','nilai2','nilai3','nilai4','nilai5','nilai6','nilai7','nilai8','nilai9','nilai10','nilai11')
                                ->where('prosalid',$proposal->id)
                                ->where('iddosen',$list->iddosen)->first();
                                $totalnilai = $nilai->nilai1 + $nilai->nilai2 + $nilai->nilai3 + $nilai->nilai4 + $nilai->nilai5 + $nilai->nilai6 + $nilai->nilai7 + $nilai->nilai8 + $nilai->nilai9 + $nilai->nilai10 + $nilai->nilai11  ;
                                
                                $rata[] = $totalnilai;
                                if ($temp != $list->nama){
                                    $data .= '<strong><td class="text-left">- '. $list->nama. '</td></strong><br><small class="label label-success">' . $totalnilai . '</small><br>
                                     <button id="' . $list->id . '" class="btn btn-xs  delete" ><i class="glyphicon glyphicon-trash"></i> </button><br>
                                    
                                    '
                                    ;
                                    $temp = $list->nama;
                                }else{
                                    $data .= '<small class="label label-success">' . $totalnilai . '</small><br>
                                     <button id="' . $list->id . '" class="btn btn-xs  delete" ><i class="glyphicon glyphicon-trash"></i> </button><br>
                                    '
                                    ;
                                }

                            }
                           
                           $rata_len = count($rata)-1;

                            sort($rata);
                            
                            $result = $rata[$rata_len];
                            for ($i = $rata_len-1; $i >= 0; $i--) {
                                $result -= $rata[$i];
                            } 
                            
                            if($result > 100 && count($rata) ==2 && $result != array_sum($rata)){
                                 $return =
                                '<td class="text-left">' .$data . '</td><br>
                                <td class="text-left">Selisih : <small class="label label-primary"> '  . $result . '</small></td><br>
                                <td class="text-left">Perlu di Tambah Reviewer</td>
                                  <br> <button id="' . $proposal->id . '" class="btn btn-xs editreviewerpenelitian btn-success" title="Tambah Reviewer"><i class="glyphicon glyphicon-plus"></i></button><div style="line-height:20%;"><br></div>
                                ';
                            }else{
                                 $return =
                                '<td class="text-left">' .$data . '</td><br>
                               <td class="text-left">Selisih : <small class="label label-primary"> '  . $result . '</small></td><br>
                               <td class="text-left">Rata-Rata : <small class="label label-primary"> '  . array_sum($rata)/count($rata) . '</small></td>
                                
                               
                               
                                ';
                            }
                           
                            if ($data == null){
                                return '<td class="text-left">Reviewer Belum Di tambahkan</td>';
                            }else{
                                return $return;
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
                        ->addColumn('jenis', function ($proposal) {
                            if ($proposal->jenis == 1){
                                return '<a class="btn-info btn-sm center-block ">Penelitian</a>';
                            }else{
                                return '<a class="btn-warning btn-sm center-block ">Pengabdian</a>';

                            }
                        })
                        ->addColumn('komentar', function ($proposal) {
                            $ploting = PlotingReviwer::select('tb_ploting_reviewer.id','tb_ploting_reviewer.iddosen','nama','adm_status.jenis')
                            ->leftJoin('tb_peneliti','tb_peneliti.id','tb_ploting_reviewer.iddosen' )
                            ->leftJoin('adm_status','adm_status.id','tb_ploting_reviewer.jenis' )
                            ->where('tb_ploting_reviewer.prosalid',$proposal->prosalid)
                            ->orderBy('tb_ploting_reviewer.iddosen','ASC')
                            ->orderBy('tb_ploting_reviewer.jenis','ASC')
                            ->get();
                        $data = '';
                        $temp = '';
                        $rata = array();
                        // here we prepare the options
                        foreach ($ploting as $list) {
                            $nilai = Nilai::select('id','komentar','kelayakan','rekomdana')
                            ->where('prosalid',$proposal->id)
                            ->where('iddosen',$list->iddosen)->first();
                            $totalnilai = $nilai->komentar ;
                            
                            $rata[] = $totalnilai;
                            if ($temp != $list->nama){
                                
                                if($nilai->kelayakan == '1'){
                                    $data .= '<strong><td class="text-left">- '. $list->nama. '</td></strong><br>' . $totalnilai . '<br>
                                     <span>Kelayakan : </span><small class="label label-success">Layak</small><br>
                                     <span>Rekomendasi Dana : </span><small class="label label-success">' . format_uang($nilai->rekomdana) . '</small><br>
                                     <a  href="'. route('hasilreviewer.resumenilai',base64_encode($nilai->id) ).'" class="btn btn-xs resumenilai btn-warning" title="Lihat Penilaian"><i class="glyphicon glyphicon-edit"></i> </a><br>
            
                                    '
                                    ;
                                    $temp = $list->nama;
                                }else if($nilai->kelayakan == '2') {
                                    $data .= '<strong><td class="text-left">- '. $list->nama. '</td></strong><br>' . $totalnilai . '<br>
                                     <span>Kelayakan : </span><small class="label label-danger">Tidak Layak</small><br><br>
                                       <a  href="'. route('hasilreviewer.resumenilai',base64_encode($nilai->id) ).'" class="btn btn-xs resumenilai btn-warning" title="Lihat Penilaian"><i class="glyphicon glyphicon-edit"></i> </a><br>
                                    
            
                                    '
                                    ;
                                    $temp = $list->nama;
                                    
                                }else{
                                    $data .= '<strong><td class="text-left">- '. $list->nama. '</td></strong><br>' . $totalnilai . '<br>
                                      <a  href="'. route('hasilreviewer.resumenilai',base64_encode($nilai->id) ).'" class="btn btn-xs resumenilai btn-warning" title="Lihat Penilaian"><i class="glyphicon glyphicon-edit"></i> </a><br>
                                    
                                    
            
                                    '
                                    ;
                                    $temp = $list->nama;
                                }
                                
                            }else{
                                $data .= '<small class="label label-success">' . $totalnilai . '</small><br>
                
                                
                                '
                                ;
                            }

                        }
                        $return =
                            '<td class="text-left">' .$data . '</td><br>
                            ';
                        if ($data == null){
                            return '<td class="text-left">Komentar Belum Di tambahkan</td>';
                        }else{
                            return $return;
                        }
                            
                        
                    })
                        ->addColumn('dana', function ($proposal) {
                                
                            if ($proposal->dana != null){
                                return '<small class="label label-success">Rp. '.format_uang($proposal->dana).'</small>';
                            }
                            else{

                                return '<small class="label label-danger">Dana Belum Ditambahkan</small>';

                            }
                        })
                        ->addColumn('status', function ($proposal) {
                            $admstatus = Posisi::select('jenis')
                                ->where('id',$proposal->status)
                                ->first();
                            if ($proposal->status == 6 or $proposal->status == 4){
                                return '<small class="label label-success">'.$admstatus->jenis.'</small>';
                            }
                            else{

                                return '<small class="label label-danger">'.$admstatus->jenis.'</small>';

                            }
                        })
                        ->addColumn('action', function ($proposal) {
                            $admstatus = Posisi::select('jenis')
                            ->where('id',$proposal->status)
                            ->first();
                                if ($proposal->status != 4){
                                    return '<a  href="'. route('usulan.resume',base64_encode(mt_rand(10,99).$proposal->prosalid) ).'" class="btn btn-xs resume btn-warning" title="Detail"><i class="glyphicon glyphicon-file"></i> </a><br>
                                    <button id="'.$proposal->id . '" class="btn btn-xs setuju" title="Setuju"><i class="glyphicon glyphicon-ok"></i> </button>
                                  
                              
                                    ';
                                }
                                elseif($proposal->status == 4){
                                    return '<a  href="'. route('usulan.resume',base64_encode(mt_rand(10,99).$proposal->prosalid) ).'" class="btn btn-xs resume btn-warning" title="Detail"><i class="glyphicon glyphicon-file"></i> </a>
                                <button id="'.$proposal->id . '" class="btn btn-xs edit" title="Tambahkan Dana"><i class="glyphicon glyphicon-plus"></i> </button>
                                ';

                                }
                                
                                
                            

                        })
                        ->rawColumns(['judul','skema','jenis','dana','komentar','status','reviewer', 'action'])
                        ->make(true);
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }
            }
        }
    }
     public function showpengabdian(Request $request)
    {
        if(request()->ajax())
        {

            if(!empty($request->filter_thn))
            {
                try
                {
                    DB::statement(DB::raw('set @rownum=0'));

                    $periodeterbaru  = Periode::orderBy('tahun', 'desc')->orderBy('sesi', 'desc')->where('jenis',2)->where('aktif','1')->first();
                    $proposal = Proposal::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'tb_proposal.id','tb_proposal.idskema','tb_proposal.idtkt','ketuaid','tb_peneliti.nidn','tb_peneliti.nama','judul','tb_penelitian.prosalid','tb_penelitian.status','tb_penelitian.dana','tb_proposal.jenis'])
                        ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
                        ->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
                        // ->leftJoin('tb_plotingreviewer', 'tb_plotingreviewer.prosalid', 'tb_proposal.id')
                        ->where('tb_proposal.periodeusul', $periodeterbaru->id)
                    //->where('tb_penelitian.status', 4)
                        ->where('tb_proposal.jenis', 2)
                        ->whereIn('tb_penelitian.status',[4,6])
                            ->orderBy('tb_proposal.idskema', 'desc')
                        // ->orwhere('tb_penelitian.status', 6)
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
                                    //$data .= '<strong><td class="text-left">-'. $list->nama. '</td></strong><br>'
                                    $data .= '<small class="label label-primary">'. $list->nama. '</small><div style="line-height:15%;"><br></div>'
                                        ;
                                }
                                $return =
                                    '<td class="text-left">' .$proposal->judul . '</td><br>
                                        <td class="text-left">' .$data . '</td>
                                ';
                                return $return;
                        })
                        ->addColumn('reviewer', function($proposal) {
                            $ploting = PlotingReviwer::select('tb_ploting_reviewer.id','tb_ploting_reviewer.iddosen','nama','adm_status.jenis')
                                ->leftJoin('tb_peneliti','tb_peneliti.id','tb_ploting_reviewer.iddosen' )
                                ->leftJoin('adm_status','adm_status.id','tb_ploting_reviewer.jenis' )
                                ->where('tb_ploting_reviewer.prosalid',$proposal->prosalid)
                                ->orderBy('tb_ploting_reviewer.iddosen','ASC')
                                ->orderBy('tb_ploting_reviewer.jenis','ASC')
                                ->get();
                            $data = '';
                            $temp = '';
                            $rata = array();
                            // here we prepare the options
                            foreach ($ploting as $list) {
                                $nilai = Nilai::select('nilai1','nilai2','nilai3','nilai4','nilai5','nilai6','nilai7','nilai8','nilai9','nilai10','nilai11')
                                ->where('prosalid',$proposal->id)
                                ->where('iddosen',$list->iddosen)->first();
                                $totalnilai = $nilai->nilai1 + $nilai->nilai2 + $nilai->nilai3 + $nilai->nilai4 + $nilai->nilai5 + $nilai->nilai6 + $nilai->nilai7 + $nilai->nilai8 + $nilai->nilai9 + $nilai->nilai10 + $nilai->nilai11  ;
                                
                                $rata[] = $totalnilai;
                                if ($temp != $list->nama){
                                    $data .= '<strong><td class="text-left">- '. $list->nama. '</td></strong><br><small class="label label-success">' . $totalnilai . '</small>
                                    
                                    '
                                    ;
                                    $temp = $list->nama;
                                }else{
                                    $data .= '<small class="label label-success">' . $totalnilai . '</small>
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
                        
                        
                        ->addColumn('skema', function ($proposal) {
                            $skema = DB::table('adm_skema')
                                ->select('id','skema')
                                ->groupBy('skema')
                                ->where('id', $proposal->idskema)
                                ->first();
                        
                                return $skema->skema;
                        
                        })
                        ->addColumn('jenis', function ($proposal) {
                            if ($proposal->jenis == 1){
                                return '<a class="btn-info btn-sm center-block ">Penelitian</a>';
                            }else{
                                return '<a class="btn-warning btn-sm center-block ">Pengabdian</a>';

                            }
                        })
                        ->addColumn('komentar', function ($proposal) {
                            $ploting = PlotingReviwer::select('tb_ploting_reviewer.id','tb_ploting_reviewer.iddosen','nama','adm_status.jenis')
                            ->leftJoin('tb_peneliti','tb_peneliti.id','tb_ploting_reviewer.iddosen' )
                            ->leftJoin('adm_status','adm_status.id','tb_ploting_reviewer.jenis' )
                            ->where('tb_ploting_reviewer.prosalid',$proposal->prosalid)
                            ->orderBy('tb_ploting_reviewer.iddosen','ASC')
                            ->orderBy('tb_ploting_reviewer.jenis','ASC')
                            ->get();
                        $data = '';
                        $temp = '';
                        $rata = array();
                        // here we prepare the options
                        foreach ($ploting as $list) {
                            $nilai = Nilai::select('komentar')
                            ->where('prosalid',$proposal->id)
                            ->where('iddosen',$list->iddosen)->first();
                            $totalnilai = $nilai->komentar ;
                            
                            $rata[] = $totalnilai;
                            if ($temp != $list->nama){
                                $data .= '<strong><td class="text-left">- '. $list->nama. '</td></strong><br>' . $totalnilai . '<br>
                                
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
                            ';
                        if ($data == null){
                            return '<td class="text-left">Komentar Belum Di tambahkan</td>';
                        }else{
                            return $return;
                        }
                            
                        
                            
                        
                    })
                        ->addColumn('dana', function ($proposal) {
                                
                            if ($proposal->dana != null){
                                return '<small class="label label-success">Rp. '.format_uang($proposal->dana).'</small>';
                            }
                            else{

                                return '<small class="label label-danger">Dana Belum Ditambahkan</small>';

                            }
                        })
                        ->addColumn('status', function ($proposal) {
                            $admstatus = Posisi::select('jenis')
                                ->where('id',$proposal->status)
                                ->first();
                            if ($proposal->status == 6 or $proposal->status == 4){
                                return '<small class="label label-success">'.$admstatus->jenis.'</small>';
                            }
                            else{

                                return '<small class="label label-danger">'.$admstatus->jenis.'</small>';

                            }
                        })
                        ->addColumn('action', function ($proposal) {
                            return '<a  href="'. route('usulan.resume',base64_encode(mt_rand(10,99).$proposal->prosalid) ).'" class="btn btn-xs edit btn-warning" title="Detail"><i class="glyphicon glyphicon-file"></i> </a>';

                        })
                        ->rawColumns(['judul','skema','jenis','dana','komentar','status','reviewer', 'action'])
                        ->make(true);
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }
            }
        }
    }
   
   
   public function resumenilai($id)
    {
        $person = HasilReviewerController::countPersonil();
        $idn = base64_decode($id);
      
        $nilai =  Nilai ::  where('id',$idn)->first();

        $idprop = $nilai->prosalid;
        $prop = Proposal::find($idprop);

        $idprop = $nilai->prosalid;
        $prop = Proposal::find($idprop);
        //$prop  = Proposal::where('id', $idprop)->Where('iddosen', Auth::user()->id)->orWhere('iddosen', 0)->first();
        $periode  = Periode::where('id',$prop->periodeusul)->first();
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
            return view('admin.penilaian.seleksi.penelitian.resumeunggulan', compact('person','periode','nilai','idprop','prop','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata','stat'));
        }elseif($prop->idskema==2){
            return view('admin.penilaian.seleksi.penelitian.resumeinovasi', compact('person','periode','nilai','idprop','prop','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata','stat'));
        }elseif($prop->idskema==3){
            return view('admin.penilaian.seleksi.penelitian.resumebidangilmu', compact('person','periode','nilai','idprop','prop','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata','stat'));
        }elseif($prop->idskema==4){
            return view('admin.penilaian.seleksi.penelitian.resumeguru', compact('person','periode','nilai','idprop','prop','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata','stat'));
        }elseif($prop->idskema==7){
            return view('admin.penilaian.seleksi.penelitian.resumedosenmuda', compact('person','periode','nilai','idprop','prop','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata'));
        }elseif($prop->idskema==9){
            return view('admin.penilaian.seleksi.penelitian.resumekolaborasi', compact('person','periode','nilai','idprop','prop','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata'));
        }else if($prop->idskema == 6 ){
            return view('admin.penilaian.seleksi.pengabdian.resumedesa', compact('person','periode','nilai','idprop','prop','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata','stat'));
        }elseif($prop->idskema==5){
           return view('admin.penilaian.seleksi.pengabdian.resumemasyarakat', compact('person','periode','nilai','idprop','prop','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata','stat'));
        }elseif($prop->idskema == 22 ){
            return view('admin.penilaian.seleksi.pengabdian.resumekemitraan', compact('person','periode','nilai','idprop','prop','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata','stat'));
        }elseif($prop->idskema == 23 ){
            return view('admin.penilaian.seleksi.pengabdian.resumekewirausahaan', compact('person','periode','nilai','idprop','prop','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata','stat'));
        }

    }
    public function getnilai($id)
    {
        $nilai = Nilai::where('id', $id)->first();

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
             $output[] = $nilai->kelayakan; //24
            
        
            return json_encode($output);
        }
        else
            return json_encode(0);
    }
   
    public function resumeberkas($id)
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
            if ( $file_path ) {
                // Show pdf
                return response()->file( $file_path, $headers );
            } else {
                // Error
                $message = 'Dokumen Tidak Ditemukan..';
                return Redirect::back()->withInput()->withErrors(array('kesalahan' => $message));
            }
        }
    }

    public function resume($id)
    {
        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 2, strlen($temp));


        $penelitian = RancanganPenelitian::where('prosalid', $idprop)->first();
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
     *
     */
    public function edit($id)
    {
        $proposal = Proposal::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'tb_proposal.id','nama','tb_peneliti.nidn','tb_peneliti.nama','judul','tb_penelitian.prosalid','tb_proposal.jenis'])
            ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
            ->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
            ->where('tb_proposal.id', $id)
            ->first();
        try
        {
            return response()->json(['success' => 'successfull retrieve data2', 'data' => $proposal->toJson()], 200);
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
    public function update(Request $request, $id)
    {
        try
        {
            $ploting = new PlotingReviwer();
            $ploting->iddosen = $request->id_dosen;
            $ploting->prosalid = $request->prosalid;
            $ploting->save();

            return response()->json(['success' ,'reviewer berhasil ditambahkan'], 200);

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
    public function destroy(Request $request)
    {
        try
        {
            $ploting = new PlotingReviwer();
            $temp = $request->id;
            $stat = (Integer)substr($temp, 0, 2);
            $iddosen = (Integer)substr($temp, 2, strlen($temp));

            $ploting->iddosen = $iddosen;
            $ploting->jenis = $stat;
            $ploting->prosalid = $request->prosalid;
            $ploting->save();

            return response()->json(['success' => 'data is successfully added'], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    public function destroyreviewer($id)
    {
        try
        {
            PlotingReviwer::destroy($id);

            return response()->json(['success' => $id], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    public function desdtroy(PlotingReviwer $plotingReviwer)
    {
        try
        {
            PlotingReviwer::destroy($plotingReviwer->id);

            return response()->json(['success' => 'data is successfully deleted'], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    public function destdroy($id)
    {
        DB::table("tb_reviewer")->delete($id);
        return response()->json(['success'=>"Product Deleted successfully.", 'tr'=>'tr_'.$id]);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        DB::table("tb_reviewer")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>"Products Deleted successfully."]);
    }

}
