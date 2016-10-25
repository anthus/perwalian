<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Cache;
use Validator;
use Vinkla\Hashids\Facades\Hashids;

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

    public function entri_nilai()
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

        $periode = $periodeAll[$index_last_periode];
        $idperiode = $periode['idperiode'];

        $matakuliah = Cache::remember('matakuliah.'.$nip.'.'.$idperiode, 60, function() use ($webservice, $iddosen, $idperiode, $iden){
            return $webservice->periode_matakuliah($iddosen, $idperiode, $iden);
        });

        return view('akademik.entri-nilai', compact('periode', 'matakuliah'));
    }

    public function entri_nilai_input($index)
    {
        $hashid = Hashids::connection('entri-nilai')->decode($index);

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

        $periodeAll = Cache::remember('periode-ajar.'.$nip, 60, function() use ($webservice, $iddosen, $iden){
            return $webservice->periode_ajar($iddosen, $iden);
        });

        $index_last_periode = count($periodeAll) - 2;
        $index_now_periode = count($periodeAll) - 1;

        $periode = $periodeAll[$index_last_periode];
        $idperiode = $periode['idperiode'];

        $matakuliahAll = Cache::remember('matakuliah.'.$nip.'.'.$idperiode, 60, function() use ($webservice, $iddosen, $idperiode, $iden){
            return $webservice->periode_matakuliah($iddosen, $idperiode, $iden);
        });

        if(!isset($matakuliahAll[$index]))
        {
            abort(500);
        }
        $matakuliah = $matakuliahAll[$index];
        $idjadwal = $matakuliah['idjadwal'];

        $validmk = Cache::remember('validmk.'.$nip.'.'.$idjadwal, 60, function() use ($webservice, $idjadwal, $iddosen, $iden){
            return $webservice->cek_validasi_matakuliah($idjadwal, $iddosen, $iden);
        });

        if($validmk['stat'] == 'Valid')
        {
            $bobot = $webservice->tampil_bobot($idjadwal, $iddosen, $iden);

            $mahasiswa = $webservice->periode_detail_matakuliah($iddosen, $idjadwal, $iden);

            return view('akademik.entri-nilai-input', compact('bobot', 'matakuliah', 'mahasiswa'));
        }
        else
        {
            return back()->with('pesan', $validmk['stat']);
        }
    }

    public function update_bobot(Request $request)
    {

        $input = $request->all();
        $jmlBobot = $request->bhadir + $request->btugas + $request->buts + $request->buas;

        $input['jmlBobot'] = $jmlBobot;

        $rules = [
            'bhadir' => 'required|numeric|between:0,100',
            'btugas' => 'required|numeric|between:0,100',
            'buts'   => 'required|numeric|between:0,100',
            'buas'   => 'required|numeric|between:0,100',
            'jmlBobot' => 'numeric|size:100'
        ];

        $message = [
            'required' => 'Semua data harus di isi',
            'numeric' => 'Semua data harus berupa angka',
            'size' => 'Jumlah bobot harus :size',
            'between' => 'Nilai harus diantara :min - :max'
        ];

        $validator = Validator::make($input, $rules, $message)->validate();

        $bool = (bool)$request->boolsyarat;

        $profil = session()->get('dosen');

        $nip = $profil['nip'];
        $iddosen = $profil['iddosen'];
        $iden = $profil['iden'];

        $webservice = new \App\Webservice;

        $bobot = $webservice->update_bobot($request->bidjadwal, $request->bhadir, $request->btugas, $request->buts, $request->buas, $request->bpertemuan, iddosen, $iden, $bool, $request->cname);

        return back();
    }

    public function cek_nilai(Request $request)
    {
        $profil = session()->get('dosen');

        $nip = $profil['nip'];
        $iddosen = $profil['iddosen'];
        $iden = $profil['iden'];

        $webservice = new \App\Webservice;

        $nilai = $webservice->input_nilai($request->idkst, $request->idjadwal, $request->absen, $request->tugas, $request->uts, $request->uas, $request->cname, $iddosen, $iden);

        return $nilai;
    }

    public function update_mutu(Request $request)
    {
        $profil = session()->get('dosen');

        $nip = $profil['nip'];
        $iddosen = $profil['iddosen'];
        $iden = $profil['iden'];

        $webservice = new \App\Webservice;

        $nilaihuruf = $webservice->update_mutu($request->idkst, $request->nilaihuruf, $request->cname, $iddosen, $iden);

        return $nilaihuruf;
    }

    public function publish(Request $request)
    {
        $profil = session()->get('dosen');

        $nip = $profil['nip'];
        $iddosen = $profil['iddosen'];
        $iden = $profil['iden'];

        $webservice = new \App\Webservice;

        $publish = $webservice->publish($request->idjadwal, $iddosen, $iden, $request->cname);

        return redirect()->route('akademik.entri-nilai');
    }
}
