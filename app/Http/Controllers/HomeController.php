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

        return view('home.admin');

    }

    public function show($id)
    {

        return view('home.admin');

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
