<?php

include "utils/utilbd.php";
include "utils/mysql.php";
include "../model/wallpaper.php";

getWallpaperByAnimes();

function getWallpaperByAnimes(){
	if (isset($_POST['userName']) && isset($_POST['pass']) && isset($_POST['anime']) ) {
		//if(true){
		     $user =  $_POST['userName'];
			 $user = urldecode($user);
	         $pass = $_POST['pass'];
			 $idAnime = $_POST['anime'];
			
			 
			 if ($user != null && $idAnime != null) {
				 $db = new MysqlCon();
				 $db->conectar();
				 $loginConsulta = $db->consulta(UtilBd::login($user,$pass));
				 if($db->num_rows($loginConsulta)>0){
					 $queryWallpaper = $db->consulta(UtilBd::getWallpaperByAnime($idAnime));
					 if($db->num_rows($queryWallpaper) > 0){
						 $listWallpaper = array();
						 while($result = $db->fetch_array($queryWallpaper)){
							 array_push($listWallpaper,new Wallpaper($result['REC_ID_RECOMPENSA'],
							 $result['REC_URL'],
							 $result['REC_URL_EXAMPLE'],
							 $result['REC_ID_ANIME'],
							 $result['REC_COSTO']));
						 }
						 $data = array('wallpapers' => $listWallpaper);
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