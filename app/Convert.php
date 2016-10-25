<?php

namespace App;
 
use Illuminate\Database\Eloquent\Model;

class Convert extends Model
{
	public static function make_slug($judul)
	{
		$slug = strtolower($judul);
		$slug = str_replace('"', '', $slug);
		$slug = str_replace("'", "", $slug);
		$slug = str_replace(',', '', $slug);
		$slug = str_replace('-', '', $slug);
		$slug = str_replace(' ', '-', $slug);
		$slug = str_replace(':', '', $slug);
		$slug = str_replace('(', '', $slug);
		$slug = str_replace(')', '', $slug);
		$slug = str_replace('?', '', $slug);
		$slug = str_replace('/', '-', $slug);
		return $slug;
	}
	public static function escape_quote($text)
	{
		$slug = str_replace('"', "'", $text);
		return $slug;
	}

	// Konvesi dd-mm-yyyy -> yyyy-mm-dd
	public static function tgl_ind_to_eng($tgl) {
		$tgl_eng=substr($tgl,6,4)."-".substr($tgl,3,2)."-".substr($tgl,0,2);
		return $tgl_eng;
	}

	// Konvesi yyyy-mm-dd -> dd-mm-yyyy
	public static function tgl_eng_to_ind($tgl) {
		$tgl_ind=substr($tgl,8,2)."-".substr($tgl,5,2)."-".substr($tgl,0,4);
		return $tgl_ind;
	}

	public static function ambil_tanggal($tanggal)
	{
		$date = explode('-',$tanggal);
		$date = $date[2];
		return $date;
	}
	public static function ambil_bulan($bulan)
	{
		$mounth = explode('-',$bulan);
		$mounth = $mounth[1];
		return $mounth;
	}
	public static function ubah_bulan($bulan)
	{
		if($bulan==1){$nama='Januari';}
		elseif($bulan==2){$nama='Februari';}
		elseif($bulan==3){$nama='Maret';}
		elseif($bulan==4){$nama='April';}
		elseif($bulan==5){$nama='Mei';}
		elseif($bulan==6){$nama='Juni';}
		elseif($bulan==7){$nama='Juli';}
		elseif($bulan==8){$nama='Aguustus';}
		elseif($bulan==9){$nama='September';}
		elseif($bulan==10){$nama='Oktober';}
		elseif($bulan==11){$nama='November';}
		elseif($bulan==12){$nama='Desember';}

		return $nama;
	}

	public static function tanggal_indo($date){
		$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

		$tahun = substr($date, 0, 4);
		$bulan = substr($date, 5, 2);
		$tgl   = substr($date, 8, 2);

		$result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;
		return $result;
	}

	public static function ubah_tanda_strip($data) {
		$hasil = ucwords(str_replace('-', ' ', $data));
		return $hasil;
	}

	public static function hitung_ambil_sks($ips)
	{
		$ip = round($ips, 2);
		if($ip >= 3.00) {
			$sks = 24;
		} else if($ip >= 2.50 && $ip <= 2.99) {
			$sks = 21;
		} else if($ip >= 2.00 && $ip <= 2.49) {
			$sks = 18;
		} else if($ip >= 1.50 && $ip <= 1.99) {
			$sks = 15;
		} else if($ip < 1.50) {
			$sks = 12;
		}
		return $sks;
	}

	public static function ubah_semester($smt)
	{
		switch ($smt) {
			case 1:
				return "Ganjil";
				break;
			
			case 2:
				return "Genap";
				break;
		}
	}

	public static function status_lirs($status)
	{
		if($status == 0) {
			$text = "<h4 style='margin:0;'><span class='label label-sm label-default'>Belum Diverifikasi</span></h4>";
		}
		else if($status == 1) {
			$text = "<h4 style='margin:0;'><span class='label label-sm label-success'>Diterima</span></h4>";
		}
		else if($status == 2) {
			$text = "<h4 style='margin:0;'><span class='label label-sm label-danger'>Ditolak</span></h4>";
		}
		else if($status == 3) {
			$text = "<h4 style='margin:0;'><span class='label label-sm label-warning'>Diterima Akademik</span></h4>";
		}
		return $text;
	}

	public static function status_perkuliahan($status)
	{
		switch ($status) {
			case 1:
				return "Reguler";
				break;
			
			case 2:
				return "Non Reguler";
				break;
		}
	}

	public static function status_publish($status)
	{
		switch ($status) {
			case 1:
				return "Sudah Terpublish";
				break;
			default:
				return "Belum Terpublish";
				break;
		}
	} 
}