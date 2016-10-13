<?php

Route::get('/', 'ProfilController@home')->name('profil');
Route::post('/auth/login', 'ProfilController@login')->name('login');
Route::get('/auth/logout', 'ProfilController@logout')->name('logout');

Route::group(['middleware' => 'login.session'], function() {

	Route::get('/histori-mengajar', 'AkademikController@histori_mengajar')->name('akademik.histori-mengajar');
	Route::get('/histori-mengajar/{indexperiode}', 'AkademikController@daftar_histori_mengajar')->name('akademik.histori-mengajar.periode');
	Route::get('/histori-mengajar/{indexperiode}/{indexjadwal}', 'AkademikController@detail_histori_mengajar')->name('akademik.histori-mengajar.detail');

	Route::get('/bimbingan', 'AkademikController@bimbingan')->name('akademik.bimbingan');
	Route::get('/bimbingan/lihs/{index}', 'AkademikController@bimbingan_lihs')->name('akademik.bimbingan.lihs');
	Route::get('/bimbingan/lirs/{index}', 'AkademikController@bimbingan_lirs')->name('akademik.bimbingan.lirs');




	Route::get('/rencana-studi/modifikasi', 'AkademikController@modifikasi_lirs')->name('akademik.lirs.modifikasi');
	Route::post('/rencana-studi/modifikasi', 'AkademikController@modifikasi_lirs_input');

	Route::get('/hasil-studi', 'AkademikController@lihs')->name('akademik.lihs');
	Route::get('/hasil-studi/{idperiode}', 'AkademikController@detail_lihs')->name('akademik.lihs.periode');

	Route::get('/transkrip', 'AkademikController@transkrip')->name('akademik.transkrip');

	Route::get('/jadwal-pribadi', 'JadwalController@jadwal_pribadi')->name('jadwal.pribadi');
	Route::get('/jadwal-prodi', 'JadwalController@jadwal_prodi')->name('jadwal.prodi');

	Route::get('/biaya-kuliah', 'KeuanganController@biaya_kuliah')->name('keuangan.biaya-kuliah');

	
});

Route::get('500', function()
{
    abort(500);
});