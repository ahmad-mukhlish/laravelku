
<html>
<head>
  <link rel="stylesheet" type="text/css" href="{{url('css/admin/admin.css')}}">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <link href="{{url('css/duDialog.css')}}" rel="stylesheet">
  <script src="{{url('js/duDialog.js')}}"></script>

</head>
<body>
  <div class="container">
    <div class="card card-container">
      <img id="profile-img" class="profile-img-card" src="{{url('images/user.png')}}" />
      <p id="profile-name" class="profile-name-card">Laris Motor</p>
      <form class="form-signin" method="post" action="{{url('admin/login')}}">
        {{csrf_field()}}
        <span id="reauth-email" class="reauth-email"></span>
        <input type="text" id="inputEmail" class="form-control" placeholder="Username" required autofocus name="username">
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required name="password">
        <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" >Login</button>

        <br>

        <?php if(strcmp($message, "") != 0){ ?>

          <?php echo $message ?>
          <script type="text/javascript">  new duDialog('Error', "{{$message}}"); </script>

        <?php } ?>

      </form><!-- /form -->



    </div><!-- /card-container -->
  </div><!-- /container -->
</body>
</html>
