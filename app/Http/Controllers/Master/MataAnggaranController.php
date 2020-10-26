<?php

namespace App\Http\Controllers\Master;

use App\Mataanggaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use Auth;
use Redirect;
use Yajra\DataTables\Facades\DataTables;
use DB;
use App\Quotation;


class MataAnggaranController extends Controller
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
       return view('master.anggaran.index');
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
            Mataanggaran::create($request->all());

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
        // return DataTables::eloquent(Mataanggaran::query())->make(true);
        try
        {
            DB::statement(DB::raw('set @rownum=0'));
            $mataanggaran = Mataanggaran::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'id', 'jenis','batas', 'aktif']);

            return DataTables::of($mataanggaran)
                ->addColumn('action', function ($mataanggaran) {
                    return '<button id="' . $mataanggaran->id . '" class="btn btn-xs edit"><i class="glyphicon glyphicon-edit"></i></button>
                    <button id="' . $mataanggaran->id . '" class="btn btn-xs  delete" ><i class="glyphicon glyphicon-trash"></i> </button>';
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
    public function edit(Mataanggaran $mataanggaran)
    {
        try
        {
            return response()->json(['success' => 'successfull retrieve data', 'data' => $mataanggaran->toJson()], 200);

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
    public function update(Request $request, Mataanggaran $mataanggaran)
    {
        try
        {

            $mataanggaran = Mataanggaran::findOrFail($mataanggaran->id);
            $mataanggaran->jenis = $request->jenis;
            $mataanggaran->batas = $request->batas;
            $mataanggaran->aktif = $request->aktif;
            $mataanggaran->update();

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
    public function destroy(Mataanggaran $mataanggaran)
    {
        try
        {
            Mataanggaran::destroy($mataanggaran->id);

            return response()->json(['success' => 'data is successfully deleted'], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }


}
