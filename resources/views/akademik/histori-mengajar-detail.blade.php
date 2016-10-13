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
						<span>Nama Matakuliah</span>
						<h2>{{ $matakuliah['namamk'] }}</h2>
					</div>
					<div class="col-md-3 col-xs-6 tile">
						<span>Program</span>
						<h2>{{ $matakuliah['program'] }}</h2>
					</div>
					<div class="col-md-3 col-xs-6 tile">
						<span>Kelas</span>
						<h2>{{ $matakuliah['kelas'] }}</h2>
					</div>
					<div class="col-md-3 col-xs-6 tile">
						<span>Jumlah Mahasiswa</span>
						<h2>{{ count($mahasiswa) }}</h2>
					</div>
				</div>
				<div class="row" style="margin-top: 20px;">
					<div class="col-md-2">
						<a href="{{ route('akademik.histori-mengajar.periode', array($indexperiode)) }}" class="btn btn-sm btn-warning btn-block" type="button"><i class="fa fa-chevron-left"></i>
						Kembali</a>
					</div>
				</div>
				<div class="row">
					<div class="table-responsive" style="margin-left: 10px; margin-top: 20px;">
						<table class="table table-striped table-hover" id="datatable">
							<thead>
								<tr>
									<th>No</th>
									<th>NIM</th>
									<th>Nama Mahasiswa</th>
									<th>Aktifitas</th>
									<th>Tugas</th>
									<th>UTS</th>
									<th>UAS</th>
									<th>Total</th>
									<th>Nilai</th>
								</tr>
							</thead>
							<tbody>
								@foreach($mahasiswa as $key => $value)
								<tr>
									<td>{{ $key + 1 }}</td>
									<td>{{ $value['nim'] }}</td>
									<td>{{ $value['nama'] }}</td>
									<td>{{ $value['absen'] }}</td>
									<td>{{ $value['tugas'] }}</td>
									<td>{{ $value['uts'] }}</td>
									<td>{{ $value['uas'] }}</td>
									<td><b>{{ $value['nilaitotal'] }}</b></td>
									<td><b>{{ $value['nilaihuruf'] }}</b></td>
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
@endsection

@section('plugin')
<script type="text/javascript">
	$(document).ready(function(){
	    $('#datatable').DataTable({
	    	"iDisplayLength": 100
	    });
	});
</script>
@endsection