<?php

include "utils/utilbd.php";
include "utils/mysql.php";
include "../model/questions.php";
include "../model/respuestas.php";


questionsByAnimeAndLevel();

function questionsByAnimeAndLevel(){
	$requestJson = file_get_contents('php://input');
	$json = json_decode($requestJson);
	if (isset($json)) {
		$user =  $json->email;
	    $pass = $json->pass;
		$level = $json->level;
		$idanime = $json->anime;
		
		if ($user != null && $idanime != null) {
		    $db = new MysqlCon();
			$db->conectar();
			$loginConsulta = $db->consulta(UtilBd::login($user,$pass));
			if($db->num_rows($loginConsulta)>0){
				$queryQuestion = $db->consulta(UtilBd::getQuestionsByAnimeAndLevel($idanime,$level));
				if($db->num_rows($queryQuestion) > 0){
					$arrayPreguntas = array();
					
					while($result = $db->fetch_array($queryQuestion)){
						$arrayRespuestas = array();
						$queryAnswers = $db->consulta(UtilBd::getAsnwersById($result['P_ID_PREGUNTA']));
						if ($db->num_rows($queryAnswers) > 0){
							while($resultA = $db->fetch_array($queryAnswers)){
								array_push($arrayRespuestas,new Respuestas($resultA['RE_ID_RESPUESTA'],$resultA['RE_RESPUESTA'],$resultA['RE_IS_CORRECT'],$resultA['RE_ID_PREGUNTA']));
							}
						} else{
							$data = array('estatus' => '204','error' => "No se encontraron Respuestas");
				            $json = json_encode($data, JSON_PRETTY_PRINT);
				            echo $json;
						}
					array_push($arrayPreguntas,new Questions($result['P_ID_PREGUNTA'],$result['P_PREGUNTA'],$result['P_PUNTOS'],$arrayRespuestas));
					
					}
					$data = array('preguntas' => $arrayPreguntas);
					//print_r($data);
					$json = json_encode($data);
				    echo $json;
				} else {
					$data = array('estatus' => '204','error' => "No se encontraron registros");
				    $json = json_encode($data, JSON_PRETTY_PRINT);
				    echo $json;
				}
			} else {
				$data = array('estatus' => '202','error' => "Credenciales incorrectas");
				$json = json_encode($data, JSON_PRETTY_PRINT);
				echo $json;
			}
			$db->closeConection();
		} else{
			        $data = array('estatus' => '404','error' => "Error !!");
				    $json = json_encode($data, JSON_PRETTY_PRINT);
				    echo $json;
		}
	} else{
		 $data = array('estatus' => '404','error' => "Bad Request");
		 $json = json_encode($data, JSON_PRETTY_PRINT);
		 echo $json;
	}
}

?>