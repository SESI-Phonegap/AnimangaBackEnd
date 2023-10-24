<?php

include "utils/utilbd.php";
include "utils/mysql.php";
include "../model/user.php";


searchFriend();

function searchFriend(){
	 if (isset($_POST['userName']) && isset($_POST['pass']) && isset($_POST['userNameQuery'])) {
		//if(true){
	
		$user =  $_POST['userName'];
		$user = urldecode($user);
	    $pass = $_POST['pass'];
	    $userNameQuery = $_POST['userNameQuery'];

	/*    $user =  "chris_slash109";
	    $pass = "mmmn";
	    $userNameQuery = "edga";
	*/
		
		 $usuario = null;
		 
		 if ($user != null && $userNameQuery != null) {
			 $db = new MysqlCon();
			 $db->conectar();
			 $loginConsulta = $db->consulta(UtilBd::login($user,$pass));
			 if($db->num_rows($loginConsulta)>0){

				while($resultLogin = $db->fetch_array($loginConsulta)){
					$usuario = new User($resultLogin['U_ID_USER'],
					$resultLogin['U_USER_NAME'],
					$resultLogin['U_NOMBRE'],
					$resultLogin['U_SEXO'],
					$resultLogin['U_EDAD'],
					$resultLogin['U_PASSWORD'],
					$resultLogin['U_EMAIL'],
					$resultLogin['U_TOKEN_FIREBASE'],
					$resultLogin['U_COINS'],
					$resultLogin['U_TOTAL_SCORE'],
					$resultLogin['U_IMG_USER'],
					$resultLogin['U_ESFERAS']
				);
				}

				$listAmigosActuales = array();
				$amigosActualesQuery = $db->consulta(UtilBd::getAllFriendsByUser($usuario->idUser));
				if($db->num_rows($amigosActualesQuery)>0){
					while($resultAmigos = $db->fetch_array($amigosActualesQuery)){
						array_push($listAmigosActuales,new User($resultAmigos['UF_ID_FRIEND'],
						$resultAmigos['U_USER_NAME'],
						$resultAmigos['U_NOMBRE'],
						"",
						 "",
						 "",
						 "",
						 "",
						 null,
						 null,
						 $resultAmigos['U_IMG_USER'],
						 $resultAmigos['U_ESFERAS']));
					}
				}
			//	echo("<script>console.log(".json_encode($listAmigosActuales).");</script>");

			 	$buscarAmigosConsulta = $db->consulta(UtilBd::searchFriendeByUserName($userNameQuery));
			 	if ($db->num_rows($buscarAmigosConsulta)>0) {
			 		$listFriends = array();
			 		while ($result = $db->fetch_array($buscarAmigosConsulta)) {
						 array_push($listFriends, new User($result['U_ID_USER'],
						 $result['U_USER_NAME'],
						 $result['U_NOMBRE'],
						 "",
						 "",
						 "",
						 "",
						 "",
						 null,
						 null,
						 $result['U_IMG_USER'],
						 $result['U_ESFERAS']));
					}
				//	echo("<script>console.log(".json_encode($listFriends).");</script>");
					$listFilter = array();
				    foreach($listFriends as $amigoQuery) {
						$bIgual = false;
						$amigosQuery = $amigoQuery;
						foreach ($listAmigosActuales as $amigo) {
							if(!$bIgual){
								if($amigosQuery->idUser == $amigo->idUser || $amigosQuery->idUser == $usuario->idUser){
									$bIgual = true;
								}
							}
						}
						if(!$bIgual){
							array_push($listFilter,$amigosQuery);
						}
					}

			 		$data = array('friends' => $listFilter);
				    $json = json_encode($data, JSON_UNESCAPED_SLASHES);
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