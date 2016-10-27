<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cache;
use Vinkla\Hashids\Facades\Hashids;

class BimbinganController extends Controller
{
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
        $hashid = Hashids::connection('bimbingan')->decode($index);

        if(!isset($hashid[0]))
        {
            abort(500);
        }
        $index = $hashid[0];

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
        $hashid = Hashids::connection('bimbingan')->decode($index);

        if(!isset($hashid[0]))
        {
            abort(500);
        }
        $index = $hashid[0];
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

        $lirs = Cache::remember('bimbingan-lirs.'.$nip.'.'.$idmahasiswa, 60, function() use ($webservice, $iddosen, $idmahasiswa, $iden){
            return $webservice->get_lirs_mahasiswa($idmahasiswa, $iddosen, $iden);
        });

        // print_r($lirs);
        return view('akademik.bimbingan-lirs', compact('mahasiswa', 'lirs'));
    }

    public function validasi_lirs(Request $request)
    {
        $profil = session()->get('dosen');

        $nip = $profil['nip'];
        $iddosen = $profil['iddosen'];
        $iden = $profil['iden'];

        $webservice = new \App\Webservice;

        $jadwal = $request->idjadwal;
        $idmahasiswa = $request->idmahasiswa;
        $status = $request->status;
        
        $idjadwalArray = explode(",", $jadwal);

        foreach($idjadwalArray as $key => $idjadwal)
        {
            $webservice->validasi_lirs_mahasiswa($status, $idjadwal, $idmahasiswa, $iddosen, $iden);
        }

        Cache::forget('bimbingan-lirs.'.$nip.'.'.$idmahasiswa);

        return "Validasi Sukses";
    }
}
