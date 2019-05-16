@extends('larisview/index')
@section('content')

<link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/css/main.css') }}">

<!-- 	CAROUSEL -->
<div class="main"  id="home">
	<div class="motor-banner-search">
		<form id="form1" action="{{url('motorBy/')}}">

			<h2 class="text-center">Cari Motor</h2>

			<div class="row">

				<div class="col-sm-4 col-md-4">
					<label>Merk</label>
					<div class="form-group">
						<select class="form-control" name="merk">
							<option value="">Merk</option>
							@foreach($merk as $merkMotor)
							<option value="{{$merkMotor->nama_merk}}">{{$merkMotor->nama_merk}}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="col-sm-6 col-md-6">
					<div class="form-group">
						<label>Tahun</label>
						<select class="form-control" name="tahun">
							<option value="">Tahun</option>
							<option value="2018">2018</option>
							<option value="2017">2017</option>
							<option value="2016">2016</option>
							<option value="2015">2015</option>
							<option value="2014">2014</option>
							<option value="2013">2013</option>
							<option value="2012">2012</option>
							<option value="2011">2011</option>
							<option value="2010">2010</option>
							<option value="2009">2009</option>
							<option value="2008">2008</option>
							<option value="2007">2007</option>
							<option value="2006">2006</option>
							<option value="2005">2005</option>
						</select>
					</div>
				</div>


				<div class="col-sm-6 col-md-6">
					<div class="form-group">
						<label>Min Harga</label>
						<input name="pricemin" placeholder="Min Harga" id="pricemin" class="form-control autoformatnumber" type="text">
					</div>
				</div>

				<div class="col-sm-6 col-md-6">
					<div class="form-group">
						<label>Max Harga</label>
						<input name="pricemax" placeholder="Max Harga" id="pricemax" class="form-control autoformatnumber" type="text">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 col-md-6">
					<div class="form-group">
						<button type="reset" class="btn btn-block" >Reset</button>
					</div>
				</div>
				<div class="col-sm-6 col-md-6">
					<div class="form-group">
						<button type="submit" class="btn btn-block">Cari</button>
					</div>
				</div>
			</div>
		</form>
	</div>

	<div id="myCarousel" class="carousel slide" data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<?php $count = 0?>
			@foreach($banner as $gambar)
			<li data-target="#myCarousel" data-slide-to="{{$count}}" class="@if($count==0) {{'active'}} @endif"></li>

			<?php $count++?>
			@endforeach
		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner">
			<?php $count = 0?>
			@foreach($banner as $gambar)
			<div class="item @if($count==0) {{'active'}} @endif">
				<img src="{{asset('storage/banner/'.$gambar->gambar)}}" />
			</div>
			<?php $count++?>
			@endforeach

			<!-- Left and right controls -->
			<a class="left carousel-control" href="#myCarousel" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#myCarousel" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	</div>
</div>
<!-- 	END CAROUSEL -->

<!-- MOTOR -->
<br><br><br>
<div class="main" id="motor">
	<div class="container">
		@foreach($motor as $listMotor)
		<div class="main-content">
			<div class="col-md-4 col-sm-3 col-xs-6">
				<a href="{{url('detail/'.$listMotor->no_mesin)}}">
					<figure>
						@if($listMotor->gambar=="")
						<img src="{{asset('images/motor.jpg')}}"/>
						@else
						<img src="{{asset('storage/motor/'.$listMotor->gambar)}}"/>
						@endif

						<figcaption>
							<span>{{$listMotor->nama_merk}}</span>
							<span><?php echo "harga ".$listMotor->harga; ?></span>
						</figcaption>

						<div class="detail text-center">
							<div class="col-md-4">
								<span>{{$listMotor->nama_tipe}}</span>
							</div>
							<div class="col-md-4">
								<span>{{$listMotor->tahun}}</span>
							</div>
							<div class="col-md-4">
								<span><?php if($listMotor->status==0) {
									echo "Tersedia";
								}else{
									echo "Terjual";
								}?></span>
							</div>
						</div>
					</figure>
				</a>
			</div>
		</div>

		@endforeach;

	</div>

	<div class="text-center lainnya">
		<a href="{{url('motor/page/1')}}"><button class="form-control" id="btnLain">Lihat Lainnya</button></a>
	</div>
</div>
<!-- 	END MOTOR -->

<div class="container" id="sejarah">
	<div class="row"></div>
	<center><h1>SEJARAH</h1></center>
	<div>
		<span>Laris Motor adalah Perusahaan yang bergerak di bidang Jual Beli Motor Baru dan Bekas yang beralamat di Jl. Raya Kamasan Banjaran No.246, Kamasan, Bandung Selatan, Bandung, Jawa Barat 40377. Laris Motor berdiri pada tahun 1994 karena Hobby. Pada saat itu hanya 1-2 unit motor bekas yang diperjualbelikan. Pada tahun 1996 Laris Motor berada di Jl. Muhammad Acon, Desa Sindangpanon, Kec. Banjaran, Bandung. Kemudian pada tahun 2000, Laris Motor pindah ke Jl. Sindangpanon No. 126, Kec. Banjaran, Bandung. Pada saat itu motor yang diperjualbelikan mulai beranekaragam.</span><br>
		<span>Pada tahun 2005, Laris Motor mendapatkan penghargaan dari Leasing FIF (Federal International Finance). Kemudian pada tahun 2007, Laris Motor mendapat juara ke-2 Nasional Untuk Penjualan Motor bekas. Hingga saat ini Laris Motor telah berkembang dan menjadi salah satu perusahaan terbesar di bidang jual beli motor baru dan bekas.</span>

		<h4>Partner</h4>
		<ul>
			<li>FIF (Federal International Finance)</li>
			<li>Adira Finance</li>
			<li>Wom Finance</li>
			<li>Oto</li>
			<li>Mandiri Utama Finance</li>
		</ul>
	</div>
</div>


{{-- 	CONTACT --}}

<div class="container" id="kontak">
	<div class="row cardKontak">
		<h1 id="labelkontak">KONTAK</h1>
		<div class="col-md-3 card">
			<a class="btn-lg" href="tel:(022) 5941275"><i class="fa fa-phone fa-2x"></i></a>
			<div class="container">
				<h4>(022) 5941275</h4>
			</div>
		</div>

		<div class="col-md-3 card">
			<a href="https://web.facebook.com/LMBanjaran/" class="btn-lg"><i class="fa fa-facebook fa-2x"></i></a>
			<div class="container">
				<h4>Laris Motor Banjaran</h4>
			</div>
		</div>

		<div class="col-md-3 card">
			<a href="https://mail.google.com/mail/?view=cm&fs=1&to=putralarismotor@gmail.com&su=SUBJECT&body=BODY" class="btn-lg"><i class="fa fa-envelope fa-2x"></i></a>
			<div class="container">
				<h4>putralarismotor@gmail.com</h4>
			</div>
		</div>

		<div class="col-md-3 card">
			<a href="http://bit.ly/2pxbxHW" class="btn-lg"><i class="fa fa-whatsapp fa-2x"></i></a>
			<div class="container">
				<h4>6281321488489</h4>
			</div>
		</div>


	</div>
	<div class="maps col-md-12" id="maps">
		<iframe
		width="100%"
		height="450"
		frameborder="0" style="border:0"
		src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAzoY1jZBDTqnOdYunQprk9pWDLlhcDZnY&q=Laris+Motor, Jalan+Raya+Kamasan+Banjaran, Kamasan, Bandung, West+Java" allowfullscreen>
	</iframe>
</div>

</div>
{{-- 	END CONTACT --}}


{{-- 	FOOTER --}}

<hr>
<div class="container">
	<div class="row footer">
		<span id="text">&copy 2018 Powered By : Tim KP UNIKOM</span>
	</div>
</div>
<hr>
{{-- END FOOTER --}}


@endsection
