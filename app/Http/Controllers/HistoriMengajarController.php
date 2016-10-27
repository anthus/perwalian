<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cache;
use Vinkla\Hashids\Facades\Hashids;

class HistoriMengajarController extends Controller
{
    public function histori_mengajar()
    {
        $profil = session()->get('dosen');

        $nip = $profil['nip'];
        $iddosen = $profil['iddosen'];
        $iden = $profil['iden'];

        $webservice = new \App\Webservice;

        $periode = Cache::remember('periode-ajar.'.$nip, 60, function() use ($webservice, $iddosen, $iden){
            return $webservice->periode_ajar($iddosen, $iden);
        });

        krsort($periode);
        
        return view('akademik.histori-mengajar', compact('periode'));
    }

    public function daftar_histori_mengajar($indexperiode)
    {

        $hashid = Hashids::connection('histori-mengajar')->decode($indexperiode);
        if(!isset($hashid[0]))
        {
            abort(500);
        }
        $indexperiode = $hashid[0];

        $profil = session()->get('dosen');

        $nip = $profil['nip'];
        $iddosen = $profil['iddosen'];
        $iden = $profil['iden'];

        $webservice = new \App\Webservice;

        $periodeAll = Cache::remember('periode-ajar.'.$nip, 60, function() use ($webservice, $iddosen, $iden){
            return $webservice->periode_ajar($iddosen, $iden);
        });

        if(!isset($periodeAll[$indexperiode]))
        {
            abort(500);
        }
        $periode = $periodeAll[$indexperiode];
        $idperiode = $periode['idperiode'];

        $matakuliah = Cache::remember('matakuliah.'.$nip.'.'.$idperiode, 60, function() use ($webservice, $iddosen, $idperiode, $iden){
            return $webservice->periode_matakuliah($iddosen, $idperiode, $iden);
        });

        return view('akademik.histori-mengajar-daftar', compact('matakuliah', 'periode', 'indexperiode'));
    }

    public function detail_histori_mengajar($indexperiode, $indexjadwal)
    {
        $hashid1 = Hashids::connection('histori-mengajar')->decode($indexperiode);
        $hashid2 = Hashids::connection('histori-mengajar')->decode($indexjadwal);

        if(!isset($hashid1[0]) || !isset($hashid2[0]))
        {
            abort(500);
        }

        $indexperiode = $hashid1[0];
        $indexjadwal = $hashid2[0];

        $profil = session()->get('dosen');

        $nip = $profil['nip'];
        $iddosen = $profil['iddosen'];
        $iden = $profil['iden'];

        $webservice = new \App\Webservice;

        $periodeAll = Cache::remember('periode-ajar.'.$nip, 60, function() use ($webservice, $iddosen, $iden){
            return $webservice->periode_ajar($iddosen, $iden);
        });

        if(!isset($periodeAll[$indexperiode]))
        {
            abort(500);
        }
        $periode = $periodeAll[$indexperiode];
        $idperiode = $periode['idperiode'];

        $matakuliahAll = Cache::remember('matakuliah.'.$nip.'.'.$idperiode, 60, function() use ($webservice, $iddosen, $idperiode, $iden){
            return $webservice->periode_matakuliah($iddosen, $idperiode, $iden);
        });

        if(!isset($matakuliahAll[$indexjadwal]))
        {
            abort(500);
        }
        $matakuliah = $matakuliahAll[$indexjadwal];
        $idjadwal = $matakuliah['idjadwal'];

        $mahasiswa = Cache::remember('detail-matakuliah.'.$nip.'.'.$idjadwal, 60, function() use ($webservice, $iddosen, $idjadwal, $iden){
            return $webservice->periode_detail_matakuliah($iddosen, $idjadwal, $iden);
        });

        return view('akademik.histori-mengajar-detail', compact('mahasiswa', 'matakuliah', 'indexperiode'));
    }
}
