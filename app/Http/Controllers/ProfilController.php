<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Cache;

class ProfilController extends Controller
{
    public function home()
    {
    	if(session()->has('success_login') && session()->has('dosen'))
    	{
    		return view('profil');
    	}
    	return view('login');
    }

    public function login(Request $request)
    {
    	$nip = $request->nip;
    	$password = $request->password;

    	$webservice = new \App\Webservice;

        Cache::forget('dosen.'.$nip);
    	$profil = Cache::remember('dosen.'.$nip, 60, function() use ($webservice, $nip, $password){
    		return $webservice->cek_dosen($nip, $password);
    	});

        if(!$profil)
        {
            return redirect('/')->with('error', 'Periksa kembali username dan password anda');
        }

    	session()->put('dosen', $profil);
    	session()->put('success_login', TRUE);

    	return redirect('/');
    }

    public function logout()
    {
        session()->flush();
        Cache::flush();
        return redirect('/');
    }

    public function update_password(Request $request)
    {
        $profil = session()->get('dosen');
        $iddosen = $profil['iddosen'];
        $iden = $profil['iden'];

       if($request->password_lama == '' || $request->password_baru == '' || $request->konfirmasi_password == '')
       {
            return back()->with('error', 'Form harus di isi semua');
       }
       else if($request->password_lama != $profil['password'])
       {
            return back()->with('error', 'Password lama berbeda');
       }
       else if(strlen($request->password_baru) < 5)
       {
            return back()->with('error', 'Password baru minimal 5 karakter');
       }
       else if($request->password_baru != $request->konfirmasi_password)
       {
            return back()->with('error', 'Konfirmasi password tidak sama');
       }
       else
       {
            $webservice = new \App\Webservice;
            $webservice->update_password_dosen($iddosen, $iden, $request->password_baru);

            return back()->with('berhasil', 'Update password berhasil');
       }
    }

    public function cek_foto(Request $request)
    {
        header(" Content-Type: image/jpeg");
        header(" Content-Disposition: inline");

        $nim = $request->nim;
        $webservice = new \App\Webservice;

        $foto = Cache::remember('foto.'.$nim, 60, function() use ($webservice, $nim)
        {
            return $webservice->cek_foto($nim);
        });     
        
        if($foto['photo'] != NULL)
        {
            echo base64_decode($foto['photo']);
        }
        else
        {
            echo base64_decode('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
            ');
        }
    }
}
