<?php

Route::get('/', 'ProfilController@home')->name('profil');
Route::post('/auth/login', 'ProfilController@login')->name('login');
Route::get('/auth/logout', 'ProfilController@logout')->name('logout');
Route::get('/cek-foto', 'ProfilController@cek_foto');

Route::group(['middleware' => 'login.session'], function() {

	Route::post('/update-password', 'ProfilController@update_password');

	Route::get('/histori-mengajar', 'AkademikController@histori_mengajar')->name('akademik.histori-mengajar');
	Route::get('/histori-mengajar/{indexperiode}', 'AkademikController@daftar_histori_mengajar')->name('akademik.histori-mengajar.periode');
	Route::get('/histori-mengajar/{indexperiode}/{indexjadwal}', 'AkademikController@detail_histori_mengajar')->name('akademik.histori-mengajar.detail');

	Route::get('/bimbingan', 'AkademikController@bimbingan')->name('akademik.bimbingan');
	Route::get('/bimbingan/lihs/{index}', 'AkademikController@bimbingan_lihs')->name('akademik.bimbingan.lihs');
	Route::post('/bimbingan/lirs/validasi', 'AkademikController@validasi_lirs');
	Route::get('/bimbingan/lirs/{index}', 'AkademikController@bimbingan_lirs')->name('akademik.bimbingan.lirs');

	Route::get('/entri-nilai', 'AkademikController@entri_nilai')->name('akademik.entri-nilai');
	Route::get('/entri-nilai/{index}', 'AkademikController@entri_nilai_input')->name('akademik.entri-nilai.input');
	Route::post('/entri-nilai/update-bobot', 'AkademikController@update_bobot');
	Route::post('/entri-nilai/cek-nilai', 'AkademikController@cek_nilai');
	Route::post('/entri-nilai/update-mutu', 'AkademikController@update_mutu');
	Route::post('/entri-nilai/publish', 'AkademikController@publish');

	Route::get('/jadwal-mengajar', 'JadwalController@jadwal_mengajar')->name('jadwal.mengajar');

	
});

Route::get('500', function()
{
    abort(500);
});