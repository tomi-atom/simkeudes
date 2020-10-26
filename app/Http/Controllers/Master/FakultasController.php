<?php

namespace App\Http\Controllers\Master;

use App\Fakultas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



use DB;
use App\Quotation;
use Auth;
use Redirect;
use Yajra\DataTables\Facades\DataTables;

class FakultasController extends Controller
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
    public function index(Request $request)
    {
        return view('master.fakultas.index');
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
            Fakultas::create($request->all());

            return response()->json(['success' => 'data berhasil ditambahkan'], 200);
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
        // return DataTables::eloquent(Fakultas::query())->make(true);
        try
        {
            DB::statement(DB::raw('set @rownum=0'));
            $fakultas = Fakultas::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'adm_fakultas.id', 'adm_pt.pt','adm_fakultas.fakultas','adm_fakultas.sinonim','adm_fakultas.dekan','adm_fakultas.nip', 'adm_fakultas.aktif'])
                ->Join('adm_pt', 'adm_fakultas.idpt', 'adm_pt.id');

            return DataTables::of($fakultas)
                ->addColumn('action', function ($fakultas) {
                    return '<button id="' . $fakultas->id . '" class="btn btn-xs edit"><i class="glyphicon glyphicon-edit"></i></button>
                    <button id="' . $fakultas->id . '" class="btn btn-xs  delete" ><i class="glyphicon glyphicon-trash"></i> </button>';
                })
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
    public function edit(Fakultas $fakultas)
    {
        try
        {
            return response()->json(['success' => 'successfull retrieve data', 'data' => $fakultas->toJson()], 200);

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
    public function update(Request $request, Fakultas $fakultas)
    {
        try
        {

            $fakultas = Fakultas::findOrFail($fakultas->id);
            $fakultas->idpt = $request->pt;
            $fakultas->fakultas = $request->fakultas;
            $fakultas->sinonim = $request->sinonim;
            $fakultas->dekan = $request->dekan;
            $fakultas->nip = $request->nip;
            $fakultas->aktif = $request->aktif;
            $fakultas->update();

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
    public function destroy(Fakultas $fakultas)
    {
        try
        {
            Fakultas::destroy($fakultas->id);

            return response()->json(['success' => 'data is successfully deleted'], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }



}
