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

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12">
    	<div class="x_panel" style="min-height: 650px;">
      		<div class="x_title">
        		<h2>Rencana Akademik Mahasiswa</h2>
        		<div class="clearfix"></div>
      		</div>
      		<div class="x_content">
				<div class="row">
					<div class="table-responsive">
						<div class="col-md-12">
							<table class="table table-striped jambo_table bulk_action">
								<thead>
									<tr class="headings">
										<th>
											<input type="checkbox" id="check-all" class="flat">
										</th>
										<th class="column-title">No</th>
										<th class="column-title">Kode Matakuliah</th>
										<th class="column-title">Nama Matakuliah</th>
										<th class="column-title">SKS</th>
										<th class="column-title">Semester</th>
										<th class="column-title">Kelas</th>
										<th class="column-title">Jadwal</th>
										<th class="column-title">Status</th>
										<th class="column-title">Verifikasi</th>
										<th class="bulk-actions" colspan="9">
											<a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> )</a>
										</th>
									</tr>
	                        	</thead>
								<tbody>
									@foreach($lirs as $key => $value)
									<tr>
										<td><input type="checkbox" class="flat" name="table_records"></td>
										<td>{{ $key + 1 }}</td>
										<td>{{ $value['kodemk'] }}</td>
										<td>{{ $value['namamk'] }}</td>
										<td>{{ $value['sks'] }}</td>
										<td>{{ $value['semester'] }}</td>
										<td>{{ $value['kelas'] }}</td>
										<td>{{ $value['pertemuan'] }}</td>
										<?php $convert = \App\Convert::status_lirs($value['stat']); ?>
										<td><?php echo $convert; ?></td>
										<td style="width: 100px;">
											<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>
											<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
										</td>
									</tr>
									@endforeach
									<tr>
										<td>
											<input type="checkbox" id="check-all" class="flat">
										</td>
										<td colspan="8"></td>
										<td>
											<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>
											<button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
										</td>
									</tr>
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

