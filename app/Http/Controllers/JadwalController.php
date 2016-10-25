<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Cache;

class JadwalController extends Controller
{
    public function jadwal_mengajar()
    {
        $profil = session()->get('dosen');

        $nip = $profil['nip'];
        $iddosen = $profil['iddosen'];
        $iden = $profil['iden'];

        $webservice = new \App\Webservice;

        $periodeAll = Cache::remember('periode-ajar.'.$nip, 60, function() use ($webservice, $iddosen, $iden){
            return $webservice->periode_ajar($iddosen, $iden);
        });

        $index_last_periode = count($periodeAll) - 2;
        $index_now_periode = count($periodeAll) - 1;

        $periode = $periodeAll[$index_now_periode];
        $idperiode = $periode['idperiode'];

        $matakuliah = Cache::remember('matakuliah.'.$nip.'.'.$idperiode, 60, function() use ($webservice, $iddosen, $idperiode, $iden){
            return $webservice->periode_matakuliah($iddosen, $idperiode, $iden);
        });

        return view('jadwal.mengajar', compact('matakuliah', 'periode'));
    }
}
