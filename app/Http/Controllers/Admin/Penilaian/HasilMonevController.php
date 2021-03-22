<?php

namespace App\Http\Controllers\Admin\Penilaian;

use App\Anggaran;
use App\Luaran;
use App\Nilai;
use App\NilaiLaporanKemajuan;
use App\Nilai2LaporanKemajuan;
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

class HasilMonevController extends Controller
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
        $person = HasilMonevController::countPersonil();

        $peneliti = Peneliti::select('id','hindex','sinta','status','tanggungan')->find(Auth::user()->id);
        $periode  = Periode::where('aktif','1')->orderBy('tahun', 'desc')->orderBy('sesi', 'desc')
            ->get();
        $aperiode  = Periode::where('aktif','0')->orderBy('tahun', 'desc')->orderBy('sesi', 'desc')
            ->get();
        $proposal = Proposal::select('judul','idprogram','idskema','periodeusul','idfokus','aktif','thnkerja','status','prosalid')
            ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
            //->where('tb_proposal.periodeusul',$periode[0]->id)
            ->where('tb_penelitian.ketuaid', $peneliti->id)
            ->where('tb_penelitian.status', '>', 0)
            ->where('tb_proposal.jenis', 1)
            ->get();

        $peserta = Proposal::select('judul','idprogram','idskema','periodeusul','idfokus','thnkerja','status','prosalid','peran','setuju')
            ->leftJoin('tb_keanggota', 'tb_proposal.id', 'tb_keanggota.idpenelitian')
            ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
            //->where('tb_proposal.periodeusul',$periode[0]->id)
            ->where('tb_keanggota.anggotaid', $peneliti->id)
            ->where('tb_penelitian.status', '>', 0)
            ->where('tb_keanggota.setuju', '<', 2)
            ->where('tb_proposal.jenis', 1)
            ->where('tb_proposal.aktif', '1')
            ->orderBy('tb_keanggota.peran', 'asc')
            ->get();

        $minat =  Proposal::leftJoin('tb_keanggota', 'tb_proposal.id', 'tb_keanggota.idpenelitian')
            ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
            //  ->where('tb_proposal.periodeusul',$periode[0]->id)
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



        return view('admin.penilaian.hasilmonev.index', compact('skema','person', 'peneliti','reviewerpenelitian','reviewerpengabdian', 'periode','aperiode', 'proposal', 'total','ketua','peserta','member', 'status', 'minat'));
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


    public function show(Request $request)
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
                        ->where('tb_proposal.periodeusul', $request->filter_thn)
                        ->where('tb_penelitian.status', 4)
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
                                    $data .= '<strong><td class="text-left">- '. $list->nama. '</td></strong><br><small class="label label-success">' . $totalnilai . '</small><br>
                            <a  href="'. route('hasilmonev.resumenilai',base64_encode(mt_rand(10,99).$nilai->id) ).'" class="btn btn-xs edit btn-warning" title="Penilaian Monev"><i class="glyphicon glyphicon-edit"></i> </a>
                            <a  href="'. route('hasilmonev.resumenilai2',base64_encode(mt_rand(10,99).$nilai2->id) ).'" class="btn btn-xs edit btn-primary" title="Tanggapan Reviewer"><i class="glyphicon glyphicon-edit"></i> </a><br>
                          
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
                                ->where('tb_ploting_reviewer.jenis', 52)
                                ->orderBy('tb_ploting_reviewer.iddosen','ASC')
                                ->orderBy('tb_ploting_reviewer.jenis','ASC')
                                ->get();
                            $data = '';
                            $temp = '';
                            $rata = array();
                            // here we prepare the options
                            foreach ($ploting as $list) {
                                $nilai = NilaiLaporanKemajuan::select('komentar')
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
                            return '<a  href="'. route('usulan.resume',base64_encode(mt_rand(10,99).$proposal->prosalid) ).'" class="btn btn-xs edit btn-warning" title="Detail"><i class="glyphicon glyphicon-file"></i> </a>
                   ';


                        })
                        ->rawColumns(['judul','skema','jenis','dana','komentar','status','reviewer', 'action'])
                        ->make(true);
                }  catch (\Exception $e) {
                    dd($e->getMessage());
                }

            }
        }



    }

    public function resumenilai($id)
    {
        $person = HasilMonevController::countPersonil();
        $idn = base64_decode($id);
       //  = (Integer)substr($temp, 2, strlen($temp));


        $nilai =  NilaiLaporanKemajuan ::  where('id',$idn)->first();

        $idprop = $nilai->prosalid;
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
            return view('admin.penilaian.hasilmonev.resumeunggulan', compact('person','idprop','prop','nilai','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata'));
        }elseif($prop->idskema==2){
            return view('admin.penilaian.hasilmonev.resumeinovasi', compact('person','idprop','prop','nilai','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata'));
        }elseif($prop->idskema==3){
            return view('admin.penilaian.hasilmonev.resumebidangilmu', compact('person','idprop','prop','nilai','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata'));
        }elseif($prop->idskema==4){
            return view('admin.penilaian.hasilmonev.resumeguru', compact('person','idprop','prop','nilai','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata'));
        }elseif($prop->idskema == 6 ){
            return view('admin.penilaian.hasilmonev.resumedesa', compact('person','idprop','prop','nilai','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata'));
        }elseif($prop->idskema==5){
            return view('admin.penilaian.hasilmonev.resumemasyarakat', compact('person','idprop','nilai','prop','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata'));
        }elseif($prop->idskema==7){
            return view('admin.penilaian.hasilmonev.resumedosenmuda', compact('person','idprop','nilai','prop','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata'));
        }

    }
    public function resumenilai2($id)
    {
        $person = HasilMonevController::countPersonil();
        $temp = base64_decode($id);
        $idn = (Integer)substr($temp, 2, strlen($temp));

        $nilai =  Nilai2LaporanKemajuan ::  where('id',$idn)->first();

        $idprop = $nilai->prosalid;
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
            return view('admin.penilaian.hasilmonev.resumepenelitian', compact('person','idprop','prop','nilai','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata'));
        }elseif($prop->jenis==2){
            return view('admin.penilaian.hasilmonev.resumepengabdian', compact('person','idprop','prop','nilai','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata'));
        }

    }
    public function getnilai($id)
    {
        $nilai = NilaiLaporanKemajuan::where('id', $id)->first();

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
    public function getnilai2($id)
    {
        $nilai = Nilai2LaporanKemajuan::where('id', $id)->first();

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
