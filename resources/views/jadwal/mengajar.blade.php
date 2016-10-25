@extends('dashboard')

@section('content')
<div class="page-title">
	<div class="title_left" style="width: 100%;">
        <h3>Histori Mengajar</h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel" style="min-height: 650px;">
			<div class="x_title">
				<h2>Daftar Matakuliah </h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row top_tiles">
					<div class="col-md-3 col-xs-6 tile">
						<span>Tahun Akademik</span>
						<h2>{{ $periode['thakad'] }}</h2>
					</div>
					<div class="col-md-3 col-xs-6 tile">
						<span>Semester</span>
						<h2>{{ \App\Convert::ubah_semester($periode['semester']) }}</h2>
					</div>
					<div class="col-md-3 col-xs-6 tile">
						<span>Perkuliahan</span>
						<h2>{{ \App\Convert::status_perkuliahan($periode['perkuliahan']) }}</h2>
					</div>
					<div class="col-md-3 col-xs-6 tile">
						<span>Jumlah Matakuliah</span>
						<h2>{{ count($matakuliah) }}</h2>
					</div>
				</div>
				<div class="row" style="margin-top: 20px;">
					<div class="col-md-2">
						<a href="{{ route('akademik.histori-mengajar') }}" class="btn btn-sm btn-warning btn-block" type="button"><i class="fa fa-chevron-left"></i>
						Kembali</a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive" style="margin-left: 10px; margin-top: 20px;">
							<table class="table table-striped" id="datatable">
								<thead>
									<tr>
										<th>No</th>
										<th>Kode MK</th>
										<th>Nama Matakuliah</th>
										<th>Program</th>
										<th>Kelas</th>
										<th>Jadwal</th>
									</tr>
								</thead>
								<tbody>
									@foreach($matakuliah as $key => $value)
									<tr>
										<td>{{ $key + 1 }}</td>
										<td>{{ $value['kodemk'] }}</td>
										<td>{{ $value['namamk'] }}</td>
										<td>{{ $value['program'] }}</td>
										<td>{{ $value['kelas'] }}</td>
										<td>-</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

