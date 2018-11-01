<?php

include "utils/utilbd.php";
include "utils/mysql.php";
include "../model/wallpaper.php";

getAvatarsByUser();

function getAvatarsByUser(){
	if (isset($_POST['userName']) && isset($_POST['pass']) && isset($_POST['iduser']) ) {
		//if(true){
		     $user =  $_POST['userName'];
	         $pass = $_POST['pass'];
			 $idUser = $_POST['iduser'];
			
           /* $user = "chris_slash10";
            $pass = "Mexico-17";
            $idUser = 1;*/
			 if ($user != null && $pass != null && $idUser != null) {
				 $db = new MysqlCon();
				 $db->conectar();
				 $loginConsulta = $db->consulta(UtilBd::login($user,$pass));
				 if($db->num_rows($loginConsulta)>0){
					 $queryAvatar = $db->consulta(UtilBd::getAllAvatarsByUser($idUser));
					 if($db->num_rows($queryAvatar) > 0){
						 $listAvatar = array();
						 while($result = $db->fetch_array($queryAvatar)){
							 array_push($listAvatar,new Wallpaper($result['REC_ID_RECOMPENSA'],
							 $result['REC_URL'],
							 "",
							 null,
							 null));
						 }
						 $data = array('wallpapers' => $listAvatar);
						 $json = json_encode($data,JSON_UNESCAPED_SLASHES);
						 echo $json;
					 } else {
						$json = '{"wallpapers": []}';
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