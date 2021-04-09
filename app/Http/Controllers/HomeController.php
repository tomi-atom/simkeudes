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

class HomeController extends Controller
{
    protected function countPersonil()
    {
        $personil = Keanggotaan::select('tb_proposal.id', 'anggotaid', 'jenis', 'nama', 'foto', 'tb_keanggota.created_at')
                        ->leftJoin('tb_penelitian', 'tb_keanggota.idpenelitian', 'tb_penelitian.prosalid')
                        ->leftJoin('tb_proposal', 'tb_penelitian.prosalid', 'tb_proposal.id')
                        ->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
                        ->where('tb_keanggota.anggotaid', Auth::user()->id)
                        ->where('tb_keanggota.setuju', 0)
                        ->where('tb_penelitian.status', '>', 0)
                        //->where('tb_proposal.aktif', '1')
                        ->get();
        return $personil;
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $person = HomeController::countPersonil();
        
        if (Auth::user()->level == 1)
            return view('home.dosen', compact('person'));
        elseif (Auth::user()->level == 2)
            return view('home.reviewer');
        elseif (Auth::user()->level == 3)
            return view('home.admin');
        elseif (Auth::user()->level == 4)
            return view('home.operator');

        //return view('home');
    }

    public function show($id)
    {
        $person = HomeController::countPersonil();

        if (Auth::user()->level == 1)
            return view('home.dosen', compact('person'));
        elseif (Auth::user()->level == 2)
            return view('home.reviewer');
        elseif (Auth::user()->level == 3)
            return view('home.admin');
        elseif (Auth::user()->level == 4)
            return view('home.operator');

    }
    public function error() 
    {
        $person = HomeController::countPersonil();

        return view('err123', compact('person'));
    }
    public function destroy($id)
    {
        $user = User::where('id', $id)->first();

        if($user->level == '1'){
            $user->level = '2';
            $user->update();

            //return response()->json(['success' => 'success verifikasi data'], 200);
        }elseif ($user->level == '2'){
            $user->level = '1';
            $user->update();
            //return response()->json(['success' => 'success verifikasi data'], 200);
        }
        else {
            // Error
            $message = 'Data Tidak bisa diubah..';
            //return Redirect::back()->withInput()->withErrors(array('kesalahan' => $message));
        }
    }
    public function gantiperan($id)
    {
        $user = User::where('id', $id)->first();

        if($user->level == '1'){
            $user->level = '2';
            $user->update();
            return Redirect::back();
            //return response()->json(['success' => 'success verifikasi data'], 200);
        }elseif ($user->level == '2'){
            $user->level = '1';
            $user->update();
            return Redirect::back();
            //return response()->json(['success' => 'success verifikasi data'], 200);
        }
        else {
            // Error
            $message = 'Data Tidak bisa diubah..';
            return Redirect::back();
            //return Redirect::back()->withInput()->withErrors(array('kesalahan' => $message));
        }
    }

}
