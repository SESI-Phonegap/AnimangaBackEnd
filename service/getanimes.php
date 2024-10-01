<?php

include "utils/utilbd.php";
include "utils/mysql.php";
include "../model/anime.php";

getAllAnimes();

function getAllAnimes(){
	$requestJson = file_get_contents('php://input');
	$json = json_decode($requestJson);
	if (isset($json) ) {
		     $email =  $json->email;
	         $pass = $json->pass;
			 
			 if ($email != null) {
				 $db = new MysqlCon();
				 $db->conectar();
				 $loginConsulta = $db->consulta(UtilBd::login($email,$pass));
				 if($db->num_rows($loginConsulta)>0){
					 $queryAllAnimes = $db->consulta(UtilBd::getAllAnimes());
					 if($db->num_rows($queryAllAnimes) > 0){
						 $arrayAnimes = array();
						 
						 while($result = $db->fetch_array($queryAllAnimes)){
							 array_push($arrayAnimes,new Anime($result['AN_ID_ANIME'],$result['AN_ANIME'],$result['AN_IMG']));
						 }
						 $data = array('animes' => $arrayAnimes);
						//print_r($data);
						 $json = json_encode($data,JSON_UNESCAPED_SLASHES);
						 echo $json;
					 }else {
						$data = array('estatus' => '204','error' => "No se encontraron registros");
						$json = json_encode($data, JSON_PRETTY_PRINT);
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