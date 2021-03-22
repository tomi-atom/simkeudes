<?php

namespace App\Http\Controllers\Penelitian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Proposal;
use App\Keanggotaan;

use App\Peneliti;
use App\Periode;

use Yajra\DataTables\Facades\DataTables;
use Auth;
use Redirect;

class AnggotaController extends Controller
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
        $person = AnggotaController::countPersonil();

        $idx = $id; 
        $data = explode("/", base64_decode($id));
        $proposalid = (Integer)$data[0];
        $idskemapro = (Integer)substr($data[1], 2, strlen($data[1]))-9;


        return view('penelitianng.anggota.index', compact('person', 'proposalid', 'idskemapro', 'idx'));
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
    public function store($id, Request $request)
    {
        $_token = $request->get('_token');

        $periode  = Periode::where('aktif', '1')->orderBy('tahun', 'desc')->get();

        $peserta = Keanggotaan::where('idpenelitian',  $request->get('propid'))->where('anggotaid', $request->get('select'))->count();

        $partisi = Proposal::leftJoin('tb_keanggota', 'tb_proposal.id', 'tb_keanggota.idpenelitian')
                           ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
                                    ->where('tb_proposal.periodeusul',$periode[0]->id)
                                    ->where('tb_keanggota.anggotaid', $request->get('select'))
                                    ->where('tb_penelitian.status', '>', 0)
                                    ->where('tb_keanggota.setuju', 1)
                                    ->where('tb_proposal.jenis', 1)
                                    ->where('tb_proposal.aktif', '1')
                                    ->count(); 

        if (!$peserta && $partisi < 2) {
        
            $peneliti = new Keanggotaan;

            $peneliti->idketua      = Auth::user()->id;
            $peneliti->idpenelitian = $request->get('propid');
            $peneliti->anggotaid    = $request->get('select');
            $peneliti->peran        = $request->get('peran');
            $peneliti->tugas        = $request->get('tugas');
            $peneliti->setuju       = '0';
        
            $peneliti->save();
           // return Redirect::back()->withInput()->withErrors(array('success' => 'komentar'));
        }else {
            // Error
            return Redirect::back()->withInput()->withErrors(array('error' => 'error'));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($iddosen, $id)
    {
        $person = AnggotaController::countPersonil();

        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 2, strlen($temp)) / 2;

        $skema = Proposal::select('idskema')->find($idprop);

        if ($skema) {
            $proposalid = $idprop;
            $idskemapro = $skema->idskema;
            $idx = base64_encode($proposalid."/".mt_rand(10,99).(9 + $idskemapro));

            return view('penelitianng.anggota.show', compact('person', 'proposalid', 'idskemapro', 'idx'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($iduser, $id)
    {
        $peneliti = Keanggotaan::find($id);

        if($peneliti) {
            $peneliti->delete();
            return Redirect::back()->withInput()->withErrors(array('success' => 'komentar'));
        }else {
            // Error
            return Redirect::back()->withInput()->withErrors(array('error' => 'error'));
        }
    }

    public function loadanggota($id)
    {
        $temp = explode("/", base64_decode($id));
        $proposalid = (Integer)$temp[0];
        $idskemapro = (Integer)substr($temp[1], 2, strlen($temp[1]))-9;
        
        if ($idskemapro == 7) { 
            $peserta = Peneliti::select('id','nama','nidn','idpddk', 'fungsi')->whereNotIn('id', Keanggotaan::select('anggotaid')->where('idpenelitian','=',$proposalid)->get())
                            //->where('sinta', '!=', '')
                            ->where('idpddk', '>', 4)
                            ->where('fungsi', '<', 3)
                            ->where('id', '!=', Auth::user()->id)
                            ->orderBy('nama', 'asc')
                            ->get();
        }
        else if ($idskemapro == 3) {
            $peserta = Peneliti::whereNotIn('id', Keanggotaan::select('anggotaid')->where('idpenelitian','=',$proposalid)->get())
                           // ->where('sinta', '!=', '')
                            ->where('idpddk', '>', 1)
                            ->where('id', '!=', Auth::user()->id)
                            ->orderBy('nama', 'asc')
                            ->get();
        }
        else if ($idskemapro == 2) {
            $peserta = Peneliti::whereNotIn('id', Keanggotaan::select('anggotaid')->where('idpenelitian','=',$proposalid)->get())
                           // ->where('sinta', '!=', '')
                            ->where('idpddk', '>', 1)
                            ->where('id', '!=', Auth::user()->id)
                            ->orderBy('nama', 'asc')
                            ->get();
        }
        else 
            $peserta = Peneliti::whereNotIn('id', Keanggotaan::select('anggotaid')->where('idpenelitian','=',$proposalid)->get())
                           // ->where('sinta', '!=', '')
                            ->where('idpddk', '>', 4)
                            ->where('id', '!=', Auth::user()->id)
                            ->orderBy('nama', 'asc')
                            ->get();
               
        $no = 0;
        foreach($peserta as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->nidn;
            $row[] = $list->nama;
            $row[] = $list->pendidikan->pendidikan;
            $row[] = $list->fungsional->fungsional;
            $row[] = '<a onclick="selectAnggota('.$list->id.','.$list->nidn.')" class="btn btn-primary"><i class="fa fa-check-circle"></i> Pilih</a>';

            $data[] = $row;
        }

        $output = array("data" => $data);
        return Datatables::of($data)->escapeColumns([])->make(true);
    }

    public function reloadpeserta(Request $request)
    {
        $select = $request->get('select');
        $_token = $request->get('_token');
       
        $peserta = Peneliti::leftJoin('tb_keanggota', 'tb_keanggota.anggotaid', '=', 'tb_peneliti.id')
                                 ->where('tb_keanggota.idpenelitian', '=', $select)
                                 ->orderBy('peran', 'asc')
                                 ->get();
        $output = '<tbody>';

        foreach ($peserta as $data) {
            $output .= 
                '<tr>
                    <td align="center" style="width: 80px"><div class="pull-left image"><img src="'.asset("public/images/".$data->foto).'" class="img-thumbnail  img-circle" alt="User Image" style="width:90%"></div>
                    </td>
                    <td align="left"><strong>'.$data->nama.'</strong> ( '.$data->nidn.' ) <br/>
                    '.$data->universitas->pt.' - '.$data->prodi->prodi.' <font size="2"> <span class="label label-primary"> Anggota Pengusul '.$data->peran.'</span>';
                        if ($data->setuju == 0) 
                            $output .= ' <span class="label label-warning">Belum Disetujui</span>';
                        else if($data->setuju == 1) 
                            $output .= ' <span class="label label-success">Disetujui</span>';
                        else
                            $output .= ' <span class="label label-danger">Tidak Setuju</span>';
                    $output .= '</font> 
                    <br/>
                    Tugas: '.$data->tugas.'
                    </td>
                    <td align="right" style="widows: 80px"><a onclick="deleteData('.$data->id.')" class="btn btn-app btn-sm" id="hapus"><i class="ion ion-ios-trash-outline text-red"></i> Hapus </a>
                    </td>
                </tr>';
        }

        if ($output == '<tbody>')
            $output .= '<tr><td width="25"></td><td colspan="2"><b>ANGGOTA PELAKSANA BELUM ADA</b></td></tr>';

        $output .= '<tr><td></td><td></td><td></td></tr>
                </tbody>';

        echo $output;

    }

    public function rincipeserta(Request $request)
    {
        $id = $request->get('idx');
        $_token = $request->get('_token');

        $peserta = Peneliti::find($id);

        $output = '';
        if($peserta) {
            $output = ' <div class="col-sm-2">
                            <label class="control-label"><div class="pull-right image">
                                <img src="'.asset("public/images/".$peserta->foto).'" id="idimage" class="img-thumbnail" alt="User Image" style="width:98%"></div>
                                </label>
                            </div>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-2">
                                        Nama
                                    </div>
                                <div class="col-sm-9">
                                    : <strong>'.$peserta->nama.'</strong> 
                                </div>
                            </div>
                            <p></p>
                            <div class="row">
                                <div class="col-sm-2">
                                    Institusi
                                </div>
                                <div class="col-sm-9">
                                    : <strong>'.$peserta->universitas->pt.'</strong> 
                                </div>
                            </div>
                            <p></p>
                            <div class="row">
                                <div class="col-sm-2">
                                    Program Studi
                                </div>
                                <div class="col-sm-9">
                                    : <strong>'.$peserta->prodi->prodi.'</strong> 
                                </div>
                            </div>
                            <p></p>
                            <div class="row">
                                <div class="col-sm-2">
                                    Kualifikasi
                                </div>
                                <div class="col-sm-9">
                                    : <strong>'.$peserta->pendidikan->pendidikan.'</strong> 
                                </div>
                            </div>
                            <p></p>
                            <div class="row">
                                <div class="col-sm-2">
                                    Alamat Surel
                                </div>
                                <div class="col-sm-9">
                                    : <strong><i>'.$peserta->email.'</i></strong> 
                                </div>
                            </div>
                        </div>
                        '; 
        }

        echo $output;

    }
}
