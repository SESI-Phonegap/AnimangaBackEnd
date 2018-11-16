<?php

include "utils/utilbd.php";
include "utils/mysql.php";
include "../model/questions.php";
include "../model/respuestas.php";

questionsByAnime();

function questionsByAnime(){
	if (isset($_POST['userName']) && isset($_POST['pass']) && isset($_POST['anime'])) {
		//if(true){
		     $user =  $_POST['userName'];
	         $pass = $_POST['pass'];
			 $idAnime = $_POST['anime'];
			/* $user = 'chris_slash10';
			 $pass = 'Mexico-17';
			 $idAnime = 1;*/
			 
			 if($user != null && $idAnime != null) {
				 $db = new MysqlCon();
				 $db->conectar();
				 $loginConsulta = $db->consulta(UtilBd::login($user,$pass));
				 if($db->num_rows($loginConsulta)>0){
					$queryQuestion = $db->consulta(UtilBd::getQuestionsByAnime($idAnime));
					 if($db->num_rows($queryQuestion) > 0){
						 $arrayPreguntas = array();
						 
						 while($result = $db->fetch_array($queryQuestion)){
							 $arrayRespuestas = array();
							 $queryAnswers = $db->consulta(UtilBd::getAsnwersById($result['P_ID_PREGUNTA']));
							 if ($db->num_rows($queryAnswers) > 0){
								 while($resultA = $db->fetch_array($queryAnswers)){
									array_push($arrayRespuestas,new Respuestas($resultA['RE_ID_RESPUESTA'],$resultA['RE_RESPUESTA'],$resultA['RE_IS_CORRECT'],$resultA['RE_ID_PREGUNTA']));
									}
							 }else{
								$data = array('estatus' => '204','error' => "No se encontraron Respuestas");
								$json = json_encode($data, JSON_PRETTY_PRINT);
								echo $json;
								}
							array_push($arrayPreguntas,new Questions($result['P_ID_PREGUNTA'],$result['P_PREGUNTA'],$result['P_PUNTOS'],$arrayRespuestas));
						 }
						 $data = array('preguntas' => $arrayPreguntas);
						//print_r($data);
						 $json = json_encode($data,JSON_UNESCAPED_UNICODE);
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