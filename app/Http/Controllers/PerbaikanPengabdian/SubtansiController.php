<?php

namespace App\Http\Controllers\PerbaikanPengabdian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Keanggotaan;
use App\Substansi;

use Auth;
use Redirect;

class SubtansiController extends Controller
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
        $person = SubtansiController::countPersonil();
        $temp = base64_decode($id) - 127;

        $idtemp = $temp + 135;
        $proposalid = base64_encode(mt_rand(1,9).($temp + Auth::user()->id));

        return view('perbaikanpengabdianng.subtansi.index', compact('person','proposalid','idtemp'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
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

        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 1, strlen($temp)) - Auth::user()->id;
        
        $ceklog = Substansi::where('proposalid', $idprop)->count();
        
        if (!$ceklog) {
            $subtansi = new Substansi;

            $subtansi->proposalid = $idprop;
            $subtansi->ringkasan  = $request->get('ringkasan');
            $subtansi->katakunci  = $request->get('katakunci');
            $subtansi->lbelakang  = $request->get('lbelakang');
            $subtansi->literatur  = $request->get('literatur');
            $subtansi->metode     = $request->get('metode');
            $subtansi->jadwal     = $request->get('jadwal');
            $subtansi->pustaka    = $request->get('pustaka');
            $subtansi->iptek      = $request->get('iptek');
            $subtansi->peta       = $request->get('peta');
            $subtansi->unggah     = 'None';

            $subtansi->save();
        }
        else {

        }
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
    public function edit($iddosen, $id)
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
        //
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
            $output[] = $usulan->iptek;
            $output[] = $usulan->peta;

            return json_encode($output);
        }
        else
            return json_encode(0);
    }

    function perbaru(Request $request, $id) 
    {
        $_token= $request['_token'];

        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 1, strlen($temp)) - Auth::user()->id;

        $subtansi = Substansi::where('proposalid', $idprop)->first();
        
        if ($subtansi) {
            $subtansi->ringkasan  = $request['ringkasan'];
            $subtansi->katakunci  = $request['katakunci'];
            $subtansi->lbelakang  = $request['lbelakang'];
            $subtansi->literatur  = $request['literatur'];
            $subtansi->metode     = $request['metode'];
            $subtansi->jadwal     = $request['jadwal'];
            $subtansi->pustaka    = $request['pustaka'];
            $subtansi->iptek      = $request['iptek'];
            $subtansi->peta       = $request['peta'];

            $subtansi->update();
        }
    }
}
