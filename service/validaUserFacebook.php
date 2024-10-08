<?php

include "utils/utilbd.php";
include "utils/mysql.php";
include "../model/user.php";

/*Login Mobile*/
loginUser();

function loginUser(){
	$requestJson = file_get_contents('php://input');
	$json = json_decode($requestJson);
	 if (isset($json)) {
	
		$user =  $json->userName;
		$usuario = null;
		 
		 if ($user != null) {
			 $db = new MysqlCon();
			 $db->conectar();
			 $loginConsulta = $db->consulta(UtilBd::validaUserFacebook($user));
			 if($db->num_rows($loginConsulta)>0){
				 while($result = $db->fetch_array($loginConsulta)){ 
					$usuario = new User($result['U_ID_USER'],$result['U_USER_NAME'],$result['U_NOMBRE'],$result['U_SEXO'],$result['U_EDAD'],$result['U_PASSWORD'],$result['U_EMAIL'],$result['U_TOKEN_FIREBASE'],$result['U_COINS'],$result['U_TOTAL_SCORE'],$result['U_IMG_USER'],$result['U_ESFERAS']);
				 }
				 $data = array('estatus' => '200','user' => $usuario);
				 $json = json_encode($data, JSON_PRETTY_PRINT);
				 echo $json;
			 } else {
				 $data = array('estatus' => '204','error' => "No se encontraron registros");
				 $json = json_encode($data, JSON_PRETTY_PRINT);
				 echo $json;
			 }
			 $db->closeConection();
		} else {
			$data = array('estatus' => '404','error' => "Bad Request2");
			$json = json_encode($data, JSON_PRETTY_PRINT);
			$db->closeConection();
			echo $json;
		}
	 } else {
		 $data = array('estatus' => '404','error' => "Bad Request");
		 $json = json_encode($data, JSON_PRETTY_PRINT);
		 echo $json;
	 }
	
}
?>