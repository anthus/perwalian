<?php

Route::get('/', 'ProfilController@home')->name('profil');
Route::post('/auth/login', 'ProfilController@login')->name('login');
Route::get('/auth/logout', 'ProfilController@logout')->name('logout');
Route::get('/cek-foto', 'ProfilController@cek_foto');

Route::group(['middleware' => 'login.session'], function() {

	Route::post('/update-password', 'ProfilController@update_password');

	Route::get('/histori-mengajar', 'HistoriMengajarController@histori_mengajar')->name('akademik.histori-mengajar');
	Route::get('/histori-mengajar/{indexperiode}', 'HistoriMengajarController@daftar_histori_mengajar')->name('akademik.histori-mengajar.periode');
	Route::get('/histori-mengajar/{indexperiode}/{indexjadwal}', 'HistoriMengajarController@detail_histori_mengajar')->name('akademik.histori-mengajar.detail');

	Route::get('/bimbingan', 'BimbinganController@bimbingan')->name('akademik.bimbingan');
	Route::get('/bimbingan/lihs/{index}', 'BimbinganController@bimbingan_lihs')->name('akademik.bimbingan.lihs');
	Route::post('/bimbingan/lirs/validasi', 'BimbinganController@validasi_lirs');
	Route::get('/bimbingan/lirs/{index}', 'BimbinganController@bimbingan_lirs')->name('akademik.bimbingan.lirs');

	Route::get('/entri-nilai', 'EntriNilaiController@entri_nilai')->name('akademik.entri-nilai');
	Route::get('/entri-nilai/{index}', 'EntriNilaiController@entri_nilai_input')->name('akademik.entri-nilai.input');
	Route::post('/entri-nilai/update-bobot', 'EntriNilaiController@update_bobot');
	Route::post('/entri-nilai/cek-nilai', 'EntriNilaiController@cek_nilai');
	Route::post('/entri-nilai/update-mutu', 'EntriNilaiController@update_mutu');
	Route::post('/entri-nilai/publish', 'EntriNilaiController@publish');

	Route::get('/entri-nilai/export-excel/{idjadwal}', 'EntriNilaiController@export_excel')->name('akademik.export-excel');
	Route::get('/entri-nilai/export-pdf/{idjadwal}', 'EntriNilaiController@export_pdf')->name('akademik.export-pdf');

	Route::get('/jadwal-mengajar', 'JadwalController@jadwal_mengajar')->name('jadwal.mengajar');

	
});
