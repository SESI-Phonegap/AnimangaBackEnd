<?php

include "utils/utilbd.php";
include "utils/mysql.php";

nuevoUsuario();

function nuevoUsuario(){

	$requestJson = file_get_contents('php://input');
	$json = json_decode($requestJson);

		if (isset($json)) {

			 $userNameFirend = $json->userNameFriend;
			 $userName =  $json->userName;
	         $pass = $json->pass;
			 $nombre = $json->nombre;
			 $email = $json->email;
			 $edad = $json->edad;
			 $genero = $json->genero;
			 
				 $db = new MysqlCon();
				 $db->conectar();
				 
				 //Consulta para comprobar que no este en uso el email
				 $emailConsulta = $db->consulta(UtilBd::checkEmail($email));
				 
				  if($db->num_rows($emailConsulta)>0){
					  //Ya existe es correo
					  $data = array('estatus' => '202','error' => "El correo ya esta registrado");
					  $json = json_encode($data, JSON_PRETTY_PRINT);
					  echo $json;
				  } else {
					  $userNameConsulta = $db->consulta(UtilBd::checkUserName($userName));
					  
					  if($db->num_rows($userNameConsulta)>0){
						  //Ya existe ese nombre de usuario
						  $data = array('estatus' => '203','error' => "El User Name ya esta registrado");
						  $json = json_encode($data, JSON_PRETTY_PRINT);
						  echo $json;
					  } else {
						  $nuevoUsuarioQuery = $db->bConsulta(UtilBd::registroNuevoUsuario($userName, $nombre, $genero, $edad, $pass, $email));
						  
						  if($nuevoUsuarioQuery){
							  if($userNameFirend != ""){
								$updateGemsFriend = $db->bConsulta(UtilBd::updateGemsUserName($userNameFirend));
							  }
							  $data = array('estatus' => '200','error' => "Registro exitoso !!");
							  $json = json_encode($data, JSON_PRETTY_PRINT);
							  echo $json;
						  } else {
							  $data = array('estatus' => '404','error' => "Error no fue posible realizar el registro !!");
							  $json = json_encode($data, JSON_PRETTY_PRINT);
							  echo $json;
						  }
					  }
					  
				  }
				 
		
			 
		}else{
			$data = array('estatus' => '404','error' => "Bad Request");
			$json = json_encode($data, JSON_PRETTY_PRINT);
			echo $json;
		}
}

?>