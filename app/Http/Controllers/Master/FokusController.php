<?php

namespace App\Http\Controllers\Master;

use App\Fokus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use App\Quotation;
use Auth;
use Redirect;
use Yajra\DataTables\Facades\DataTables;

class FokusController extends Controller
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
        return view('master.fokus.index');
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
            Fokus::create($request->all());

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
        // return DataTables::eloquent(Fokus::query())->make(true);
        try
        {
            DB::statement(DB::raw('set @rownum=0'));
            $fokus = Fokus::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'id', 'fokus', 'aktif']);

            return DataTables::of($fokus)
                ->addColumn('action', function ($fokus) {
                    return '<button id="' . $fokus->id . '" class="btn btn-xs edit"><i class="glyphicon glyphicon-edit"></i></button>
                    <button id="' . $fokus->id . '" class="btn btn-xs  delete" ><i class="glyphicon glyphicon-trash"></i> </button>';
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
    public function edit(Fokus $fokus)
    {
        try
        {
            return response()->json(['success' => 'successfull retrieve data', 'data' => $fokus->toJson()], 200);

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
    public function update(Request $request, Fokus $fokus)
    {
        try
        {

            $fokus = Fokus::findOrFail($fokus->id);
            $fokus->fokus = $request->fokus;
            $fokus->aktif = $request->aktif;
            $fokus->update();

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
    public function destroy(Fokus $fokus)
    {
        try
        {
            Fokus::destroy($fokus->id);

            return response()->json(['success' => 'data is successfully deleted'], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }


}
