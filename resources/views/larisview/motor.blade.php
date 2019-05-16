@extends('larisview/index')
@section('content')

	<link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/css/motor.css') }}">
	<script type="{{asset('js/jquery.js')}}"></script>
	
	
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
	                            <span>{{$listMotor->nama_merk}}</span><br>
	                            <span>{{$listMotor->harga}}</span>
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

		{{-- <div class="text-center">
			{!! $listMotor->links() !!}
		</div> --}}


		<div class="text-center">
		  <ul class="pagination">
		  	<?php $pages = ceil($total/$perPage);
		  	for ($x = max(1, $page - 5); $x <= min($page + 5, $pages); $x++) { ?>
		  		<li><a href="{{url('motor/page/'.$x)}}"><?php echo $x ?></a></li>
		  	<?php } ?>
		  </ul>
		</div>

@endsection
