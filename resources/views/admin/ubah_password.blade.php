@extends('admin/index')
@section('content')
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>

<style type="text/css">
	.status {
	    width: 100%;
	    margin-left: 80px;
	}

	#a{
		width: 20% !important;
	}

	#labelstatus{
		margin-top: 100px !important;
	}
</style>

<div class="status">
	@if($status->status==0)
		<div><span id="labelstatus">Tidak Ada Perubahan Password</span></div>
	@else
		<form method="post" action="{{url('admin/ubahpassword')}}">
			{{csrf_field()}}
			Info Perubahan Password <br>
			<input type="hidden" name="id" value="{{$status->id}}">
			<input type="text" name="username" value="{{$status->username}}" class="form-control" id="a">
			<input type="text" name="password" value="{{$status->password}}" class="form-control" id="a">
			<input type="submit" value="Konfirmasi" name="submit">
			<input type="submit" value="Tolak" name="submit">
		</form>
	@endif


</div>

@endsection