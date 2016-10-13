@extends('dashboard')

@section('content')
<div class="page-title">
	<div class="title_left" style="width: 100%;">
        <h3>Biaya Perkuliahan</h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel" style="min-height: 650px;">
			<div class="x_title">
				<h2>Tahun Ajaran Perkuliahan</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>No</th>
										<th>Tahun Akademik</th>
										<th>Semester</th>
										<th>Tagihan</th>
										<th>Pembayaran</th>
										<th>Bank</th>
									</tr>
								</thead>
								<tbody>
									@foreach($detail as $key => $value)
									<tr>
										<td>{{ $key+1 }}</td>
										<td>{{ $value['thakad'] }}</td>
										<td>{{  \App\Convert::ubah_semester($value['semester']) }}</td>
										<td>{{ 'Rp '.number_format($value['tagihan'],0,'.','.') }}</td>
										<td>{{ 'Rp '.number_format($value['pembayaran'],0,'.','.') }}</td>
										<td>{{ $value['bank'] }}</td>
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