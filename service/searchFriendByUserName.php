<?php

include "utils/utilbd.php";
include "utils/mysql.php";
include "../model/user.php";


searchFriend();

function searchFriend(){
	 if (isset($_POST['userName']) && isset($_POST['pass']) && isset($_POST['userNameQuery'])) {
	//	if(true){
	
		$user =  $_POST['userName'];
	    $pass = $_POST['pass'];
	    $userNameQuery = $_POST['userNameQuery'];

	  /*  $user =  "chris_slash10";
	    $pass = "Mexico-17";
	    $userNameQuery = "chr";*/
	
		
		 $usuario = null;
		 
		 if ($user != null && $pass != null && $userNameQuery != null) {
			 $db = new MysqlCon();
			 $db->conectar();
			 $loginConsulta = $db->consulta(UtilBd::login($user,$pass));
			 if($db->num_rows($loginConsulta)>0){
			 	$buscarAmigosConsulta = $db->consulta(UtilBd::searchFriendeByUserName($userNameQuery));
			 	if ($db->num_rows($buscarAmigosConsulta)>0) {
			 		$listFriends = array();
			 		while ($result = $db->fetch_array($buscarAmigosConsulta)) {
			 			array_push($listFriends, new User($result['U_ID_USER'],$result['U_USER_NAME'],$result['U_NOMBRE'],"","","","","",null,null,$result['U_IMG_USER']));
			 		}
			 		$data = array('friends' => $listFriends);
				    $json = json_encode($data, JSON_PRETTY_PRINT);
				    echo $json;
			 	} else {
				    $json = '{"friends": []}';
				    echo $json;
			 	}
			
				 
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