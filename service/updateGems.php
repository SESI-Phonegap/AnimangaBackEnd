<?php

include "utils/utilbd.php";
include "utils/mysql.php";
include "../model/user.php";

updateGemas();

function updateGemas(){
		if (isset($_POST['userName']) && isset($_POST['pass']) && isset($_POST['iduser']) && isset($_POST['gems'])) {
			 $user =  $_POST['userName'];
			 $user = urldecode($user);
	         $pass = $_POST['pass'];
			 $gems = $_POST['gems'];
			 $idUser = $_POST['iduser'];
			 $usuario = null;
			 
			 if ($user != null && $gems != null && $idUser != null) {
				 $db = new MysqlCon();
				 $db->conectar();
				 $loginConsulta = $db->consulta(UtilBd::login($user,$pass));
				 
				 if($db->num_rows($loginConsulta)>0){
					while($result = $db->fetch_array($loginConsulta)){
						$usuario = new User($result['U_ID_USER'],
						$result['U_USER_NAME'],
						$result['U_NOMBRE'],
						$result['U_SEXO'],
						$result['U_EDAD'],
						$result['U_PASSWORD'],
						$result['U_EMAIL'],
						$result['U_TOKEN_FIREBASE'],
						$result['U_COINS'],
						$result['U_TOTAL_SCORE'],
						$result['U_IMG_USER'],
						$result['U_ESFERAS']);
					}
					 $totalGems = $usuario->getCoins() + $gems;
					 $updateGemasConsulta = $db->bConsulta(UtilBd::updateGems($idUser,$totalGems));
					 if($updateGemasConsulta){
						 $data = array('estatus' => '200','error' => "Ok");
						 $json = json_encode($data, JSON_PRETTY_PRINT);
						 echo $json;
					 }else{
						 $data = array('estatus' => '500','error' => "Error en la operacion en base de datos, no fue posible actualizar las gemas.");
						 $json = json_encode($data, JSON_PRETTY_PRINT);
						 echo $json;
					 }
				 }else {
					$data = array('estatus' => '202','error' => "Credenciales incorrectas");
					$json = json_encode($data, JSON_PRETTY_PRINT);
					echo $json;
				 }
				 $db->closeConection();
			 }else{
			        $data = array('estatus' => '404','error' => "Error !!");
				    $json = json_encode($data, JSON_PRETTY_PRINT);
				    echo $json;
				  }

		}else{
			$data = array('estatus' => '404','error' => "Bad Request");
			$json = json_encode($data, JSON_PRETTY_PRINT);
			echo $json;
		}

}

?>