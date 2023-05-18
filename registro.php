<!DOCTYPE html>
<html lang="en">
<head>
	<title>Contact V5</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/noui/nouislider.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
<?php
include "service/utils/utilbd.php";
include "service/utils/mysql.php";

$db = new MysqlCon();
$db->conectar();

$animes = UtilBd::getAllAnimes();
$consultaAnimes = $db->consulta($animes);

	$nivel = $_POST['level'];
	$anime = $_POST['anime'];
	$pregunta = $_POST['question'];
	$respuesta1 = $_POST['answer1'];
	$respuesta2 = $_POST['answer2'];
	$respuesta3 = $_POST['answer3'];
	$respuesta4 = $_POST['answer4'];
	$iscorrect = $_POST['iscorrect'];
	$puntos = 0;
	$queryGetQuestion = null;
	$idLastQuestion = null;


	if (null != $nivel && null != $anime && null != $pregunta && null != $respuesta1 && null != $respuesta2 && null != $respuesta3 && $respuesta4 && null != $iscorrect){

		if($nivel == 1){
			$puntos = 10;
		} elseif ($nivel == 2) {
			$puntos = 20;
		} elseif ($nivel == 3) {
			$puntos = 30;
		} elseif ($nivel == 4) {
			$puntos = 45;
		}

		$queryInsertQuestion = $db->bConsulta(UtilBd::registraPregunta($pregunta,$anime,$nivel,$puntos));

		if ($queryInsertQuestion) {
			$queryGetQuestion = $db->consulta(UtilBd::ultimaPreguntaAgregada());
			if($db->num_rows($queryGetQuestion)>0){
				while($resultados = $db->fetch_array($queryGetQuestion)){ 
					$idLastQuestion = $resultados[0];
				}

				if ($idLastQuestion != null) {
					$queryInsertAnswer = $db->consulta(UtilBd::registraRespuesta($idLastQuestion,$respuesta1,($iscorrect == 1) ? 1 : 0));
					$queryInsertAnswer = $db->consulta(UtilBd::registraRespuesta($idLastQuestion,$respuesta2,($iscorrect == 2) ? 1 : 0));
					$queryInsertAnswer = $db->consulta(UtilBd::registraRespuesta($idLastQuestion,$respuesta3,($iscorrect == 3) ? 1 : 0));
					$queryInsertAnswer = $db->consulta(UtilBd::registraRespuesta($idLastQuestion,$respuesta4,($iscorrect == 4) ? 1 : 0));
					$db->closeConection();
					echo "<script>alert('Guardado correctamente');</script>";
				}
			}
		} else{
			echo "<script>alert('Error: No se pudo guardar');</script>";
		}
	}
?>

		<div id="fondo" class="container-contact100">
		<div id="formulario" class="wrap-contact100">
			<form class="contact100-form validate-form" action="registro.php" method="post">
				<span class="contact100-form-title">
					Registro
				</span>
				<div class='wrap-input100 input100-select bg1'>
					<span class='label-input100'>Dificultad *</span>
					<div>
					<select class='js-select2' name='level'>
					<option value="1" selected="selected">Facil</option>
					<option value="2">Medio</option>
					<option value="3">Dificil</option>
					<option value="4">Modo Dios</option>
					</select>
 							  
 				<div class='dropDownSelect2'></div>
 				</div>
 				</div>
				<?php

					if($db->num_rows($consultaAnimes)>0){
						echo "<div class='wrap-input100 input100-select bg1'>
								<span class='label-input100'>Anime *</span>
								<div>
								<select class='js-select2' name='anime'>";
						
  						while($resultados = $db->fetch_array($consultaAnimes)){ 
   						echo "<option selected='selected' value='".$resultados[0]."'>$resultados[1]</option>";
 						}
 						echo "</select>
 							  <div class='dropDownSelect2'></div>
 							  </div>
 							  </div>"; 
					}else {
 						echo "Sin registros";
 					}
					
				?>
				<div class="wrap-input100 validate-input bg1" data-validate="Please Type Your Name">
					<span class="label-input100">Pregunta *</span>
					<input class="input100" type="text" name="question" placeholder="Enter Your Question">
				</div>

				<div class="wrap-input100 validate-input bg1 rs1-wrap-input100" data-validate = "Enter Your Answer ">
					<span class="label-input100">Respuesta 1 *</span>
					<input class="input100" type="text" name="answer1" placeholder="Enter Your Asnswer ">
					<input class="input-radio100" id="radio1" type="radio" name="iscorrect" value="1" checked="checked">
					<label class="label-radio100" for="radio1">
					Es correcta
					</label>
				</div>

				<div class="wrap-input100 validate-input bg1 rs1-wrap-input100" data-validate = "Enter Your Answer">
					<span class="label-input100">Respuesta 2 *</span>
					<input class="input100" type="text" name="answer2" placeholder="Enter Your Asnswer">
					<input class="input-radio100" id="radio2" type="radio" name="iscorrect" value="2">
					<label class="label-radio100" for="radio2">
					Es correcta
					</label>
				</div>

				<div class="wrap-input100 validate-input bg1 rs1-wrap-input100" data-validate = "Enter Your Answer">
					<span class="label-input100">Respuesta 3 *</span>
					<input class="input100" type="text" name="answer3" placeholder="Enter Your Asnswer ">
					<input class="input-radio100" id="radio3" type="radio" name="iscorrect" value="3">
					<label class="label-radio100" for="radio3">
					Es correcta
					</label>
				</div>

				<div class="wrap-input100 validate-input bg1 rs1-wrap-input100" data-validate = "Enter Your Answer">
					<span class="label-input100">Respuesta 4 *</span>
					<input class="input100" type="text" name="answer4" placeholder="Enter Your Asnswer">
					<input class="input-radio100" id="radio4" type="radio" name="iscorrect" value="4">
					<label class="label-radio100" for="radio4">
					Es correcta
					</label>
				</div>

				<div class="container-contact100-form-btn">
					<button class="contact100-form-btn" type="Submit">
						<span>
							Submit
							<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
						</span>
					</button>
					<br>
					<button class="contact100-form-btn" onclick="limpiar();" ><span>
							Limpiar		
						</span>
					</button>
				</div>

			</form>
		</div>
	</div>

<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});


			$(".js-select2").each(function(){
				$(this).on('select2:close', function (e){
					if($(this).val() == "Please chooses") {
						$('.js-show-service').slideUp();
					}
					else {
						$('.js-show-service').slideUp();
						$('.js-show-service').slideDown();
					}
				});
			});
		})

	</script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="vendor/noui/nouislider.min.js"></script>
	<script>
	    var filterBar = document.getElementById('filter-bar');

	    noUiSlider.create(filterBar, {
	        start: [ 1500, 3900 ],
	        connect: true,
	        range: {
	            'min': 1500,
	            'max': 7500
	        }
	    });

	    var skipValues = [
	    document.getElementById('value-lower'),
	    document.getElementById('value-upper')
	    ];

	    filterBar.noUiSlider.on('update', function( values, handle ) {
	        skipValues[handle].innerHTML = Math.round(values[handle]);
	        $('.contact100-form-range-value input[name="from-value"]').val($('#value-lower').html());
	        $('.contact100-form-range-value input[name="to-value"]').val($('#value-upper').html());
	    });
		
		function limpiar() {
			var t = document.getElementById("formulario").getElementsByTagName("input");
			for (var i=0; i<t.length; i++) {
    			t[i].value = "";
    		}
		}
		
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>

</body>
</html>
