<?php

namespace App\Http\Controllers\Penelitian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Proposal;
use App\Penelitian;
use App\Pengukuran;
use App\Keanggotaan;

use App\Peneliti;

use App\Program;
use App\Rumpun;
use App\Fokus;
use App\Skema;
use App\Topik;
use App\Tema;

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
    public function index($id)
    {
        $person = ProposalController::countPersonil();

        $temp = explode("/", base64_decode($id));

        $idskem = (Integer)substr($temp[0], 1, strlen($temp[0])) - 2; 
        $idprog = (Integer)substr($temp[1], 1, strlen($temp[1])) - 9;

        $iddsn = Auth::user()->id;
        $program  = Program::find($idprog);
        $peneliti = Peneliti::select('idpddk','fungsi')->where('id', $iddsn)->first();

        $skema = Skema::where('idprogram', $idprog)->where('aktif', '1')->get();

        $total = Penelitian::leftJoin('tb_proposal', 'tb_penelitian.prosalid', 'tb_proposal.id')
                           ->where('tb_penelitian.prosalid', 'tb_proposal.id') 
                           ->where('ketuaid', $iddsn)
                           ->count();
        
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
        }
        
        $rumpun = Rumpun::groupBy('ilmu1')->orderBy('id')->get();

        $fokus = Fokus::where('aktif', '1')->get(); 

        return view('penelitianng.proposal.index', compact('person', 'idprog', 'iddsn', 'program', 'skema','ttl','rumpun', 'fokus', 'idskem'));

        /*
        $periode = 2;

        $person = ProposalController::countPersonil();

        $peneliti = Peneliti::find(Auth::user()->id);
       
        $program = Program::where('kategori', 1)->where('aktif', '1')->get();

        return view('penelitianng.proposal.index', compact('person', 'peneliti', 'program', 'periode'));
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
    public function store($id, Request $request)
    {
        $temp = explode("/", base64_decode($id));
        $periode= (Integer)substr($temp[0], 2, strlen($temp[0]));
        $idprog = (Integer)$temp[1];
        $jdlprop= $request['judul'] ? $request['judul'] : '';

        $penelitian  = Proposal::where('idketua',Auth::user()->id)
                               ->where('periodeusul', $periode)
                               ->where('jenis', 1)
                               ->where('aktif', '1')
                               ->count();

        $judul = Proposal::select('judul')->where('judul', $jdlprop)->count();

        $batasskema = Keanggotaan::select('anggotaid')
            ->leftJoin('tb_proposal', 'tb_proposal.id', 'tb_keanggota.idpenelitian')
            ->where('tb_keanggota.anggotaid', Auth::user()->id)
            ->where('tb_keanggota.setuju', 1)
            ->where('tb_proposal.jenis', 1)
            ->where('tb_proposal.periodeusul',$periode)
            ->where('tb_proposal.idskema', $request['skema'])
            ->where('tb_proposal.aktif', '1')
            ->count();

        if(!$penelitian && !$judul && !$batasskema) {
            $proposal = new Proposal;
            $proposal->idketua    = Auth::user()->id;
            $proposal->idtkt      = 1;
            $proposal->periodeusul= $periode;
            $proposal->jenis      = 1;
            $proposal->idprogram  = $idprog;
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
            $penelitian->ketuaid  = Auth::user()->id;
            $penelitian->thnkerja = $request['thnkerja'];
            $penelitian->tahun_ke = 1;
          //  $penelitian->status   = 1;

            $penelitian->save();


            return Redirect::route('penelitianng.anggota.index', base64_encode($proposal->id."/".mt_rand(10,99).(9 + $proposal->idskema)))->withInput()->withErrors(array('success' => 'succes'));;
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
    public function show($iddosen, $id)
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
        
            return view('penelitianng.proposal.show', compact('person', 'proposal', 'iddsn', 'program','skema','ttl', 'rumpun','ilmu2','ilmu3', 'fokus','tema','topik', 'tahun'));
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

        $tema    = Tema::where('idskema', $idskema)->where('aktif', '1')->get();
        $output = '<option value=""> -- Pilih Tema Penelitian --</option>';
        foreach ($tema as $row) 
        {
            $output .= '<option value="'.$row->id.'">'.$row->tema.'</option>';
        }
        echo $output;
    } 
}
