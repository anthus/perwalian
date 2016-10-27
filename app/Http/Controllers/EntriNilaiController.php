<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cache;
use Validator;
use Excel;
use PDF;
use Vinkla\Hashids\Facades\Hashids;

class EntriNilaiController extends Controller
{
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

        // if($validmk['stat'] == 'Valid')
        // {
            $bobot = $webservice->tampil_bobot($idjadwal, $iddosen, $iden);

            $mahasiswa = $webservice->periode_detail_matakuliah($iddosen, $idjadwal, $iden);

            return view('akademik.entri-nilai-input', compact('bobot', 'matakuliah', 'mahasiswa', 'index'));
        // }
        // else
        // {
            // return back()->with('pesan', $validmk['stat']);
        // }
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

    public function export_excel($index)
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

        $mahasiswa = $webservice->periode_detail_matakuliah($iddosen, $idjadwal, $iden);

        Excel::create('entri-nilai-siakad', function($excel) use($mahasiswa, $matakuliah) {

    		$excel->sheet('Sheet 1', function($sheet) use($mahasiswa, $matakuliah) {

    			$data['mahasiswa'] = $mahasiswa;
    			$data['matakuliah'] = $matakuliah;

    			$sheet->loadView('export.entri-nilai-excel', $data);

    		});

    	})->download('xls');
    }

    public function export_pdf($index)
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

        $mahasiswa = $webservice->periode_detail_matakuliah($iddosen, $idjadwal, $iden);

        $pdf = PDF::loadView('export.entri-nilai-pdf', compact('mahasiswa', 'matakuliah'));
        return $pdf->stream();
    }
















    public function export_excel_old($idjadwal)
    {
    	$idjadwal = Hashids::connection('entri-nilai')->decode($idjadwal)[0];

    	$profil = session()->get('dosen');

        $nip = $profil['nip'];
        $iddosen = $profil['iddosen'];
        $iden = $profil['iden'];

        $webservice = new \App\Webservice;

        $mahasiswa = Cache::remember('matakuliah-mahasiswa.'.$idjadwal, 60, function() use ($webservice, $iddosen, $idjadwal, $iden) {
        	return $webservice->periode_detail_matakuliah($iddosen, $idjadwal, $iden);
        });

    	Excel::create('entri-nilai-siakad', function($excel) use($mahasiswa) {

    		$excel->sheet('Sheet 1', function($sheet) use($mahasiswa) {

    			$data['mahasiswa'] = $mahasiswa;

    			$sheet->loadView('export.entri-nilai', $data);

    		});

    	})->download('xls');
    }


}
