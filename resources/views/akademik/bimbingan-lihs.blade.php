@extends('dashboard')

@section('content')
<div class="page-title">
	<div class="title_left" style="width: 100%;">
        <h3>Mahasiswa Bimbingan</h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row" style="margin-top: 10px; margin-bottom: 10px;">
	<div class="col-md-2">
		<a href="{{ route('akademik.bimbingan') }}" class="btn btn-sm btn-warning btn-block" type="button"><i class="fa fa-chevron-left"></i>
		Kembali</a>
	</div>
</div>
<div class="row top_tiles">
	<div class="col-md-3 col-xs-6 tile">
		<span>NIM</span>
		<h2>{{ $mahasiswa['nim'] }}</h2>
	</div>
	<div class="col-md-3 col-xs-6 tile">
		<span>Nama Mahasiswa</span>
		<h2>{{ $mahasiswa['nama'] }}</h2>
	</div>
	<div class="col-md-3 col-xs-6 tile">
		<span>Angkatan</span>
		<h2>{{ $mahasiswa['angkatan'] }}</h2>
	</div>
	<div class="col-md-3 col-xs-6 tile">
		<span>Prodi</span>
		<h2>{{ $mahasiswa['namabagian'] }}</h2>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
    	<div class="x_panel">
      		<div class="x_title">
        		<h2>Grafik Akademik Mahasiswa</h2>
        		<div class="clearfix"></div>
      		</div>
      		<div class="x_content">
				<div class="row">
					<div class="col-md-12">
						<canvas id="line_chart" style="width:100%;" height="80px;"></canvas>
					</div>
				</div>
      		</div>
    	</div>
  	</div>
</div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Detail Nilai Mahasiswa</h2>
				<div class="clearfix"></div>
			</div>
		<div class="x_content">
			<div class="col-xs-3">
				<ul class="nav nav-tabs tabs-left">
					<?php $last_key = count($lihs) - 1; ?>
					@foreach($lihs as $key => $value)
					<li class="@if($key == $last_key) active @endif" ><a href="#{{ $value['idperiode'] }}" data-toggle="tab">{{ $value['thakad'] }}</a>
					</li>
					@endforeach
				</ul>
			</div>

			<div class="col-xs-9">
				<div class="tab-content">
					@foreach($lihs as $key => $value)
						<div class="tab-pane @if($key == $last_key) active @endif" id="{{$value['idperiode']}}">
							<p class="lead">IPS: {{ round($value['ips'], 2) }}</p>
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Kode Matakuliah</th>
											<th>Nama Matakuliah</th>
											<th>SKS</th>
											<th>Absen</th>
											<th>Tugas</th>
											<th>UTS</th>
											<th>UAS</th>
											<th>Nilai Total</th>
											<th>Nilai Huruf</th>
										</tr>
									</thead>
								<tbody>
									@foreach($lihs[$key]['rekap'] as $index => $data)
									<tr>
										<td>{{ $index+1 }}</td>
										<td>{{ $data['kodemk'] }}</td>
										<td>{{ $data['namamk'] }}</td>
										<td>{{ $data['sks'] }}</td>
										<td>{{ $data['absen'] }}</td>
										<td>{{ $data['tugas'] }}</td>
										<td>{{ $data['uts'] }}</td>
										<td>{{ $data['uas'] }}</td>
										<td>{{ round($data['nilaitotal'], 2) }}</td>
										<td>{{ $data['nilaihuruf'] }}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					@endforeach
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>

@endsection

@section('plugin')
<style>
	.tabs-left > li.active > a, 
	.tabs-left > li.active > a:hover, 
	.tabs-left > li.active > a:focus{
		background: #1ABB9C;
		color: #fff;
	}
</style>
<script type="text/javascript">
	// Line chart
	var ctx = document.getElementById("line_chart");
	var lineChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: <?php echo $json_periode; ?>,
			datasets: [{
				label: "IPS",
				backgroundColor: "transparent",
				borderColor: "rgba(38, 185, 154, 0.7)",
				pointBorderColor: "rgba(38, 185, 154, 0.7)",
				pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
				pointHoverBackgroundColor: "#fff",
				pointHoverBorderColor: "rgba(220,220,220,1)",
				pointBorderWidth: 1,
				data: {{ $json_ips }}
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