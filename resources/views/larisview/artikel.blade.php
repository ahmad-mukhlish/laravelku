@extends('larisview/index')
@section('content')

	<link rel="stylesheet" type="text/css" href="{{asset('bootstrap/css/artikel.css')}}">

<style type="text/css">
		#artikel{
			margin-bottom: 40px;
		}
	</style>
	
	<div class="container artikel">
		@foreach($artikel as $item)
        <div class="row">
	    	<article id="artikel">
	    		<div class="row">
		        		<div class="portfolio-caption">
		        			<img src="{{asset('storage/artikel/'.$item->gambar)}}" style="width: 60px;" />
		                	<h3>{{$item->judul}}</h3>
		                	<?php // truncate string
							    $stringCut = substr($item->isi, 0, 500);
							    $endPoint = strrpos($stringCut, ' ');

							    //if the string doesn't contain any space then it will cut without word basis.
							    $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
							     ?>
		                    <a href="{{url('/artikel/'.$item->id)}}"><p class="text-muted">{{$string}}</p> <span>Selengkapnya..</span></a>
		            	</div>
		        	</div>
	    	</article>
    	</div>

    	@endforeach
	</div>
						
@endsection