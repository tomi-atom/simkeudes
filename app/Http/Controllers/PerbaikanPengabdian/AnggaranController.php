<?php

namespace App\Http\Controllers\PerbaikanPengabdian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Proposal;
use App\Keanggotaan;
use App\Anggaran;

use App\Mataanggaran;

use Auth;
use Redirect;

class AnggaranController extends Controller
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
        $person = AnggaranController::countPersonil();

        $idprop = base64_decode($id)-15;

        $skema  = Proposal::select('idskema')->find($idprop);
        $biaya  = Mataanggaran::where('aktif', '1')->get();

        $honor  = Anggaran::where('proposalid', $idprop)->where('anggaranid', 1)->orderBy('id','asc')->get();
        $bahan  = Anggaran::where('proposalid', $idprop)->where('anggaranid', 2)->orderBy('id','asc')->get();
        $jalan  = Anggaran::where('proposalid', $idprop)->where('anggaranid', 3)->orderBy('id','asc')->get();
        $barang = Anggaran::where('proposalid', $idprop)->where('anggaranid', 4)->orderBy('id','asc')->get();

        return view('perbaikanpengabdianng.anggaran.index', compact('idprop','skema','biaya','honor','bahan','jalan','barang','person'));
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
        $idanggaran =  $request['idanggaran'];

        $idprop = $request['id'];
        $idrab  = $request['belanja'];
        $volum  = $request['volume'];
        $harga  = $request['biaya']; 

        $skema  = Proposal::select('idskema')->find($idprop);
        $biaya  = Mataanggaran::select('batas')->find($idrab);
        $subtot = Anggaran::select('id','anggaranid','volume', 'biaya')->where('proposalid', $idprop)->get();
        $total  = 0;
        $grand  = 0;
        foreach ($subtot as $list) {
            if ($list->id != $idanggaran) {
                if ($list->anggaranid == $idrab)
                    $total += $list->volume * $list->biaya;

                $grand += $list->volume * $list->biaya;
            }
        }
        $total += $volum * $harga;
        $grand += $volum * $harga;

        if ($idanggaran != null){

            //$mataanggaran = Anggaran::findOrFail($idanggaran);

            if (($total <= ($biaya->batas*$skema->skema->dana/100)) && ($grand <= $skema->skema->dana)) {
                $biaya = Anggaran::findOrFail($idanggaran);

                $biaya->item       = $request['item'];
                $biaya->satuan     = $request['satuan'];
                $biaya->volume     = $request['volume'];
                $biaya->biaya      = $request['biaya'];

                $biaya->update();
            }
            else {
                echo decode("error");
            }


        }else {


            if (($total <= ($biaya->batas * $skema->skema->dana / 100)) && ($grand <= $skema->skema->dana)) {
                $biaya = new Anggaran;

                $biaya->idketua = Auth::user()->id;
                $biaya->proposalid = $request['id'];
                $biaya->anggaranid = $request['belanja'];
                $biaya->item = $request['item'];
                $biaya->satuan = $request['satuan'];
                $biaya->volume = $request['volume'];
                $biaya->biaya = $request['biaya'];

                $biaya->save();
            }
            else {
                echo decode("error");
            }
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
        $person = AnggaranController::countPersonil();

        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 2, strlen($temp)) / 2;

        $skema  = Proposal::select('idskema')->find($idprop);
        if($skema) {
            $biaya  = Mataanggaran::where('aktif', '1')->get();

            $honor  = Anggaran::where('proposalid', $idprop)->where('anggaranid', 1)->orderBy('id','asc')->get();
            $bahan  = Anggaran::where('proposalid', $idprop)->where('anggaranid', 2)->orderBy('id','asc')->get();
            $jalan  = Anggaran::where('proposalid', $idprop)->where('anggaranid', 3)->orderBy('id','asc')->get();
            $barang = Anggaran::where('proposalid', $idprop)->where('anggaranid', 4)->orderBy('id','asc')->get();

            return view('perbaikanpengabdianng.anggaran.show', compact('idprop','skema','biaya','honor','bahan','jalan','barang','person'));
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
        $anggaran = Anggaran::all()
            ->where('id', $id)
            ->first();
        try
        {
            return response()->json(['success' => 'successfull retrieve data 222', 'data' => $anggaran->toJson()], 200);
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
        $anggaran = Anggaran::find($id);

        if ($anggaran)
            $anggaran->delete();
    }

    public function showtotal(Request $request)
    {
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

    public function showhonor(Request $request)
    {
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
                            <td class="text-center"><a onclick="editAnggaran('.$list->id.',1)" class="btn btn-default fa fa-edit fa-ca" data-toggle="tooltip" data-placement="bottom" title="Revisi anggaran"></a> &nbsp; <a onclick="hapusAnggaran('.$list->id.',1)" class="btn btn-default fa fa-trash-o fa-ca" data-toggle="tooltip" data-placement="bottom" title="Hapus"></a>
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

    public function showbahan(Request $request) 
    {
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
                            <td class="text-center"><a onclick="editAnggaran('.$list->id.',2)" class="btn btn-default fa fa-edit fa-ca" data-toggle="tooltip" data-placement="bottom" title="Revisi anggaran"></a> &nbsp; <a onclick="hapusAnggaran('.$list->id.',2)" class="btn btn-default fa fa-trash-o fa-ca" data-toggle="tooltip" data-placement="bottom" title="Hapus"></a>
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

    public function showjalan(Request $request) 
    {
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
                            <td class="text-center"><a onclick="editAnggaran('.$list->id.',3)" class="btn btn-default fa fa-edit fa-ca" data-toggle="tooltip" data-placement="bottom" title="Revisi anggaran"></a> &nbsp; <a onclick="hapusAnggaran('.$list->id.',3)" class="btn btn-default fa fa-trash-o fa-ca" data-toggle="tooltip" data-placement="bottom" title="Hapus"></a>
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

    public function showbrng(Request $request) 
    {
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
                            <td class="text-center"><a onclick="editAnggaran('.$list->id.',4)" class="btn btn-default fa fa-edit fa-ca" data-toggle="tooltip" data-placement="bottom" title="Revisi anggaran"></a> &nbsp;&nbsp; 
                                                    <a onclick="hapusAnggaran('.$list->id.',4)" class="btn btn-default fa fa-trash-o fa-ca" data-toggle="tooltip" data-placement="bottom" title="Hapus"></a>
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
