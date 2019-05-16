<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="{{url('css/admin/index.css')}}">
<!------ Include the above in your HEAD tag ---------->

<div id="wrapper" class="active">
      
      <!-- Sidebar -->
            <!-- Sidebar -->
      <div id="sidebar-wrapper">
      <ul id="sidebar_menu" class="sidebar-nav">
           <li class="sidebar-brand"><a href="#">Admin</a></li>
      </ul>
        <ul class="sidebar-nav" id="sidebar">     
          <li><a href="{{url('admin/home')}}">Banner</a></li>
          <li><a href="{{url('admin/artikel')}}">Artikel</a></li>
          <li><a href="{{url('admin/password_status')}}">Password</a></li>
           <li><a href= "#" id="test" user>Logout</a></li>
        </ul>
      </div>
          
      <!-- Page content -->
      <div id="page-content-wrapper">
        <!-- Keep all page content within the page-content inset div! -->
        <div class="page-content inset">
              @yield('content')
        </div>
      </div>
      
    </div>

    <script type="text/javascript">
          $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("active");
        });
    </script>

    <script type="text/javascript">
      $('a[user]').click(function(){
          console.log('klik');
        $.ajax({
                    url: '{{url('admin/logout')}}',
                    type: 'POST',
                    success: function(data){
                        window.location.reload();
                    }
                });
        return false;
        });
    </script>