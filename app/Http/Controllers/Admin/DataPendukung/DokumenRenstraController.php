<?php

namespace App\Http\Controllers\Admin\DataPendukung;

use App\DokumenRenstra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use Auth;
use Redirect;
use Yajra\DataTables\Facades\DataTables;
use DB;
use App\Quotation;


class DokumenRenstraController extends Controller
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
       return view('admin.datapendukung.dokumenrenstra.index');
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

            if ($request->hasFile('upload')) {

                $file  = $request->file('upload');
                if ($file->getClientMimeType() !== 'application/pdf' ) {

                }
                else {
                    if ($file->getSize() < 2097152) {
                        $nama_file = "docs-1".$request->keterangan."-".$request->jenis.".".$file->getClientOriginalExtension();

                        $lokasi = public_path('docs/periode2/rancangan');

                        $file->move($lokasi, $nama_file);


                    }
                    else {
                        $message = 'Gagal mengunggah, ukuran dokumen melebihi aturan..';
                        return Redirect::back()->withInput()->withErrors(array('kesalahan' => $message));
                    }
                    $dokumen = new DokumenRenstra();

                }

            }

            $dokumen->keterangan     = $request->keterangan;
            $dokumen->jenis     = $request->jenis;
            $dokumen->upload  = $nama_file;

            $dokumen->save();

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
        // return DataTables::eloquent(DokumenRenstra::query())->make(true);
        try
        {
            DB::statement(DB::raw('set @rownum=0'));
            $dokumenrenstra = DokumenRenstra::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'id', 'keterangan','jenis', 'upload']);

            return DataTables::of($dokumenrenstra)
                ->addColumn('action', function ($dokumenrenstra) {
                    return '<button id="' . $dokumenrenstra->id . '" class="btn btn-xs edit"><i class="glyphicon glyphicon-edit"></i></button>
                    <button id="' . $dokumenrenstra->id . '" class="btn btn-xs  delete" ><i class="glyphicon glyphicon-trash"></i> </button>';
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
    public function edit(DokumenRenstra $dokumenrenstra)
    {
        try
        {
            return response()->json(['success' => 'successfull retrieve data', 'data' => $dokumenrenstra->toJson()], 200);

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
    public function update(Request $request, DokumenRenstra $dokumenrenstra)
    {
        try
        {

            $dokumenrenstra = DokumenRenstra::findOrFail($dokumenrenstra->id);
            $dokumenrenstra->keterangan = $request->keterangan;
            $dokumenrenstra->jenis = $request->jenis;
            $dokumenrenstra->upload = $request->upload;
            $dokumenrenstra->aktif = $request->aktif;
            $dokumenrenstra->update();

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
    public function destroy(DokumenRenstra $dokumenrenstra)
    {
        try
        {
            DokumenRenstra::destroy($dokumenrenstra->id);

            return response()->json(['success' => 'data is successfully deleted'], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }


}
