<?php

include "utils/utilbd.php";
include "utils/mysql.php";

updateGemas();

function updateGemas(){
		if (isset($_POST['userName']) && isset($_POST['pass']) && isset($_POST['iduser']) && isset($_POST['gems'])) {
			 $user =  $_POST['userName'];
	         $pass = $_POST['pass'];
			 $gems = $_POST['gems'];
			 $idUser = $_POST['iduser'];
			 
			 if ($user != null && $pass != null && $gems != null && $idUser != null) {
				 $db = new MysqlCon();
				 $db->conectar();
				 $loginConsulta = $db->consulta(UtilBd::login($user,$pass));
				 
				 if($db->num_rows($loginConsulta)>0){
					 $updateGemasConsulta = $db->bConsulta(UtilBd::updateGems($idUser,$gems));
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