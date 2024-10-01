<?php

include "utils/utilbd.php";
include "utils/mysql.php";

updateEsferas();

function updateEsferas(){
	$requestJson = file_get_contents('php://input');
	$json = json_decode($requestJson);
		if (isset($json)) {
			 $user =  $json->email;
	         $pass = $json->pass;
			 $esferas = $json->esferas;
			 $idUser = $json->iduser;
			 
			 if ($user != null && $idUser != null && $esferas != null) {
				 $db = new MysqlCon();
				 $db->conectar();
				 $loginConsulta = $db->consulta(UtilBd::login($user,$pass));
				 
				 if($db->num_rows($loginConsulta)>0){
					 $updateEsferasConsulta = $db->bConsulta(UtilBd::updateEsferasByUser($idUser,$esferas));
					 if($updateEsferasConsulta){
						 $data = array('estatus' => '200','error' => "Obtuviste una esfera del dragon");
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
			        $data = array('estatus' => '404','error' => "Error esferas !!");
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