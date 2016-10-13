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
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel" style="min-height: 650px;">
			<div class="x_title">
				<h2>Profil Dosen</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="col-md-4 col-sm-4 col-xs-12 profile_left">
					
					<h3>{{ $profil['gelardpn'].' '.ucwords(strtolower($profil['nama'])).''.$profil['gelarblk']  }}</h3>
					<p style="font-size: 16px;">NIP: {{ $profil['nip'] }}</p>
					
				</div>
				<div class="col-md-9 col-sm-9 col-xs-12">
					
				</div>
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