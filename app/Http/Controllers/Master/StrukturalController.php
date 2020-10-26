<?php

namespace App\Http\Controllers\Master;

use App\Struktural;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use Redirect;
use DB;
use App\Quotation;
use Yajra\DataTables\Facades\DataTables;


class StrukturalController extends Controller
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
        return view('master.struktural.index');
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
            Struktural::create($request->all());

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
        // return DataTables::eloquent(Struktural::query())->make(true);
        try
        {
            DB::statement(DB::raw('set @rownum=0'));
            $struktural = Struktural::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'id', 'struktural']);

            return DataTables::of($struktural)
                ->addColumn('action', function ($struktural) {
                    return '<button id="' . $struktural->id . '" class="btn btn-xs edit"><i class="glyphicon glyphicon-edit"></i></button>
                    <button id="' . $struktural->id . '" class="btn btn-xs  delete" ><i class="glyphicon glyphicon-trash"></i> </button>';
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
    public function edit(Struktural $struktural)
    {
        try
        {
            return response()->json(['success' => 'successfull retrieve data', 'data' => $struktural->toJson()], 200);

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
    public function update(Request $request, Struktural $struktural)
    {
        try
        {

            $struktural = Struktural::findOrFail($struktural->id);
            $struktural->struktural = $request->struktural;
            $struktural->update();

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
    public function destroy(Struktural $struktural)
    {
        try
        {
            Struktural::destroy($struktural->id);

            return response()->json(['success' => 'data is successfully deleted'], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }



}
