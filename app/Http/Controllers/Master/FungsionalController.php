<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Proposal;
use App\Keanggotaan;
use App\MataAnggaran;


use Auth;
use Redirect;

class FungsionalController extends Controller
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
    public function index(Request $request)
    {

        $select = $request->get('select');
        $_token = $request->get('_token');




        return view('master.fungsional.index');
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

        $anggaran = new MataAnggaran;

        $anggaran->jenis    = $request['jenis'];
        $anggaran->batas    = $request['batas'];
        $anggaran->aktif    = $request['aktif'];

        $anggaran->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $pagu = MataAnggaran::orderBy('id','asc')->get();

        $output =   '<thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-center" width="4%">No.</th>
                            <th scope="col" class="text-center" width="50%">Jenis</th>
                            <th scope="col" class="text-center" width="10%">Batas</th>
                            <th scope="col" class="text-center" width="10%">Aktif</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>';
        $output .= '<tbody>';
        $no = 0;
        $total = 0;
        foreach ($pagu as $list) {
            $no++;
            //$total += $list->volume*$list->biaya;
            $output .= '<tr>
                            <td class="text-center">'.$no.'</td>
                            <td>'.$list->jenis.'</td>
                            <td class="text-center">'.$list->batas.'</td>
                            <td class="text-center">'.$list->aktif.'</td>
                            <td class="text-center"><a onclick="editMataAnggaran('.$list->id.',1)" class="btn btn-default fa fa-edit fa-ca" data-toggle="tooltip" data-placement="bottom" title="Edit: not done"></a> &nbsp; <a onclick="hapusMataAnggaran('.$list->id.',1)" class="btn btn-default fa fa-trash-o fa-ca" data-toggle="tooltip" data-placement="bottom" title="Hapus"></a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7"></td>
                        </tr>
                       ';
        }

        echo $output;

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
        $where = array('id' => $id);
        $anggaran  = MataAnggaran::where($where)->first();

        return Response::json($anggaran);
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
    public function destroy( $id)
    {
        $anggaran = MataAnggaran::find($id);

        if ($anggaran)
            $anggaran->delete();
    }



    public function showhonor(Request $request)
    {
        $select = $request->get('select');
        $_token = $request->get('_token');

        $pagu = MataAnggaran::where('proposalid', $select)->where('anggaranid', 1)->orderBy('id','asc')->get();

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
                            <td class="text-center"><a onclick="editMataAnggaran('.$list->id.',1)" class="btn btn-default fa fa-edit fa-ca" data-toggle="tooltip" data-placement="bottom" title="Edit: not done"></a> &nbsp; <a onclick="hapusMataAnggaran('.$list->id.',1)" class="btn btn-default fa fa-trash-o fa-ca" data-toggle="tooltip" data-placement="bottom" title="Hapus"></a>
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

}
