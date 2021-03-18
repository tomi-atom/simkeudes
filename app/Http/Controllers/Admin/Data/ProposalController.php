<?php

namespace App\Http\Controllers\Admin\Data;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Proposal;
use App\Penelitian;
use App\Pengukuran;
use App\Keanggotaan;

use App\Peneliti;

use App\Periode;
use App\Program;
use App\Rumpun;
use App\Fokus;
use App\Skema;
use App\Topik;
use App\Tema;
use DB;

use Yajra\DataTables\Facades\DataTables;
use Auth;
use Redirect;

class ProposalController extends Controller
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
        $person = ProposalController::countPersonil();

        //$temp = explode("/", base64_decode($id));

       // $idskem = (Integer)substr($temp[0], 1, strlen($temp[0])) - 2; 
        //$idprog = (Integer)substr($temp[1], 1, strlen($temp[1])) - 9;
        $periode  = Periode::where('aktif','1')->orderBy('tahun', 'desc')->orderBy('sesi', 'desc')
        ->get();
        $iddsn = Auth::user()->id;
        $program  = Program::get();
        $peneliti = Peneliti::select('idpddk','fungsi')->where('id', $iddsn)->first();

        $skema = Skema::where('aktif', '1')->get();

        $total = Penelitian::leftJoin('tb_proposal', 'tb_penelitian.prosalid', 'tb_proposal.id')
                           ->where('tb_penelitian.prosalid', 'tb_proposal.id') 
                           ->where('ketuaid', $iddsn)
                           ->count();
        
        /*                   
        $ttl = count($skema);
        foreach ($skema as $data) {
            if (($total >= $data->kuota)){
                $ttl --;
                $data->id = 0;
                $data->skema = '';
            }
            else if (!((($peneliti->idpddk >= $data->mindidik1 && $peneliti->fungsi >= $data->minjabat1) 
                || ($peneliti->idpddk >= $data->mindidik2 && $peneliti->fungsi >= $data->minjabat2)) 
                && ($peneliti->fungsi <= $data->maxjabat))) {
                    $ttl --;
                    $data->id = 0;
                    $data->skema = '';
            }
        }*/
        
        $rumpun = Rumpun::groupBy('ilmu1')->orderBy('id')->get();

        $fokus = Fokus::where('aktif', '1')->get(); 

        return view('admin.datapenelitian.proposal.index', compact('person','periode', 'idprog', 'iddsn', 'program', 'skema','ttl','rumpun', 'fokus', 'idskem'));

        /*
        $periode = 2;

        $person = ProposalController::countPersonil();

        $peneliti = Peneliti::find(Auth::user()->id);
       
        $program = Program::where('kategori', 1)->where('aktif', '1')->get();

        return view('admin.datapenelitian.proposal.index', compact('person', 'peneliti', 'program', 'periode'));
        */
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
         //   $temp = explode("/", base64_decode($id));
        //$periode= (Integer)substr($temp[0], 2, strlen($temp[0]));
         //  $idprog = (Integer)$temp[1];
        $jdlprop= $request['judul'] ? $request['judul'] : '';

        $penelitian  = Proposal::where('idketua',$request['iddosen'])
                               ->where('periodeusul', $request['periodeusul'])
                               ->where('jenis', 1)
                               ->where('aktif', '1')
                               ->count();

        $judul = Proposal::select('judul')->where('judul', $jdlprop)->count();

        $batasskema = Keanggotaan::select('anggotaid')
            ->leftJoin('tb_proposal', 'tb_proposal.id', 'tb_keanggota.idpenelitian')
            ->where('tb_keanggota.anggotaid', $request['iddosen'])
            ->where('tb_keanggota.setuju', 1)
            ->where('tb_proposal.jenis', 1)
            ->where('tb_proposal.periodeusul',$request['periodeusul'])
            ->where('tb_proposal.idskema', $request['skema'])
            ->where('tb_proposal.aktif', '1')
            ->count();

        if( !$judul && !$batasskema) {
            $proposal = new Proposal;
            $proposal->idketua    = $request['iddosen'];
            $proposal->idtkt      = 1;
            $proposal->periodeusul= $request['periodeusul'];
            $proposal->jenis      = 1;
            $proposal->idprogram  = 3;
            $proposal->judul      = $request['judul'];
            $proposal->tktawal    = $request['tkt1'];
            $proposal->tktakhir   = $request['tkt2'];
            $proposal->idskema    = $request['skema'];
            $proposal->idilmu     = $request['ilmu3'];
            $proposal->idsbk      = $request['sbk'];
            $proposal->idfokus    = $request['bidang'];
            $proposal->idtema     = $request['tema'];
            $proposal->idtopik    = $request['topik'];
        
            $proposal->lama       = $request['lama'];
            $proposal->aktif      = '0';
            $proposal->pengesahan = '';
            $proposal->usulan   = '';

            $proposal->save();

            $penelitian = new Penelitian;
            $penelitian->prosalid = $proposal->id;
            $penelitian->ketuaid  = $request['iddosen'];
            $penelitian->thnkerja = $request['thnkerja'];
            $penelitian->tahun_ke = 1;
            $penelitian->status   = 4;

            $penelitian->save();


          
            return Redirect::back()->withInput()->withErrors(array('success' => 'success'));
            }
        else {
            return Redirect::back()->withInput()->withErrors(array('error' => 'error'));
            //return Redirect::route('error666');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        try
        {
            DB::statement(DB::raw('set @rownum=0'));
            $peneliti = Peneliti::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'users.id', 'nidn','nip','nama','tb_peneliti.email'])
            ->leftJoin('users','users.email','tb_peneliti.nidn')
            //->where('users.level',1);
            ->whereIn('users.level',[1,2]);
            //->groupBy('users.id');

            return DataTables::of($peneliti)
                ->addColumn('action', function ($peneliti) {
                    return ' <a onclick="selectAnggota('.$peneliti->id.','.$peneliti->nidn.')" class="btn btn-primary"><i class="fa fa-check-circle"></i> Pilih</a>';
                })
                ->make(true);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }
    public function show2()
    {
        
        $person = ProposalController::countPersonil();

        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 2, strlen($temp)) - 13;

        $iddsn = Auth::user()->id;

        $proposal = Proposal::find($idprop);
        if ($proposal) {
            $program  = Program::find($proposal->idprogram);
            $peneliti = Peneliti::select('idpddk','fungsi')->where('id', $iddsn)->first();

            $skema = Skema::where('idprogram', $proposal->idprogram)->where('aktif', '1')->get();

            $total = Penelitian::leftJoin('tb_proposal', 'tb_penelitian.prosalid', 'tb_proposal.id')
                           ->where('tb_penelitian.prosalid', 'tb_proposal.id') 
                           ->where('ketuaid', $iddsn)
                           ->count();
        
            $ttl = count($skema);
            
            /* Lose Filter
            foreach ($skema as $data) {
                if (($total >= $data->kuota)){
                    $ttl --;
                    $data->id = 0;
                    $data->skema = '';
                }
                else if (!((($peneliti->idpddk >= $data->mindidik1 && $peneliti->fungsi >= $data->minjabat1) 
                    || ($peneliti->idpddk >= $data->mindidik2 && $peneliti->fungsi >= $data->minjabat2)) 
                    && ($peneliti->fungsi <= $data->maxjabat))) {
                        $ttl --;
                        $data->id = 0;
                        $data->skema = '';
                }
            }*/

            $rumpun = Rumpun::select('ilmu1')->groupBy('ilmu1')->orderBy('id')->get();
            $ilmu2 =  Rumpun::select('ilmu2')
                            ->groupBy('ilmu2')
                            ->where('ilmu1',$proposal->rumpun->ilmu1)
                            ->orderBy('id')
                            ->get();
            $ilmu3 =  Rumpun::select('id', 'ilmu3')
                            ->groupBy('ilmu3')
                            ->where('ilmu2',$proposal->rumpun->ilmu2)
                            ->orderBy('id')
                            ->get();

            $fokus = Fokus::where('aktif', '1')->get(); 
            $tema  = Tema::select('id','tema')->where('idskema', $proposal->idskema)->orderBy('id')->get();
            $topik = Topik::select('id','topik')->where('idtema', $proposal->idtema)->orderBy('id')->get();

            $tahun = Penelitian::select('thnkerja')->where('prosalid', $proposal->id)->first();
        
            return view('admin.datapenelitian.proposal.show', compact('person', 'proposal', 'iddsn', 'program','skema','ttl', 'rumpun','ilmu2','ilmu3', 'fokus','tema','topik', 'tahun'));
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
    public function update(Request $request, $iddosen, $id)
    {
        $idprop = base64_decode($id)-81;

        $proposal = Proposal::find($idprop);
        if ($proposal) {
            
            $proposal->judul      = $request['judul'];
            $proposal->tktawal    = $request['tkt1'];
            $proposal->tktakhir   = $request['tkt2'];
            $proposal->idskema    = $request['skema'];
            $proposal->idilmu     = $request['ilmu3'];
            $proposal->idsbk      = $request['sbk'];
            $proposal->idfokus    = $request['bidang'];
            $proposal->idtema     = $request['tema'];
            $proposal->idtopik    = $request['topik'];
        
            $proposal->lama       = $request['lama'];

            $proposal->update();

            $penelitian = Penelitian::where('prosalid', $idprop)->first();

            $penelitian->thnkerja = $request['thnkerja'];

            $penelitian->update();

            return Redirect::route('validasipenelitian.show', base64_encode(mt_rand(10,99).($idprop*2+29)))->withInput()->withErrors(array('success' => 'komentar'));
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
        //
    }

    public function fetchilmu(Request $request)
    {
        $select = $request->get('select');
        $value  = $request->get('value');
        $_token = $request->get('_token');
        $dependent = $request->get('dependent');

        $data = Rumpun::where($select, '=', $value)->groupBy($dependent)->orderBy('id')->get();

        if ($dependent == 'ilmu2') {
            $idtm = $dependent;
            $temp = '-- Pilih Rumpun Ilmu Level 2 --';
        }
        else if ($dependent == 'ilmu3') {
            $idtm = 'id';
            $temp = '-- Pilih Rumpun Ilmu Level 3 --';
        }


        $output = '<option value="">'.$temp.'</option>';
        foreach ($data as $row) 
        {
            $output .= '<option value="'.$row->$idtm.'">'.$row->$dependent.'</option>';
        }

        echo $output;
    }

    public function loadtkt(Request $request)
    {
        $indikator = $request->get('indikator');
        $_token    = $request->get('_token');

        $output = '<option value=""> -- Pilih TKT --</option>';

        if ($indikator <= 3)
            $index = 0;
        else if ($indikator <= 6)
            $index = 1;
        else
            $index = 2;

        $indikator = $indikator ? $indikator : 10; 

        for ($i = $indikator; $i<=3+$index*3; $i++){
            $output .= '<option value="'.$i.'"> TKT '.$i.'</option>';
        }

        echo $output;
    }

    public function loadtpk(Request $request) 
    {
        $idtema = $request->get('idtema'); 
        $_token = $request->get('_token');

        $topik    = Topik::where('idtema', $idtema)->where('aktif', '1')->get();
        $output = '<option value=""> -- Pilih Topik Penelitian --</option>';
        foreach ($topik as $row) 
        {
            $output .= '<option value="'.$row->id.'">'.$row->topik.'</option>';
        }
        echo $output;
    }

    public function loadbdg(Request $request) 
    {
        $idskema = $request->get('idskema'); 
        $_token  = $request->get('_token');

        $tema    = Tema::where('aktif', '1')->get();
        $output = '<option value=""> -- Pilih Tema Penelitian --</option>';
        foreach ($tema as $row) 
        {
            $output .= '<option value="'.$row->id.'">'.$row->tema.'</option>';
        }
        echo $output;
    } 
   

    public function loadanggota()
    {
    
        $peserta = Peneliti::where('sinta', '!=', '')
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
