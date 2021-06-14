<?php

namespace App\Http\Controllers\Pelaksanaan\LaporanAkhir;

use App\Fakultas;
use App\Keanggotaan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Proposal;
use App\Mahasiswa;

use App\Peneliti;
use App\Periode;

use Yajra\DataTables\Facades\DataTables;

use Auth;
use Redirect;

class MahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {

        $idx = $id;
        $data = explode("/", base64_decode($id));
        $proposalid = (Integer)$data[0];
        $idskemapro = (Integer)substr($data[1], 2, strlen($data[1]))-9;
        $fk = Fakultas::where('id', '!=', 0)->where('aktif', '1')->orderBy('id','asc')->get();


        return view('pelaksanaan.laporanakhir.mahasiswa.index', compact( 'proposalid', 'idskemapro', 'idx','fk'));
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

        $mahasiswa = new Mahasiswa;

        $mahasiswa->prosalid        = $request->get('propsid');
        $mahasiswa->nim        = $request->get('nim');
        $mahasiswa->nama        = $request->get('nama');
        $mahasiswa->fakultas       = $request->get('fk');
        $mahasiswa->jenis_kelamin = $request->get('jk');

        $mahasiswa->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($iddosen, $id)
    {

        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 2, strlen($temp)) / 2;

        $skema = Proposal::select('idskema')->find($idprop);
        $fk = Fakultas::where('id', '!=', 0)->where('aktif', '1')->orderBy('id','asc')->get();

        if ($skema) {
            $proposalid = $idprop;
            $idskemapro = $skema->idskema;
            $idx = base64_encode($proposalid."/".mt_rand(10,99).(9 + $idskemapro));

            return view('pelaksanaan.laporanakhir.mahasiswa.show', compact('person', 'proposalid', 'idskemapro', 'idx','fk'));
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
        $peneliti = Mahasiswa::find($id);

        $peneliti->delete();
    }

    public function loadmahasiswa($id)
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
                //->where('sinta', '!=', '')
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
                //->where('sinta', '!=', '')
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

    public function reloadmahasiswa(Request $request)
    {
        $select = $request->get('select');
        $_token = $request->get('_token');

        $peserta = Mahasiswa::where('prosalid', '=', $select)
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

    public function rincimahasiswa(Request $request)
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
