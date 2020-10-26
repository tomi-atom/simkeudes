<?php

namespace App\Http\Controllers\Pengabdian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Keanggotaan;
use App\Luaran;

use App\Keluaran;

use Auth;
use Redirect;

class LuaranController extends Controller
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
        $person = LuaranController::countPersonil();

        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 1, strlen($temp)) - Auth::user()->id;

        $jenis = Keluaran::groupBy('jenis')->orderBy('id')->get();

        return view('pengabdianng.luaran.index', compact( 'person', 'jenis', 'idprop'));
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
        $jurnal  = $request['jurnal'] ? $request['jurnal'] : '';
        $linkurl = $request['linkurl'] ? $request['linkurl'] : '';

        $peneliti = new Luaran;
        $peneliti->idketua      = Auth::user()->id;
        $peneliti->idpenelitian = $request['id'];
        $peneliti->idluaran     = $request['target'];
        $peneliti->kategori     = $request['kategori'];
        $peneliti->publish      = $jurnal;
        $peneliti->urllink      = $linkurl;
        $peneliti->status       = '1';
        
        $peneliti->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($iddosen, $id)
    {
        $person = LuaranController::countPersonil();

        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 2, strlen($temp)) / 2;

        $luaran = Luaran::where('idpenelitian', $idprop)->count(); 

        if($luaran)
        {
            $jenis = Keluaran::groupBy('jenis')->orderBy('id')->get();
            return view('pengabdianng.luaran.show', compact( 'person', 'jenis', 'idprop'));
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
    public function destroy($iddosen, $id)
    {
        $luaran = Luaran::find($id);

        if ($luaran) {
            $luaran->delete();

            return 1;
        }
    }

    public function luaranwajib(Request $request) 
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

    public function luarantambah(Request $request) 
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

    public function loadtarget(Request $request)
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
}
