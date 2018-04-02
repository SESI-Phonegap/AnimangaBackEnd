<?php
class UtilBd{
 
 /*
  * Login para la app android
  */
	public static function login($user, $passw){
	  return "SELECT * 
	  FROM TB_USER 
	  WHERE U_USER_NAME = '".$user."' AND U_PASSWORD = '".$passw."';";
  }
  
 /*
  * Login para la app web
  */
  public static function loginWeb($user, $passw){
	  return "SELECT U_USER_NAME, U_PASSWORD 
	  FROM TB_USER 
	  WHERE U_USER_NAME = '".$user."' AND U_PASSWORD = '".$passw."' ;";
  }
  
  /*
   *  Registro de nuevo usuario
   *  
   */
   public static function registroNuevoUsuario($userName, $nombre, $sexo, $edad, $password, $email, $token){
	   return "INSERT INTO TB_USER (U_USER_NAME,U_NOMBRE,U_SEXO,U_EDAD,U_PASSWORD,U_EMAIL,U_TOKEN_FIREBASE,U_COINS)
			   VALUES ('".$userName."', '".$nombre."', '".$sexo."', ".$edad.", '".$password."', '".$email."', '".$token."', 500);";
   }
   
  /*
   *  Actualiza los items gemas o monedas
   *
   */
   public static function updateGems($idUser,$gemas){
	   return "UPDATE TB_USER
			   SET U_COINS = ".$gemas.
			   " WHERE U_ID_USER = ".$idUser." ;";
   }
  
 /*
  * Registro de preguntas
  */
  public static function registraPregunta($pregunta, $idAnime, $dificultad, $puntos){
	  return "INSERT INTO TB_PREGUNTAS (P_PREGUNTA, P_NIVEL_DIFICULTAD, P_PUNTOS, P_ID_ANIME)
	  VALUES ('".$pregunta."' , ".$dificultad." , ".$puntos.", ".$idAnime.") ;";
  }
  
 /*
  * Registro de respuestas
  */
  public static function registraRespuesta($idPregunta,$respuesta,$iscorrect){
	  return "INSERT INTO TB_RESPUESTAS (RE_RESPUESTA, RE_IS_CORRECT, RE_ID_PREGUNTA )
	  VALUES ('".$respuesta."',".$iscorrect.",".$idPregunta."); ";
  }
  
 /*
  * Obtiene la ultima pregunta registrada para poder añadir sus respectivas respuestas  
  */
  public static function ultimaPreguntaAgregada(){
	  return "SELECT P_ID_PREGUNTA
	  FROM TB_PREGUNTAS
	  ORDER BY P_ID_PREGUNTA DESC LIMIT 1";
  }
  
 /*
  * Obtiene preguntas clasificados por un anime especifico y un nivel de dificultad.
  * Limite de 20 preguntas. 
  */
  public static function getQuestionsByAnimeAndLevel($idAnime, $nivel){
	  return "SELECT TB_PREGUNTAS.P_ID_PREGUNTA,
					 TB_PREGUNTAS.P_PREGUNTA,
					 TB_PREGUNTAS.P_PUNTOS
			 FROM TB_PREGUNTAS
			 WHERE TB_PREGUNTAS.P_ID_ANIME = ".$idAnime." AND TB_PREGUNTAS.P_NIVEL_DIFICULTAD = ".$nivel.
             " ORDER BY RAND() LIMIT 20";
  }
/*  public static function getQuestionsByAnimeAndLevel($idAnime, $nivel){
	  return "SELECT TB_PREGUNTAS.P_ID_PREGUNTA,
					 TB_PREGUNTAS.P_PREGUNTA,
					 TB_PREGUNTAS.P_PUNTOS,
					 TB_RESPUESTAS.RES_ID_RESPUESTA,
					 TB_RESPUESTAS.RES_RESPUESTA,
					 TB_RESPUESTAS.RES_ISCORRECT
			 FROM TB_PREGUNTAS
			 INNER JOIN TB_RESPUESTAS ON TB_PREGUNTAS.P_ID_PREGUNTA = TB_RESPUESTAS.RES_ID_PREGUNTA 
			 WHERE TB_PREGUNTAS.P_ID_ANIME = ".$idAnime." AND TB_PREGUNTAS.P_NIVEL_DIFICULTAD = ".$nivel.
			 " ORDER BY RAND() LIMIT 20;";
  }*/
  
  /*
  * Obtiene las respuestas de la pregunta por ID en orden aleatorio
  *  
  */
  public static function getAsnwersById($idQuestion){
	  return "SELECT TB_RESPUESTAS.RE_ID_RESPUESTA,
			         TB_RESPUESTAS.RE_RESPUESTA,
					 TB_RESPUESTAS.RE_IS_CORRECT,
					 TB_RESPUESTAS.RE_ID_PREGUNTA
			 FROM TB_RESPUESTAS
			 WHERE TB_RESPUESTAS.RE_ID_PREGUNTA = ".$idQuestion.
             " ORDER BY RAND()";
  }
  
 /*
  * Obtiene preguntas clasificados por un anime especifico 
  * Limite de 40 preguntas. 
  */
  public static function getQuestionsByAnime($idAnime){
	  return "SELECT TB_PREGUNTAS.P_ID_PREGUNTA,
					 TB_PREGUNTAS.P_PREGUNTA,
					 TB_PREGUNTAS.P_PUNTOS,
					 TB_RESPUESTAS.RES_ID_RESPUESTA,
					 TB_RESPUESTAS.RES_RESPUESTA,
					 TB_RESPUESTAS.RES_ISCORRECT
			 FROM TB_PREGUNTAS
			 INNER JOIN TB_RESPUESTAS ON TB_PREGUNTAS.P_ID_PREGUNTA = TB_RESPUESTAS.RES_ID_PREGUNTA 
			 WHERE TB_PREGUNTAS.P_ID_ANIME = ".$idAnime." 
			 ORDER BY RAND() LIMIT 40 ;";
  }
  
 /*
  * Obtiene preguntas de animes aleatorios de un nivel especifico. 
  * Limite de 20 preguntas. 
  */
  public static function getQuestionsRandomByLevel($nivel){
	  return "SELECT TB_PREGUNTAS.P_ID_PREGUNTA,
					 TB_PREGUNTAS.P_PREGUNTA,
					 TB_PREGUNTAS.P_PUNTOS,
					 TB_RESPUESTAS.RES_ID_RESPUESTA,
					 TB_RESPUESTAS.RES_RESPUESTA,
					 TB_RESPUESTAS.RES_ISCORRECT
			 FROM TB_PREGUNTAS
			 INNER JOIN TB_RESPUESTAS ON TB_PREGUNTAS.P_ID_PREGUNTA = TB_RESPUESTAS.RES_ID_PREGUNTA 
			 WHERE TB_PREGUNTAS.P_NIVEL_DIFICULTAD = ".$nivel." 
			 ORDER BY RAND() LIMIT 20 ;";
  }

  public static function getAllAnimes(){
  	return "SELECT * FROM TB_ANIME;";
  }
}

?>