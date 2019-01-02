<?php

include "utils/utilbd.php";
include "utils/mysql.php";
include "../model/questions.php";
include "../model/respuestas.php";

questionsByAnimeImg();

function questionsByAnimeImg(){
	if (isset($_POST['userName']) && isset($_POST['pass']) && isset($_POST['anime'])) {
		//if(true){
		$user =  $_POST['userName'];
	    $pass = $_POST['pass'];
        $idanime = $_POST['anime'];
        /*$user = 'chris_slash10';
	    $pass = 'Mexico-17';
		$idanime = 1;*/
		
		if ($user != null && $idanime != null) {
		    $db = new MysqlCon();
			$db->conectar();
			$loginConsulta = $db->consulta(UtilBd::login($user,$pass));
			if($db->num_rows($loginConsulta)>0){
				$queryQuestion = $db->consulta(UtilBd::getQuestionImg($idanime));
				if($db->num_rows($queryQuestion) > 0){
                    $arrayPreguntas = array();
					
					while($result = $db->fetch_array($queryQuestion)){
						$arrayRespuestas = array();
						$queryAnswers = $db->consulta(UtilBd::getAnswersByIdImg($result['Q_ID_QUIZ']));
						if ($db->num_rows($queryAnswers) > 0){
							while($resultA = $db->fetch_array($queryAnswers)){
								array_push($arrayRespuestas,new Respuestas($resultA['REQU_ID_RESPUESTA'],$resultA['REQU_RESPUESTA'],$resultA['REQU_IS_CORRECT'],$resultA['REQU_ID_PREGUNTA']));
							}
						} else{
							$data = array('estatus' => '204','error' => "No se encontraron Respuestas");
				            $json = json_encode($data, JSON_PRETTY_PRINT);
				            echo $json;
						}
					array_push($arrayPreguntas,new Questions($result['Q_ID_QUIZ'],$result['Q_URL_IMG'],$result['Q_PUNTOS'],$arrayRespuestas));
					
					}
					$data = array('preguntas' => $arrayPreguntas);
					//print_r($data);
					$json = json_encode($data,JSON_UNESCAPED_SLASHES);
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