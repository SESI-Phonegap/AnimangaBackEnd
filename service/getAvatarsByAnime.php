<?php

include "utils/utilbd.php";
include "utils/mysql.php";
include "../model/wallpaper.php";

getAvatarsByAnimes();

function getAvatarsByAnimes(){
	if (isset($_POST['userName']) && isset($_POST['pass']) && isset($_POST['anime']) ) {
		//if(true){
		     $user =  $_POST['userName'];
	         $pass = $_POST['pass'];
			 $idAnime = $_POST['anime'];
			
			 
			 if ($user != null && $idAnime != null) {
				 $db = new MysqlCon();
				 $db->conectar();
				 $loginConsulta = $db->consulta(UtilBd::login($user,$pass));
				 if($db->num_rows($loginConsulta)>0){
					 $queryAvatar = $db->consulta(UtilBd::getAvatarByAnime($idAnime));
					 if($db->num_rows($queryAvatar) > 0){
						 $listAvatar = array();
						 while($result = $db->fetch_array($queryAvatar)){
							 array_push($listAvatar,new Wallpaper($result['REC_ID_RECOMPENSA'],
							 $result['REC_URL'],
							 $result['REC_URL_EXAMPLE'],
							 $result['REC_ID_ANIME'],
							 $result['REC_COSTO']));
						 }
						 $data = array('wallpapers' => $listAvatar);
						 //print_r($data);
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