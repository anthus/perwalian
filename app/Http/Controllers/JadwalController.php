<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Cache;

class JadwalController extends Controller
{
    public function jadwal_pribadi()
    {
    	$profil = session()->get('mhs');

    	$nim = $profil['nim'];
    	$idmhs = $profil['idmhs'];
    	$iden = $profil['iden'];
    	$idperiode = $profil['idperiode'];

    	$webservice = new \App\Webservice;

    	$lirs = Cache::remember('lirs'.$nim, 60, function() use ($webservice, $idmhs, $idperiode, $iden){
			return $webservice->tampil_lirs($idmhs, $idperiode, $iden);
		});
    	return view('jadwal.pribadi', compact('lirs'));
    }

    public function jadwal_prodi()
    {
    	$profil = session()->get('mhs');

    	$nim = $profil['nim'];
    	$idperiode = $profil['idperiode'];
    	$idprogdi = $profil['idprogdi'];
    	$idprogram = $profil['idprogram'];

    	$webservice = new \App\Webservice;

		$lirsAll = Cache::remember('lirs-all.'.$nim, 60, function() use ($webservice, $idprogdi, $idprogram, $idperiode){
			return $webservice->tampil_lirs_all($idprogdi, $idprogram, $idperiode);
		});
		return view('jadwal.prodi', compact('lirsAll'));
    }
}
