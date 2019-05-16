@extends('larisview/index')
@section('content')

	<link rel="stylesheet" type="text/css" href="{{asset('bootstrap/css/artikel.css')}}">

	<div class="container artikel">
        <div class="row">
	    	<article id="artikel">
	    		<div class="row">
		        		<div class="portfolio-caption">
		        			<img src="{{asset('storage/artikel/'.$artikel->gambar)}}" style="width: 60px;" />
		                	<h3>{{$artikel->judul}}</h3>
		                    <p class="text-muted">{{$artikel->isi}}</p>
		            	</div>
		        	</div>
	    	</article>
    	</div>

	</div>
						
@endsection