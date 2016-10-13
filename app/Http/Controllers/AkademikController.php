<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Cache;

class AkademikController extends Controller
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

    public function bimbingan()
    {
        $profil = session()->get('dosen');

        $nip = $profil['nip'];
        $iddosen = $profil['iddosen'];
        $iden = $profil['iden'];

        $webservice = new \App\Webservice;

        $bimbingan = Cache::remember('bimbingan.'.$nip, 60, function() use ($webservice, $iddosen, $iden){
            return $webservice->mahasiswa_bimbingan($iddosen, $iden);
        });

        return view('akademik.bimbingan', compact('bimbingan'));
    }

    public function bimbingan_lihs($index)
    {
        $profil = session()->get('dosen');

        $nip = $profil['nip'];
        $iddosen = $profil['iddosen'];
        $iden = $profil['iden'];

        $webservice = new \App\Webservice;

        $bimbinganAll = Cache::remember('bimbingan.'.$nip, 60, function() use ($webservice, $iddosen, $iden){
            return $webservice->mahasiswa_bimbingan($iddosen, $iden);
        });

        if(!isset($bimbinganAll[$index]))
        {
            abort(500);
        }
        $mahasiswa = $bimbinganAll[$index];
        $idmahasiswa = $mahasiswa['idmahasiswa'];

        $lihs = Cache::remember('bimbingan-lihs.'.$nip.'.'.$mahasiswa['nim'], 60, function() use ($webservice, $iddosen, $idmahasiswa, $iden){
            return $webservice->lihs_mahasiswa_bimbingan($iddosen, $idmahasiswa, $iden);
        });

        foreach($lihs as $key => $data)
        {
            $idperiode = $data['idperiode'];
            $rekap = Cache::remember('bimbingan-lihs.'.$nip.'.'.$mahasiswa['nim'].'.'.$idperiode, 60, function() use ($webservice, $iddosen, $idmahasiswa, $iden, $idperiode){
                return $webservice->rekap_lihs_mahasiswa_bimbingan($idmahasiswa, $idperiode, $iddosen, $iden);
            });
            $lihs[$key]['rekap'] = $rekap;

            $grafik_ips[] = round($data['ips'], 2);
            $grafik_periode[] = $data['thakad'].' '.\App\Convert::ubah_semester($data['semester']);
        }

        array_pop($grafik_ips);
        array_pop($grafik_periode);

        $json_ips = json_encode($grafik_ips);
        $json_periode = json_encode($grafik_periode);

        krsort($lihs);

        return view('akademik.bimbingan-lihs', compact('mahasiswa', 'lihs', 'json_ips', 'json_periode'));
    }

    public function bimbingan_lirs($index)
    {
        $profil = session()->get('dosen');

        $nip = $profil['nip'];
        $iddosen = $profil['iddosen'];
        $iden = $profil['iden'];

        $webservice = new \App\Webservice;

        $bimbinganAll = Cache::remember('bimbingan.'.$nip, 60, function() use ($webservice, $iddosen, $iden){
            return $webservice->mahasiswa_bimbingan($iddosen, $iden);
        });

        if(!isset($bimbinganAll[$index]))
        {
            abort(500);
        }
        $mahasiswa = $bimbinganAll[$index];
        $idmahasiswa = $mahasiswa['idmahasiswa'];

        $lirs = Cache::remember('bimbingan-lirs.'.$nip.'.'.$mahasiswa['nim'], 60, function() use ($webservice, $iddosen, $idmahasiswa, $iden){
            return $webservice->get_lirs_mahasiswa($idmahasiswa, $iddosen, $iden);
        });

        // print_r($lirs);
        return view('akademik.bimbingan-lirs', compact('mahasiswa', 'lirs'));
    }
}
