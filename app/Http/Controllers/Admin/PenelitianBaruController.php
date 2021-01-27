<?php

namespace App\Http\Controllers\Admin;

use App\Anggaran;
use App\Http\Controllers\Penelitian\PenelitianngController;
use App\Luaran;
use App\Mataanggaran;
use App\Peneliti;
use App\Periode;
use App\Posisi;
use App\Substansi;
use Barryvdh\DomPDF\Facade as PDF;
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

class PenelitianBaruController extends Controller
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
        $person = PenelitianBaruController::countPersonil();

        $peneliti = Peneliti::select('id','hindex','sinta','status','tanggungan')->find(Auth::user()->id);
        $periodeterbaru  = Periode::orderBy('tahun', 'desc')->orderBy('sesi', 'desc')->where('jenis',1)->where('aktif','1')->first();
        $periode  = Periode::where('aktif', '1')->orderBy('tahun', 'desc')->orderBy('sesi', 'desc')->get();

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
            ->where('idprogram','1')
            ->orderBy('id', 'ASC')
            ->get();



        return view('admin.usulan.penelitianbaru.index', compact('skema','person', 'peneliti', 'periode','periodeterbaru', 'proposal', 'total','ketua','peserta','member', 'status', 'minat'));

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
            Penelitian::create($request->all());

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
        $periodeterbaru  = Periode::orderBy('tahun', 'desc')->orderBy('sesi', 'desc')->where('jenis',1)->where('aktif','1')->first();

        if(request()->ajax())
        {

            if(!empty($request->filter_skema))
            {
                try
                {
                    DB::statement(DB::raw('set @rownum=0'));


                    $proposal = Proposal::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'tb_proposal.id','ketuaid','users.email','users.name','judul','tb_proposal.jenis','tb_penelitian.status','tb_penelitian.dana'])
                        ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
                        ->leftJoin('users', 'tb_penelitian.ketuaid', 'users.id')
                        ->where('tb_proposal.periodeusul', $periodeterbaru->id)
                       // ->where('tb_proposal.jenis', $request->filter_jenis)
                        ->where('tb_proposal.idskema', $request->filter_skema)
                        //->where('tb_penelitian.status', 4)
                         ->where('tb_proposal.jenis', 1)
                    ;


                    return DataTables::of($proposal)

                        ->addColumn('judul', function($proposal) {
                            $anggota = Keanggotaan::select('nama')
                                ->leftJoin('tb_peneliti','tb_keanggota.anggotaid', 'tb_peneliti.id')
                                ->where('idpenelitian',$proposal->id)
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
                        ->addColumn('dana', function ($proposal) {
                            $subtot = Anggaran::select('volume', 'biaya')->where('proposalid', $proposal->id)->get();
                            $grand  = 0;
                            foreach ($subtot as $list) {
                                $grand += $list->volume * $list->biaya;
                            }

                            return '<small class="label label-success">Rp. '.format_uang($grand).'</small>';

                        })

                        ->addColumn('action', function ($proposal) {
                            $subtansi = Substansi::where('proposalid', $proposal->id)->first();
                            if ($subtansi){
                                if ($proposal->status > 4 && $proposal->status != 6 ){
                                    return '<a  href="'. route('penelitianbaru.resume',base64_encode(mt_rand(10,99).$proposal->id) ).'" class="btn btn-xs " title="Detail"><i class="glyphicon glyphicon-file"></i> </a>                       
                                <a  href="'. route('usulan.unduh',base64_encode(mt_rand(10,99).$proposal->id) ).'" class="btn btn-xs " title="Unduh"><i class="glyphicon glyphicon-download"></i> </a>    
                                <a  href="'. route('usulan.resumeberkas',base64_encode(mt_rand(10,99).$proposal->id) ).'" class="btn btn-xs " title="Unduh Proposal"><i class="glyphicon glyphicon-download-alt"></i> </a>
                                <button id="'.$proposal->id . '" class="btn btn-xs verifikasi" title="Verifikasi"><i class="glyphicon glyphicon-check"></i> </button>';

                                }elseif ($proposal->status == 6 ){
                                    return '<a  href="'. route('penelitianbaru.resume',base64_encode(mt_rand(10,99).$proposal->id) ).'" class="btn btn-xs " title="Detail"><i class="glyphicon glyphicon-file"></i> </a>                       
                                <a  href="'. route('usulan.unduh',base64_encode(mt_rand(10,99).$proposal->id) ).'" class="btn btn-xs " title="Unduh"><i class="glyphicon glyphicon-download"></i> </a>                      
                                <a  href="'. route('usulan.resumeberkas',base64_encode(mt_rand(10,99).$proposal->id) ).'" class="btn btn-xs " title="Unduh Proposal"><i class="glyphicon glyphicon-download-alt"></i> </a>
                                <button id="'.$proposal->id . '" class="btn btn-xs setuju" title="Setuju"><i class="glyphicon glyphicon-ok"></i> </button>
                                ';

                                }elseif ($proposal->status == 4 ){
                                    return '<a  href="'. route('penelitianbaru.resume',base64_encode(mt_rand(10,99).$proposal->id) ).'" class="btn btn-xs " title="Detail"><i class="glyphicon glyphicon-file"></i> </a>                       
                                <a  href="'. route('usulan.unduh',base64_encode(mt_rand(10,99).$proposal->id) ).'" class="btn btn-xs " title="Unduh"><i class="glyphicon glyphicon-download"></i> </a>                       
                                <a  href="'. route('usulan.resumeberkas',base64_encode(mt_rand(10,99).$proposal->id) ).'" class="btn btn-xs " title="Unduh Proposal"><i class="glyphicon glyphicon-download-alt"></i> </a>
                                ';

                                }else{
                                    return '<a  href="'. route('penelitianbaru.resume',base64_encode(mt_rand(10,99).$proposal->id) ).'" class="btn btn-xs " title="Detail"><i class="glyphicon glyphicon-file"></i> </a>   
                                     <a  href="'. route('usulan.unduh',base64_encode(mt_rand(10,99).$proposal->id) ).'" class="btn btn-xs " title="Unduh"><i class="glyphicon glyphicon-download"></i> </a>
                                      <a  href="'. route('usulan.resumeberkas',base64_encode(mt_rand(10,99).$proposal->id) ).'" class="btn btn-xs " title="Unduh Proposal"><i class="glyphicon glyphicon-download-alt"></i> </a>
                                       <button id="'.$proposal->id . '" class="btn btn-xs verifikasi" title="Verifikasi"><i class="glyphicon glyphicon-check"></i> </button>
                                ';

                                }

                            }else{
                                if ($proposal->status > 4 && $proposal->status != 6 ){
                                    return '<a  href="'. route('penelitianbaru.resume',base64_encode(mt_rand(10,99).$proposal->id) ).'" class="btn btn-xs " title="Detail"><i class="glyphicon glyphicon-file"></i> </a>  
                                    <a  href="'. route('usulan.resumeberkas',base64_encode(mt_rand(10,99).$proposal->id) ).'" class="btn btn-xs " title="Unduh Proposal"><i class="glyphicon glyphicon-download-alt"></i> </a>
                                <button id="'.$proposal->id . '" class="btn btn-xs verifikasi" title="Verifikasi">'.$proposal->status . '<i class="glyphicon glyphicon-check"></i> </button>';

                                }elseif ($proposal->status == 6 ){
                                    return '<a  href="'. route('penelitianbaru.resume',base64_encode(mt_rand(10,99).$proposal->id) ).'" class="btn btn-xs " title="Detail"><i class="glyphicon glyphicon-file"></i> </a>    
                                    <a  href="'. route('usulan.resumeberkas',base64_encode(mt_rand(10,99).$proposal->id) ).'" class="btn btn-xs " title="Unduh Proposal"><i class="glyphicon glyphicon-download-alt"></i> </a>
                                <button id="'.$proposal->id . '" class="btn btn-xs setuju" title="Setuju"><i class="glyphicon glyphicon-ok"></i> </button>';

                                }elseif ($proposal->status == 4 ){
                                    return '<a  href="'. route('penelitianbaru.resume',base64_encode(mt_rand(10,99).$proposal->id) ).'" class="btn btn-xs " title="Detail"><i class="glyphicon glyphicon-file"></i> </a>   
                                    <a  href="'. route('usulan.resumeberkas',base64_encode(mt_rand(10,99).$proposal->id) ).'" class="btn btn-xs " title="Unduh Proposal"><i class="glyphicon glyphicon-download-alt"></i> </a>
                                ';

                                }else{
                                    return '<a  href="'. route('penelitianbaru.resume',base64_encode(mt_rand(10,99).$proposal->id) ).'" class="btn btn-xs " title="Detail"><i class="glyphicon glyphicon-file"></i> </a>                       
                                ';

                                }

                            }

                        })
                        ->rawColumns(['status','judul','upload','dana', 'action'])
                        ->make(true);
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }

            }


        }



    }
    public function unduh($id)
    {

        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 2, strlen($temp));
        $idprop /= 2;
        //$prop  = Proposal::where('id', $idprop)->Where('iddosen', Auth::user()->id)->orWhere('iddosen', 0)->first();
        $prop = Proposal::find($idprop);
        $usulan = Substansi::where('proposalid', $idprop)->first();


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


        if($usulan) {


            $pdf = PDF::loadView('penelitianng.unduh',compact('person','idprop','prop','usulan','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata','stat'));

            return  $pdf->stream($prop->judul.".pdf");

        }
        else
            return Redirect::back()->withInput()->withErrors(array('error0' => 'error'));




        //return view('penelitianng.unduh', compact('person','idprop','prop',));
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
    public function resume($id)
    {
        $person = PenelitianBaruController::countPersonil();
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

        return view('admin.usulan.resume', compact('person','idprop','prop','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata','stat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Penelitian $usulan)
    {
        try
        {
            return response()->json(['success' => 'successfull retrieve data', 'data' => $usulan->toJson()], 200);

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
     */
    public function update(Request $request, Penelitian $usulan)
    {
        try
        {

            $usulan = Penelitian::findOrFail($usulan->id);
            $usulan->bidang = $request->bidang;
            $usulan->aktif = $request->aktif;
            $usulan->update();

            return response()->json(['success' => 'data is successfully updated'], 200);
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
        $proposal = Penelitian::find($id);

        try
        {
            if($proposal){
                $proposal->status = '6';
                $proposal->update();
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
    public function setuju($id)
    {
        $proposal = Penelitian::find($id);

        try
        {
            if($proposal){
                $proposal->status = '4';
                $proposal->update();
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
