<?php

namespace App\Http\Controllers\Master;

use App\Prodi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Proposal;
use App\Keanggotaan;
use DB;
use App\Quotation;


use Auth;
use Redirect;
use Yajra\DataTables\Facades\DataTables;

class ProdiController extends Controller
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
        return view('master.prodi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
            Prodi::create($request->all());

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
        // return DataTables::eloquent(Prodi::query())->make(true);
        try
        {
            DB::statement(DB::raw('set @rownum=0'));
            $prodis = Prodi::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'adm_prodi.id',
                'adm_fakultas.fakultas',
                'adm_prodi.prodi',
                'adm_prodi.sinonim',
                'adm_prodi.aktif'])
                ->leftJoin('adm_fakultas', 'adm_fakultas.id', 'adm_prodi.idfakultas');

            return DataTables::of($prodis)
                ->addColumn('action', function ($prodis) {
                    return '<button id="' . $prodis->id . '" class="btn btn-xs edit"><i class="glyphicon glyphicon-edit"></i></button>
                    <button id="' . $prodis->id . '" class="btn btn-xs  delete" ><i class="glyphicon glyphicon-trash"></i> </button>';
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
    public function edit(Prodi $prodi)
    {
        try
        {
            return response()->json(['success' => 'successfull retrieve data', 'data' => $prodi->toJson()], 200);

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
    public function update(Request $request, Prodi $prodi)
    {
        try
        {

            $prodi = Prodi::findOrFail($prodi->id);
            $prodi->idfakultas = $request->idfakultas;
            $prodi->prodi = $request->prodi;
            $prodi->sinonim = $request->sinonim;
            $prodi->aktif = $request->aktif;
            $prodi->update();

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
    public function destroy(Prodi $prodi)
    {
        try
        {
            Prodi::destroy($prodi->id);

            return response()->json(['success' => 'data is successfully deleted'], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }



}
