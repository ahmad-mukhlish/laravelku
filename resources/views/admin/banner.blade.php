@extends('admin/index')
@section('content')

<style type="text/css">
.main .main-content {
	width: 100%;
	margin-left: 60px;
}

.tambah{
	margin-left: 80px !important;
	padding-top: 30px !important;
	padding-bottom: 30px !important;
}

.main .main-content .col-md-4 {
	padding: 10px;
}

.main .main-content a{
	color: black;
}
.main .main-content .row{
	margin : 10px;
}
.main .main-content figure {
	display: inline-block;
	width: 80%;
	height: 350px;
	background-color: #FFFFFF;
	-webkit-box-shadow: 0px 0px 5px 0px rgba(149,152,154,1);
	-moz-box-shadow: 0px 0px 5px 0px rgba(149,152,154,1);
	box-shadow: 0px 0px 5px 0px rgba(149,152,154,1);
	margin: 5px;
}

.main .main-content figure img {
	width: 100%;
	height: 200px;
}

.main .main-content figure figcaption {
	text-align: left;
}

.main .main-content figure figcaption span {
	font-size: 14px;
	font-family: 'Roboto', sans-serif;
	font-weight: bold;
}

.main .main-content figure .detail .col-md-4{
	font-weight: normal;
}


@media (max-width:767px) {
	.main .main-content .col-md-4 {
		width: 100% !important;
		padding: 10px !important;
	}
}


.modal-content .modal-header {
	background: #00B1FF;
	border-radius: 5px 5px 0px 0px;
	padding-left: 0px;
	padding-right: 0px;
	height: 50px;
}

.modal-content .modal-header i {
	color: #FFFFFF;
	font-size: 20px;
	cursor: pointer;
}

.modal-content .modal-header i:hover {
	color: #F2F2F2;
}

.modal-title {
	color: #FFFFFF;
	font-size: 18px;
}

.modal-body .col-md-6 {
	padding: 5px;
}

.modal-body span {
	color: #95989A;
}

.modal-footer {
	text-align: center;
	border: 0px;
	padding-top: 0px;
	padding-bottom: 30px;
}

.modal-footer .col-md-12 {
	padding-top: 20px;
}

.modal-footer .btn-default {
	width: 80px;
	background: #FF5722;
	color: #FFFFFF;
	border: 0px;
}

.modal-footer .btn-default:hover {
	background-color: #E64A19;
}


</style>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>

<div class="row tambah">
	<a href="#"><i class="fa fa-plus fa-2x" data-toggle="modal" data-target="#tambahModal"> Tambah Banner</i></a>
</div>

<div class="main">

	<?php $count = 0;
	$id;
	?>


	@foreach($banner as $gambar)
	<div class="main-content">
		<div class="col-md-4 col-sm-3 col-xs-6">
			<figure>
				<img src="{{asset('storage/banner/'.$gambar->gambar)}}"/>
				<div class="detail">
					<div class="row text-center">
						<span>{{$gambar->judul_banner}}</span>
					</div>

					<div class="row">
						<span>{{$gambar->keterangan}}</span>
					</div>

					<div class="row pull-right">
						<a href="#" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil fa-2x" aria-hidden="true" onclick="editBanner({{$gambar->id_banner}})"></i></a>
						<a href="{{url('admin/home/deleteBanner/'.$gambar->id_banner.'/name/'.$gambar->gambar)}}"><i class="fa fa-trash fa-2x" aria-hidden="true"></i></a>
					</div>


				</div>

			</figure>
		</div>
	</div>

	<?php $count++?>
	@endforeach
</div>


<div class="modal fade" id="tambahModal" role="dialog">
	<div class="modal-dialog">


		<!-- Modal content-->
		<div class="modal-content">
			<form action="{{route('addBanner')}}" method="post" enctype="multipart/form-data" id="uploadimage">
				{{ csrf_field() }}
				<div class="modal-header">
					<div class="col-md-10 col-sm-10 col-xs-10">
						<span class="modal-title">Tambah Banner</span>
						<span class="modal-title">(Ukuran 1920px x 720px)</span>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-2 text-right">
						<i class="fa fa-close" data-dismiss="modal"></i>
					</div>
				</div>
				<div class="modal-body">
					<div id="message">

					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<img id="gambarUbah"  src="{{url('images/no_image.png')}}" alt="your image" width="80px;" />
						<input type='file' required id="gambar" name="gambar" onchange="readURL(this);" />
					</div>
				</div>


				<div class="col-md-6 col-sm-6 col-xs-12">
					<span>Judul</span>
					<input type="text" class="form-control" id="judul" name="judul" required>
				</div>

				<div class="col-md-6 col-sm-6 col-xs-12">
					<span>Keterangan</span>
					<textarea class="form-control" name="keterangan"></textarea>
				</div>

				<div class="modal-footer">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<input type="submit" class="btn btn-default" value="Simpan" required>
						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					</div>
				</div>
			</form>
		</div>

	</div>
</div>


<div class="modal fade" id="editModal" role="dialog">
	<div class="modal-dialog">


		<!-- Modal content-->
		<div class="modal-content">
			<form action="{{route('editBanner')}}" method="post" enctype="multipart/form-data" id="uploadimage">
				{{ csrf_field() }}
				<div class="modal-header">
					<div class="col-md-10 col-sm-10 col-xs-10">
						<span class="modal-title">Edit Banner</span>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-2 text-right">
						<i class="fa fa-close" data-dismiss="modal"></i>
					</div>
				</div>
				<div class="modal-body">
					<div id="message">

					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<img id="gambarEdit" alt="your image" width="200px;" />
						<input type='file' id="gambar" name="gambar" onchange="readURL2(this);" />
					</div>
				</div>


				<div class="col-md-6 col-sm-6 col-xs-12">
					<span>Judul</span>
					<input type="text" class="form-control" id="judulEdit" name="judul" required>
				</div>

				<div class="col-md-6 col-sm-6 col-xs-12">
					<span>Keterangan</span>
					<textarea class="form-control" name="keterangan" id="keteranganEdit"></textarea>
				</div>


				<input type="hidden" name="id_banner" id="id_banner">
				<input type="hidden" name="gambar_awal" id="gambar_awal">

				<div class="modal-footer">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<input type="submit" class="btn btn-default" value="Simpan" required>
						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					</div>
				</div>
			</form>
		</div>

	</div>
</div>

</div>

<script type="text/javascript">
function readURL(input) {
	$("#message").empty();
	var file = input.files[0];
	var imagefile = file.type;
	var match= ["image/jpeg","image/png","image/jpg"];

	if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
	{
		$('#gambarUbah').attr('src','{{asset('images/no_image.png')}}');
		$("#message").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><p>Only jpeg, jpg and png Images type allowed</p></div>');
		input.value = "";
		return false;
	}
	else{
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#gambarUbah')
				.attr('src', e.target.result)
				.width(200)
				.height(200);
			};

			reader.readAsDataURL(input.files[0]);
		}

	}
}
</script>

<script type="text/javascript">
function readURL2(input) {

	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			$('#gambarEdit')
			.attr('src', e.target.result)
			.width(400)
			.height(400);
		};

		reader.readAsDataURL(input.files[0]);
	}

}

</script>

<script type="text/javascript">
function editBanner(id_banner) {

	$.ajax({
		type: "POST",
		dataType: "JSON",
		url: "{{url('api/getBannerById')}}",
		data: {'id_banner': id_banner},
		success: function(data){
			console.log(data.keterangan)
			var gambar = '{{asset('storage/banner/')}}/'+data.gambar
			console.log(gambar)
			$("#id_banner").val(data.id_banner)
			$("#gambar_awal").val(data.gambar)
			$("#judulEdit").val(data.judul_banner)
			$("#keteranganEdit").val(data.keterangan)
			$("#gambarEdit").attr('src', gambar);
		}
	});
}

</script>
@endsection
