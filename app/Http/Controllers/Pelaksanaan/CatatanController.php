<?php

namespace App\Http\Controllers\Pelaksanaan;

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

class CatatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    protected function countPersonil()
    {

        $personil = Keanggotaan::select('tb_proposal.id', 'anggotaid', 'jenis', 'nama', 'foto', 'tb_keanggota.created_at')
            ->leftJoin('tb_penelitian', 'tb_keanggota.idpenelitian', 'tb_penelitian.prosalid')
            ->leftJoin('tb_proposal', 'tb_penelitian.prosalid', 'tb_proposal.id')
            ->leftJoin('tb_peneliti', 'tb_penelitian.ketuaid', 'tb_peneliti.id')
            ->where('tb_keanggota.anggotaid', Auth::user()->id)
            ->where('tb_keanggota.setuju', 0)
            ->where('tb_penelitian.status', '>', 0)
            ->where('tb_proposal.aktif', '1')
            ->get();
        return $personil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $person = CatatanController::countPersonil();
        $temp = base64_decode($id) - 127;

        $idtemp = $temp;
        $proposalid = base64_encode(mt_rand(1,9).($temp + Auth::user()->id));

        return view('pelaksanaan.catatan.index', compact('person','proposalid','idtemp'));
        $this->show($idtemp);


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
 
         $idprop = $request['id'];
 
         $proposal = Proposal::find($idprop);
         if ($proposal) {
 
             if ($request->hasFile('upload')) {
 
                 $file  = $request->file('upload');
                 if ($file->getClientMimeType() !== 'application/pdf' ) {
                   
                 }
                 else {
                     if ($file->getSize() < 5147152) {
                         $nama_file = "docs-catatan".$request->get('tanggal').mt_rand(100,999).$proposal->id.mt_rand(10,99)."-".$proposal->idketua.".".$file->getClientOriginalExtension();
 
                         $lokasi = public_path('docs/periode2/rancangan');
 
                         $file->move($lokasi, $nama_file);
                     }
                     else {
                         $message = 'Gagal mengunggah, ukuran dokumen melebihi aturan..';
                         return Redirect::back()->withInput()->withErrors(array('kesalahan' => $message));
                     }
                 }
             }else{
                  $nama_file = "0";
             }
         }
         $keterangan  = $request['keterangan'] ? $request['keteranngan'] : '';
         
         
         $catatanharian = new CatatanHarian();
 
         $catatanharian->prosalid    = $idprop;
         $catatanharian->tanggal     = $request->get('tanggal');
         $catatanharian->keterangan  =  $request->get('keterangan');
         $catatanharian->status      = 4;
         $catatanharian->upload      = $nama_file;
         
         $catatanharian->save();
         
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
    public function show($prosalid)
    {
        // return DataTables::eloquent(CatatanHarian::query())->make(true);
        try
        {
            $id = base64_decode($prosalid)-127;

            DB::statement(DB::raw('set @rownum=0'));
            $catatans = CatatanHarian::select([ DB::raw('@rownum  := @rownum  + 1 AS rownum'),'id', 'prosalid','tanggal','keterangan', 'status','created_at'])
                ->where('prosalid', $id);

            return DataTables::of($catatans)
                ->addColumn('action', function ($catatans) {

                    return ' 
                    <a  href="'. route('catatanharian.resume',base64_encode(mt_rand(10,99).$catatans->id) ).'" class="btn btn-xs resume" title="File"><i class="glyphicon glyphicon-file"></i> </a>                                    
                    <a onclick="hapus2('.$catatans->id.')" class="btn btn-xs  " ><i class="glyphicon glyphicon-trash"></i> </a>';
                })
                ->make(true);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }
    public function resume($id)
    {
        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 2, strlen($temp));


        $penelitian = CatatanHarian::where('id', $idprop)->first();
        $file_path = public_path('docs/periode2/rancangan/').$penelitian->upload;
        if($penelitian){
            $headers = array(
                'Content-Type: pdf',
                'Content-Disposition: attachment; filename='.$penelitian->upload,
            );
            if ( file_exists( $file_path ) ) {
                // Show pdf
                return response()->file( $file_path, $headers );
            } else {
                // Error
                $message = 'Dokumen Tidak Ditemukan..';
                return Redirect::back()->withInput()->withErrors(array('kesalahan' => $message));
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CatatanHarian $catatan)
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
    public function update(Request $request, CatatanHarian $catatan)
    {
        try
        {

            $catatan = CatatanHarian::findOrFail($catatan->id);
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
    public function destroy($id)
    {
        try
        {

            $temp = base64_decode($id);
            //$prosalid = $temp - 127;
            $penelitian = CatatanHarian::where('id',$id)->first();
            if ($penelitian) {
               // $penelitian = CatatanHarian::find($prosalid);

                $penelitian->delete();
                return Redirect::back()->withInput()->withErrors(array('success' => 'success'));


            }else{
                return Redirect::back()->withInput()->withErrors(array('error' => 'error'));


            }


        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }




}
