<?php

include "utils/utilbd.php";
include "utils/mysql.php";

nuevoUsuario();

function nuevoUsuario(){

		if (isset($_POST['userNameFriend']) && isset($_POST['userName']) && isset($_POST['pass']) && isset($_POST['nombre']) && isset($_POST['email']) 
			&& isset($_POST['edad']) && isset($_POST['genero'])) {

			 $userNameFirend = $_POST['userNameFriend'];
			 $userName =  $_POST['userName'];
	         $pass = $_POST['pass'];
			 $nombre = $_POST['nombre'];
			 $email = $_POST['email'];
			 $edad = $_POST['edad'];
			 $genero = $_POST['genero'];
			 
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