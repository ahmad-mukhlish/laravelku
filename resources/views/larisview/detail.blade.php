@extends('larisview/index')
@section('content')

	<link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/css/detail.css') }}">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
	<script type="{{asset('js/jquery.js')}}"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>\

	<style type="text/css">
		.slick-slide{
			height: 260px !important;
		}
	</style>

	<div class="main">
			<div class="col-md-4">
				<h3>Spesifikasi</h3>
					<div class="row">
						<table>
	                      		<tr>
	                                <td>Merk</td>
	                                <th>{{$motor->nama_merk}}</th>
	                            </tr>
	                            <tr>
	                                <td>Tipe</td>
	                                <th>{{$motor->nama_tipe}}</th>
	                            </tr>
	                            <tr>
	                                <td>Tahun</td>
	                                <th>{{$motor->tahun}}</th>
	                            </tr>
	                            <tr>
	                                <td>Kondisi</td>
	                                <th><?php if($motor->kondisi==1){
	                                	echo "Baru";
	                                }else{
	                                	echo "Bekas";
	                                }?></th>
	                            </tr>
	                            <tr>
	                                <td>Harga</td>
	                                <th>Rp. {{$motor->harga}}</th>
	                            </tr>
	                    </table>
                    </div>
			</div>
			
			<div class="col-md-4">
				<h3>Harga dan Pembayaran</h3>
				<div class="row">
						<table>
	                      		<tr>
	                                <td>Cash</td>
	                                <th>Rp. {{$motor->harga}}</th>
	                            </tr>
	                            
	                            <th>Kredit</th>
	                            <tr>
	                                <td>DP</td>
	                                <th>Rp. {{$motor->dp}}</th>
	                            </tr>
	                            <tr>
	                                <td>Cicilan</td>
	                                <th>Rp. {{$motor->cicilan}}</th>
	                            </tr>
	                            <tr>
	                                <td>Tenor</td>
	                                <th>{{$motor->tenor}} Bulan</th>
	                            </tr>
	                    </table>
                </div>

                <?php $phone_number = preg_replace('/^0/','+62',$motor->no_wa); ?>
				<a href="https://api.whatsapp.com/send?phone={{$phone_number}}">
					<div class="row wa">
						<i class="fa fa-whatsapp fa-3x" aria-hidden="true"></i>				
					</div>
				</a>
				<a href="https://api.whatsapp.com/send?phone={{$phone_number}}">
					<div class="hubungi">
						<span>Hubungi Sales</span>
					</div>
				</a>
			</div>

			<div class="col-md-4">
				<div class="slide">
					  <div class="slider slider-for">
					  	@if ($motor->gambar1=='') 						  		
						    <img src="{{asset('storage/motor/'.$motor->gambar)}}" id="slideGambar" />
					  	@elseif($motor->gambar1!='' && $motor->gambar2=='') 
							<img src="{{asset('storage/motor/'.$motor->gambar)}}" id="slideGambar" />
					    	<img src="{{asset('storage/motor/'.$motor->gambar1)}}" id="slideGambar" />
					    @else
							<img src="{{asset('storage/motor/'.$motor->gambar)}}" id="slideGambar" />
					    	<img src="{{asset('storage/motor/'.$motor->gambar1)}}" id="slideGambar" />
					    	<img src="{{asset('storage/motor/'.$motor->gambar2)}}" id="slideGambar" />		
					    @endif	  
				</div>
			</div>
			</div>
		<script type="text/javascript">
        $(document).ready(function(){       
			$('.slider-for').slick({
			    dots: true,
			    infinite: true,
			    speed: 700,
			    autoplay:true,
			    autoplaySpeed: 2000,
			    arrows:false,
			    slidesToShow: 1,
			    slidesToScroll: 1
			 });
    
        });
		</script>
	
@endsection

