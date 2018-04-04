<?php

include "utils/utilbd.php";
include "utils/mysql.php";
include "../model/score.php";


serviceUpdateScoreAndGems();

public function serviceUpdateScoreAndGems(){
	//if (isset($_POST['userName']) && isset($_POST['pass']) && isset($_POST['gems']) && isset($_POST['score']) && isset($_POST['level']) && isset($_POST['idUser'])) {
		if(true){
		   /*$user =  $_POST['userName'];
	         $pass = $_POST['pass'];
			 $gems = $_POST['gems'];
			 $score = $_POST['score'];
			 $level = $_POST['level'];
			 $idUser = $_POST['idUser'];*/
			 $user = 'chris_slash10';
			 $pass = 'Mexico-17';
			 $gems = 50;
			 $score = 600;
			 $level = 2;
			 $idUser = 1;
			 
			 if ($user != null && $pass != null && $gems != null && $score != null && $level != null && $idUser != null) {
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
						 
						 
					 } else {
						 $data = array('estatus' => '500','error' => "Error en la operacion en base de datos");
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