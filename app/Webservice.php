<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Webservice extends Model
{
    private $url 		= 'http://203.24.50.30';
    private $port 		= '7475';
    private $portFoto	= '9999';

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
                'nip' => $nip
            );
        }
        else
        {
            return false;
        }
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



























    public function validlirs($idmhs, $iden)
    {
        $link = $this->url.':'.$this->port.'/Datasnap/Rest/Tservermethods1/validlirs/'.$idmhs.'/'.$iden;

        $service = $this->cek_service($link);

        return $service;
    }

    public function tampil_lirs($idmhs, $idperiode, $iden)
    {
        $link = $this->url.':'.$this->port.'/Datasnap/Rest/Tservermethods1/tampillirs/'.$idmhs.'/'.$idperiode.'/'.$iden;
        $service = $this->cek_service($link);

        return $service;
    }

    public function tampil_lirs_all($idprogdi, $idprogram, $idperiode)
    {
        $link = $this->url.':'.$this->port.'/Datasnap/Rest/Tservermethods1/jadwal/'.$idprogdi.'/'.$idprogram.'/'.$idperiode;
        $service = $this->cek_service($link);

        return $service;
    }

    public function input_lirs($idmhs, $idjadwal, $idmatakuliah, $idperiode, $iden, $cname)
    {
        $link = $this->url.':'.$this->port.'/Datasnap/Rest/Tservermethods1/inputlirs/'.$idmhs.'/'.$idjadwal.'/'.$idmatakuliah.'/'.$idperiode.'/'.$iden.'/'.$cname;

        $service = $this->cek_service($link);

        return $service;
    }

    public function periode_lihs($idmhs, $iden)
    {
        $link = $this->url.':'.$this->port.'/Datasnap/Rest/Tservermethods1/periodelihs/'.$idmhs.'/'.$iden;

        $service = $this->cek_service($link);

        return $service;
    }

    public function tampil_lihs($idmhs, $idperiode, $iden)
    {
        $link = $this->url.':'.$this->port.'/Datasnap/Rest/Tservermethods1/tampillihs/'.$idmhs.'/'.$idperiode.'/'.$iden;

        $service = $this->cek_service($link);

        return $service;
    }

    public function transkrip($idmhs, $iden)
    {
        $link = $this->url.':'.$this->port.'/Datasnap/Rest/Tservermethods1/transkrip/'.$idmhs.'/'.$iden;

        $service = $this->cek_service($link);

        return $service;
    }

    public function periode_bayar($idmhs, $iden)
    {
        $link = $this->url.':'.$this->port.'/Datasnap/Rest/Tservermethods1/periodebayar/'.$idmhs.'/'.$iden;

        $service = $this->cek_service($link);

        return $service;
    }

    public function detail_bayar($idmhs, $idperiode, $iden)
    {
        $link = $this->url.':'.$this->port.'/Datasnap/Rest/Tservermethods1/tampilbayar/'.$idmhs.'/'.$idperiode.'/'.$iden;

        $service = $this->cek_service($link);

        return $service;
    }
}
