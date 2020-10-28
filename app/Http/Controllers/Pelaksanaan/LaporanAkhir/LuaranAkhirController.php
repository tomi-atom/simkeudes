<?php

namespace App\Http\Controllers\Pelaksanaan\LaporanAkhir;
use App\Http\Controllers\Controller;
use App\LuaranAkhir;
use Illuminate\Http\Request;

use App\Keanggotaan;

use App\Keluaran;

use Auth;
use Redirect;


use App\Bidangtkt;
use App\CatatanHarian;
use App\Substansi;
use Carbon\Carbon;

use App\Proposal;
use App\Peneliti;
use App\Program;
use App\Periode;
use App\Posisi;

class LuaranAkhirController extends Controller
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
    public function index()
    {
        $person = LuaranAkhirController::countPersonil();

        $peneliti = Peneliti::select('id','hindex','sinta','status','tanggungan')->find(Auth::user()->id);
        $periode  = Periode::where('aktif', '1')->orderBy('tahun', 'desc')->orderBy('sesi', 'desc')->get();
        $periodeterbaru  = Periode::orderBy('tahun', 'desc')->orderBy('sesi', 'desc')->first();
        $proposal = Proposal::select('judul','idprogram','idskema','periodeusul','idfokus','aktif','thnkerja','tb_penelitian.prosalid','jenis')
            ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
            //->where('tb_proposal.periodeusul',$periode[0]->id)
            ->where('tb_penelitian.ketuaid', $peneliti->id)
            ->where('tb_penelitian.status',  4)
            // ->where('tb_proposal.jenis', 1)
            ->get();

        $peserta = Proposal::select('judul','idprogram','idskema','periodeusul','idfokus','thnkerja','status','prosalid','peran','setuju')
            ->leftJoin('tb_keanggota', 'tb_proposal.id', 'tb_keanggota.idpenelitian')
            ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
           // ->where('tb_proposal.periodeusul',$periode[0]->id)
            ->where('tb_keanggota.anggotaid', $peneliti->id)
            ->where('tb_penelitian.status',  4)
            ->where('tb_keanggota.setuju', '<', 2)
            ->where('tb_proposal.jenis', 1)
            ->where('tb_proposal.aktif', '1')
            ->orderBy('tb_keanggota.peran', 'asc')
            ->get();

        $minat =  Proposal::leftJoin('tb_keanggota', 'tb_proposal.id', 'tb_keanggota.idpenelitian')
            ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
           // ->where('tb_proposal.periodeusul',$periode[0]->id)
            ->where('tb_penelitian.ketuaid', $peneliti->id)
            ->where('tb_penelitian.status', '>', 0)
            ->where('tb_keanggota.setuju', 0)
            ->where('tb_proposal.jenis', 1)
            ->where('tb_proposal.aktif', '1')
            ->count(); 

        $status = Posisi::select('jenis')->where('aktif', '1')->orderBy('id','asc')->get(); //*temp

        $member = Keanggotaan::leftJoin('tb_proposal', 'tb_keanggota.idpenelitian', 'tb_proposal.id')
                        ->where('tb_keanggota.anggotaid', Auth::user()->id)
                        ->where('tb_keanggota.setuju', 1)
                        ->where('tb_proposal.jenis', 1)
                        ->count();

        $ketua   = count($proposal);
        $total   = $ketua + count($peserta);
        $waktu = Carbon::now('Asia/Jakarta');


        return view('pelaksanaan.laporanakhir.luaran.index', compact('person', 'peneliti', 'periode','periodeterbaru', 'waktu', 'proposal', 'total','ketua','peserta','member', 'status', 'minat','upload'));
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
                        $nama_file = "docs-".$proposal->periodeusul."-".$proposal->id."-".mt_rand(100,999).$proposal->id.mt_rand(10,99)."-".$proposal->idketua.".".$file->getClientOriginalExtension();

                        $lokasi = public_path('docs/pelaksanaan/laporanakhir');

                        $file->move($lokasi, $nama_file);
                    }
                    else {
                        $message = 'Gagal mengunggah, ukuran dokumen melebihi aturan..';
                        return Redirect::back()->withInput()->withErrors(array('kesalahan' => $message));
                    }
                }
            }
        }
        $judul  = $request['judul'] ? $request['judul'] : '';
        $jurnal  = $request['jurnal'] ? $request['jurnal'] : '';
        $issn    = $request['issn'] ? $request['issn'] : '';
        $linkurl = $request['linkurl'] ? $request['linkurl'] : '';

        
        $peneliti = new LuaranAkhir;
        $peneliti->idketua      = Auth::user()->id;
        $peneliti->idpenelitian = $idprop ;
        $peneliti->idluaran     = $request['jenis'];
        $peneliti->kategori     = $request['kategori'];
        $peneliti->judul        = $judul;
        $peneliti->publish      = $jurnal;
        $peneliti->issn         = $issn;
        $peneliti->urllink      = $linkurl;
        $peneliti->status       = $request['status'];
        $peneliti->sinta        = $request['sinta'];
        $peneliti->upload       = $nama_file;
        
        $peneliti->save();
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LuaranAkhir  $luaranAkhir
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $person = LuaranAkhirController::countPersonil();

        $idprop = base64_decode($id);
        //$idprop = (Integer)substr($temp, 2, strlen($temp)) ;

       
        $jenis = Keluaran::groupBy('jenis')->orderBy('id')->get();
        return view('pelaksanaan.laporanakhir.luaran.show', compact( 'person', 'jenis', 'idprop'));
    
    }
    public function showlainnya($id)
    {
        $person = LuaranAkhirController::countPersonil();

        $idprop = base64_decode($id);
        //$idprop = (Integer)substr($temp, 2, strlen($temp)) ;

       
        $jenis = Keluaran::groupBy('jenis')->orderBy('id')->get();
        return view('pelaksanaan.laporanakhir.luaran.showlainnya', compact( 'person', 'jenis', 'idprop'));
    
    }
    public function showtambahan($id)
    {
        $person = LuaranAkhirController::countPersonil();

        $idprop = base64_decode($id);
        //$idprop = (Integer)substr($temp, 2, strlen($temp)) ;

       
        $jenis = Keluaran::groupBy('jenis')->orderBy('id')->get();
        return view('pelaksanaan.laporanakhir.luaran.showtambahan', compact( 'person', 'jenis', 'idprop'));
    
    }
    public function showwajib($id)
    {
        $person = LuaranAkhirController::countPersonil();

        $idprop = base64_decode($id);
        //$idprop = (Integer)substr($temp, 2, strlen($temp)) ;

       
        $jenis = Keluaran::groupBy('jenis')->orderBy('id')->get();
        return view('pelaksanaan.laporanakhir.luaran.showwajib', compact( 'person', 'jenis', 'idprop'));
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LuaranAkhir  $luaranAkhir
     * @return \Illuminate\Http\Response
     */
    public function edit(LuaranAkhir $luaranAkhir)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LuaranAkhir  $luaranAkhir
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LuaranAkhir $luaranAkhir)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LuaranAkhir  $luaranAkhir
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $luaran = LuaranAkhir::find($id);

        if ($luaran) {
            $luaran->delete();

            return 1;
        }
    }

    public function datalainnya(Request $request) 
    {
        $select = $request->get('select');
        $_token = $request->get('_token');

        $luaran = LuaranAkhir::where('idpenelitian', $select)->where('kategori', '3')->orderBy('id', 'asc')->get();

        $output = '<tbody>';
        $no = 0;
        foreach ($luaran as $data) {
            $no++;
            $output .= 
                '<tr>
                    <td>'.$no.'</td>
                    <td><b>'.$data->judul.'</b><br>';
                    if ($data->publish) {
                        $output .= '<code>'.$data->publish.'</code><br>';
                    }
                    $output .= '<span class="label label-success">'.$data->status.'</span>
                    </td>
                    
                    <td align="right" style="widows: 80px">
                    <a  href="'. route('luaranakhir.baca',base64_encode(mt_rand(10,99).$data->id) ).'" class="btn btn-app btn-sm" id="Unduh"><i class="ion ion-ios-book-outline text-blue"></i> Baca </a>
                     <a onclick="deleteData('.$data->id.')" class="btn btn-app btn-sm" id="hapus"><i class="ion ion-ios-trash-outline text-red"></i> Hapus </a>
                    </td>
                ';
        }
        if ($output == '<tbody>')
            $output .= '<tr><td width="25"></td><td colspan="2"><b>LUARAN KEGIATAN WAJIB BELUM ADA</b></td></tr>';

        $output .= '<tr><td></td><td></td><td></td></tr>
                </tbody>';

        echo $output;
    } 
    public function loadtarget(Request $request)
    {
        $ceklog = Keluaran::findOrFail($request->get('idtarget'));

        $target = Keluaran::where('jenis', $ceklog->jenis)->groupBy('target')->orderBy('id')->get();

        $output = '<option value="">  -- Pilih Target --</option>';
        foreach ($target as $row) 
        {
            $output .= '<option value="'.$row->id.'">'.$row->target.'</option>';
        }
        echo $output;
    }
    public function baca($id)
    {
        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 2, strlen($temp));


        $penelitian = LuaranAkhir::where('id', $idprop)->first();
        $file_path = public_path('docs/pelaksanaan/laporanakhir/').$penelitian->upload;
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
                return Redirect::back()->withInput()->withErrors(array('error' => "File Tidak Ditemukan"));
            }
        }

    }
}
