@extends('dashboard')

@section('content')
<?php 
$oricname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$cname = substr($oricname,0,19);
?>
<div class="page-title">
	<div class="title_left" style="width: 100%;">
        <h3>Entri Nilai</h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel" style="min-height: 650px;">
			<div class="x_title">
				<h2>Daftar Mahasiswa</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row" style="margin-bottom: 20px;">
					<div class="col-md-2">
						<a href="{{ route('akademik.entri-nilai') }}" class="btn btn-sm btn-warning btn-block" type="button"><i class="fa fa-chevron-left"></i>
						Kembali</a>
					</div>
					<div class="col-md-2">
						<a href="{{ route('akademik.export-excel',  Hashids::connection('entri-nilai')->encode($index)) }}" class="btn btn-sm btn-success btn-block" type="button"><i class="fa fa-file"></i>
						Export Excel</a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-md-push-6">
						<div class="row top_tiles" style="margin-top: 30px;">
							<div class="col-md-12 col-xs-6 tile">
								<span>Nama Matakuliah</span>
								<h2>{{ $matakuliah['namamk'] }}</h2>
							</div>
							<div class="col-md-12 col-xs-6 tile">
								<span>Program</span>
								<h2>{{ $matakuliah['program'] }}</h2>
							</div>
							<div class="col-md-12 col-xs-6 tile">
								<span>Kelas</span>
								<h2>{{ $matakuliah['kelas'] }}</h2>
							</div>
							<div class="col-md-12 col-xs-6 tile">
								<span>Jumlah Mahasiswa</span>
								<h2>{{ count($mahasiswa) }}</h2>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-md-pull-6">
						@if (count($errors) > 0)
						    {{-- <div class="alert alert-danger"> --}}
						        <ul style="margin-left: 10px;">
						            @foreach ($errors->all() as $error)
						                <li style="color: #E96152;">{{ $error }}</li>
						            @endforeach
						        </ul>
						    {{-- </div> --}}
						@endif
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Jenis</th>
									<th>Data Lama</th>
									<th>Data Baru</th>
								</tr>
							</thead>
							<tbody>
								<form action="update-bobot" method="post">
									<tr>
										<td>Aktifitas</td>
										<td>{{ $bobot[0]['bhadir'] }} %</td>
										<td><input style="width: 50px;" type="text" name="bhadir" value="{{ $bobot[0]['bhadir'] }}""></td>
									</tr>
									<tr>
										<td>Tugas</td>
										<td>{{ $bobot[0]['btugas'] }} %</td>
										<td><input style="width: 50px;" type="text" name="btugas" value="{{ $bobot[0]['btugas'] }}"></td>
									</tr>
									<tr>
										<td>UTS</td>
										<td>{{ $bobot[0]['buts'] }} %</td>
										<td><input style="width: 50px;" type="text" name="buts" value="{{ $bobot[0]['buts'] }}"></td>
									</tr>
									<tr>
										<td>UAS</td>
										<td>{{ $bobot[0]['buas'] }} %</td>
										<td><input style="width: 50px;" type="text" name="buas" value="{{ $bobot[0]['buas'] }}"></td>
									</tr>
									<tr>
										<td>Jumlah Pertemuan</td>
										<td>{{ $bobot[0]['pertemuan'] }} Pertemuan</td>
										<td><input style="width: 50px;" type="text" name="bpertemuan" value="{{ $bobot[0]['pertemuan'] }}"></td>
									</tr>
									<tr>
										<td></td>
										<td>
											<div class="checkbox">
					                            <label>
					                            	<input type="checkbox" name="boolsyarat" value="75" checked=""> Harus memenuhi minimal 75% kehadiran
					                            </label>
					                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
					                            <input type="hidden" name="bcname" value="<?php echo $cname; ?>" />
					                            <input type="hidden" name="bidjadwal" value="{{ $matakuliah['idjadwal'] }}">
					                        </div>
										</td>
										<td>
											<button type="submit" class="btn btn-primary">Simpan</button>
										</td>
									</tr>
								</form>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div style="text-align: center;">
						<h3 style="margin-left: 20px;">Pilih Model Input</h3>
						<div class="radio" style="display: inline-block;">
	                        <label class="">
	                        	<div class="iradio_flat-green" style="position: relative;">
	                        		<input type="radio" class="flat" checked="" name="modelInput" value="komponen"></div> Per-Komponen
	                        </label>
	                    </div>
	                    <div class="radio" style="display: inline-block;">
	                        <label class="">
	                        	<div class="iradio_flat-green" style="position: relative;">
	                        		<input type="radio" class="flat" name="modelInput" value="nilai_huruf"></div> Nilai Huruf
	                        </label>
	                    </div>
	                    <br>
	                    <img id="loading" src="{{ asset('images/loading.gif') }}" alt="" style="position: absolute; width: 50px;">
					</div>
					
					<div class="table-responsive" style="margin-left: 10px; margin-top: 20px;">
						
						<table class="table table-striped table-hover" id="datatable">
							<thead>
								<tr>
									<th>No</th>
									<th>NIM</th>
									<th>Nama Mahasiswa</th>
									<th>Absen</th>
									<th>Tugas</th>
									<th>UTS</th>
									<th>UAS</th>
									<th></th>
									<th>Total</th>
									<th>Nilai Huruf</th>
								</tr>
							</thead>
							<tbody>
								@foreach($mahasiswa as $key => $value)
								<tr>
									<td>{{ $key + 1 }}</td>
									<td>{{ $value['nim'] }}</td>
									<td>{{ $value['nama'] }}</td>
									<td><input style="width: 50px;" class="input_absen" type="text" name="absen.{{ $value['nim'] }}" value="{{ $value['absen'] }}"></td>
									<td><input style="width: 50px;" class="input_tugas" type="text" name="tugas.{{ $value['nim'] }}" value="{{ $value['tugas'] }}"></td>
									<td><input style="width: 50px;" class="input_uts" type="text" name="uts.{{ $value['nim'] }}" value="{{ $value['uts'] }}"></td>
									<td><input style="width: 50px;" class="input_uas" type="text" name="uas.{{ $value['nim'] }}" value="{{ $value['uas'] }}"></td>
									<td><button class="btn btn-xs btn-primary btn_cek" onclick='cek_nilai("{{ $value['nim'] }}", "{{ $value['idkst'] }}")'>Cek</button></td>
									<td><span class="text_total_{{ $value['nim'] }} span_total">{{ $value['nilaitotal'] }}</span></td>
									<td>
										<span class="text_huruf_{{ $value['nim'] }} span_huruf">{{ $value['nilaihuruf'] }}</span>
										<input style="display: none; width: 50px;" class="input_mutu" type="text" name="mutu.{{ $value['nim'] }}" value="{{ $value['nilaihuruf'] }}" onblur='update_mutu("{{ $value['nim'] }}", "{{ $value['idkst'] }}")'></td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 pull-right">
						<h4 style="color:  #E96152;">Perhatian! : Setelah mempublish nilai, Anda tidak dapat menginput/mengedit kembali nilai-nilai yang ada. </h4>
						<form action="publish" method="post" id="form_publish">
							<input type="hidden" name="idjadwal" value="{{ $matakuliah['idjadwal'] }}">
							<input type="hidden" name="cname" value="<?php echo $cname; ?>">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<button type="button" onclick="publish()" class="btn btn-danger">Publish</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('plugin')
<script type="text/javascript">
	$(document).ready(function(){
	    $('#datatable').DataTable({
	    	"iDisplayLength": 100
	    });

	    $('#loading').hide();

	    $("input[name='modelInput']").on('ifChecked', function(event) {
	    	var model = $(this).val();
	    	if(model == 'nilai_huruf') {
	    		$('.input_absen').hide();
	    		$('.input_tugas').hide();
	    		$('.input_uts').hide();
	    		$('.input_uas').hide();
	    		$('.btn_cek').hide();
	    		$('.span_total').hide();
	    		$('.span_huruf').hide();
	    		$('.input_mutu').show();
	    	}
	    	else if(model == 'komponen') {
	    		$('.input_absen').show();
	    		$('.input_tugas').show();
	    		$('.input_uts').show();
	    		$('.input_uas').show();
	    		$('.btn_cek').show();
	    		$('.span_total').show();
	    		$('.span_huruf').show();
	    		$('.input_mutu').hide();
	    	}
	    });
	});

	function cek_nilai(nim, idkst)
	{
		var absen = $("input[name='absen."+nim+"']").val();
		var tugas = $("input[name='tugas."+nim+"']").val();
		var uts = $("input[name='uts."+nim+"']").val();
		var uas = $("input[name='uas."+nim+"']").val();
		var idjadwal = $("input[name='bidjadwal']").val();
		var cname = $("input[name='bcname']").val();

		var batas_pertemuan = {{ $bobot[0]['pertemuan'] }};
		var token = "{{ csrf_token() }}";

		// console.log(token);
		if(absen > batas_pertemuan)
		{
			swal(
				"Jumlah absen melebihi dari batas pertemuan","", "error"
			);
		}

		$('#loading').css('display', 'inline-block');
		$.ajax({
			url: 'cek-nilai',
			type: 'post',
			data: {
				'idkst': idkst,
				'idjadwal': idjadwal,
				'absen': absen,
				'tugas': tugas,
				'uts': uts,
				'uas': uas,
				'cname': cname,
				'_token': token
			},
			success: function(data) {
				// console.log(data.ntotal);
				$('.text_total_'+nim).html(data.ntotal);
				$('.text_huruf_'+nim).html(data.nhuruf);
				$('#loading').hide();
				swal(
					"Berhasil Input Nilai","", "success"
				);
			}
		});
	}

	function update_mutu(nim, idkst)
	{
		var mutu = $("input[name='mutu."+nim+"']").val().toUpperCase();
		var idjadwal = $("input[name='bidjadwal']").val();
		var cname = $("input[name='bcname']").val();
		var token = "{{ csrf_token() }}";

		if(mutu == 'A' || mutu == 'B' || mutu == 'C' || mutu == 'D' || mutu == 'E')
		{
			$('#loading').css('display', 'inline-block');
			$.ajax({
				url: 'update-mutu',
				type: 'post',
				data: {
					'idkst': idkst,
					'idjadwal': idjadwal,
					'nilaihuruf': mutu,
					'cname': cname,
					'_token': token
				},
				success: function(data) {
					console.log(data);
					$('#loading').hide();
					swal(
						"Berhasil Input Mutu Nilai","", "success"
					);
				}
			});
		}
		else
		{
			swal(
				"Isilah menggunakan Huruf A, B, C, D, E","", "error"
			);
		}		
	}

	function publish()
	{
		swal({   
			title: "Apakah Anda Yakin?",   
			text: "Anda mempublish nilai pada matakuliah ini?",   
			type: "warning",   
			showCancelButton: true,   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "Yes, publish",   
			closeOnConfirm: false }, 
			function(){   
				$('#form_publish').submit();
			});
	}
	
</script>
@endsection