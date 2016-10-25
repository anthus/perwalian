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
				<div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Semua Mahasiswa</a>
                        </li>
                        
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Belum Verifikasi</a>
                        </li>
                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
	                        <div class="row">
								<div class="table-responsive">
									<div class="col-md-12">
										<table class="table table-striped" id="datatable1">
											<thead>
												<tr>
													<th>No</th>
													<th>NIM</th>
													<th>Nama Mahasiswa</th>
													<th>Angkatan</th>
													<th>Total Matakuliah</th>
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
													<td><a href="{{ route('akademik.bimbingan.lirs', array(Hashids::connection('bimbingan')->encode($key))) }}" class="btn btn-success btn-xs">Detail</a></td>
													<td><a href="{{ route('akademik.bimbingan.lihs', array(Hashids::connection('bimbingan')->encode($key))) }}" class="btn btn-primary btn-xs">Detail</a></td>
													
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                        	<div class="row">
								<div class="table-responsive">
									<div class="col-md-12">
										<table class="table table-striped" id="datatable3" style="width: 100%;">
											<thead>
												<tr>
													<th>No</th>
													<th>NIM</th>
													<th>Nama Mahasiswa</th>
													<th>Angkatan</th>
													<th>Total Matakuliah</th>
													<th>Rencana Studi (LIRS)</th>
													<th>Histori Kuliah</th>
												</tr>
											</thead>
											<tbody>
												@foreach($bimbingan as $key => $value)
												@if($value['terima'] + $value['akd'] + $value['tolak'] > $value['total'])
												<tr>
													<td>{{ $key+1 }}</td>
													<td>{{ $value['nim'] }}</td>
													<td>{{ $value['nama'] }}</td>
													<td>{{ $value['angkatan'] }}</td>
													<td>{{ $value['total'] }}</td>
													<td><a href="{{ route('akademik.bimbingan.lirs', array(Hashids::connection('bimbingan')->encode($key))) }}" class="btn btn-success btn-xs">Detail</a></td>
													<td><a href="{{ route('akademik.bimbingan.lihs', array(Hashids::connection('bimbingan')->encode($key))) }}" class="btn btn-primary btn-xs">Detail</a></td>	
												</tr>
												@endif
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
		</div>
	</div>
</div>
@endsection

@section('plugin')
<script type="text/javascript">
	$(document).ready(function(){
	    $('#datatable1').DataTable();
	    $('#datatable2').DataTable();
	});
</script>
@endsection