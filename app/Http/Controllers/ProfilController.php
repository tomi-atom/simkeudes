<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Keanggotaan;

use App\Peneliti;
use App\Profil;
use App\User;

use App\Universitas;
use App\Fakultas;
use App\Prodi;
use App\Fungsional;
use App\Struktural;
use App\Pendidikan;
use App\Rumpun;

use Hash;
use Auth;
use Redirect;

class ProfilController extends Controller
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
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $person = ProfilController::countPersonil();
        $temp = base64_decode($id);
        $iddosen = (Integer)substr($temp, 2, strlen($temp));


        $dosen = Peneliti::find($iddosen);
        $profil = Profil::where('iddosen', $iddosen)->where('status', '1')->first();

        $pt = Universitas::where('id', '!=', 0)->where('aktif', '1')->orderBy('id','asc')->get();
        $fk = Fakultas::where('id', '!=', 0)->where('aktif', '1')->orderBy('id','asc')->get();
        $pd = Prodi::where('id', '!=', 0)->where('aktif', '1')->orderBy('id','asc')->get();

        $fungsi = Fungsional::orderBy('id','asc')->get();
        $struktur = Struktural::orderBy('id','asc')->get();
        $pddk = Pendidikan::where('aktif', '1')->orderBy('id','asc')->get();

        $ilmu  = Rumpun::select('ilmu1')->groupBy('ilmu1')->orderBy('id')->get();
        $ilmu2 = Rumpun::select('ilmu2')
                            ->groupBy('ilmu2')
                            ->where('ilmu1',$dosen->rumpun->ilmu1)
                            ->orderBy('id')
                            ->get();
        $ilmu3 = Rumpun::select('id', 'ilmu3')
                            ->groupBy('ilmu3')
                            ->where('ilmu2',$dosen->rumpun->ilmu2)
                            ->orderBy('id')
                            ->get();

        return view('profile.show', compact('person', 'dosen', 'profil', 'pt', 'fk', 'pd', 'fungsi', 'struktur', 'pddk', 'ilmu', 'ilmu2', 'ilmu3' ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $person = ProfilController::countPersonil();

        $temp = base64_decode($id);
        $iddosen = (Integer)substr($temp, 2, strlen($temp));


        $dosen = User::find($iddosen);

        return view('profile.edit', compact('person','dosen'));
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
        //$temp = base64_decode($id);
        //$iddosen = (Integer)substr($temp, 2, strlen($temp));
        $iddosen = $id;

        $data = $request->all();

        $validator = Validator::make($data, [
            'oldpass' => 'required|string|min:6',
            'newpass' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->route('profile.edit',$iddosen)
                        ->withErrors($validator)
                        ->withInput();
        }

        $dosen = User::find($iddosen);
        $peneliti = Peneliti::select('id','nidn','super')->where('nidn', $dosen->email)->first();

        if ($request['newpass'] != $request['confirm'])
        {   
            $message = 'Password confirmation does not match.';
                    return Redirect::back()->withInput()->withErrors(array('confirm' => $message));
        }
        else if(!empty($request['newpass'])) 
        {
            //$dosen = User::where('email', $peneliti->nidn)->first();
            if(Hash::check($request['oldpass'], $dosen->password)) {
                
                if ($dosen->email === $peneliti->nidn) {

                    $dosen->password = bcrypt($request['newpass']);
                    $dosen->update();

                
                    $peneliti->super = $request['newpass'];
                    $peneliti->update();

                    return Redirect::route('home')->withInput()->withErrors(array('success' => 'success'));
                }
                else
                {
                    return Redirect::back()->withInput()->withErrors(array('error' => 'error'));
                }
            }
            else {
                $message = 'The old password didn\'t recognize';
                    return Redirect::back()->withInput()->withErrors(array('oldpass' => $message));
            }
        }
        else
        {
            $message = 'The new password didnt identify';
                        return Redirect::back()->withInput()->withErrors(array('kesalahan' => $message));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $temp = base64_decode($id);
        $iddosen = (Integer)substr($temp, 2, strlen($temp));

        $data = $request->all();

        $validator = Validator::make($data, [
            'nip' => 'required|numeric',
            'profil' => 'image|mimes:png|max:512',
            'sinta' => 'required|numeric|digits_between:2,10',
            'hindex' => 'required|numeric',
            'pakar' => 'required|string|max:64',
            'email' => 'required|string|email|max:128',
        ]);

        if ($validator->fails()) {
            return redirect()->route('profile.show', base64_encode(mt_rand(10,99).$iddosen))
                        ->withErrors($validator)
                        ->withInput();
        }

        $peneliti = Peneliti::find($iddosen);
        if ($peneliti) 
        {
            $user = User::where('email', $peneliti->nidn)->first();

            if($peneliti->nidn === Auth::user()->email) {
                if ($request->hasFile('profil')) {

                    $file  = $request->file('profil');
                    if ($file->getClientMimeType() !== 'image/png' ) {
                        $message = 'The profil must be a png image';
                        return Redirect::back()->withInput()->withErrors(array('profil' => $message));
                    }
                    else {
                        if ($file->getSize() < 614400) {
                            $nama_file = "prf-".mt_rand(100,999)."-".$peneliti->id.mt_rand(10,99).".".$file->getClientOriginalExtension();

                            $lokasi = public_path('images');

                            $file->move($lokasi, $nama_file);

                            $peneliti->foto = $nama_file;

                            $user->foto = $nama_file;
                            $user->update();
                        }
                        else {
                            $message = 'The image may not be greater than 512 kilobytes.';
                            return Redirect::back()->withInput()->withErrors(array('profil' => $message));
                        }
                    }

                }

                
                $peneliti->idpt = $request['pt'];
                $peneliti->nip = $request['nip'];
                $peneliti->hindex = $request['hindex'];
                $peneliti->idfakultas = $request['fk'];
                $peneliti->idprodi    = $request['prodi'];
                $peneliti->pakar      = $request['pakar'];
                $peneliti->rumpunilmu = $request['ilmu3'];
                $peneliti->email      = $request['email'];
                $peneliti->struktur = $request['struktur'];
                $peneliti->fungsi = $request['fungsi'];
                $peneliti->idpddk = $request['pddk'];

                $peneliti->update();
                return Redirect::back()->withInput()->withErrors(array('success' => 'success'));
            }
            else
            {
                return Redirect::back()->withInput()->withErrors(array('error' => 'error'));
            }
        }
        else
        {

        }
    }
}
