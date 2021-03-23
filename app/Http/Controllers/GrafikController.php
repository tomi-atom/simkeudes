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

        $none = Penelitian::select('tb_penelitian.id')->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
            ->where('tb_penelitian.thnkerja','2020')->where('tb_peneliti.idfakultas','0')->get();
        $cnone = count($none);

        $mipa = Penelitian::select('tb_penelitian.id')->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
            ->where('tb_penelitian.thnkerja','2020')->where('tb_peneliti.idfakultas','1')->get();
        $cmipa = count($mipa);

        $ft = Penelitian::select('tb_penelitian.id')->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
            ->where('tb_penelitian.thnkerja','2020')->where('tb_peneliti.idfakultas','2')->get();
        $cft = count($ft);

        $feb = Penelitian::select('tb_penelitian.id')->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
            ->where('tb_penelitian.thnkerja','2020')->where('tb_peneliti.idfakultas','3')->get();
        $cfeb = count($feb);

        $fisip = Penelitian::select('tb_penelitian.id')->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
            ->where('tb_penelitian.thnkerja','2020')->where('tb_peneliti.idfakultas','4')->get();
        $cfisip = count($fisip);

        $faperika = Penelitian::select('tb_penelitian.id')->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
            ->where('tb_penelitian.thnkerja','2020')->where('tb_peneliti.idfakultas','5')->get();
        $cfaperika = count($faperika);

        $fkip = Penelitian::select('tb_penelitian.id')->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
            ->where('tb_penelitian.thnkerja','2020')->where('tb_peneliti.idfakultas','6')->get();
        $cfkip = count($fkip);

        $faperta = Penelitian::select('tb_penelitian.id')->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
            ->where('tb_penelitian.thnkerja','2020')->where('tb_peneliti.idfakultas','7')->get();
        $cfaperta = count($faperta);

        $fk = Penelitian::select('tb_penelitian.id')->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
            ->where('tb_penelitian.thnkerja','2020')->where('tb_peneliti.idfakultas','8')->get();
        $cfk = count($fk);

        $keperawatan = Penelitian::select('tb_penelitian.id')->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
            ->where('tb_penelitian.thnkerja','2020')->where('tb_peneliti.idfakultas','9')->get();
        $ckeperawatan = count($keperawatan);


        $none21 = Penelitian::select('tb_penelitian.id')->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
            ->where('tb_penelitian.thnkerja','2021')->where('tb_peneliti.idfakultas','0')->get();
        $cnone21 = count($none21);

        $mipa21 = Penelitian::select('tb_penelitian.id')->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
            ->where('tb_penelitian.thnkerja','2021')->where('tb_peneliti.idfakultas','1')->get();
        $cmipa21 = count($mipa21);

        $ft21 = Penelitian::select('tb_penelitian.id')->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
            ->where('tb_penelitian.thnkerja','2021')->where('tb_peneliti.idfakultas','2')->get();
        $cft21 = count($ft21);

        $feb21 = Penelitian::select('tb_penelitian.id')->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
            ->where('tb_penelitian.thnkerja','2021')->where('tb_peneliti.idfakultas','3')->get();
        $cfeb21 = count($feb21);

        $fisip21 = Penelitian::select('tb_penelitian.id')->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
            ->where('tb_penelitian.thnkerja','2021')->where('tb_peneliti.idfakultas','4')->get();
        $cfisip21 = count($fisip21);

        $faperika21 = Penelitian::select('tb_penelitian.id')->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
            ->where('tb_penelitian.thnkerja','2021')->where('tb_peneliti.idfakultas','5')->get();
        $cfaperika21 = count($faperika21);

        $fkip21 = Penelitian::select('tb_penelitian.id')->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
            ->where('tb_penelitian.thnkerja','2021')->where('tb_peneliti.idfakultas','6')->get();
        $cfkip21 = count($fkip21);

        $faperta21 = Penelitian::select('tb_penelitian.id')->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
            ->where('tb_penelitian.thnkerja','2021')->where('tb_peneliti.idfakultas','7')->get();
        $cfaperta21 = count($faperta21);

        $fk21 = Penelitian::select('tb_penelitian.id')->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
            ->where('tb_penelitian.thnkerja','2021')->where('tb_peneliti.idfakultas','8')->get();
        $cfk21 = count($fk21);

        $keperawatan21 = Penelitian::select('tb_penelitian.id')->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
            ->where('tb_penelitian.thnkerja','2021')->where('tb_peneliti.idfakultas','9')->get();
        $ckeperawatan21 = count($keperawatan21);





        return view('grafik.index',compact('cnone','cmipa','cft','cfeb','cfisip','cfaperika','cfkip','cfaperta','cfk','ckeperawatan','cnone21','cmipa21','cft21','cfeb21','cfisip21','cfaperika21','cfkip21','cfaperta21','cfk21','ckeperawatan21'));

        /*
         *
         * $cpro = Array();
        foreach ($periode as $p){
            $proposal = Proposal::select('judul')->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')->where('tb_penelitian.thnkerja',$p->tahun)->get();
            $cpro = count($proposal);
        }
         * $population = Penelitian::select(
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
