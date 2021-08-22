<?php

namespace App\Http\Controllers;

use App\Pekerjaan;
use App\Pendidikan;
use App\Profil;

use App\Shdk;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use DB;
use App\Quotation;


use Auth;
use Redirect;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $pekerjaan = Pekerjaan::orderBy('id','asc')->get();
        $pendidikan = Pendidikan::orderBy('id','asc')->get();
        $shdk = Shdk::orderBy('id','asc')->get();


        return view('user.create', compact( 'pekerjaan', 'pendidikan', 'shdk' ));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)

    {
      //  $iduser = $id;
        $data = $request->all();

        $validator = Validator::make($data, [
            'nip' => 'required|numeric|digits:18',
            'profil' => 'image|mimes:png|max:512',
            'sinta' => 'required|numeric|digits_between:2,10',
            'hindex' => 'required|numeric|min:1',
            'pakar' => 'required|string|max:64',
            'email' => 'required|string|email|max:128',
            'newpass' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.create')
                ->withErrors($validator)
                ->withInput();
        }
        if ($request['newpass'] != $request['confirm'])
        {   
            $message = 'Password confirmation does not match.';
                    return Redirect::back()->withInput()->withErrors(array('confirm' => $message));
        }
    
        $user = new user();
        $user = new User();
        

        if ($request->hasFile('profil')) {

            $file  = $request->file('profil');
            if ($file->getClientMimeType() !== 'image/png' ) {
                $message = 'The profil must be a png image';
                return Redirect::back()->withInput()->withErrors(array('profil' => $message));
            }
            else {
                if ($file->getSize() < 614400) {
                    $nama_file = "prf-".mt_rand(100,999)."-".$request['nama'].mt_rand(10,99).".".$file->getClientOriginalExtension();

                    $lokasi = public_path('images');

                    $file->move($lokasi, $nama_file);

                    $user->foto = $nama_file;
                    $user->foto = $nama_file;
                  //  $user->save();
                }
                else {
                    $message = 'The image may not be greater than 512 kilobytes.';
                    return Redirect::back()->withInput()->withErrors(array('profil' => $message));
                }
            }

        }
        $checknidn = User::select('id')->where('email',$request->nidn)->first();
        
        if($checknidn){
            $message = 'Nidn Telah Digunakan.';
            return Redirect::back()->withInput()->withErrors(array('nidn' => $message));
        }
        

        $user->level = '1';
        $user->name = $request['nama'];
        $user->email = $request['nidn'];
        $user->password =  bcrypt($request['newpass']);
        

        $user->nidn = $request['nidn'];
        $user->sinta = $request['sinta'];
        $user->nip = $request['nip'];
        $user->nama = $request['nama'];
        $user->email = $request['email'];
        $user->struktur = $request['struktur'];
        $user->fungsi = $request['fungsi'];
        $user->idpddk = $request['pddk'];

        $user->idpt = $request['pt'];
        $user->idfakultas = $request['fk'];
        $user->idprodi    = $request['prodi'];
        $user->pakar      = $request['pakar'];
        $user->hindex      = $request['hindex'];
        $user->tanggungan      = '0';
        $user->super      = '123456';
        $user->rumpunilmu = $request['ilmu3'];
        $user->email      = $request['email'];

        $user->save();
        $user->save();
        return Redirect::route('user.index')->withInput()->withErrors(array('success' => 'succes'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getRowNum()
    {
        return view('datatables.eloquent.rownum');
    }
    public function show()
    {
        try
        {
            DB::statement(DB::raw('set @rownum=0'));
            $user = User::orderBy('id')->where('level','!=',1);

            return DataTables::of($user)
                ->addColumn('lahir', function ($user) {

                    return '<small">'.$user->tempat_lahir.' - '.$user->tanggal_lahir.'</small>';
                })
                ->addColumn('status', function ($user) {

                    if ($user->status == 1){
                        return '<small class="label label-success">Aktif</small>';
                    }
                    else{

                        return '<small class="label label-danger">Tidak Aktif</small>';

                    }
                })
                ->addColumn('action', function ($user) {
                    return ' <a  href="'. route('user.resume',base64_encode(mt_rand(10,99).$user->id) ).'" class="btn btn-xs  title="Edit Profil"><i class="glyphicon glyphicon-edit"></i> </a>
                    <a  href="'. route('user.edit',base64_encode(mt_rand(10,99).$user->id) ).'" class="btn btn-xs  title="Reset Password"><i class="glyphicon glyphicon-retweet"></i> </a>
                    <button id="' . $user->id . '" class="btn btn-xs  delete" ><i class="glyphicon glyphicon-trash"></i> </button>';
                })
                ->rawColumns(['lahir','status', 'action'])

                ->make(true);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }

    public function resume($id)
    {
        $person = UserController::countPersonil();
        $temp = base64_decode($id);
        $iduser = (Integer)substr($temp, 2, strlen($temp));
        //$iduser = (Integer)substr($temp, 2, strlen($temp));
       
       // $nidn = User::select('email')->where('id',$iduser)->first();

        $user = user::all()->where('id',$iduser)->first();
        //$profil = Profil::where('iduser', $iduser)->where('status', '1')->first();

        $pt = Universitas::where('id', '!=', 0)->where('aktif', '1')->orderBy('id','asc')->get();
        $fk = Fakultas::where('id', '!=', 0)->where('aktif', '1')->orderBy('id','asc')->get();
        $pd = Prodi::where('id', '!=', 0)->where('aktif', '1')->orderBy('id','asc')->get();

        $fungsi = Fungsional::orderBy('id','asc')->get();
        $struktur = Struktural::orderBy('id','asc')->get();
        $pddk = Pendidikan::where('aktif', '1')->orderBy('id','asc')->get();

        $ilmu  = Rumpun::select('ilmu1')->groupBy('ilmu1')->orderBy('id')->get();
        $ilmu2 = Rumpun::select('ilmu2')
                            ->groupBy('ilmu2')
                            ->where('ilmu1',$user->rumpun->ilmu1)
                            ->orderBy('id')
                            ->get();
    
        $ilmu3 = Rumpun::select('id', 'ilmu3')
                            ->groupBy('ilmu3')
                            ->where('ilmu2',$user->rumpun->ilmu2)
                            ->orderBy('id')
                            ->get();

        return view('user.show', compact('iduser','person', 'user', 'pt', 'fk', 'pd', 'fungsi', 'struktur', 'pddk', 'ilmu', 'ilmu2', 'ilmu3' ));
 
    }
    public function reset(Request $request,$id)
    {
        $temp = base64_decode($id);
        $iduser = (Integer)substr($temp, 2, strlen($temp));

        $data = $request->all();

        $validator = Validator::make($data, [
            'newpass' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return  Redirect::back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = User::find($iduser);

        if ($request['newpass'] != $request['confirm'])
        {   
            $message = 'Password confirmation does not match.';
                    return Redirect::back()->withInput()->withErrors(array('confirm' => $message));
        }
        else if(!empty($request['newpass'])) 
        {
            $user = user::where('nidn', $user->email)->first();
            if ($user->nidn === $user->email) {

                $user->password = bcrypt($request['newpass']);
                $user->update();

            
                $user->super = $request['newpass'];
                $user->update();

                return Redirect::route('user.index')->withInput()->withErrors(array('success' => 'success'));
            }
            else
            {
                return Redirect::back()->withInput()->withErrors(array('error' => 'error'));
            }
        }
        else
        {
            $message = 'The new password didnt identify';
                        return Redirect::back()->withInput()->withErrors(array('kesalahan' => $message));
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
        $temp = base64_decode($id);
        $iduser = (Integer)substr($temp, 2, strlen($temp));
        try
        {
            $person = UserController::countPersonil();

            $user = User::find($iduser);

            return view('user.edit', compact('person','user'));
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
        $temp = base64_decode($id);
        $iduser = (Integer)substr($temp, 2, strlen($temp));

        $data = $request->all();

        $validator = Validator::make($data, [
            'nip' => 'required|numeric|digits:18',
            'profil' => 'image|mimes:png|max:512',
            'sinta' => 'required|numeric|digits_between:2,10',
            'hindex' => 'required|numeric|min:1',
            'pakar' => 'required|string|max:64',
            'email' => 'required|string|email|max:128',
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.resume', base64_encode(mt_rand(10,99).$iduser))
                        ->withErrors($validator)
                        ->withInput();
        }
        $checknidn = User::select('id')->where('email',$request->nidn)
            ->where('id','!=',$iduser)->first();
        
        if($checknidn){
            $message = 'Nidn Telah Digunakan.';
            return Redirect::back()->withInput()->withErrors(array('nidn' => $message));
        }

        $user = User::find($iduser);
        $user = user::all()->where('nidn',$user->email)->first();

        if($user) {
            if ($request->hasFile('profil')) {

                $file  = $request->file('profil');
                if ($file->getClientMimeType() !== 'image/png' ) {
                    $message = 'The profil must be a png image';
                    return Redirect::back()->withInput()->withErrors(array('profil' => $message));
                }
                else {
                    if ($file->getSize() < 614400) {
                        $nama_file = "prf-".mt_rand(100,999)."-".$user->id.mt_rand(10,99).".".$file->getClientOriginalExtension();

                        $lokasi = public_path('images');

                        $file->move($lokasi, $nama_file);

                        $user->foto = $nama_file;

                        $user->foto = $nama_file;
                        $user->update();
                    }
                    else {
                        $message = 'The image may not be greater than 512 kilobytes.';
                        return Redirect::back()->withInput()->withErrors(array('profil' => $message));
                    }
                }

            }

            
            $user->nidn = $request['nidn'];
            $user->sinta = $request['sinta'];
            $user->nip = $request['nip'];
            $user->nama = $request['nama'];
            $user->email = $request['email'];
            $user->struktur = $request['struktur'];
            $user->fungsi = $request['fungsi'];
            $user->idpddk = $request['pddk'];
    
            $user->idpt = $request['pt'];
            $user->idfakultas = $request['fk'];
            $user->idprodi    = $request['prodi'];
            $user->pakar      = $request['pakar'];
            $user->hindex      = $request['hindex'];

            $user->rumpunilmu = $request['ilmu3'];
            $user->email      = $request['email'];
    

            $user->update();
            return Redirect::route('user.index')->withInput()->withErrors(array('success' => 'success'));

        }
        else
        {
            return Redirect::back()->withInput()->withErrors(array('error' => 'error'));
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
        try
        {
            $user = User::find($id);

            $user->delete();

    
            return response()->json(['success' => 'data is successfully deleted'], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }




}
