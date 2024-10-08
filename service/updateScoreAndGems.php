<?php

include "utils/utilbd.php";
include "utils/mysql.php";
include "../model/score.php";
include "../model/user.php";


serviceUpdateScoreAndGems();

function serviceUpdateScoreAndGems(){
	$requestJson = file_get_contents('php://input');
	$json = json_decode($requestJson);
	if (isset($json)) {
		  	 $user =  $json->email;
	         $pass = $json->pass;
			 $gems = $json->gems;
			 $score = $json->score;
			 $level = $json->level;
			 $idUser = $json->iduser;
			 $idAnime = $json->anime;
	
			 if ($user != null && $gems != null && $score != null && $level != null && $idUser != null && $idAnime != null) {
				 $db = new MysqlCon();
				 $db->conectar();
				 $_level = 1;
				 $loginConsulta = $db->consulta(UtilBd::login($user,$pass));
				 $userObj = null;
				 $totalGems = 0;
				 if($db->num_rows($loginConsulta)>0){

				 	while ($resultado = $db->fetch_array($loginConsulta)) {
				 		$userObj = new User($resultado['U_ID_USER'],$resultado['U_USER_NAME'],$resultado['U_NOMBRE'],$resultado['U_SEXO'],$resultado['U_EDAD'],$resultado['U_PASSWORD'],$resultado['U_EMAIL'],$resultado['U_TOKEN_FIREBASE'],$resultado['U_COINS'],$resultado['U_TOTAL_SCORE'],$resultado['U_IMG_USER'],$resultado['U_ESFERAS']);
				 	}
				 	$totalGems = $gems + $userObj->coins;


					 $queryScoreLevel = $db->consulta(UtilBd::checkLevelAndScoreByUser($idUser,$idAnime));
					 $scoreObj = null;
					 if($db->num_rows($queryScoreLevel) > 0){
						 
						 while($result = $db->fetch_array($queryScoreLevel)){
							$scoreObj = new ScoreLevel($result['SC_ID_SCORE'],$result['SC_SCORE'],$result['SC_NIVEL'],$result['SC_ID_ANIME'],$result['SC_ID_USER']); 
						 }
						 $_level = $scoreObj->level;
						 if($_level < 4){
							 $_level = $scoreObj->level + 1;
						 }
						 if ($score < $scoreObj->score) {
						 	$score = $scoreObj->score;
						 }

						 $queryUpdateScoreLevel = $db->bConsulta(UtilBd::updateScoreAndLevel($scoreObj->idScore, $idUser, $idAnime, $score, $_level));
						 
						 if($queryUpdateScoreLevel){
							 //actualiza las gemas
							 $queryUpdateGemas = $db->bConsulta(UtilBd::updateGems($idUser,$totalGems));
							 if($queryUpdateGemas){
								 
								 $queryUpdateTotalScore = $db->bConsulta(UtilBd::updateTotalScore($idUser));
								 
								 if($queryUpdateTotalScore){
									 $data = array('estatus' => '200','error' => "Ok");
									 $json = json_encode($data, JSON_PRETTY_PRINT);
									 echo $json;
								 } else {
									 $data = array('estatus' => '500','error' => "Error en la operacion en base de datos, no fue posible actualizar el score.");
							         $json = json_encode($data, JSON_PRETTY_PRINT);
									 echo $json;
								 }
								 
							 } else {
								 $data = array('estatus' => '500','error' => "Error en la operacion en base de datos, no fue posible actualizar las gemas.");
							     $json = json_encode($data, JSON_PRETTY_PRINT);
								 echo $json;
							 }
							 
						 } else {
							 $data = array('estatus' => '500','error' => "Error en la operacion en base de datos, no fue posible actualizar.");
							 $json = json_encode($data, JSON_PRETTY_PRINT);
							 echo $json;
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