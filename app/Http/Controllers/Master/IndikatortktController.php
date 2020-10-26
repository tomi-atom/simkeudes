<?php

namespace App\Http\Controllers\Master;

use App\Indikatortkt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use App\Quotation;


use Auth;
use Redirect;
use Yajra\DataTables\Facades\DataTables;

class IndikatortktController extends Controller
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

        $bidang = DB::table('adm_bidangtkt')
            ->select('id','bidang')
            ->groupBy('bidang')
            ->orderBy('id', 'ASC')
            ->get();


        return view('master.indikatortkt.index',compact('bidang'));
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
            Indikatortkt::create($request->all());

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
        // return DataTables::eloquent(Indikatortkt::query())->make(true);
        try
        {
            DB::statement(DB::raw('set @rownum=0'));
            $indikatortkt = Indikatortkt::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'adm_indikatortkt.id', 'adm_bidangtkt.bidang','adm_indikatortkt.leveltkt','adm_indikatortkt.nourut','adm_indikatortkt.indikator', 'adm_indikatortkt.aktif'])
                ->leftJoin('adm_bidangtkt', 'adm_bidangtkt.id', 'adm_indikatortkt.idbidang');

            return DataTables::of($indikatortkt)
                ->addColumn('action', function ($indikatortkt) {
                    return '<button id="' . $indikatortkt->id . '" class="btn btn-xs edit"><i class="glyphicon glyphicon-edit"></i></button>
                    <button id="' . $indikatortkt->id . '" class="btn btn-xs  delete" ><i class="glyphicon glyphicon-trash"></i> </button>';
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
    public function edit(Indikatortkt $indikatortkt)
    {
        try
        {
            return response()->json(['success' => 'successfull retrieve data', 'data' => $indikatortkt->toJson()], 200);

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
    public function update(Request $request, Indikatortkt $indikatortkt)
    {
        try
        {

            $indikatortkt = Indikatortkt::findOrFail($indikatortkt->id);
            $indikatortkt->idbidang = $request->bidang;
            $indikatortkt->leveltkt = $request->leveltkt;
            $indikatortkt->nourut = $request->nourut;
            $indikatortkt->indikator = $request->indikator;
            $indikatortkt->aktif = $request->aktif;
            $indikatortkt->update();

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
    public function destroy(Indikatortkt $indikatortkt)
    {
        try
        {
            Indikatortkt::destroy($indikatortkt->id);

            return response()->json(['success' => 'data is successfully deleted'], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }


}
