<?php

include "utils/utilbd.php";
include "utils/mysql.php";
include "../model/user.php";


getAllFriendsByUser();

function getAllFriendsByUser(){
	$requestJson = file_get_contents('php://input');
	$json = json_decode($requestJson);
    if (isset($json)) {
	
		$user =  $json->email;
        $pass = $json->pass;
        
        $usuario = null;
        if ($user != null) {
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
					$resultLogin['U_ESFERAS']);
                }
                $listAmigosActuales = array();
                $amigosActualesQuery = $db->consulta(UtilBd::getAllFriendsScoreByUser($usuario->idUser));
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
                         $resultAmigos['U_TOTAL_SCORE'],
                         $resultAmigos['U_IMG_USER'],
						 $resultLogin['U_ESFERAS']));
                    }
                    $data = array('friends' => $listAmigosActuales);
				    $json = json_encode($data, JSON_UNESCAPED_SLASHES);
				    echo $json;
				}else {
                    $json = '{"friends": []}';
				    echo $json;
                }
            }else {
				 $data = array('estatus' => '204','error' => "No se encontraron registros");
				 $json = json_encode($data, JSON_PRETTY_PRINT);
				 echo $json;
			 }
			 $db->closeConection();
        }else {
			$data = array('estatus' => '404','error' => "Bad Request2");
			$json = json_encode($data, JSON_PRETTY_PRINT);
			echo $json;
		}
    }else {
            $data = array('estatus' => '404','error' => "Bad Request");
            $json = json_encode($data, JSON_PRETTY_PRINT);
            echo $json;
        }
}

?>