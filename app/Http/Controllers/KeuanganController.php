<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Cache;

class KeuanganController extends Controller
{
    public function biaya_kuliah()
    {
    	$profil = session()->get('mhs');

    	$nim = $profil['nim'];
    	$idmhs = $profil['idmhs'];
    	$iden = $profil['iden'];

    	$webservice = new \App\Webservice;

    	$periode = Cache::remember('periode-bayar.'.$nim, 60, function() use ($webservice, $idmhs, $iden){
            return $webservice->periode_bayar($idmhs, $iden);
        });

        foreach($periode as $key => $value)
        {
        	$data = $webservice->detail_bayar($idmhs, $value['idperiode'], $iden);
        	$detail[$key]['tagihan'] = $data[0]['jumlah'];
        	$detail[$key]['pembayaran'] = $data[1]['jumlah'];
        	$detail[$key]['thakad'] = $value['thakad'];
        	$detail[$key]['semester'] = $value['semester'];
        	$detail[$key]['bank'] = $data[1]['cname'];
        }
    	return view('keuangan.biaya-kuliah', compact('detail'));
    }
}
