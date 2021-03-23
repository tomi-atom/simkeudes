<?php

namespace App\Http\Controllers;

use App\Fakultas;
use App\Fungsional;
use App\Pendidikan;
use App\Peneliti;
use App\Penelitian;
use App\Periode;
use App\Prodi;
use App\Profil;
use App\Proposal;
use App\Reviewer;
use App\Rumpun;
use App\Struktural;
use App\Universitas;
use App\User;
use Illuminate\Http\Request;
use Auth;

use App\Keanggotaan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class GrafikController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periode  = Periode::orderBy('tahun', 'desc')->groupBy('tahun')->get();

        $cpro = Array();
        foreach ($periode as $p){
            $proposal = Proposal::select('judul')->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')->where('tb_penelitian.thnkerja',$p->tahun)->get();
            $cpro = count($proposal);
        }

        return view('grafik.index',compact('cpro',$periode));

        /*
         *  $population = Penelitian::select(
            DB::raw("year(thnkerja) as year"),
            DB::raw("SUM(id) as bears"),
            DB::raw("SUM(id) as dolphins"))
            ->orderBy(DB::raw("YEAR(created_at)"))
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->get();

        $res[] = ['Year', 'bears', 'dolphins'];
        foreach ($population as $key => $val) {
            $res[++$key] = [$val->year, (int)$val->bears, (int)$val->dolphins];
        }

        return view('grafik.index')
            ->with('population', json_encode($res));
         */
        //return view('home');
    }
    public function chart()
    {
        $result = \DB::table('tb_proposal')
            ->get();
        return response()->json($result);
    }


}
