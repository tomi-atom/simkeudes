<?php

namespace App\Http\Controllers\Master;

use App\Fakultas;
use App\Fungsional;
use App\Http\Controllers\ProfilController;
use App\Pendidikan;
use App\Peneliti;
use App\Dsperubahan;
use App\Prodi;
use App\Profil;
use App\Rumpun;
use App\Struktural;
use App\Universitas;
use App\User;
use App\Keanggotaan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use DB;
use App\Quotation;


use Auth;
use Redirect;

class PerubahanController extends Controller
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
        return view('master.perubahan.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       // $person = ProfilController::countPersonil();
        //$iddosen = $id;

        //$dosen = Peneliti::find($iddosen);
       // $profil = Profil::where('iddosen', $iddosen)->where('status', '1')->first();

        $pt = Universitas::where('id', '!=', 0)->where('aktif', '1')->orderBy('id','asc')->get();
        $fk = Fakultas::where('id', '!=', 0)->where('aktif', '1')->orderBy('id','asc')->get();
        $pd = Prodi::where('id', '!=', 0)->where('aktif', '1')->orderBy('id','asc')->get();

        $fungsi = Fungsional::orderBy('id','asc')->get();
        $struktur = Struktural::orderBy('id','asc')->get();
        $pddk = Pendidikan::where('aktif', '1')->orderBy('id','asc')->get();

        $ilmu  = Rumpun::select('ilmu1')->groupBy('ilmu1')->orderBy('id')->get();
        $ilmu2 = Rumpun::select('ilmu2')
            ->groupBy('ilmu2')
         //   ->where('ilmu1',$dosen->rumpun->ilmu1)
            ->orderBy('id')
            ->get();
        $ilmu3 = Rumpun::select('id', 'ilmu3')
            ->groupBy('ilmu3')
            //->where('ilmu2',$dosen->rumpun->ilmu2)
            ->orderBy('id')
            ->get();

        return view('master.perubahan.create', compact( 'pt', 'fk', 'pd', 'fungsi', 'struktur', 'pddk', 'ilmu', 'ilmu2', 'ilmu3' ));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)

    {
      //  $iddosen = $id;
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
            return redirect()->route('perubahan.create')
                ->withErrors($validator)
                ->withInput();
        }
        if ($request['newpass'] != $request['confirm'])
        {   
            $message = 'Password confirmation does not match.';
                    return Redirect::back()->withInput()->withErrors(array('confirm' => $message));
        }
    
        $peneliti = new Peneliti();
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

                    $peneliti->foto = $nama_file;
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
        

        $peneliti->nidn = $request['nidn'];
        $peneliti->sinta = $request['sinta'];
        $peneliti->nip = $request['nip'];
        $peneliti->nama = $request['nama'];
        $peneliti->email = $request['email'];
        $peneliti->struktur = $request['struktur'];
        $peneliti->fungsi = $request['fungsi'];
        $peneliti->idpddk = $request['pddk'];

        $peneliti->idpt = $request['pt'];
        $peneliti->idfakultas = $request['fk'];
        $peneliti->idprodi    = $request['prodi'];
        $peneliti->pakar      = $request['pakar'];
        $peneliti->hindex      = $request['hindex'];
        $peneliti->tanggungan      = '0';
        $peneliti->super      = '123456';
        $peneliti->rumpunilmu = $request['ilmu3'];
        $peneliti->email      = $request['email'];

        $peneliti->save();
        $user->save();
        return Redirect::route('perubahan.index')->withInput()->withErrors(array('success' => 'succes'));

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
            $peneliti = Dsperubahan::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'ds_perubahan.id', 'name','email','nip','sinta','idpddk','struktur','fungsi','hindex'])
            ->leftJoin('users','users.id','ds_perubahan.iddosen')
            ;
            //->groupBy('users.id');

            return DataTables::of($peneliti)
                ->addColumn('pendidikan', function($peneliti) {
                    $peneliti = Pendidikan::select('pendidikan')
                        ->where('id',$peneliti->idpddk)
                        ->first();
                    return $peneliti->pendidikan;
                })
                ->addColumn('struktural', function($peneliti) {
                    $peneliti = Struktural::select('struktural')
                        ->where('id',$peneliti->struktur)
                        ->first();
                    return $peneliti->struktural;
                })
                ->addColumn('fungsional', function($peneliti) {
                    $peneliti = Fungsional::select('fungsional')
                        ->where('id',$peneliti->fungsi)
                        ->first();
                    return $peneliti->fungsional;
                })
                ->addColumn('action', function ($peneliti) {
                    return ' 
                    <button id="' . $peneliti->id . '" class="btn btn-xs  verifikasi" ><i class="glyphicon glyphicon-ok-circle"></i> </button>
                    <button id="' . $peneliti->id . '" class="btn btn-xs  delete" ><i class="glyphicon glyphicon-remove-circle"></i> </button>
                    ';
                })
                ->rawColumns(['pendidikan','struktural','fungsional', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            dd($e->getMessage());
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
        $iddosen = (Integer)substr($temp, 2, strlen($temp));
        try
        {
            $person = PerubahanController::countPersonil();

            $dosen = User::find($iddosen);

            return view('master.perubahan.edit', compact('person','dosen'));
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
        
        try
        {
            $ds = Dsperubahan::find($id);

            if($ds) {
            
                $user = User::where('id',$ds->iddosen)->first();
                $peneliti = Peneliti::where('nidn',$user->email)->first();
                if($peneliti){
                    $peneliti->nip = $ds->nip;
                    $peneliti->sinta = $ds->sinta;
                    $peneliti->idpddk = $ds->idpddk;
                    $peneliti->struktur = $ds->struktur;
                    $peneliti->fungsi = $ds->fungsi;
                    $peneliti->hindex = $ds->hindex;
                    $peneliti->update();
                    $ds->delete();
                    
                } 
            }

            return response()->json(['success' => $user], 200);
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
        try
        {
            $dosen = Dsperubahan::find($id);

            $dosen->delete();
     
    
            return response()->json(['success' => 'data is successfully deleted'], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }




}
