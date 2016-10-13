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
}
