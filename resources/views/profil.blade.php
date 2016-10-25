@extends('dashboard')

@section('content')
<?php $profil = session()->get('dosen'); ?>
<div class="page-title">
	<div class="title_left">
        <h3>Selamat Datang</h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
	<div class="col-md-4 col-sm-6 col-xs-12">
		<div class="x_panel" style="min-height: 500px;">
			<div class="x_title">
				<h2>Profil Dosen</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<h3>{{ $profil['gelardpn'].' '.ucwords(strtolower($profil['nama'])).' '.$profil['gelarblk']  }}</h3>
				<p style="font-size: 16px;">NIP: {{ $profil['nip'] }}</p>
			</div>
		</div>
	</div>
	<div class="col-md-4 col-sm-6 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Ubah Password</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				@if (session('error'))
					<h2><div class="label label-danger">{{ session('error') }}</div></h2>
				@endif
				@if (session('berhasil'))
					<h2><div class="label label-success">{{ session('berhasil') }}</div></h2>
				@endif
				<form action="update-password" method="POST" role="form">
				
					<div class="form-group">
						<label for="">Username</label>
						<input type="text" class="form-control" disabled="" value="{{ $profil['nip'] }}">
					</div>
				
					<div class="form-group">
						<label for="">Password Lama</label>
						<input type="text" name="password_lama" required="" class="form-control" id="" placeholder="Password Lama">
					</div>

					<div class="form-group">
						<label for="">Password Baru</label>
						<input type="text" name="password_baru" required="" class="form-control" id="" placeholder="Password Baru">
					</div>
					
					<div class="form-group">
						<label for="">Konfirmasi</label>
						<input type="text" name="konfirmasi_password" required="" class="form-control" id="" placeholder="Konfirmasi Password">
					</div>
					
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('plugin')
<script type="text/javascript">
	// Line chart
	var ctx = document.getElementById("line_chart");
	var lineChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: ["2013 / 2014 Ganjil", "2013 / 2014 Genap", "2014 / 2015 Ganjil", "2014 / 2015 Genap", "2015 / 2016 Ganjil", "2015 / 2016 Genap"],
			datasets: [{
				label: "Grafik Indek Prestasi Mahasiswa",
				backgroundColor: "transparent",
				borderColor: "rgba(38, 185, 154, 0.7)",
				pointBorderColor: "rgba(38, 185, 154, 0.7)",
				pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
				pointHoverBackgroundColor: "#fff",
				pointHoverBorderColor: "rgba(220,220,220,1)",
				pointBorderWidth: 1,
				data: [3.36, 3.09, 3.09, 2.87, 3.25, 1.7]
			}]
		},
		options: {
			scales: {
				yAxes: [{
                    ticks: {
                        min: 0,
                        max: 4
                    }
                }]
			}
		}
	});
</script>
@endsection