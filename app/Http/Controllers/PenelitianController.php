<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Proposal;
use App\Penelitian;
use App\Keanggotaan;
use App\Substansi;
use App\Keluaran;
use App\Luaran;
use App\Anggaran;

use App\Peneliti;
use App\Universitas;
use App\Fakultas;
use App\Prodi;
use App\Pendidikan;
use App\Fungsional;
use App\Mataanggaran;

use App\Pengukuran;
use App\Bidangtkt;
use App\Indikatortkt;
use App\Program;
use App\Periode;
use App\Skema;
use App\Fokus;
use App\Tema;
use App\Topik;
use App\Rumpun;
use App\Posisi;

use Datatables;
use PDF;

use Auth;

use Redirect;

class PenelitianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    protected $pesan = array(
            'tahun.required' => 'Pilih tahun terlebih dahulu',
            );

    protected $aturan = array(
            'tahun' => 'required',
            );

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
        $person = PenelitianController::countPersonil();

        $peneliti = Peneliti::select('id','hindex','sinta','status','tanggungan')->find(Auth::user()->id);
        $periode  = Periode::where('aktif', '1')->orderBy('tahun', 'sesi', 'desc')->get();

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

        $member = Keanggotaan::where('anggotaid', Auth::user()->id)->where('setuju', 1)->count();

        $ketua   = count($proposal);
        $total   = $ketua + count($peserta);

        return view('penelitian.index', compact('peneliti','periode','proposal','total','ketua','peserta','person','member', 'status', 'minat'));
    }

    public function proposal($id, Request $request)
    {
        $person = PenelitianController::countPersonil();

        $stat = $id[0];
        if ($stat == 0) {
            $idprog = (Integer)$id;
        }
        else {
            $idprog = (Integer)substr($id, 1, strlen($id));
            //$proposal = Penelitian::orderBy('id', 'desc')->first(); 
        }
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
        
        $thn = $request['tahun'];
        
        $rumpun = Rumpun::groupBy('ilmu1')->orderBy('id')->get();

        $fokus = Fokus::where('aktif', '1')->get();
        $bidang = Bidangtkt::where('aktif', '1')->get(); 

        return view('penelitian.proposal', compact('skema', 'program','thn', 'idprog', 'stat', 'iddsn', 'rumpun','ttl', 'fokus', 'total','person','bidang'));
    }

    public function fetch(Request $request)
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

    public function fetchtkt(Request $request) 
    {
        $teknologi = $request->get('teknologi');
        $indikator = $request->get('indikator');
        $_token    = $request->get('_token');

        $idtkt = Auth::user()->email;
        $ukur  = Pengukuran::where('id','LIKE', Auth::user()->email.'%')->count(); 

        $idtkt .= ++$ukur;

        $tkt = new Pengukuran;
        $tkt->id = $idtkt;
        $tkt->teknologi = $teknologi;
        $tkt->indikator = $indikator;

        $tkt->save();

        echo $idtkt;
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

        for ($i = $indikator; $i<=3+$index*3; $i++){
            $output .= '<option value="'.$i.'"> TKT '.$i.'</option>';
        }

        echo $output;

    } 

    public function prosestkt(Request $request, $id)
    {
        $indikator = $request->get('indikator');
        $_token    = $request->get('_token');

        $pagu = Indikatortkt::where('idbidang', $indikator)
                            ->where('leveltkt', $id)
                            ->orderBy('id','asc')
                            ->get();

        $output =   '<thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-center" width="4%">No.</th>
                            <th scope="col" class="text-center" width="84%">Indikator</th>
                            <th scope="col" class="text-center" width="12%">Penilaian</th>
                        </tr>
                    </thead>';
        $output .= '<tbody>';
        $no = 0;
        foreach ($pagu as $list) {
            $no++;
            $output .= '<tr>
                            <td>'.$no.'</td>
                            <td>'.$list->indikator.'</td>
                            <td><div class="input-group input-group-sm">
                                <select id="point'.$no.'" class="form-control" name="point'.$no.'" required>
                                <option value="0" selected> 0%</option>
                                <option value="20">20%</option>
                                <option value="40">40%</option>
                                <option value="60">60%</option>
                                <option value="80">80%</option>
                                <option value="100">100%</option>
                                </select>
                                </div>
                            </td>
                        </tr>
                       ';
        }

        echo $output;
    }

    public function calculatetkt(Request $request)
    {
        $idtkt = $request['idtkt'];
        $level = $request['indextkt'];
        $_token= $request['_token'];

        $ukur  = Pengukuran::select('indikator')->findOrFail($idtkt); 
        $total = Indikatortkt::where('idbidang', $ukur->indikator)
                             ->where('leveltkt', $level)
                             ->count();

        $nilaitkt = 0;
        for($i=1; $i<=$total; $i++)
        {
            $nilaitkt += $request['point'.$i];
        }

        $nilaitkt /= $total;

        if (round($nilaitkt) >= 80 && $level < 9) {
            $output =  '<div class="alert alert-success alert-dismissible">
                            <p>Nilai Indikator TKT anda <b id="kode">'.round($nilaitkt).'</b>. Silakan klik tombol <b>Lanjut</b> untuk mengisi Indikator di <b>Level TKT '.++$level.'</b></p>
                        </div>';
        } else {
            if ($level == 1)
                $akhir = $level;
            else if ($level < 9)
                $akhir = $level-1;
            else if ($level == 9 && round($nilaitkt) < 80)
                $akhir = $level-1;
            else
                $akhir = $level;

            $output =  '<div class="alert alert-info alert-dismissible">
                            <p>Nilai Indikator TKT anda <b id="kode">'.round($nilaitkt).'</b>. Level TKT yang dicapai adalah <b id="grade">'.$akhir.'</b>. Silakan klik tombol <b>Simpan</b></p>
                        </div>';
        }


        echo $output;
        
    } 

    public function updatetkt(Request $request, $id) 
    {
        $level = $request['indextkt'];
        $_token= $request['_token'];

        $tkt = Pengukuran::findOrFail($id);
        $total = Indikatortkt::where('idbidang', $tkt->indikator)
                             ->where('leveltkt', $level)
                             ->count(); 
        $tulis='';                     
        for($i=1; $i<=$total; $i++)
        {
            $tulis .= $request['point'.$i].';';
        }

        switch ($level) {
            case 1: $tkt->tkt1 = $tulis; break;
            case 2: $tkt->tkt2 = $tulis; break;
            case 3: $tkt->tkt3 = $tulis; break;
            case 4: $tkt->tkt4 = $tulis; break;
            case 5: $tkt->tkt5 = $tulis; break;
            case 6: $tkt->tkt6 = $tulis; break;
            case 7: $tkt->tkt7 = $tulis; break;
            case 8: $tkt->tkt8 = $tulis; break;
            default:
                    $tkt->tkt9 = $tulis;
        }
 
        $tkt->update();

        echo ++$level;
    }

    public function fetchbidang(Request $request) 
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

    public function fetchtopik(Request $request) 
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

    public function hapusproposal($id) 
    {
        $proposal = Proposal::find($id);
        $proposal->delete();

        $tkt = Pengukuran::find($proposal->idtkt);
        if (count($tkt))
            $tkt->delete();
        
        $penelitian = Penelitian::where('prosalid', $proposal->id)->first();
        if (count($penelitian))
            $penelitian->delete();
        
        $anggota = Keanggotaan::where('idpenelitian', $proposal->id)->get();
        foreach ($anggota as $list)
            $list->delete();
        
        $subtansi = Substansi::where('proposalid', $proposal->id)->first();
        if (count($subtansi))
            $subtansi->delete();

        $luaran = Luaran::where('idpenelitian', $proposal->id)->get();
        foreach ($luaran as $list)
            $list->delete();
        
        $anggaran = Anggaran::where('proposalid', $proposal->id)->get();
        foreach ($anggaran as $list)
            $list->delete();

        return Redirect::route('penelitian.index');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $person = PenelitianController::countPersonil();
        $peneliti = Peneliti::find(Auth::user()->id);
       
        $program = Program::where('kategori', 1)->where('aktif', '1')->get();
        $thn = $request['idxtahun'];

        return view('penelitian.create', compact('peneliti', 'program', 'thn', 'person'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->aturan, $this->pesan);
        
        $proposal = new Proposal;
        $proposal->idketua    = Auth::user()->id;
        $proposal->idtkt      = $request['tktid'];
        $proposal->periodeusul= $request['tahun'];
        $proposal->jenis      = 1;
        $proposal->idprogram  = $request['program'];
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

        $proposal->save();

        $penelitian = new Penelitian;
        $penelitian->prosalid = $proposal->id;
        $penelitian->ketuaid  = Auth::user()->id;
        $penelitian->thnkerja = $request['thnkerja'];
        $penelitian->tahun_ke = 1;
        $penelitian->status   = 1;

        $penelitian->save();

        return Redirect::route('penelitian.anggota', base64_encode($proposal->id."/".$proposal->idskema));
    }

    public function anggota($id) 
    {
        $person = PenelitianController::countPersonil();

        $data = explode("/", base64_decode($id));
        $proposalid = (Integer)$data[0];
        $idskemapro = (Integer)$data[1];

        if ($idskemapro == 7) {
            $peserta = Peneliti::select('id','nidn', 'nama', 'email', 'idpt', 'idfakultas', 'idprodi', 'idpddk', 'fungsi', 'foto')->whereNotIn('id', Keanggotaan::select('anggotaid')->where('idpenelitian','=',$proposalid)->get())
                            ->where('sinta', '!=', '')
                            ->where('idpddk', '>', 4)
                            ->where('fungsi', '<', 3)
                            ->where('id', '!=', Auth::user()->id)
                            ->orderBy('nama', 'asc')
                            ->get();
        }
        else if ($idskemapro == 3) {
            $peserta = Peneliti::whereNotIn('id', Keanggotaan::select('anggotaid')->where('idpenelitian','=',$proposalid)->get())
                            ->where('sinta', '!=', '')
                            ->where('idpddk', '>', 1)
                            ->where('id', '!=', Auth::user()->id)
                            ->orderBy('nama', 'asc')
                            ->get();
        }
        else if ($idskemapro == 2) {
            $peserta = Peneliti::whereNotIn('id', Keanggotaan::select('anggotaid')->where('idpenelitian','=',$proposalid)->get())
                            ->where('sinta', '!=', '')
                            ->where('idpddk', '>', 1)
                            ->where('id', '!=', Auth::user()->id)
                            ->orderBy('nama', 'asc')
                            ->get();
        }
        else 
            $peserta = Peneliti::whereNotIn('id', Keanggotaan::select('anggotaid')->where('idpenelitian','=',$proposalid)->get())
                            ->where('sinta', '!=', '')
                            ->where('idpddk', '>', 4)
                            ->where('id', '!=', Auth::user()->id)
                            ->orderBy('nama', 'asc')
                            ->get();


        return view('penelitian.anggota', compact('proposalid','idskemapro','peserta','person'));
    }

    public function listData(Request $request)
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
                        else
                            $output .= ' <span class="label label-success">Disetujui</span>';
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

    public function simpanData(Request $request) 
    {
        $_token = $request->get('_token');

        $periode  = Periode::where('aktif', '1')->orderBy('tahun', 'sesi', 'desc')->get();

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
        }
        else
        {
            
        }
    }

    public function subtansi($id)
    {
        $person = PenelitianController::countPersonil();

        $proposalid = base64_decode($id);

        return view('penelitian.subtansi', compact('proposalid','person'));
    }

    public function unggahsub(Request $request) 
    {
     
        $_token = $request->get('_token');
        
        $ceklog = Substansi::where('proposalid', $request->get('propid'))->count();
        //$this->validate($request, $this->aturan, $this->pesan);
        if (!$ceklog) {
            $subtansi = new Substansi;

            $subtansi->proposalid = $request->get('propid');
            $subtansi->ringkasan  = $request->get('ringkasan');
            $subtansi->katakunci  = $request->get('katakunci');
            $subtansi->lbelakang  = $request->get('lbelakang');
            $subtansi->literatur  = $request->get('literatur');
            $subtansi->metode     = $request->get('metode');
            $subtansi->jadwal     = $request->get('jadwal');
            $subtansi->pustaka    = $request->get('pustaka');
            $subtansi->iptek      = 'None';
            $subtansi->peta       = 'None';
            $subtansi->unggah     = 'None';

            $subtansi->save();
        }
        else {

        }
    }

    public function luaran($id)
    {
        $person = PenelitianController::countPersonil();

        $jenis = Keluaran::groupBy('jenis')->orderBy('id')->get();
        $idprop = base64_decode($id)-2;

        return view('penelitian.luaran', compact('jenis', 'idprop', 'person'));
    }

    public function fetchtarget(Request $request)
    {
        $ceklog = Keluaran::findOrFail($request->get('idtarget'));

        $target = Keluaran::where('jenis', $ceklog->jenis)->groupBy('target')->orderBy('id')->get();

        $output = '<option value="">  -- Pilih Target --</option>';
        foreach ($target as $row) 
        {
            $output .= '<option value="'.$row->id.'">'.$row->target.'</option>';
        }
        echo $output;
    }

    public function simpanLuaran(Request $request)
    {
        $jurnal  = $request['jurnal'] ? $request['jurnal'] : '';
        $linkurl = $request['linkurl'] ? $request['linkurl'] : '';

        $peneliti = new Luaran;
        
        $peneliti->idpenelitian = $request['id'];
        $peneliti->idluaran     = $request['target'];
        $peneliti->kategori     = $request['kategori'];
        $peneliti->publish      = $jurnal;
        $peneliti->urllink      = $linkurl;
        $peneliti->status       = '1';
        
        $peneliti->save();
    }

    public function tampilLuaranWajib(Request $request) 
    {
        $select = $request->get('select');
        $_token = $request->get('_token');

        $luaran = Luaran::where('idpenelitian', $select)->where('kategori', '1')->orderBy('id', 'asc')->get();

        $output = '<tbody>';
        $no = 0;
        foreach ($luaran as $data) {
            $no++;
            $output .= 
                '<tr>
                    <td>'.$no.'</td>
                    <td><b>'.$data->keluaran->jenis.'</b><br>';
                    if ($data->publish) {
                        $output .= '<code>'.$data->publish.'</code><br>';
                    }
                    $output .= '<span class="label label-success">'.$data->keluaran->target.'</span>
                    </td>
                    <td align="right" style="widows: 80px"><a onclick="deleteData('.$data->id.')" class="btn btn-app btn-sm" id="hapus"><i class="ion ion-ios-trash-outline text-red"></i> Hapus </a>
                    </td>
                ';
        }
        if ($output == '<tbody>')
            $output .= '<tr><td width="25"></td><td colspan="2"><b>LUARAN KEGIATAN WAJIB BELUM ADA</b></td></tr>';

        $output .= '<tr><td></td><td></td><td></td></tr>
                </tbody>';

        echo $output;

    }

    public function tampilLuaranTambah( Request $request) 
    {
        $select = $request->get('select');
        $_token = $request->get('_token');

        $luaran = Luaran::where('idpenelitian', $select)->where('kategori', '2')->orderBy('id', 'asc')->get();

        $output = '<tbody>';
        $no = 0;
        foreach ($luaran as $data) {
            $no++;
            $output .= 
                '<tr>
                    <td>'.$no.'</td>
                    <td><b>'.$data->keluaran->jenis.'</b><br>';
                    if ($data->publish) {
                        $output .= '<code>'.$data->publish.'</code><br>';
                    }
                    $output .= '<span class="label label-success">'.$data->keluaran->target.'</span>
                    </td>
                    <td align="right" style="widows: 80px"><a onclick="deleteData('.$data->id.')" class="btn btn-app btn-sm" id="hapus"><i class="ion ion-ios-trash-outline text-red"></i> Hapus </a>
                    </td>
                ';
        }
        if ($output == '<tbody>')
            $output .= '<tr><td width="25"></td><td colspan="2"><b>LUARAN KEGIATAN TAMBAHAN BELUM ADA</b></td></tr>';

        $output .= '<tr><td></td><td></td><td></td></tr>
                </tbody>';

        echo $output;

    }

    public function hapusluaran($id)
    {
        $luaran = Luaran::find($id);

        $luaran->delete();
    }

    public function rab($id)
    {
        $person = PenelitianController::countPersonil();

        $idprop = base64_decode($id)-5;

        $skema = Proposal::select('idskema')->find($idprop);
        $biaya = Mataanggaran::where('aktif', '1')->get();

        $honor = Anggaran::where('proposalid', $idprop)->where('anggaranid', 1)->orderBy('id','asc')->get();
        $bahan = Anggaran::where('proposalid', $idprop)->where('anggaranid', 2)->orderBy('id','asc')->get();
        $jalan = Anggaran::where('proposalid', $idprop)->where('anggaranid', 3)->orderBy('id','asc')->get();
        $barang = Anggaran::where('proposalid', $idprop)->where('anggaranid', 4)->orderBy('id','asc')->get();

        return view('penelitian.rab', compact('idprop','skema','biaya','honor','bahan','jalan','barang','person'));
    }

    public function simpanrab(Request $request) 
    {
        $idprop = $request['id'];
        $idrab  = $request['belanja'];
        $volum  = $request['volume'];
        $harga  = $request['biaya']; 

        $skema  = Proposal::select('idskema')->find($idprop);
        $biaya  = Mataanggaran::select('batas')->find($idrab);
        $subtot = Anggaran::select('anggaranid','volume', 'biaya')->where('proposalid', $idprop)->get();
        $total  = 0;
        $grand  = 0;
        foreach ($subtot as $list) {
            if ($list->anggaranid == $idrab)
                $total += $list->volume * $list->biaya;

            $grand += $list->volume * $list->biaya; 
        }
        $total += $volum * $harga;
        $grand += $volum * $harga;

        if (($total <= ($biaya->batas*$skema->skema->dana/100)) && ($grand <= $skema->skema->dana)) {
            $biaya = new Anggaran;
        
            $biaya->proposalid = $request['id'];
            $biaya->anggaranid = $request['belanja'];
            $biaya->item       = $request['item'];
            $biaya->satuan     = $request['satuan'];
            $biaya->volume     = $request['volume'];
            $biaya->biaya      = $request['biaya'];
        
            $biaya->save();
        }
        else if ($grand > $skema->skema->dana) {
            echo "error";
        }
        else {
            echo "error 2";
        }

    }

    public function tampiltotal(Request $request) {
        $select = $request->get('select');
        $_token = $request->get('_token');

        $subtot = Anggaran::select('volume', 'biaya')->where('proposalid', $select)->get();
        $grand  = 0; 
        foreach ($subtot as $list) {
            $grand += $list->volume * $list->biaya; 
        }

        $output = 'TOTAL BIAYA: Rp '.format_uang($grand).',-&nbsp;&nbsp;';

        echo $output;
    }

    public function tampilhonor(Request $request) {
        $select = $request->get('select');
        $_token = $request->get('_token');

        $pagu = Anggaran::where('proposalid', $select)->where('anggaranid', 1)->orderBy('id','asc')->get();

        $output =   '<thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-center" width="4%">No.</th>
                            <th scope="col" class="text-center" width="52%">Item</th>
                            <th scope="col" class="text-center" width="7%">Satuan</th>
                            <th scope="col" class="text-center" width="6%">Vol.</th>
                            <th scope="col" class="text-center" width="10%">Biaya <br>Satuan</th>
                            <th scope="col" class="text-center" width="10%">Total</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>';
        $output .= '<tbody>';
        $no = 0;
        $total = 0;
        foreach ($pagu as $list) {
            $no++;
            $total += $list->volume*$list->biaya;
            $output .= '<tr>
                            <td>'.$no.'</td>
                            <td>'.$list->item.'</td>
                            <td>'.$list->satuan.'</td>
                            <td>'.$list->volume.'</td>
                            <td>'.format_uang($list->biaya).'</td>
                            <td>'.format_uang($list->volume*$list->biaya).'</td>
                            <td class="text-center"><a onclick="editAnggaran('.$list->id.',1)" class="btn btn-default fa fa-edit fa-ca" data-toggle="tooltip" data-placement="bottom" title="Edit: not done"></a> &nbsp; <a onclick="hapusAnggaran('.$list->id.',1)" class="btn btn-default fa fa-trash-o fa-ca" data-toggle="tooltip" data-placement="bottom" title="Hapus"></a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7"></td>
                        </tr>
                       ';
        }

        $output .= '<tr>
                        <td colspan="5" class="text-right"><b>SUB TOTAL </b></td>
                        <td colspan="2"><b>Rp '.format_uang($total).'</b></td>
                    </tr>
                    <tr>
                        <td colspan="7"><b>Terbilang: </b><i>'.terbilang($total).' Rupiah<i></td>
                    </tr>
                    ';

        echo $output;

    }

    public function tampilbahan(Request $request) {
        $select = $request->get('select');
        $_token = $request->get('_token');

        $pagu = Anggaran::where('proposalid', $select)->where('anggaranid', 2)->orderBy('id','asc')->get();

        $output =   '<thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-center" width="4%">No.</th>
                            <th scope="col" class="text-center" width="52%">Item</th>
                            <th scope="col" class="text-center" width="7%">Satuan</th>
                            <th scope="col" class="text-center" width="6%">Vol.</th>
                            <th scope="col" class="text-center" width="10%">Biaya <br>Satuan</th>
                            <th scope="col" class="text-center" width="10%">Total</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>';
        $output .= '<tbody>';
        $no = 0;
        $total = 0;
        foreach ($pagu as $list) {
            $no++;
            $total += $list->volume*$list->biaya;
            $output .= '<tr>
                            <td>'.$no.'</td>
                            <td>'.$list->item.'</td>
                            <td>'.$list->satuan.'</td>
                            <td>'.$list->volume.'</td>
                            <td>'.format_uang($list->biaya).'</td>
                            <td>'.format_uang($list->volume*$list->biaya).'</td>
                            <td class="text-center"><a onclick="editAnggaran('.$list->id.',2)" class="btn btn-default fa fa-edit fa-ca" data-toggle="tooltip" data-placement="bottom" title="Edit: not done"></a> &nbsp; <a onclick="hapusAnggaran('.$list->id.',2)" class="btn btn-default fa fa-trash-o fa-ca" data-toggle="tooltip" data-placement="bottom" title="Hapus"></a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7"></td>
                        </tr>
                       ';
        }

        $output .= '<tr>
                        <td colspan="5" class="text-right"><b>SUB TOTAL </b></td>
                        <td colspan="2"><b>Rp '.format_uang($total).'</b></td>
                    </tr>
                    <tr>
                        <td colspan="7"><b>Terbilang: </b><i>'.terbilang($total).' Rupiah<i></td>
                    </tr>
                    ';

        echo $output;

    }

    public function tampiljalan(Request $request) {
        $select = $request->get('select');
        $_token = $request->get('_token');

        $pagu = Anggaran::where('proposalid', $select)->where('anggaranid', 3)->orderBy('id','asc')->get();

        $output =   '<thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-center" width="4%">No.</th>
                            <th scope="col" class="text-center" width="52%">Item</th>
                            <th scope="col" class="text-center" width="7%">Satuan</th>
                            <th scope="col" class="text-center" width="6%">Vol.</th>
                            <th scope="col" class="text-center" width="10%">Biaya <br>Satuan</th>
                            <th scope="col" class="text-center" width="10%">Total</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>';
        $output .= '<tbody>';
        $no = 0;
        $total = 0;
        foreach ($pagu as $list) {
            $no++;
            $total += $list->volume*$list->biaya;
            $output .= '<tr>
                            <td>'.$no.'</td>
                            <td>'.$list->item.'</td>
                            <td>'.$list->satuan.'</td>
                            <td>'.$list->volume.'</td>
                            <td>'.format_uang($list->biaya).'</td>
                            <td>'.format_uang($list->volume*$list->biaya).'</td>
                            <td class="text-center"><a onclick="editAnggaran('.$list->id.',3)" class="btn btn-default fa fa-edit fa-ca" data-toggle="tooltip" data-placement="bottom" title="Edit: not done"></a> &nbsp; <a onclick="hapusAnggaran('.$list->id.',3)" class="btn btn-default fa fa-trash-o fa-ca" data-toggle="tooltip" data-placement="bottom" title="Hapus"></a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7"></td>
                        </tr>
                       ';
        }

        $output .= '<tr>
                        <td colspan="5" class="text-right"><b>SUB TOTAL </b></td>
                        <td colspan="2"><b>Rp '.format_uang($total).'</b></td>
                    </tr>
                    <tr>
                        <td colspan="7"><b>Terbilang: </b><i>'.terbilang($total).' Rupiah<i></td>
                    </tr>
                    ';

        echo $output;

    }

    public function tampilbarang(Request $request) {
        $select = $request->get('select');
        $_token = $request->get('_token');

        $pagu = Anggaran::where('proposalid', $select)->where('anggaranid', 4)->orderBy('id','asc')->get();

        $output =   '<thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-center" width="4%">No.</th>
                            <th scope="col" class="text-center" width="52%">Item</th>
                            <th scope="col" class="text-center" width="7%">Satuan</th>
                            <th scope="col" class="text-center" width="6%">Vol.</th>
                            <th scope="col" class="text-center" width="10%">Biaya <br>Satuan</th>
                            <th scope="col" class="text-center" width="10%">Total</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>';
        $output .= '<tbody>';
        $no = 0;
        $total = 0;
        foreach ($pagu as $list) {
            $no++;
            $total += $list->volume*$list->biaya;
            $output .= '<tr>
                            <td>'.$no.'</td>
                            <td>'.$list->item.'</td>
                            <td>'.$list->satuan.'</td>
                            <td>'.$list->volume.'</td>
                            <td>'.format_uang($list->biaya).'</td>
                            <td>'.format_uang($list->volume*$list->biaya).'</td>
                            <td class="text-center"><a onclick="editAnggaran('.$list->id.',4)" class="btn btn-default fa fa-edit fa-ca" data-toggle="tooltip" data-placement="bottom" title="Edit: not done"></a> &nbsp; <a onclick="hapusAnggaran('.$list->id.',4)" class="btn btn-default fa fa-trash-o fa-ca" data-toggle="tooltip" data-placement="bottom" title="Hapus"></a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7"></td>
                        </tr>
                       ';
        }

        $output .= '<tr>
                        <td colspan="5" class="text-right"><b>SUB TOTAL </b></td>
                        <td colspan="2"><b>Rp '.format_uang($total).'</b></td>
                    </tr>
                    <tr>
                        <td colspan="7"><b>Terbilang: </b><i>'.terbilang($total).' Rupiah<i></td>
                    </tr>
                    ';

        echo $output;

    }

    public function hapusanggaran($id) 
    {
        $anggaran = Anggaran::find($id);

        $anggaran->delete();
    }

    public function resume($id) {
        $person = PenelitianController::countPersonil();

        $temp = base64_decode($id);
        $stat = (Integer)substr($temp, 0, 1);
        $idprop = (Integer)substr($temp, 1, strlen($temp));

        $prop = Proposal::findOrFail($idprop);
        $peneliti = Penelitian::where('prosalid', $idprop)->first();
        $thn = $peneliti->tahun_ke;
        $ketua = Peneliti::select('sinta','nama','idpt','idfakultas','idprodi','hindex')->findOrFail($peneliti->ketuaid);
        $peserta = Peneliti::leftJoin('tb_keanggota', 'tb_keanggota.anggotaid', '=', 'tb_peneliti.id')
                                 ->where('tb_keanggota.idpenelitian', '=', $idprop)
                                 ->where('tb_keanggota.setuju', '<', 2)
                                 ->orderBy('peran', 'asc')
                                 ->get();
        $luarw = Luaran::select('idluaran','publish','urllink')->where('idpenelitian', $idprop)
                                 ->where('kategori', '1')->get();
        $luart = Luaran::select('idluaran','publish','urllink')->where('idpenelitian', $idprop)
                                 ->where('kategori', '2')->get();

        $hnr = Anggaran::where('proposalid', $idprop)->where('anggaranid', 1)->orderBy('id','asc')->get();
        $bhn = Anggaran::where('proposalid', $idprop)->where('anggaranid', 2)->orderBy('id','asc')->get();
        $jln = Anggaran::where('proposalid', $idprop)->where('anggaranid', 3)->orderBy('id','asc')->get();
        $brg = Anggaran::where('proposalid', $idprop)->where('anggaranid', 4)->orderBy('id','asc')->get();

        $thnr = 0;
        foreach ($hnr as $list) {
            $thnr += $list->volume * $list->biaya;
        }

        $tbhn = 0;
        foreach ($bhn as $list) {
            $tbhn += $list->volume * $list->biaya;
        }

        $tjln = 0;
        foreach ($jln as $list) {
            $tjln += $list->volume * $list->biaya;
        }

        $tbrg = 0;
        foreach ($brg as $list) {
            $tbrg += $list->volume * $list->biaya;
        }

        $mata = Mataanggaran::select('batas')->get();

        return view('penelitian.resume', compact('idprop','prop','thn','ketua','peserta','luarw','luart','hnr','bhn','jln','brg','person','thnr','tbhn','tjln','tbrg','mata','stat'));
    }

    public function baca($id) 
    {
        $person = PenelitianController::countPersonil();

        $idprop = base64_decode($id);
        $prop = Proposal::findOrFail($idprop);
        $peneliti = Penelitian::where('prosalid', $idprop)->first();
        $thn = $peneliti->tahun_ke;
        $ketua = Peneliti::select('sinta','nama','idpt','idfakultas','idprodi','hindex')->findOrFail($peneliti->ketuaid);
        $peserta = Peneliti::leftJoin('tb_keanggota', 'tb_keanggota.anggotaid', '=', 'tb_peneliti.id')
                                 ->where('tb_keanggota.idpenelitian', '=', $idprop)
                                 ->where('tb_keanggota.setuju', '<', 2)
                                 ->orderBy('peran', 'asc')
                                 ->get();
        $luarw = Luaran::select('idluaran','publish','urllink')->where('idpenelitian', $idprop)
                                 ->where('kategori', '1')->get();
        $luart = Luaran::select('idluaran','publish','urllink')->where('idpenelitian', $idprop)
                                 ->where('kategori', '2')->get();

        $hnr = Anggaran::where('proposalid', $idprop)->where('anggaranid', 1)->orderBy('id','asc')->get();
        $bhn = Anggaran::where('proposalid', $idprop)->where('anggaranid', 2)->orderBy('id','asc')->get();
        $jln = Anggaran::where('proposalid', $idprop)->where('anggaranid', 3)->orderBy('id','asc')->get();
        $brg = Anggaran::where('proposalid', $idprop)->where('anggaranid', 4)->orderBy('id','asc')->get();

        $thnr = 0;
        foreach ($hnr as $list) {
            $thnr += $list->volume * $list->biaya;
        }

        $tbhn = 0;
        foreach ($bhn as $list) {
            $tbhn += $list->volume * $list->biaya;
        }

        $tjln = 0;
        foreach ($jln as $list) {
            $tjln += $list->volume * $list->biaya;
        }

        $tbrg = 0;
        foreach ($brg as $list) {
            $tbrg += $list->volume * $list->biaya;
        }

        $mata = Mataanggaran::select('batas')->get();

        return view('penelitian.baca', compact('idprop','prop','thn','ketua','peserta','luarw','luart','hnr','bhn','jln','brg','person','thnr','tbhn','tjln','tbrg','mata'));
    }

    public function setuju($id) {
        $person = PenelitianController::countPersonil();

        $temp = base64_decode($id);
        $stat = (Integer)substr($temp, 0, 1);
        $idprop = (Integer)substr($temp, 1, strlen($temp));
         $idprop -= Auth::user()->id*3;

        $ketua    = Peneliti::select('tb_peneliti.id','nama','idfakultas','hindex','foto')
                             ->leftJoin('tb_penelitian', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
                             ->where('tb_penelitian.prosalid', $idprop)
                             ->first(); 
        $anggota  = Peneliti::select('tb_keanggota.id','anggotaid','nama','peran','tugas')
                             ->leftJoin('tb_keanggota', 'tb_keanggota.anggotaid', 'tb_peneliti.id')
                             ->where('tb_keanggota.anggotaid', Auth::user()->id)
                             ->where('tb_keanggota.idpenelitian', $idprop)
                             ->first();
        $proposal = Proposal::select('judul','idskema','idilmu')
                             ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
                             ->where('tb_penelitian.prosalid', $idprop)
                             ->first();
        $toteliti = Penelitian::leftJoin('tb_proposal', 'tb_penelitian.prosalid', 'tb_proposal.id')
                             ->where('tb_penelitian.ketuaid', $ketua->id)
                             ->where('tb_penelitian.status', '>', 0)
                             ->where('tb_proposal.jenis', '1')
                             ->count();
        $tempory  = Keanggotaan::leftJoin('tb_penelitian', 'tb_keanggota.idpenelitian', 'tb_penelitian.id')
                             ->leftJoin('tb_proposal', 'tb_penelitian.prosalid', 'tb_proposal.id')
                             ->where('tb_keanggota.anggotaid', $ketua->id)
                             ->where('tb_proposal.jenis', '1')
                             ->count();
        $toteliti += $tempory;

        $totabdi  = Penelitian::leftJoin('tb_proposal', 'tb_penelitian.prosalid', 'tb_proposal.id')
                             ->where('tb_penelitian.ketuaid', $ketua->id)
                             ->where('tb_penelitian.status', '>', 0)
                             ->where('tb_proposal.jenis', '2')
                             ->count();
        $tempory  = Keanggotaan::leftJoin('tb_penelitian', 'tb_keanggota.idpenelitian', 'tb_penelitian.id')
                             ->leftJoin('tb_proposal', 'tb_penelitian.prosalid', 'tb_proposal.id')
                             ->where('tb_keanggota.anggotaid', $ketua->id)
                             ->where('tb_proposal.jenis', '2')
                             ->count();
        $totabdi  += $tempory;
        
        return view('penelitian.persetujuan', compact('ketua','proposal','anggota','toteliti', 'totabdi','person'));
    }

    public function response(Request $request, $id) 
    {
        $temp = base64_decode($id) / Auth::user()->id;
        $stat = (Integer)substr($temp, 0, 1);
        $idprog = (Integer)substr($temp, 1, strlen($temp));

        $periode  = Periode::select('id')->where('aktif', '1')->orderBy('tahun', 'sesi', 'desc')->first();

        $ketua  = Penelitian::leftJoin('tb_proposal', 'tb_penelitian.prosalid', 'tb_proposal.id')
                           ->where('tb_penelitian.ketuaid', Auth::user()->id)
                           ->where('tb_proposal.periodeusul', $periode->id)
                           ->where('tb_proposal.jenis', '1')
                           ->count();

        $member = Keanggotaan::where('anggotaid', Auth::user()->id)->where('setuju', 1)->count(); 

        if (($ketua + $member) < 2) {
     
            $anggota = Keanggotaan::findOrFail($idprog);

            $anggota->setuju = $stat;
            $anggota->update();
        }

        $member = Keanggotaan::where('anggotaid', Auth::user()->id)->where('setuju', 1)->count();

        if (($ketua + $member) >= 2) {
            $anggota = Keanggotaan::where('anggotaid', Auth::user()->id)->where('setuju', 0)->get();
            foreach($anggota as $data) {
                $data->setuju = 2;
                $data->update();
            }
        }

        return Redirect::route('penelitian.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $idprop = base64_decode($id);

        $proposal = Proposal::find($idprop);

        $proposal->aktif = '1';
        $proposal->update();

        $penelitian = Penelitian::where('prosalid', $idprop)
                                ->where('ketuaid', Auth::user()->id)
                                ->where('status', 1)
                                ->first();

        $penelitian->status = 2;
        $penelitian->update();

        return Redirect::route('penelitian.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $peneliti = Keanggotaan::find($id);

        $peneliti->delete();
    }

    public function rangkuman($id) 
    {
        $person = PenelitianController::countPersonil();

        $temp = base64_decode($id);
        $stat = (Integer)substr($temp, 0, 1);
        $idprop = (Integer)substr($temp, 1, strlen($temp));

        $prop = Proposal::findOrFail($idprop);
        $peneliti = Penelitian::where('prosalid', $idprop)->first();
        $thn = $peneliti->tahun_ke;
        $ketua = Peneliti::select('sinta','nama','idpt','idfakultas','idprodi','hindex')->findOrFail($peneliti->ketuaid);
        $peserta = Peneliti::leftJoin('tb_keanggota', 'tb_keanggota.anggotaid', '=', 'tb_peneliti.id')
                                 ->where('tb_keanggota.idpenelitian', '=', $idprop)
                                 ->where('tb_keanggota.setuju', '<', 2)
                                 ->orderBy('peran', 'asc')
                                 ->get();
        $luarw = Luaran::select('idluaran','publish','urllink')->where('idpenelitian', $idprop)
                                 ->where('kategori', '1')->get();
        $luart = Luaran::select('idluaran','publish','urllink')->where('idpenelitian', $idprop)
                                 ->where('kategori', '2')->get();

        $hnr = Anggaran::where('proposalid', $idprop)->where('anggaranid', 1)->orderBy('id','asc')->get();
        $bhn = Anggaran::where('proposalid', $idprop)->where('anggaranid', 2)->orderBy('id','asc')->get();
        $jln = Anggaran::where('proposalid', $idprop)->where('anggaranid', 3)->orderBy('id','asc')->get();
        $brg = Anggaran::where('proposalid', $idprop)->where('anggaranid', 4)->orderBy('id','asc')->get();

        $thnr = 0;
        foreach ($hnr as $list) {
            $thnr += $list->volume * $list->biaya;
        }

        $tbhn = 0;
        foreach ($bhn as $list) {
            $tbhn += $list->volume * $list->biaya;
        }

        $tjln = 0;
        foreach ($jln as $list) {
            $tjln += $list->volume * $list->biaya;
        }

        $tbrg = 0;
        foreach ($brg as $list) {
            $tbrg += $list->volume * $list->biaya;
        }

        $mata = Mataanggaran::select('batas')->get();

        return view('penelitian.rangkuman', compact('idprop','prop','thn','ketua','peserta','luarw','luart','hnr','bhn','jln','brg','person','thnr','tbhn','tjln','tbrg','mata','stat'));
    }
}
