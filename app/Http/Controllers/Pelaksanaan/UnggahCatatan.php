<?php

namespace App\Http\Controllers\Master;

use App\CatatanHarian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Proposal;
use App\Keanggotaan;
use App\Bidangtkt;

use Yajra\DataTables\Facades\DataTables;
use DB;
use App\Quotation;


use Auth;
use Redirect;

class UnggahCatatan extends Controller
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
        return view('master.bidangtkt.index');

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
            CatatanHarian::create($request->all());

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
        // return DataTables::eloquent(Bidangtkt::query())->make(true);
        try
        {
            DB::statement(DB::raw('set @rownum=0'));
            $catatans =CatatanHarian::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'id', 'bidang', 'aktif']);

            return DataTables::of($catatans)
                ->addColumn('action', function ($catatans) {
                    return '<button id="' . $catatans->id . '" class="btn btn-xs edit"><i class="glyphicon glyphicon-edit"></i></button>
                    <button id="' . $catatans->id . '" class="btn btn-xs  delete" ><i class="glyphicon glyphicon-trash"></i> </button>';
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
    public function edit(Bidangtkt $catatan)
    {
        try
        {
            return response()->json(['success' => 'successfull retrieve data', 'data' => $catatan->toJson()], 200);

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
    public function update(Request $request,CatatanHarian $catatan)
    {
        try
        {

            $catatan =CatatanHarian::findOrFail($catatan->id);
            $catatan->bidang = $request->bidang;
            $catatan->aktif = $request->aktif;
            $catatan->update();

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
    public function destroy(CatatanHarian $catatan)
    {
        try
        {
           CatatanHarian::destroy($catatan->id);

            return response()->json(['success' => 'data is successfully deleted'], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }




}
