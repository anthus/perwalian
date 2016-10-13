@extends('dashboard')

@section('content')
<div class="page-title">
	<div class="title_left" style="width: 100%;">
        <h3>Mahasiswa Bimbingan</h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel" style="min-height: 650px;">
			<div class="x_title">
				<h2>Data Mahasiswa Bimbingan</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="table-responsive">
						<div class="col-md-12">
							<table class="table table-striped" id="datatable">
								<thead>
									<tr>
										<th>No</th>
										<th>NIM</th>
										<th>Nama Mahasiswa</th>
										<th>Angkatan</th>
										<th>Total Matakuliah</th>
										<th>Belum Verifikasi</th>
										<th>Rencana Studi (LIRS)</th>
										<th>Histori Kuliah</th>
									</tr>
								</thead>
								<tbody>
									@foreach($bimbingan as $key => $value)
									<tr>
										<td>{{ $key+1 }}</td>
										<td>{{ $value['nim'] }}</td>
										<td>{{ $value['nama'] }}</td>
										<td>{{ $value['angkatan'] }}</td>
										<td>{{ $value['total'] }}</td>
										<td>{{ $value['total'] - $value['akd'] }}</td>
										<td><a href="{{ route('akademik.bimbingan.lirs', array($key)) }}" class="btn btn-success btn-xs">Detail</a></td>
										<td><a href="{{ route('akademik.bimbingan.lihs', array($key)) }}" class="btn btn-primary btn-xs">Detail</a></td>
										
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

@section('plugin')
<script type="text/javascript">
	$(document).ready(function(){
	    $('#datatable').DataTable();
	});
</script>
@endsection