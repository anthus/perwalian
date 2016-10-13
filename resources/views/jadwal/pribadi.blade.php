@extends('dashboard')

@section('content')
<?php $profile = session()->get('mhs'); ?>
<div class="page-title">
	<div class="title_left" style="width: 100%;">
        <h3>Jadwal Perkuliahan</h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel" style="min-height: 650px;">
			<div class="x_title">
				<h2>Jadwal Perkuliahan Pribadi Mahasiswa</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="table-responsive" style="margin-top: 20px;">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Kode Matakuliah</th>
								<th>Nama Matakuliah</th>
								<th>Semester</th>
								<th>SKS</th>
								<th>Kelas</th>
								<th>Jadwal</th>
							</tr>
						</thead>
						<tbody>
							@foreach($lirs as $key => $value)
							<tr>
								<td>{{ $key+1 }}</td>
								<td>{{ $value['kodemk'] }}</td>
								<td>{{ $value['namamk'] }}</td>
								<td>{{ $value['semester'] }}</td>
								<td>{{ $value['sks'] }} SKS</td>
								<td>{{ $value['kelas'] }}</td>
								<td>{{ $value['pertemuan'] }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
