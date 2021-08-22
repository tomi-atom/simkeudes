<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use App\User;


use Hash;
use Auth;
use Redirect;

class ProfilController extends Controller
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
        //
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
        $iduser = (Integer)substr($temp, 2, strlen($temp));


        $user = user::find($iduser);

        return view('profile.show', compact('person', 'user', 'profil', 'pt', 'fk', 'pd', 'fungsi', 'struktur', 'pddk', 'ilmu', 'ilmu2', 'ilmu3' ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $person = ProfilController::countPersonil();

        $temp = base64_decode($id);
        $iduser = (Integer)substr($temp, 2, strlen($temp));


        $user = User::find($iduser);

        return view('profile.edit', compact('person','user'));
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
        //$temp = base64_decode($id);
        //$iduser = (Integer)substr($temp, 2, strlen($temp));
        $iduser = $id;

        $data = $request->all();

        $validator = Validator::make($data, [
            'oldpass' => 'required|string|min:6',
            'newpass' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->route('profile.edit',$iduser)
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = User::find($iduser);

        if ($request['newpass'] != $request['confirm'])
        {   
            $message = 'Password confirmation does not match.';
                    return Redirect::back()->withInput()->withErrors(array('confirm' => $message));
        }
        else if(!empty($request['newpass'])) 
        {
            //$user = User::where('email', $user->nidn)->first();
            if(Hash::check($request['oldpass'], $user->password)) {

                $user->password = bcrypt($request['newpass']);
                $user->update();


            }
            else {
                $message = 'The old password didn\'t recognize';
                    return Redirect::back()->withInput()->withErrors(array('oldpass' => $message));
            }
        }
        else
        {
            $message = 'The new password didnt identify';
                        return Redirect::back()->withInput()->withErrors(array('kesalahan' => $message));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $temp = base64_decode($id);
        $iduser = (Integer)substr($temp, 2, strlen($temp));

        $data = $request->all();

        $validator = Validator::make($data, [
            'nip' => 'required|numeric',
            'profil' => 'image|mimes:png|max:512',
            'sinta' => 'required|numeric|digits_between:2,10',
            'hindex' => 'required|numeric',
            'pakar' => 'required|string|max:64',
            'email' => 'required|string|email|max:128',
        ]);

        if ($validator->fails()) {
            return redirect()->route('profile.show', base64_encode(mt_rand(10,99).$iduser))
                        ->withErrors($validator)
                        ->withInput();
        }

        if ($request->hasFile('profil')) {

            $file  = $request->file('profil');
            if ($file->getClientMimeType() !== 'image/png' ) {
                $message = 'The profil must be a png image';
                return Redirect::back()->withInput()->withErrors(array('profil' => $message));
            }
            else {
                if ($file->getSize() < 614400) {
                    $nama_file = "prf-".mt_rand(100,999)."-".$user->id.mt_rand(10,99).".".$file->getClientOriginalExtension();

                    $lokasi = public_path('images');

                    $file->move($lokasi, $nama_file);

                    $user->foto = $nama_file;

                    $user->update();
                }
                else {
                    $message = 'The image may not be greater than 512 kilobytes.';
                    return Redirect::back()->withInput()->withErrors(array('profil' => $message));
                }
            }

        }


        $user->email      = $request['email'];

        $user->update();
        return Redirect::back()->withInput()->withErrors(array('success' => 'success'));
    }
}
