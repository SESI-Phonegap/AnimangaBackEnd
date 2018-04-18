<?php

include "utils/utilbd.php";
include "utils/mysql.php";
include "../model/score.php";

ServieCheckLevelAndScorByUser();

function ServieCheckLevelAndScorByUser(){
	if (isset($_POST['userName']) && isset($_POST['pass']) && isset($_POST['anime']) && isset($_POST['iduser'])) {
		//if(true){
		     $user =  $_POST['userName'];
	         $pass = $_POST['pass'];
			 $idAnime = $_POST['anime'];
			 $idUser = $_POST['iduser'];
			/* $user = 'chris_slash10';
			 $pass = 'Mexico-17';
			 $idAnime = 1;
			 $idUser = 1;*/
			 
			 if ($user != null && $pass != null && $idUser != null && $idAnime != null) {
				 $db = new MysqlCon();
				 $db->conectar();
				 $loginConsulta = $db->consulta(UtilBd::login($user,$pass));
				 if($db->num_rows($loginConsulta)>0){
					 $queryScoreLevel = $db->consulta(UtilBd::checkLevelAndScoreByUser($idUser,$idAnime));
					 $scoreObj = null;
					 if($db->num_rows($queryScoreLevel) > 0){
						 
						 while($result = $db->fetch_array($queryScoreLevel)){
							$scoreObj = new ScoreLevel($result['SC_ID_SCORE'],$result['SC_SCORE'],$result['SC_NIVEL'],$result['SC_ID_ANIME'],$result['SC_ID_USER']); 
						 }
						  $data = array('estatus' => '200','score' => $scoreObj);
						  //print_r($data);
						  $json = json_encode($data,JSON_PRETTY_PRINT);
						  echo $json;
						 
					 } else {
						 $queryInitScore = $db->bConsulta(UtilBd::initScore($idUser,$idAnime));
						 if ($queryInitScore){
							 $queryScoreLevel = $db->consulta(UtilBd::checkLevelAndScoreByUser($idUser,$idAnime));
							 
							 while($result = $db->fetch_array($queryScoreLevel)){
								$scoreObj = new ScoreLevel($result['SC_ID_SCORE'],$result['SC_SCORE'],$result['SC_NIVEL'],$result['SC_ID_ANIME'],$result['SC_ID_USER']); 
							}
							
							$data = array('estatus' => '200','score' => $scoreObj);
							//print_r($data);
							$json = json_encode($data,JSON_PRETTY_PRINT);
							echo $json;
							
						 } else {
							  $data = array('estatus' => '500','error' => "Error en la operacion en base de datos");
							  $json = json_encode($data, JSON_PRETTY_PRINT);
							  echo $json;
						 }
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