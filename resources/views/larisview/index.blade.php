<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	<link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/kc.fab.css') }}">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/kc.fab.min.js')}}"></script>
	<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
	<link rel="icon" href="{{asset('images/logo.png')}}">
	<title>Laris Motor</title>

</head>
<body>
	<header>

		{{-- 		TOPBAR --}}
			    <div class="container" id="topContent">
			    	<div class="row">
			    		<div class="col-md-3">
			    			<a href="{{url('')}}">
				    			<img src="{{asset('images/logo.png')}}" width="60px;">
				    			<img src="{{asset('images/larismotor.png')}}" width="180px;">
			    			</a>
			    		</div>

			    		<div class="col-md-9">
			    			<form class="navbar-form" action="{{url('/motor/')}}">
						        <div class="form-group">
						          <input type="text" class="form-control" placeholder="&#xF002; Cari Motor" style="font-family:Arial, FontAwesome" id="searchform" name="search">
						          <button class="form-control" id="btnCari">Cari</button>
						        </div>
						    </form>
			    		</div>
			    	</div>
			    </div>
		{{-- END TOPBAR --}}


			<!-- 	NAVBAR -->
		<nav class="navbar navbar-fixed-top">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header nav-button">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav navbar-right smooth-scroll">
		        <li><a class="scroll-link" href="{{url('/artikel')}}">Artikel</a></li>
		        <li><a  class="scroll-link" href="#sejarah">Sejarah</a></li>
		        <li><a class="scroll-link" href="#kontak">Kontak Kami</a></li>
		      </ul>

		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>

		<!-- 	END NAVBAR -->
	</header>



	{{-- 	CONTENT --}}
	@yield('content')
	{{-- 	END CONTENT --}}


	<style type="text/css">

	.fab {
	  bottom: 15px;
	  right: 0;
	  position: fixed;
	  margin: 1em;
	  display: none;
	  z-index: 100;
	}

	</style>

	  <nav class="fab">
	    <a href="#" class="scroll-top"><i class="fa fa-arrow-circle-up fa-4x" aria-hidden="true"></i></a>
  	 </nav>

  	 <div class="kc_fab_wrapper" style="margin-bottom: 15px">

    </div>

    <script>
            $(document).ready(function(){
                var links = [
                    {
                        "bgcolor":"red",
                        "icon":"<i class='fa fa-comments-o'></i>",
                        "title": "Click me"
                    },
                    {
                        "url":"http://bit.ly/2pxbxHW",
                        "bgcolor":"#34B225",
                        "color":"white",
                        "icon":"<i class='fa fa-whatsapp'></i>",
                        "target":"_blank",
                        "title": "Hey, Click me ..."
                    },
                    {
                        "url":"https://mail.google.com/mail/?view=cm&fs=1&to=putralarismotor@gmail.com&su=SUBJECT&body=BODY",
                        "bgcolor":"red",
                        "color":"white",
                        "icon":"<i class='fa fa-envelope'></i>",
                        "title":"Hey again, Click!"
                    },
                    {
                        "url":"https://web.facebook.com/LMBanjaran/",
                        "bgcolor":"blue",
                        "color":"white",
                        "icon":"<i class='fa fa-facebook'></i>",
                        "title":"Hey again, Click!"
                    },
                    {
                        "url":"tel:(022) 5941275",
                        "bgcolor":"black",
                        "color":"white",
                        "icon":"<i class='fa fa-phone'></i>",
                        "title":"Hey again, Click!"
                    }
                ]
                $('.kc_fab_wrapper').kc_fab(links);
            })
        </script>

</body>
</html>
<script type="text/javascript">
	jQuery(window).scroll(function() {
		var scroll = jQuery(window).scrollTop();
		if (scroll >= 30) {
			jQuery(".navbar").addClass("fixed_div");
			jQuery(".fab").fadeIn();
		}
		if (scroll <= 30) {
			jQuery(".navbar").removeClass("fixed_div");
			jQuery(".fab").fadeOut();
		}
	});
</script>

<script type="text/javascript">
	$('ul>li>a.scroll-link').on('click', function() {
	  var to = $(this).attr('href'); // $(this) is the clicked link. We store its href.
	  $('html, body').animate({ scrollTop: $(to).offset().top }, 'slow');
	});

</script>

<!-- <script type="text/javascript">
	$('nav>a.scroll-top').on('click', function() {
	  var to = $(this).attr('href'); // $(this) is the clicked link. We store its href.
	  $('html, body').animate({ scrollTop: 0}, 'slow');
	});
</script> -->
