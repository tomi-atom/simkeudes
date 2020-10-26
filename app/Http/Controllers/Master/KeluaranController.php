<?php

namespace App\Http\Controllers\Master;

use App\Keluaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Proposal;
use App\Keanggotaan;


use Auth;
use Redirect;
use Yajra\DataTables\Facades\DataTables;
use DB;
use App\Quotation;


class KeluaranController extends Controller
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


        return view('master.keluaran.index');
    }

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
            Keluaran::create($request->all());

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
        // return DataTables::eloquent(Keluaran::query())->make(true);
        try
        {
            DB::statement(DB::raw('set @rownum=0'));
            $keluaran = Keluaran::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'id', 'kategori','jenis','target','aktif']);

            return DataTables::of($keluaran)
                ->addColumn('kategori', function ($keluaran) {
                    if ($keluaran->kategori == 1){
                        return ' <small class="label label-info">Penelitian</small>';
                    }else{
                        return '<small class="label label-warning">Pengabdian</small>';

                    }
                })

                ->addColumn('action', function ($keluaran) {
                    return '<button id="' . $keluaran->id . '" class="btn btn-xs edit"><i class="glyphicon glyphicon-edit"></i></button>
                    <button id="' . $keluaran->id . '" class="btn btn-xs  delete" ><i class="glyphicon glyphicon-trash"></i> </button>';
                })
                ->rawColumns(['kategori', 'action'])
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
    public function edit(Keluaran $keluaran)
    {
        try
        {
            return response()->json(['success' => 'successfull retrieve data', 'data' => $keluaran->toJson()], 200);

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
    public function update(Request $request, Keluaran $keluaran)
    {
        try
        {

            $keluaran = Keluaran::findOrFail($keluaran->id);
            $keluaran->kategori = $request->kategori;
            $keluaran->jenis = $request->jenis;
            $keluaran->target = $request->target;
            $keluaran->aktif = $request->aktif;
            $keluaran->update();

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
    public function destroy(Keluaran $keluaran)
    {
        try
        {
            Keluaran::destroy($keluaran->id);

            return response()->json(['success' => 'data is successfully deleted'], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }






}
