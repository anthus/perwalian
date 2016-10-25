<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Webservice extends Model
{
    public $url 		= 'http://203.24.50.30';
    public $port 		= '7475';
    public $portFoto	= '9999';

    private function cek_service($link)
    {
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $link);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    	$result = curl_exec($ch);

    	if($result === false)
    	{
    		return false;
    	}
    	else
    	{
    		$data = json_decode($result, TRUE);
    		return $data['result'][0];
    	}
    }

    public function cek_dosen($nip, $password)
    {
    	$link = $this->url.':'.$this->port.'/Datasnap/Rest/Tservermethods1/logindosen/X'.$nip.'/X'.$password;
    	$service = $this->cek_service($link);

    	if($service['stat'] == 'aktif')
        {
            $gelardpn = '';
            $gelarblk = '';
            if(isset($service['gelardpn'])) {
                $gelardpn = $service['gelardpn'];
            } else if(isset($service['gelarblk'])) {
                $gelarblk = $service['gelarblk'];
            }
            return array(
                'stat' => 'aktif',
                'iddosen' => $service['iddosen'],
                'iden' => $service['iden'],
                'nama' => $service['nama'],
                'gelarblk' => $gelarblk,
                'gelardpn' => $gelardpn,
                'nip' => $nip,
                'password' => $password
            );
        }
        else
        {
            return false;
        }
    }

    public function cek_foto($nim)
    {
        $link = $this->url.':'.$this->portFoto.'/Datasnap/Rest/Tservermethods1/getpicbynim/'.$nim;

        $service = $this->cek_service($link);

        return $service;
    }

    public function periode_ajar($iddosen, $iden)
    {
        $link = $this->url.':'.$this->port.'/Datasnap/Rest/Tservermethods1/periodeajar/'.$iddosen.'/'.$iden;

        $service = $this->cek_service($link);

        return $service;
    }

    public function periode_matakuliah($iddosen, $idperiode, $iden)
    {
        $link = $this->url.':'.$this->port.'/Datasnap/Rest/Tservermethods1/mkdosen/'.$iddosen.'/'.$idperiode.'/'.$iden;

        $service = $this->cek_service($link);

        return $service;
    }

    public function periode_detail_matakuliah($iddosen, $idjadwal, $iden)
    {
        $link = $this->url.':'.$this->port.'/Datasnap/Rest/Tservermethods1/pesertamk/'.$idjadwal.'/'.$iddosen.'/'.$iden;

        $service = $this->cek_service($link);

        return $service;
    }

    public function mahasiswa_bimbingan($iddosen, $iden)
    {
        $link = $this->url.':'.$this->port.'/Datasnap/Rest/Tservermethods1/GetMhsPa/'.$iddosen.'/'.$iden;

        $service = $this->cek_service($link);

        return $service;
    }

    public function lihs_mahasiswa_bimbingan($iddosen, $idmahasiswa, $iden)
    {
        $link = $this->url.':'.$this->port.'/Datasnap/Rest/Tservermethods1/GetPerLihsMhsPa/'.$iddosen.'/'.$idmahasiswa.'/'.$iden;

        $service = $this->cek_service($link);

        return $service;
    }

    public function rekap_lihs_mahasiswa_bimbingan($idmahasiswa, $idperiode, $iddosen, $iden)
    {
        $link = $this->url.':'.$this->port.'/Datasnap/Rest/Tservermethods1/GetMkMhsPa/'.$idmahasiswa.'/'.$idperiode.'/'.$iddosen.'/'.$iden;

        $service = $this->cek_service($link);

        return $service;
    }

    public function get_lirs_mahasiswa($idmahasiswa, $iddosen, $iden)
    {
        $link = $this->url.':'.$this->port.'/Datasnap/Rest/Tservermethods1/GetLirsMhs/'.$idmahasiswa.'/'.$iddosen.'/'.$iden;

        $service = $this->cek_service($link);

        return $service;
    }

    public function validasi_lirs_mahasiswa($status, $idjadwal, $idmahasiswa, $iddosen, $iden)
    {
        $link = $this->url.':'.$this->port.'/Datasnap/Rest/Tservermethods1/ValidasiLirsMhs/'.$status.'/'.$idjadwal.'/'.$idmahasiswa.'/'.$iddosen.'/'.$iden;

        $service = $this->cek_service($link);

        return $service;
    }

    public function cek_validasi_matakuliah($idjadwal, $iddosen, $iden)
    {
        $link = $this->url.':'.$this->port.'/Datasnap/Rest/Tservermethods1/validmk/'.$idjadwal.'/'.$iddosen.'/'.$iden;

        $service = $this->cek_service($link);

        return $service;
    }

    public function tampil_bobot($idjadwal, $iddosen, $iden)
    {
        $link = $this->url.':'.$this->port.'/Datasnap/Rest/Tservermethods1/tampilbobot/'.$idjadwal.'/'.$iddosen.'/'.$iden;

        $service = $this->cek_service($link);

        return $service;
    }

    public function update_bobot($bidjadwal, $bhadir, $btugas, $buts, $buas, $bpertemuan, $iddosen, $iden, $bool, $cname)
    {
        $link = $this->url.':'.$this->port.'/Datasnap/Rest/Tservermethods1/ubahbobot/'.$bidjadwal.'/'.$bhadir.'/'.$btugas.'/'.$buts.'/'.$buas.'/'.$bpertemuan.'/'.$iddosen.'/'.$iden.'/'.$bool.'/'.$cname;

        $service = $this->cek_service($link);

        return $service;
    }

    public function input_nilai($idkst, $idjadwal, $absen, $tugas, $uts, $uas, $cname, $iddosen, $iden)
    {
        $link = $this->url.':'.$this->port.'/Datasnap/Rest/Tservermethods1/inputnilai/'.$idkst.'/'.$idjadwal.'/'.$absen.'/'.$tugas.'/'.$uts.'/'.$uas.'/'.$cname.'/'.$iddosen.'/'.$iden;
        
        $service = $this->cek_service($link);

        return $service;
    }

    public function update_mutu($idkst, $nilaihuruf, $cname, $iddosen, $iden)
    {
        $link = $this->url.':'.$this->port.'/Datasnap/Rest/Tservermethods1/inputnilai/'.$idkst.'/'.$nilaihuruf.'/'.$cname.'/'.$iddosen.'/'.$iden;

        $service = $this->cek_service($link);

        return $service;
    }

    public function publish($idjadwal, $iddosen, $iden, $cname)
    {
        $link = $this->url.':'.$this->port.'/Datasnap/Rest/Tservermethods1/inputnilai/'.$idjadwal.'/'.$iddosen.'/'.$iden.'/'.$cname;

        $service = $this->cek_service($link);

        return $service;
    }

    public function update_password_dosen($iddosen, $iden, $passwordbaru)
    {
        $link = $this->url.':'.$this->port.'/Datasnap/Rest/Tservermethods1/ubahpasswdosen/'.$iddosen.'/'.$iden.'/'.$passwordbaru;
        
        $service = $this->cek_service($link);

        return $service;
    }



























    
}
