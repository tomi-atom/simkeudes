<?php

namespace App\Http\Controllers\Master;

use App\Periode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        try
        {
            $periode = Periode::create($request->all());

            return response()->json(['success' => $periode], 200);
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
            $periodes = Periode::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'id', 'tahun','sesi','jenis','tanggal_mulai','tanggal_akhir', 'aktif']);

            return DataTables::of($periodes)
                ->addColumn('jenis', function($periodes) {
                    if ($periodes->jenis == 1){
                        return '<small class="label label-primary">Penelitian</small>';
                    }
                    else{
                        return '<small class="label label-warning">Pengabdian</small>';
                    }
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
                    return '<button id="' . $periodes->id . '" class="btn btn-xs edit"><i class="glyphicon glyphicon-edit"></i></button>
                    <button id="' . $periodes->id . '" class="btn btn-xs  delete" ><i class="glyphicon glyphicon-trash"></i> </button>';
                })
                ->rawColumns(['jenis','aktif', 'action'])
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
    public function edit(Periode $periode)
    {
        try
        {
            return response()->json(['success' => 'successfull retrieve data', 'data' => $periode->toJson()], 200);

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