<?php

namespace App\Http\Controllers\Admin\Penilaian;

use App\Fakultas;
use App\Fungsional;
use App\Http\Controllers\Admin\UsulanController;
use App\Http\Controllers\ProfilController;
use App\Keanggotaan;
use App\Pendidikan;
use App\Peneliti;
use App\Periode;
use App\Posisi;
use App\Prodi;
use App\Profil;
use App\Proposal;
use App\Reviewer;
use App\Rumpun;
use App\Struktural;
use App\Universitas;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use DB;
use App\Quotation;


use Auth;
use Redirect;

class ReviewerController extends Controller
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
    public function index()
    {
        $person = ReviewerController::countPersonil();

        $peneliti = Peneliti::select('id','hindex','sinta','status','tanggungan')->find(Auth::user()->id);
        $periodeterbaru  = Periode::orderBy('tahun', 'desc')->orderBy('sesi', 'desc')->first();
        $periode  = Periode::orderBy('tahun', 'desc')->orderBy('sesi', 'desc')->where('id','!=',$periodeterbaru->id)->get();

        $proposal = Proposal::select('judul','idprogram','idskema','periodeusul','idfokus','aktif','thnkerja','status','prosalid')
            ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
            ->where('tb_proposal.periodeusul',$periode[0]->id)
            ->where('tb_penelitian.ketuaid', $peneliti->id)
            ->where('tb_penelitian.status', '>', 0)
            ->where('tb_proposal.jenis', 1)
            ->get();

        $peserta = Proposal::select('judul','idprogram','idskema','periodeusul','idfokus','thnkerja','status','prosalid','peran','setuju')
            ->leftJoin('tb_keanggota', 'tb_proposal.id', 'tb_keanggota.idpenelitian')
            ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
            ->where('tb_proposal.periodeusul',$periode[0]->id)
            ->where('tb_keanggota.anggotaid', $peneliti->id)
            ->where('tb_penelitian.status', '>', 0)
            ->where('tb_keanggota.setuju', '<', 2)
            ->where('tb_proposal.jenis', 1)
            ->where('tb_proposal.aktif', '1')
            ->orderBy('tb_keanggota.peran', 'asc')
            ->get();

        $minat =  Proposal::leftJoin('tb_keanggota', 'tb_proposal.id', 'tb_keanggota.idpenelitian')
            ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
            ->where('tb_proposal.periodeusul',$periode[0]->id)
            ->where('tb_penelitian.ketuaid', $peneliti->id)
            ->where('tb_penelitian.status', '>', 0)
            ->where('tb_keanggota.setuju', 0)
            ->where('tb_proposal.jenis', 1)
            ->where('tb_proposal.aktif', '1')
            ->count();

        $status = Posisi::select('jenis')->where('aktif', '1')->orderBy('id','asc')->get(); //*temp

        $member = Keanggotaan::leftJoin('tb_proposal', 'tb_keanggota.idpenelitian', 'tb_proposal.id')
            ->where('tb_keanggota.anggotaid', Auth::user()->id)
            ->where('tb_keanggota.setuju', 1)
            ->where('tb_proposal.jenis', 1)
            ->count();

        $ketua   = count($proposal);
        $total   = $ketua + count($peserta);


        $skema = DB::table('adm_skema')
            ->select('id','skema')
            ->groupBy('skema')
            ->orderBy('id', 'ASC')
            ->get();


        return view('admin.penilaian.reviewer.index', compact('skema','person', 'peneliti', 'periode','periodeterbaru', 'proposal', 'total','ketua','peserta','member', 'status', 'minat'));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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

        return view('admin.penilaian.reviewer.create', compact( 'pt', 'fk', 'pd', 'fungsi', 'struktur', 'pddk', 'ilmu', 'ilmu2', 'ilmu3' ));

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
        ]);

        if ($validator->fails()) {
            return redirect()->route('dosen.create')
                ->withErrors($validator)
                ->withInput();
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
                   // $user->foto = $nama_file;
                  //  $user->save();
                }
                else {
                    $message = 'The image may not be greater than 512 kilobytes.';
                    return Redirect::back()->withInput()->withErrors(array('profil' => $message));
                }
            }

        }

        //$user->level = '1';
       // $user->name = $request['nama'];
        //$user->email = $request['email'];
       /// $user->password = $request['password'];

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
        return response()->json(['success' => 'data is successfully updated'], 200);
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
               $peneliti = User::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'tb_reviewer.id', 'name','nidn','tb_reviewer.periode','tb_reviewer.jenis'])
                ->leftJoin('tb_reviewer', 'tb_reviewer.iddosen', 'users.id')
                //->leftJoin('adm_periode', 'tb_reviewer.periode', 'adm_periode.id')
               // ->where('adm_periode.aktif','0')
                ->where('users.level', '!=','3')
                ->groupBy('tb_reviewer.id')
            ;


            return DataTables::of($peneliti)

                ->addColumn('periode', function($peneliti) {
                    $periode = Periode::where('id', $peneliti->periode)->first();
                    return '<td class="text-left">' .$periode->tahun. '</td>';

                })
                ->addColumn('jenis', function ($peneliti) {
                    if ($peneliti->jenis == 1){
                        return ' <small class="label label-info">Penelitian</small>';
                    }elseif($peneliti->jenis == 2){
                        return '<small class="label label-warning">Pengabdian</small>';
                    }else{
                        return '<small class="label label-info">Penelitian</small><br><small class="label label-warning">Pengabdian</small>';
                    }
                })
                ->addColumn('action', function ($peneliti) {


                    return '
                     <button id="' . $peneliti->id . '" class="btn btn-xs  delete" ><i class="glyphicon glyphicon-trash"></i> </button> 
                    ';
                })
                ->rawColumns(['jenis','periode','action'])
                ->make(true);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }

    public function show1()
    {
        try
        {
            DB::statement(DB::raw('set @rownum=0'));
            $peneliti = Reviewer::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'tb_reviewer.id', 'name','nidn','tb_reviewer.periode','tb_reviewer.jenis'])
                ->leftJoin('users', 'tb_reviewer.iddosen', 'users.id')
                ->leftJoin('adm_periode', 'tb_reviewer.periode', 'adm_periode.id')
               // ->where('adm_periode.aktif','0')
                ->where('users.level', '!=','3')
                //->orderBy('level','DESC')
            ;


            return DataTables::of($peneliti)

                ->addColumn('periode', function($peneliti) {
                    $periode = Periode::where('id', $peneliti->periode)->first();
                    return '<td class="text-left">' .$periode->tahun. '</td>';

                })
                ->addColumn('jenis', function ($peneliti) {
                    if ($peneliti->jenis == 1){
                        return ' <small class="label label-info">Penelitian</small>';
                    }elseif($peneliti->jenis == 2){
                        return '<small class="label label-warning">Pengabdian</small>';
                    }else{
                        return '<small class="label label-info">Penelitian</small><br><small class="label label-warning">Pengabdian</small>';
                    }
                })
                ->addColumn('action', function ($peneliti) {


                    return '';
                })
                ->rawColumns(['jenis','periode','action'])
                ->make(true);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }
    public function show2()
    {
        try
        {
            DB::statement(DB::raw('set @rownum=0'));
            $peneliti = Peneliti::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'tb_peneliti.id', 'tb_peneliti.nidn','tb_peneliti.nip','nama','tb_peneliti.email','level'])
                ->leftJoin('users', 'tb_peneliti.id', 'users.id')
                ->where('users.level', '!=','3')
                //->orderBy('level','DESC')
            ;

            return DataTables::of($peneliti)
                ->addColumn('level', function ($peneliti) {
                    if ($peneliti->level == '1'){
                        return '<small class="label label-info">Dosen</small>';

                    }else{
                        return '<small class="label label-success">Reviewer</small>';
                    }
                })

                ->addColumn('action', function ($peneliti) {
                    $rev = Reviewer::select('iddosen','periode','jenis')->where('iddosen',$peneliti->id)->first()
                    ;
                    if ($rev->iddosen == null && $rev->jenis == null){
                        return '<a id="'.$peneliti->id . '" class="btn-info btn-sm center-block  add1" title="Reviewer Penelitian">Penelitian</a>
                        <a id="'.$peneliti->id . '" class="btn-warning btn-sm center-block  add2" title="Reviewer Pengabdian">Pengabdian</a>';

                    }elseif ($rev->iddosen != null && $rev->jenis == 1){
                        return '<a id="'.$peneliti->id . '" class="btn-default btn-sm center-block " title="Reviewer Penelitian">Penelitian</a>
                        <a id="'.$peneliti->id . '" class="btn-warning btn-sm center-block  add2" title="Reviewer Pengabdian">Pengabdian</a>';

                    }elseif ($rev->iddosen != null && $rev->jenis == 2){
                        return '<a id="'.$peneliti->id . '" class="btn-info btn-sm center-block add1 " title="Reviewer Penelitian">Penelitian</a>
                        <a id="'.$peneliti->id . '" class="btn-default btn-sm center-block  " title="Reviewer Pengabdian">Pengabdian</a>';

                    }
                    else{
                        return '<a class="btn-default btn-sm center-block  " title="Reviewer Penelitian">Penelitian</a>
                        <a class="btn-default btn-sm center-block  " title="Reviewer Pengabdian">Pengabdian</a>';

                    }

                })


                ->rawColumns(['level','action'])
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
        try
        {
            DB::statement(DB::raw('set @rownum=0'));
            $peneliti = Peneliti::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'tb_peneliti.id', 'tb_peneliti.nidn','tb_peneliti.nip','nama','tb_peneliti.email','level'])
                ->leftJoin('users', 'tb_peneliti.id', 'users.id')
                ->where('users.level', '!=','3')
                //->orderBy('level','DESC')
            ;

            return DataTables::of($peneliti)
                ->addColumn('level', function ($peneliti) {
                    if ($peneliti->level == '1'){
                        return '<a class="btn-info btn-sm center-block">Dosen</a>';

                    }else{
                        return '<a class="btn-success btn-sm center-block">Reviewer</a>';
                    }
                })
                ->addColumn('action', function ($peneliti) {
                    return '<a  href="'. route('p_reviewer.resume',base64_encode(mt_rand(10,99).$peneliti->id) ).'" class="btn btn-xs edit" title="Detail"><i class="glyphicon glyphicon-file"></i> </a>
                    <button id="'.$peneliti->id . '" class="btn btn-xs verifikasi" title="Ubah Level"><i class="glyphicon glyphicon-check"></i> </button>
                     <td>
                        <input data-id="'.$peneliti->id . '" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" '.$peneliti->level ? 'checked' : '' .'>
                     </td>
                    ';
                })
                ->rawColumns(['level', 'action'])
                ->make(true);
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
    public function update(Request $request, Peneliti $peneliti)
    {
        try
        {

            $peneliti = Peneliti::findOrFail($peneliti->id);
            $peneliti->nidn = $request->nidn;
            $peneliti->nip = $request->nip;
            $peneliti->nama = $request->nama;
            $peneliti->email = $request->email;
            $peneliti->update();

           return response()->json(['success' => 'data is successfully updated'], 200);
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
    public function destroy2(Request $request,$id)
    {
        $periodeterbaru  = Periode::orderBy('tahun', 'desc')->orderBy('sesi', 'desc')->first();
        $user = User::find($id);
        $rev = Reviewer::all()
            ->where('iddosen', $id)
            ->first();
        try
        {
            if ($rev)
            {
                if($user->level == '1'){
                    $user->level = '2';
                    $user->update();

                    return response()->json(['success' => 'success verifikasi data'], 200);
                }elseif ($user->level == '2'){
                    $user->level = '1';
                    $user->update();
                    return response()->json(['success' => 'success verifikasi data'], 200);
                }
                else {
                    // Error
                    $message = 'Data Tidak bisa diubah..';
                    return Redirect::back()->withInput()->withErrors(array('kesalahan' => $message));
                }

            }else{
                if($user->level == '1'){
                    $user->level = '2';
                    $user->update();
                    $reviewer = new Reviewer();
                    $reviewer->iddosen = $user->id;
                    $reviewer->nidn = $user->email;
                    $reviewer->periode = $periodeterbaru->id;
                    $reviewer->jenis = '1';
                    $reviewer->save();
                    return response()->json(['success' => 'success verifikasi data'], 200);
                }elseif ($user->level == '2'){
                    $user->level = '1';
                    $user->update();
                    $reviewer = new Reviewer();
                    $reviewer->iddosen = $user->id;
                    $reviewer->nidn = $user->email;
                    $reviewer->periode =$periodeterbaru->id;
                    $reviewer->jenis = '1';
                    $reviewer->save();
                    return response()->json(['success' => 'success verifikasi data'], 200);
                }
                else {
                    // Error
                    $message = 'Data Tidak bisa diubah..';
                    return Redirect::back()->withInput()->withErrors(array('kesalahan' => $message));
                }


            }

        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }
    public function destroy(Request $request,$id)
    {
        $user = User::find($id);
        $rev = Reviewer::all()
            ->where('iddosen', $id)
            ->first();

        try
        {
            if ($rev == null){

                if($request->jenis == '1'){
                    $reviewer = new Reviewer();
                    $reviewer->iddosen = $user->id;
                    $reviewer->nidn = $user->email;
                    $reviewer->periode = '2';
                    $reviewer->jenis = '1';
                    $reviewer->save();
                    return response()->json(['success' => 'success tambah data'], 200);
                }elseif ($request->jenis == '2'){

                    $reviewer = new Reviewer();
                    $reviewer->iddosen = $user->id;
                    $reviewer->nidn = $user->email;
                    $reviewer->periode = '2';
                    $reviewer->jenis = '2';
                    $reviewer->save();
                    return response()->json(['success' => 'success tambah data'], 200);
                }
                else {
                    // Error
                    $message = 'Data Tidak bisa diubah..';
                    return Redirect::back()->withInput()->withErrors(array('kesalahan' => $message));
                }
            }else{

                if($rev->jenis == '1'){
                    $rev->jenis = '3';
                    $rev->update();
                    return response()->json(['success' => 'success tambah data'], 200);
                }elseif ($rev->jenis == '2'){

                    $rev->jenis = '3';
                    $rev->update();
                    return response()->json(['success' => 'success tambah data'], 200);
                }
                else {
                    // Error
                    $message = 'Data Tidak bisa diubah..';
                    return Redirect::back()->withInput()->withErrors(array('kesalahan' => $message));
                }
            }



        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }

    public function destroyreviewer($id)
    {
        try
        {
            Reviewer::destroy($id);

            return response()->json(['success' => $id], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    public function resume($id)
    {
        $temp = base64_decode($id);
        $iddosen = (Integer)substr($temp, 2, strlen($temp));

        $person = ReviewerController::countPersonil();

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

        return view('admin.penilaian.reviewer.show', compact('person', 'dosen', 'profil', 'pt', 'fk', 'pd', 'fungsi', 'struktur', 'pddk', 'ilmu', 'ilmu2', 'ilmu3' ));

    }
    public function changeStatus(Request $request)
    {
        $user = User::find($request->user_id);
        $user->status = $request->status;
        $user->save();

        return response()->json(['success'=>'Status change successfully.']);
    }
}
