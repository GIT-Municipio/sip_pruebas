<?php

session_start();
//-------------------------------
header("Refresh: 1210");
//Comprobamos si esta definida la sesión 'tiempo'.
if (isset($_SESSION['tiempo'])) {

	//Tiempo en segundos para dar vida a la sesión.
	$inactivo = 1200; //20min.

	//Calculamos tiempo de vida inactivo.
	$vida_session = time() - $_SESSION['tiempo'];

	//Compraración para redirigir página, si la vida de sesión sea mayor a el tiempo insertado en inactivo.
	if ($vida_session > $inactivo) {
		//Removemos sesión.
		session_unset();
		//Destruimos sesión.
		session_destroy();
		//Redirigimos pagina.
		header("location: http://localhost/sip_pruebas/404/404.html");
		exit();
	}
}
$_SESSION['tiempo'] = time();
//---------------------


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
  <title>Sistema Integral</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<script src="jquery-3.5.1.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style type="text/css">
    @import url('https://fonts.googleapis.com/css?family=Numans');

    html,
    body {
      /* background-image: url('../imgs/logos/noche.png'); */
      background-size: cover !important;
      background-repeat: no-repeat;
      height: 100%;
      font-family: 'Numans', sans-serif;
    }

    #bg {
      position: absolute;
      z-index: -1;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      background: url(test.jpg) center center;
      opacity: .4;
      width: 100%;
      height: 100%;
    }

    .container {
      height: 100%;
      align-content: center;
    }

    .card {
      height: 350px;
      opacity: 1 !important;
      margin-top: auto;
      margin-bottom: auto;
      width: 400px;
      background-color: rgba(255, 255, 255, 0.6) !important;
    }

    .social_icon span {
      font-size: 60px;
      margin-left: 10px;
      color: #FFC312;
    }

    .social_icon span:hover {
      color: white;
      cursor: pointer;
    }

    .card-header h3 {
      color: white;
    }

    .social_icon {
      position: absolute;
      right: 20px;
      top: -40px;
    }

    .input-group-prepend span {
      width: 50px;
      background-color: #5dc1b9;
      color: black;
      border: 0 !important;
    }

    input:focus {
      outline: 0 0 0 0 !important;
      box-shadow: 0 0 0 0 !important;

    }

    .remember {
      color: white;
    }

    .remember input {
      width: 20px;
      height: 20px;
      margin-left: 15px;
      margin-right: 5px;
    }

    .login_btn {
      color: black;
      background-color: #5dc1b9;
      width: 100px;
    }

    .login_btn:hover {
      color: black;
      background-color: white;
    }

    .links {
      color: white;
    }

    .links a {
      margin-left: 4px;
    }

    .modal {
      text-align: center;
    }

    @media screen and (min-width: 768px) {
      .modal:before {
        display: inline-block;
        vertical-align: middle;
        content: " ";
        height: 80%;
      }
    }

    .modal-dialog {
      display: inline-block;
      text-align: left;
      vertical-align: middle;
    }
  </style>
</head>

<body>


  <div class="container">
    <div class="d-flex justify-content-center h-100">
      <div class="card">
        <div class="card-header" style=" text-align: center;">
          <img src="../imgs/logos/logo-login.png" width="200px"></img>
          <!-- <h4 style="color: white; opacity: 0.7;">Sistema de Gestión Documental</h4> -->
          <!-- <div class="d-flex justify-content-end social_icon">
            <img src="../imgs/logos/sol.png" width="80"></td>
          </div> -->
        </div>
        <div class="card-body">
          <!-- <div id="myForm" class="form-control"></div> -->
          <form>
            <div class="input-group form-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
              </div>
              <input type="text" class="form-control" name="login" placeholder="Usuario">

            </div>
            <div class="input-group form-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
              </div>
              <input type="password" class="form-control" name="pwd" placeholder="Contraseña">
            </div>
            <!-- <div class="row align-items-center remember">
              <input type="checkbox">Remember Me
            </div> -->
            <div class="form-group">
              <input type="submit" value="Ingresar" name="send" class="btn float-right login_btn">
            </div>
          </form>
          <br>
        </div>
        <div class="card-footer">
          <div class="d-flex justify-content-center links" style="font-size: 12px; color: rgb(0,0,0,0.8);">
            <strong>Sub Dirección de Tecnología y Sistemas 2020</strong>
          </div>
          <!-- <div class="d-flex justify-content-center links">
            SIP v2.1
          </div> -->
        </div>
      </div>
    </div>
  </div>


</body>




<div id="myModal" class="modal fade" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-body">
        <p>¡Usuario o contraseña incorrectos!</p>
        <p class="text-secondary"><small>Por favor vuelva a intentarlo.</small></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>



</html>

<script>
  $(function() {
    var body = $('body');
    var backgrounds = [
      'url(../imgs/logos/cuicocha.png)',
      'url(../imgs/logos/noche.png)'
    ];
    var current = 0;
    var r = Math.floor(Math.random() * 2); 
    if (r == 1)
      body.css('background', 'url(../imgs/logos/cuicocha.png)');
    else
      body.css('background', 'url(../imgs/logos/noche.png)');

    // function nextBackground() {
    //   body.css(
    //     'background',
    //     backgrounds[current = ++current % backgrounds.length]);

    //   setTimeout(nextBackground, 50000);
    // }
    // setTimeout(nextBackground, 50000);
    // body.css('background', backgrounds[0]);
  });

  $(function() {

    $('form').on('submit', function(e) {
      e.preventDefault();

      var response = $.ajax({
        type: 'post',
        url: 'server.php',
        data: $('form').serialize(),
        async: false
      }).responseText;
      if (response == "bien" || response == "block") {
        document.location.href = "../index.php";
      } else {
        $("#myModal").modal();
        // alertify
        //   .alert("", "¡Usuario o contraseña incorrectos!", function() {

        //   });
      }
    });

  });
</script>