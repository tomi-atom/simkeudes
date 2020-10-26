@extends('layouts.app')

@section('title')
	Dashboard
@endsection

@section('breadcrumb')
	@parent
	<li>Dashboard</li>
@endsection

@section('content')

	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-body">
					<h2>Selamat Datang</h2>
					<h3>Anda login sebagai Administrator</h3>
				</div>
			</div>
		</div>
	</div>

@endsection
