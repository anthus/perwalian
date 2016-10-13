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
				<h2>Daftar Tahun Akademik</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="table-responsive">
						<div class="col-md-8">
							<table class="table table-striped" id="datatable">
								<thead>
									<tr>
										<th>No</th>
										<th>Tahun Akademik</th>
										<th>Semester</th>
										<th>Perkuliahan</th>
										<th>-</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 0; ?>
									@foreach($periode as $key => $value)
									<tr>
										<td>{{ $i+1 }}</td>
										<td>{{ $value['thakad'] }}</td>
										<td>{{ \App\Convert::ubah_semester($value['semester']) }}</td>
										<td>{{ \App\Convert::status_perkuliahan($value['perkuliahan']) }}</td>
										<td><a href="{{ route('akademik.histori-mengajar.periode', array($key)) }}" class="btn btn-success btn-xs">Detail</a></td>
									</tr>
									<?php $i++; ?>
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