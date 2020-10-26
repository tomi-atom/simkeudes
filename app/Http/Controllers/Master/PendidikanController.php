<?php

namespace App\Http\Controllers\Master;

use App\Pendidikan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use App\Quotation;
use Auth;
use Redirect;
use Yajra\DataTables\Facades\DataTables;

class PendidikanController extends Controller
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
        return view('master.pendidikan.index');

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
            Pendidikan::create($request->all());

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
        // return DataTables::eloquent(Pendidikan::query())->make(true);
        try
        {
            DB::statement(DB::raw('set @rownum=0'));
            $pendidikan = Pendidikan::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'id', 'pendidikan', 'aktif']);

            return DataTables::of($pendidikan)
                ->addColumn('action', function ($pendidikan) {
                    return '<button id="' . $pendidikan->id . '" class="btn btn-xs edit"><i class="glyphicon glyphicon-edit"></i></button>
                    <button id="' . $pendidikan->id . '" class="btn btn-xs  delete" ><i class="glyphicon glyphicon-trash"></i> </button>';
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
    public function edit(Pendidikan $pendidikan)
    {
        try
        {
            return response()->json(['success' => 'successfull retrieve data', 'data' => $pendidikan->toJson()], 200);

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
    public function update(Request $request, Pendidikan $pendidikan)
    {
        try
        {

            $pendidikan = Pendidikan::findOrFail($pendidikan->id);
            $pendidikan->pendidikan = $request->pendidikan;
            $pendidikan->aktif = $request->aktif;
            $pendidikan->update();

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
    public function destroy(Pendidikan $pendidikan)
    {
        try
        {
            Pendidikan::destroy($pendidikan->id);

            return response()->json(['success' => 'data is successfully deleted'], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

}
