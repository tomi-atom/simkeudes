<?php

namespace App\Http\Controllers\Reviewer\Pelaksanaan;

use App\CatatanHarian;
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
        $temp = base64_decode($id);
        $prosalid = CatatanHarian::select('prosalid')->where('id', $temp)->first();

        $idtemp = $temp ;
        $proposalid = base64_encode(mt_rand(1,9).($temp + Auth::user()->id));

        return view('reviewer.pelaksanaan.subtansi.index', compact('person','proposalid','prosalid','idtemp'));
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
     * @return \Illuminate\Http\ResponseLOCA
     */
    public function store($id, Request $request)
    {
        $_token = $request->get('_token');

        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 1, strlen($temp)) - Auth::user()->id;
        
        $ceklog = Substansi::where('proposalid', $idprop)->count();
        
        if ($request->get('ringkasan')) {
            $subtansi = new CatatanHarian();

            $subtansi->prosalid = 13;
            $subtansi->status  = 4;
            $subtansi->upload  = $request->get('ringkasan');

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
        $person = SubtansiController::countPersonil();
        $temp = base64_decode($id);
        $prosalid = CatatanHarian::select('prosalid')->where('id', $temp)->first();

        $idtemp = $temp ;
        $proposalid = base64_encode(mt_rand(1,9).($temp + Auth::user()->id));

        return view('reviewer.pelaksanaan.subtansi.show', compact('person','proposalid','prosalid','idtemp'));

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
    public function update(Request $request, $id)
    {
        $_token= $request['_token'];

        $temp = base64_decode($id);
        try
        {

            //$subtansi = CatatanHarian::where('id', $temp)->first();
            //echo $subtansi;

            $subtansi = CatatanHarian::where('id', $id)->first();

            if ($request['ringkasan'] && $subtansi) {
                $subtansi->upload  = $request['ringkasan'];

                $subtansi->update();

                return Redirect::back()->withInput()->withErrors(array('success' => 'success'));


            }else{
                return Redirect::back()->withInput()->withErrors(array('error' =>'error'));


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
        //
    }

    public function getusulan($id)
    {
        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 1, strlen($temp)) - Auth::user()->id;

        $usulan = CatatanHarian::where('id', $temp)->first();

        if(count($usulan) == 1) {
            $output = array();

            $output[] = $usulan->upload;


            return json_encode($output);
        }
        else
            return json_encode(0);
    }

    function perbaru(Request $request, $id) 
    {
        $_token= $request['_token'];

        $temp = base64_decode($id);
        try
        {

            $subtansi = CatatanHarian::where('id', $temp)->first();

            if ($request['ringkasan']) {
                $subtansi->upload  = $request['ringkasan'];

                $subtansi->update();
                echo $temp;
            }else{

            }


        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }
}
