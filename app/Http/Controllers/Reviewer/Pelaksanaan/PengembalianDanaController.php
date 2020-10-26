<?php

namespace App\Http\Controllers\Reviewer\Pelaksanaan;

use App\Anggaran;
use App\Luaran;
use App\Mataanggaran;
use App\Peneliti;
use App\Periode;
use App\Posisi;
use App\PengembalianDana;
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

class PengembalianDanaController extends Controller
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
        $person = PengembalianDanaController::countPersonil();

        $peneliti = Peneliti::select('id','hindex','sinta','status','tanggungan')->find(Auth::user()->id);
        $periode  = Periode::orderBy('tahun', 'desc')->orderBy('sesi', 'desc')->where('aktif','1')->get();

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


        return view('reviewer.pelaksanaan.pengembaliandana.index', compact('skema','person', 'peneliti', 'periode', 'proposal', 'total','ketua','peserta','member', 'status', 'minat'));

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
        if(request()->ajax())
        {

            if(!empty($request->filter_thn))
            {

                try
                {
                    DB::statement(DB::raw('set @rownum=0'));


                    $proposal = Proposal::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'tb_proposal.id','ketuaid','tb_peneliti.nidn','tb_peneliti.nama','judul','tb_penelitian.prosalid','tb_proposal.jenis','tb_pengembalian_dana.status','adm_status.jenis as jenisstatus','upload'])
                        ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
                        ->leftJoin('tb_ploting_reviewer', 'tb_ploting_reviewer.prosalid', 'tb_proposal.id')
                        ->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
                        ->leftJoin('tb_pengembalian_dana', 'tb_pengembalian_dana.prosalid', 'tb_proposal.id')
                        ->leftJoin('adm_status', 'tb_penelitian.status', 'adm_status.id')
                        ->where('tb_proposal.periodeusul', $request->filter_thn)
                        ->where('tb_ploting_reviewer.iddosen', Auth::user()->id)
                        ->where('tb_ploting_reviewer.jenis', 52)
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
                                return '<a class="btn-info btn-sm center-block ">Penelitian</a>';
                            }else{
                                return '<a class="btn-warning btn-sm center-block ">Pengabdian</a>';

                            }
                        })
                        ->addColumn('jenis', function ($proposal) {
                            if ($proposal->jenis == 1){
                                return ' <small class="label label-info">Penelitian</small>';
                            }else{
                                return '<small class="label label-warning">Pengabdian</small>';

                            }
                        })
                        ->addColumn('status', function ($proposal) {
                            return '<small class="label label-success">'.$proposal->jenisstatus.'</small>';

                        })
                        ->addColumn('upload', function ($proposal) {
                            if ($proposal->upload == null){
                                return '<small class="label label-danger">Belum</small>';

                            }else{
                                return '<small class="label label-success">Sudah</small>';
                            }
                        })
                        ->addColumn('action', function ($proposal) {
                            if ($proposal->upload == null){
                                return '';
                            }
                            else {
                                return '<a  href="' . route('r_pengembaliandana.resume', base64_encode(mt_rand(10, 99) . $proposal->prosalid)) . '" class="btn btn-xs edit btn-warning" title="Detail"><i class="glyphicon glyphicon-file"></i> </a>
                            ';
                            }
                        })
                        ->rawColumns(['judul','jenis','status','upload', 'action'])
                        ->make(true);
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }

            }
        }
    }
    public function resume2($id)
    {
        $person = PengembalianDanaController::countPersonil();
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
        $penelitian = PengembalianDana::where('prosalid', $idprop)->first();

        return view('reviewer.pelaksanaan.pengembaliandana.resume', compact('person','idprop','prop','thn','ketua','peserta','luar','biaya','thnr','tbhn','tjln','tbrg','mata','stat','penelitian'));
    }
    public function resume($id)
    {
        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 2, strlen($temp));


        $penelitian = PengembalianDana::where('prosalid', $idprop)->first();
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
    public function update(Request $request, $id)
    {
        try
        {
            $rancangan = PengembalianDana::findOrFail($id);
            if($rancangan){
                $rancangan->komentar = $request->komentar;
                $rancangan->update();
                return Redirect::back()->withInput()->withErrors(array('success' => 'komentar'));
            }else {
                // Error
                return Redirect::back()->withInput()->withErrors(array('error' => 'error'));
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
        $data = PengembalianDana::select('id','status','upload')
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
