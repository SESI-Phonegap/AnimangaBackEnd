<?php

include "service/utils/utilbd.php";
include "service/utils/mysql.php";
include "service/model/user.php";

/*Login Mobile*/
loginUser();

function loginUser(){
	 if (isset($_POST['login'])) {
		 $jsonStr = urldecode($_POST['login']);
		 $jsonObj = json_decode($jsonStr);
		 $user =  $jsonObj->{'user'};
	     $pass = $jsonObj->{'pass'};
		 
		 $usuario = null;
		 
		 if ($user != null && $pass != null) {
			 $db = new MysqlCon();
			 $db->conectar();
			 $loginConsulta = $db->consulta(UtilBd::login($user,$pass));
			 if($db->num_rows($loginConsulta)>0){
				 while($result = $db->fetch_array($loginConsulta)){ 
					$usuario = new User($result['U_ID_USER'],$result['U_USER_NAME'],$result['U_NOMBRE'],$result['U_SEXO'],$result['U_EDAD'],$result['U_PASSWORD'],$result['U_EMAIL'],$result['U_TOKEN_FIREBASE'],$result['U_COINS']);
				 }
				 $data = array('estatus' => '200','user' => $usuario);
				 $json = json_encode($data, JSON_PRETTY_PRINT);
				 echo $json;
			 } else {
				 $data = array('estatus' => '204','error' => "No se encontraron registros");
				 $json = json_encode($data, JSON_PRETTY_PRINT);
				 echo $json;
			 }
			 
		} else {
			//echo "KO: is not set ";
		}
	 } else {
		 $data = array('estatus' => '404','error' => "Bad Request");
		 $json = json_encode($data, JSON_PRETTY_PRINT);
		 echo $json;
	 }
	
}
?>