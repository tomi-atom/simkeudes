<?php

namespace App\Http\Controllers\Master;

use App\Fakultas;
use App\Fungsional;
use App\Pendidikan;
use App\Peneliti;
use App\Periode;
use App\Posisi;
use App\Prodi;
use App\Program;
use App\Rumpun;
use App\Skema;
use App\Struktural;
use App\Universitas;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Proposal;
use App\Keanggotaan;


use Auth;
use Redirect;
use DB;
use App\Quotation;
use Yajra\DataTables\Facades\DataTables;

class PeriodeController extends Controller
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
        return view('master.periode.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $program = Program::get();


        return view('master.periode.create', compact( 'program' ));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $periode = Periode::create($request->all());

            return Redirect::route('periode.index')->withInput()->withErrors(array('success' => 'succes'));

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
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
        // return DataTables::eloquent(Periode::query())->make(true);
        try
        {
            DB::statement(DB::raw('set @rownum=0'));
            $periodes = Periode::get();
            return DataTables::of($periodes)
                ->addColumn('jenis', function($periodes) {
                    if ($periodes->jenis == 1){
                        return '<small class="label label-primary">Penelitian</small>';
                    }
                    else{
                        return '<small class="label label-warning">Pengabdian</small>';
                    }
                })
                ->addColumn('program', function($periodes) {
                    $prog = Program::select('program')
                        ->where('id',$periodes->program)
                        ->first();
                        return '<small>'.$prog->program.'</small>';

                })
                ->addColumn('proposal', function($periodes) {

                    return '<small class="label label-success">Mulai</small><small class="label label-primary">' . $periodes->tanggal_mulai . '</small><br>
                    <small class="label label-danger">Akhir</small><small class="label label-primary">' . $periodes->tanggal_akhir . '</small>
                   
                    ';

                })
                ->addColumn('kemajuan', function($periodes) {

                    return '<small class="label label-success">Mulai</small><small class="label label-primary">' . $periodes->tm_laporankemajuan . '</small><br>
                    <small class="label label-danger">Akhir</small><small class="label label-primary">' . $periodes->ta_laporankemajuan . '</small>
                   
                    ';

                })
                ->addColumn('akhir', function($periodes) {

                    return '<small class="label label-success">Mulai</small><small class="label label-primary">' . $periodes->tm_laporanakhir. '</small><br>
                    <small class="label label-danger">Akhir</small><small class="label label-primary">' . $periodes->ta_laporanakhir . '</small>
                   
                    ';

                })
            
                ->addColumn('aktif', function($periodes) {
                    if ($periodes->aktif == 1){
                        return '<small class="label label-success">Aktif</small>';
                    }
                    else{
                        return '<small class="label label-danger">Tidak Aktif</small>';
                    }
                })
                ->addColumn('action', function ($periodes) {
                    return ' <a  href="'. route('periode.edit',base64_encode($periodes->id) ).'" class="btn btn-xs  title="Edit"><i class="glyphicon glyphicon-edit"></i> </a>
                   <button id="' . $periodes->id . '" class="btn btn-xs  delete" ><i class="glyphicon glyphicon-trash"></i> </button>';
                })
                ->rawColumns(['jenis','program','aktif','proposal','kemajuan','akhir', 'action'])
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

        try
        {

            $periode = Periode::find($temp);
            $program = Program::get();
            $tanggal_mulai=date('Y-m-d h:i:s', strtotime($periode->tanggal_mulai));


            return view('master.periode.show', compact('temp','periode','program','tanggal_mulai'));
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
    public function update(Request $request, Periode $periode)
    {
        try
        {

            $periode = Periode::findOrFail($periode->id);
            $periode->tahun = $request->tahun;
            $periode->sesi = $request->sesi;
            $periode->jenis = $request->jenis;
            $periode->tanggal_mulai = $request->tanggal_mulai;
            $periode->tanggal_akhir = $request->tanggal_akhir;
            $periode->aktif = $request->aktif;
            $periode->update();

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
    public function destroy(Periode $periode)
    {
        try
        {
            Periode::destroy($periode->id);

            return response()->json(['success' => 'data is successfully deleted'], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }


}