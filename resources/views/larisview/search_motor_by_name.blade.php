@extends('larisview/index')
@section('content')

	<link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/css/motor.css') }}">
	<script type="{{asset('js/jquery.js')}}"></script>
	
	@if(sizeof($motor)!=0)
		
	<div class="main" id="motor">
        <div class="container">
			@foreach($motor as $listMotor)
			<div class="main-content">
                <div class="col-md-4 col-sm-3 col-xs-6">
  		    		<a href="{{url('detail/'.$listMotor->no_mesin)}}">
	                    <figure>
	                        <img src="{{asset('storage/motor/'.$listMotor->gambar)}}"/>

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
									<span><?php if($listMotor->status==1) {
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

	        @endforeach
		</div>
	</div>

		{{-- <div class="text-center">
			{!! $listMotor->links() !!}
		</div> --}}
		@else
		<center><h2 style="margin-top: 200px;">{{'Data Motor Tidak Ditemukan'}}</h2></center>
	@endif
	
@endsection
