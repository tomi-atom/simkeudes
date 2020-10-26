<?php

namespace App\Http\Controllers\Pelaksanaan;

use App\HasilPenilaian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Proposal;
use App\Keanggotaan;
use App\Peneliti;
use App\Program;
use App\Periode;
use App\Posisi;
use File;
use PDF;

use Auth;
use Redirect;


class HasilPenilaianController extends Controller
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
        $person = HasilPenilaianController::countPersonil();

        $peneliti = Peneliti::select('id','hindex','sinta','status','tanggungan')->find(Auth::user()->id);
        $periode  = Periode::where('aktif', '1')->orderBy('tahun', 'desc')->orderBy('sesi', 'desc')->get();
        $periodeterbaru  = Periode::orderBy('tahun', 'desc')->orderBy('sesi', 'desc')->first();
        $proposal = Proposal::select('judul','idprogram','idskema','periodeusul','idfokus','aktif','thnkerja','tb_rancangan_penelitian.status','tb_penelitian.prosalid','jenis','upload')
            ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
            ->leftJoin('tb_rancangan_penelitian', 'tb_rancangan_penelitian.prosalid', 'tb_proposal.id')
            //->where('tb_proposal.periodeusul',$periode[0]->id)
            ->where('tb_penelitian.ketuaid', $peneliti->id)
            ->where('tb_penelitian.status',  4)
            // ->where('tb_proposal.jenis', 1)
            ->get();

        $peserta = Proposal::select('judul','idprogram','idskema','periodeusul','idfokus','thnkerja','status','prosalid','peran','setuju')
            ->leftJoin('tb_keanggota', 'tb_proposal.id', 'tb_keanggota.idpenelitian')
            ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
            //->where('tb_proposal.periodeusul',$periode[0]->id)
            ->where('tb_keanggota.anggotaid', $peneliti->id)
            ->where('tb_penelitian.status',  4)
            ->where('tb_keanggota.setuju', '<', 2)
            ->where('tb_proposal.jenis', 1)
            ->where('tb_proposal.aktif', '1')
            ->orderBy('tb_keanggota.peran', 'asc')
            ->get();

        $minat =  Proposal::leftJoin('tb_keanggota', 'tb_proposal.id', 'tb_keanggota.idpenelitian')
            ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
            //->where('tb_proposal.periodeusul',$periode[0]->id)
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


        return view('pelaksanaan.hasilpenilaian.index', compact('person', 'peneliti', 'periode','periodeterbaru','waktu' ,'proposal', 'total','ketua','peserta','member', 'status', 'minat','upload'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $periode = $request['idtahun'];

        $person = HasilPenilaianController::countPersonil();
        $peneliti = Peneliti::find(Auth::user()->id);
       
        $program = Program::where('kategori', 1)->where('aktif', '1')->get();

        return view('pelaksanaan.hasilpenilaian.create', compact('person', 'peneliti', 'program', 'periode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 2, strlen($temp));


        $penelitian = HasilPenilaian::where('prosalid', $idprop)->first();
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
                return Redirect::back()->withInput()->withErrors(array('error' => 'error'));
            }
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $person = HasilPenilaianController::countPersonil();

        $temp = base64_decode($id);
        $idprop = (Integer)substr($temp, 2, strlen($temp));

        $proposal = Proposal::select('tb_penelitian.prosalid','judul','idprogram','idskema','periodeusul','idfokus','aktif','thnkerja','tb_penelitian.status','jenis','upload')
            ->leftJoin('tb_penelitian', 'tb_penelitian.prosalid', 'tb_proposal.id')
            ->leftJoin('tb_hasil_penilaian', 'tb_hasil_penilaian.prosalid', 'tb_proposal.id')
            // ->where('tb_proposal.jenis', 1)
            ->find($idprop);
        if ($proposal) {

            return view ('pelaksanaan.hasilpenilaian.unggahan', compact('person','proposal'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $idprop = $id;

        $proposal = Proposal::find($idprop);
        if ($proposal) {

            if ($request->hasFile('upload')) {

                $file  = $request->file('upload');
                if ($file->getClientMimeType() !== 'application/pdf' ) {

                }
                else {
                    if ($file->getSize() < 2097152) {
                        $nama_file = "docs-1".mt_rand(100,999).$proposal->id.mt_rand(10,99)."-".$proposal->idketua.".".$file->getClientOriginalExtension();

                        $lokasi = public_path('docs/periode2/rancangan');

                        $file->move($lokasi, $nama_file);

                        $proposal->prosalid =$proposal->id;
                        $proposal->status = 4;
                        $proposal->upload = $nama_file;
                    }
                    else {
                        $message = 'Gagal mengunggah, ukuran dokumen melebihi aturan..';
                        return Redirect::back()->withInput()->withErrors(array('kesalahan' => $message));
                    }
                }
            }

            $subtansi = new HasilPenilaian();

            $subtansi->prosalid = $idprop;
            $subtansi->upload  = $nama_file;
            $subtansi->status     = '7';

            $subtansi->save();
            //$proposal->update();
            return Redirect::route('hasilpenilaian.index', base64_encode(mt_rand(10,99).($idprop*2+29)));
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
        $temp = $id;
        $idprop = (Integer)substr($temp, 2, strlen($temp));
        $idprop /= 3;

        $penelitian = HasilPenilaian::where('prosalid', $idprop)->first();
        $filename = public_path('docs/periode2/rancangan/').$penelitian->upload;
        if ($penelitian) {
            $penelitian->delete();
            File::delete($filename);
        }
    }
}
