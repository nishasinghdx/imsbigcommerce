<?php
session_start();
if(isset($_SESSION['login_user']) && !empty($_SESSION['login_user'])){
  header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>ImS Parts Finder</title>
    <link href="assets/stylesheets/application-a07755f5.css" rel="stylesheet" type="text/css" /><link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<style>

@import url(https://fonts.googleapis.com/css?family=Roboto:300);

.login-page {
  width: 360px;
  padding: 8% 0 0;
  margin: auto;
}
.form {
  position: relative;
  z-index: 1;
  background: #FFFFFF;
  max-width: 360px;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
.form input {
  font-family: "Roboto", sans-serif;
  outline: 0;
  background: #f2f2f2;
  width: 100%;
  border: 0;
  margin: 0 0 15px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
}
.form button {
  font-family: "Roboto", sans-serif;
  text-transform: uppercase;
  outline: 0;
  background: #00bca4;
  width: 100%;
  border: 0;
  padding: 15px;
  color: #FFFFFF;
  font-size: 14px;
  -webkit-transition: all 0.3 ease;
  transition: all 0.3 ease;
  cursor: pointer;
}
.form button:hover,.form button:active,.form button:focus {
  background: #43A047;
}
.form .message {
  margin: 15px 0 0;
  color: #b3b3b3;
  font-size: 12px;
}
.form .message a {
  color: #4CAF50;
  text-decoration: none;
}
.form .register-form {
  display: none;
}
.container {
  position: relative;
  z-index: 1;
  max-width: 300px;
  margin: 0 auto;
}
.container:before, .container:after {
  content: "";
  display: block;
  clear: both;
}
.container .info {
  margin: 50px auto;
  text-align: center;
}
.container .info h1 {
  margin: 0 0 15px;
  padding: 0;
  font-size: 36px;
  font-weight: 300;
  color: #1a1a1a;
}
.container .info span {
  color: #4d4d4d;
  font-size: 12px;
}
.container .info span a {
  color: #000000;
  text-decoration: none;
}
.container .info span .fa {
  color: #EF3B3A;
}




</style>

<script src="assets/javascripts/jquery.min.js"></script>
<script src="assets/javascripts/jquery.ui.shake.js"></script>
<script>
    $(document).ready(function() {

    $('#login').click(function()
    {

    var username=$("#username").val();
    var password=$("#password").val();
    var dataString = 'username='+username+'&password='+password;
    if($.trim(username).length > 0 && $.trim(password).length>0)
    {


    $.ajax({
          type: "POST",
          url: "ajexLogin.php",
          data: dataString,
          cache: false,
          beforeSend: function(){ $("#login").val('Connecting...');},
          success: function(data){
          if(data != 'Invalid')
          {
            $("body").load("dashboard.php").hide().fadeIn(1500).delay(6000);
          }
          else
          {
           $('#box').shake();
              $("#login").val('Login')
              $("#error").html("<span style='color:#cc0000'>Error:</span> Invalid username and password. ");
          }
          }
          });

    }else{
      alert("Please Enter Valid login detail");
         $('#box').shake();
      return false;
    }
    });


    });
  </script>
</head>
<body>
  <div style="width:100%">
    <a class="navbar-brand" href="#">
          <i class="icon-globe"></i>
          International Marine
    </a>
  </div>
  <div class="login-page" id="box">
  <div class="form">

      <input type="text" placeholder="email" id="username" />
      <input type="password" placeholder="password" id= "password" />
      <button id="login">login</button>

  </div>
</div>
</body>
</html>
