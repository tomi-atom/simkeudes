<?php

namespace App\Http\Controllers\Master;

use App\Program;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Proposal;
use App\Keanggotaan;

use DB;
use App\Quotation;

use Auth;
use Redirect;
use Yajra\DataTables\Facades\DataTables;

class ProgramController extends Controller
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
        return view('master.program.index');
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
            Program::create($request->all());

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
        // return DataTables::eloquent(Program::query())->make(true);
        try
        {
            DB::statement(DB::raw('set @rownum=0'));
            $program = Program::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'id', 'kategori','program', 'aktif']);

            return DataTables::of($program)
                ->addColumn('kategori', function ($program) {
                    if ($program->kategori == 1){
                        return ' <small class="label label-info">Penelitian</small>';
                    }else{
                        return '<small class="label label-warning">Pengabdian</small>';

                    }
                })

                ->addColumn('action', function ($program) {
                    return '<button id="' . $program->id . '" class="btn btn-xs edit"><i class="glyphicon glyphicon-edit"></i></button>
                    <button id="' . $program->id . '" class="btn btn-xs  delete" ><i class="glyphicon glyphicon-trash"></i> </button>';
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
    public function edit(Program $program)
    {
        try
        {
            return response()->json(['success' => 'successfull retrieve data', 'data' => $program->toJson()], 200);

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
    public function update(Request $request, Program $program)
    {
        try
        {

            $program = Program::findOrFail($program->id);
            $program->kategori = $request->kategori;
            $program->program = $request->program;
            $program->aktif = $request->aktif;
            $program->update();

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
    public function destroy(Program $program)
    {
        try
        {
            Program::destroy($program->id);

            return response()->json(['success' => 'data is successfully deleted'], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }


}
