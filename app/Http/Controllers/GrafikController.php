<?php

namespace App\Http\Controllers;

use App\Fakultas;
use App\Fungsional;
use App\Pendidikan;
use App\Peneliti;
use App\Prodi;
use App\Profil;
use App\Reviewer;
use App\Rumpun;
use App\Struktural;
use App\Universitas;
use App\User;
use Illuminate\Http\Request;
use Auth;

use App\Keanggotaan;
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
        return view('grafik.index');
        //return view('home');
    }
    public function chart()
    {
        $result = \DB::table('tb_proposal')
            ->get();
        return response()->json($result);
    }


}
