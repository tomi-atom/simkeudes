<?php

namespace App\Http\Controllers\Admin\Penilaian;

use App\Anggaran;
use App\Luaran;
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

class PlotingReviewerController extends Controller
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
        $person = PlotingReviewerController::countPersonil();

        $peneliti = Peneliti::select('id','hindex','sinta','status','tanggungan')->find(Auth::user()->id);
      
        $periodeterbaru1  = Periode::orderBy('tahun', 'desc')->orderBy('sesi', 'desc')->where('jenis',1)->where('aktif','1')->first();
        $periodeterbaru2  = Periode::orderBy('tahun', 'desc')->orderBy('sesi', 'desc')->where('jenis',2)->where('aktif','1')->first();
        $periode  = Periode::orderBy('tahun', 'desc')->orderBy('sesi', 'desc')
           // ->where('id','!=',$periodeterbaru->id)
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



        return view('admin.penilaian.plotingreviewer.index', compact('skema','person', 'peneliti','reviewerpenelitian','reviewerpengabdian', 'periode','periodeterbaru1','periodeterbaru2', 'proposal', 'total','ketua','peserta','member', 'status', 'minat'));
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
        try
        {
            DB::statement(DB::raw('set @rownum=0'));
            $periodeterbaru  = Periode::orderBy('tahun', 'desc')->orderBy('sesi', 'desc')->where('jenis',1)->where('aktif','1')->first();
    
   //         $periodeterbaru  = Periode::orderBy('tahun', 'desc')->orderBy('sesi', 'desc')->first();
            $proposal = Proposal::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'tb_proposal.id','tb_proposal.idskema','ketuaid','tb_peneliti.nidn','tb_peneliti.nama','judul','tb_penelitian.prosalid','tb_proposal.jenis','tb_penelitian.status'])
                ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
                ->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
                // ->leftJoin('tb_plotingreviewer', 'tb_plotingreviewer.prosalid', 'tb_proposal.id')
                  ->where('tb_proposal.periodeusul',  $request->filter_thn)
            //->where('tb_penelitian.status', 4)
                 ->where('tb_penelitian.status','!=',4 )
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
                    $ploting = PlotingReviwer::select('tb_ploting_reviewer.id','nama','adm_status.jenis')
                        ->leftJoin('tb_peneliti','tb_peneliti.id','tb_ploting_reviewer.iddosen' )
                        ->leftJoin('adm_status','adm_status.id','tb_ploting_reviewer.jenis' )
                        ->where('tb_ploting_reviewer.prosalid',$proposal->prosalid)
                        ->orderBy('tb_ploting_reviewer.iddosen','ASC')
                        ->orderBy('tb_ploting_reviewer.jenis','ASC')
                        ->get();
                    $data = '';
                    $temp = '';
                    // here we prepare the options
                    foreach ($ploting as $list) {
                        if ($temp != $list->nama){
                            $data .= '<strong><td class="text-left">- '. $list->nama. '</td></strong><br><small class="label label-success">' . $list->jenis . '</small>
                                    <button id="' . $list->id . '" class="btn btn-xs  delete" ><i class="glyphicon glyphicon-trash"></i> </button><br>'
                            ;
                            $temp = $list->nama;
                        }else{
                            $data .= '<small class="label label-success">' . $list->jenis . '</small>
                                    <button id="' . $list->id . '" class="btn btn-xs  delete" ><i class="glyphicon glyphicon-trash"></i> </button><br>'
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
                ->addColumn('status', function ($proposal) {
                    $admstatus = Posisi::select('jenis')
                                ->where('id',$proposal->status)
                                ->first();
                            if ($proposal->status == 6){
                                return '<small class="label label-success">'.$admstatus->jenis.'</small>';
                            }
                            else{

                                return '<small class="label label-danger">'.$admstatus->jenis.'</small>';

                            }
                })
                ->addColumn('action', function ($proposal) {
                    return '    <button id="' . $proposal->id . '" class="btn btn-xs editreviewerpenelitian btn-success" title="Tambah Reviewer"><i class="glyphicon glyphicon-plus"></i></button><div style="line-height:20%;"><br></div>
                                <a  href="'. route('usulan.resume',base64_encode(mt_rand(10,99).$proposal->prosalid) ).'" class="btn btn-xs edit btn-warning" title="Detail"><i class="glyphicon glyphicon-file"></i> </a>';

                })
                ->rawColumns(['judul','skema','jenis','status','reviewer', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    public function showpengabdian(Request $request)
    {
        try
        {
            DB::statement(DB::raw('set @rownum=0'));

            $periodeterbaru  = Periode::orderBy('tahun', 'desc')->orderBy('sesi', 'desc')->where('jenis',2)->where('aktif','1')->first();

            $proposal = Proposal::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'tb_proposal.id','tb_proposal.idskema','ketuaid','tb_peneliti.nidn','tb_peneliti.nama','judul','tb_penelitian.prosalid','tb_proposal.jenis','tb_penelitian.status'])
                ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
                ->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
               // ->leftJoin('tb_plotingreviewer', 'tb_plotingreviewer.prosalid', 'tb_proposal.id')
                  ->where('tb_proposal.periodeusul',  $request->filter_thn)
                 ->where('tb_penelitian.status', 4)
                 ->orderBy('tb_proposal.idskema', 'desc')
                 //->orwhere('tb_penelitian.status', 6)
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
                    $ploting = PlotingReviwer::select('tb_ploting_reviewer.id','nama','adm_status.jenis')
                        ->leftJoin('tb_peneliti','tb_peneliti.id','tb_ploting_reviewer.iddosen' )
                        ->leftJoin('adm_status','adm_status.id','tb_ploting_reviewer.jenis' )
                        ->where('tb_ploting_reviewer.prosalid',$proposal->prosalid)
                        ->orderBy('tb_ploting_reviewer.iddosen','ASC')
                        ->orderBy('tb_ploting_reviewer.jenis','ASC')
                        ->get();
                    $data = '';
                    $temp = '';
                    // here we prepare the options
                    foreach ($ploting as $list) {
                        if ($temp != $list->nama){
                            $data .= '<strong><td class="text-left">- '. $list->nama. '</td></strong><br><small class="label label-success">' . $list->jenis . '</small>
                                    <button id="' . $list->id . '" class="btn btn-xs  delete2" ><i class="glyphicon glyphicon-trash"></i> </button><br>'
                            ;
                            $temp = $list->nama;
                        }else{
                            $data .= '<small class="label label-success">' . $list->jenis . '</small>
                                    <button id="' . $list->id . '" class="btn btn-xs  delete2" ><i class="glyphicon glyphicon-trash"></i> </button><br>'
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
                ->addColumn('status', function ($proposal) {
                    $admstatus = Posisi::select('jenis')
                                ->where('id',$proposal->status)
                                ->first();
                            if ($proposal->status == 4){
                                return '<small class="label label-success">'.$admstatus->jenis.'</small>';
                            }
                            else{

                                return '<small class="label label-danger">'.$admstatus->jenis.'</small>';

                            }
                })
                ->addColumn('action', function ($proposal) {
                    return '    <button id="' . $proposal->id . '" class="btn btn-xs editreviewerpengabdian btn-success" title="Tambah Reviewer"><i class="glyphicon glyphicon-plus"></i></button><div style="line-height:20%;"><br></div>
                                <a  href="'. route('usulan.resume',base64_encode(mt_rand(10,99).$proposal->prosalid) ).'" class="btn btn-xs edit btn-warning" title="Detail"><i class="glyphicon glyphicon-file"></i> </a>';

                })
                ->rawColumns(['judul','skema','jenis','status','reviewer', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            dd($e->getMessage());
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
    public function show2(Request $request)
    {
        if(request()->ajax())
        {

            if(!empty($request->filter_thn) && !empty($request->filter_jenis) && !empty($request->filter_skema))
            {

                try
                {
                    DB::statement(DB::raw('set @rownum=0'));


                    $proposal = Proposal::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'tb_proposal.id','nama','tb_peneliti.nidn','tb_peneliti.nama','judul','tb_penelitian.prosalid','tb_proposal.jenis'])
                        ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
                        ->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
                        ->where('tb_proposal.periodeusul', $request->filter_thn)
                        ->where('tb_proposal.jenis', $request->filter_jenis)
                        ->where('tb_proposal.idskema', $request->filter_skema)
                    ;


                    return DataTables::of($proposal)

                        ->addColumn('judul', function($proposal) {
                            $anggota = Keanggotaan::select('nama','peran','setuju')
                                ->leftJoin('tb_peneliti','tb_keanggota.anggotaid', 'tb_peneliti.id')
                                ->where('idpenelitian',$proposal->prosalid)
                                ->get();
                            $data = '';
                            foreach ($anggota as $list) {
                                $data = $list->nama;
                            }
                            return '<td class="text-left">' .$proposal->judul . '</td><br>
                                    <strong><td class="text-left">' .$data . '</td></strong>';

                        })
                        ->addColumn('jenis', function ($proposal) {
                            if ($proposal->jenis == 1){
                                return '<a class="btn-info btn-sm center-block ">Penelitian</a>';
                            }else{
                                return '<a class="btn-warning btn-sm center-block ">Pengabdian</a>';

                            }
                        })
                        ->addColumn('anggota', function ($proposal) {
                            $anggota = Keanggotaan::select('nama','peran','setuju')
                                ->leftJoin('tb_peneliti','tb_keanggota.anggotaid', 'tb_peneliti.id')
                                ->where('idpenelitian',$proposal->prosalid)
                                ->get();
                            $data = '';
                            foreach ($anggota as $list) {
                                $data = $list->nama;
                            }
                            return '<td class="text-left">' .$data . '</td><br>';

                        })
                        ->addColumn('status', function ($proposal) {
                            if ($proposal->status == 6){
                                return '<a class="btn-success btn-sm center-block">'.$proposal->jenisstatus.'</a>';
                            }
                            else{
                                return '<a class="btn-danger btn-sm center-block">Belum di Verifikasi</a>';

                            }
                        })
                        ->addColumn('upload', function ($proposal) {
                            if ($proposal->upload == null){
                                return '<a class="btn-danger btn-sm center-block">Belum</a>';

                            }else{
                                return '<a class="btn-success btn-sm center-block">Sudah</a>';
                            }
                        })
                        ->addColumn('action', function ($proposal) {
                            return '<a  href="'. route('p_rancangan.resumeberkas',base64_encode(mt_rand(10,99).$proposal->prosalid) ).'" class="btn btn-xs edit" title="Detail"><i class="glyphicon glyphicon-file"></i> </a>                       
                                <button id="'.$proposal->id . '" class="btn btn-xs verifikasi" title="Verivikasi"><i class="glyphicon glyphicon-check"></i> </button>';
                        })
                        ->rawColumns(['judul','anggota','jenis','status','upload', 'action'])
                        ->make(true);
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }

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
