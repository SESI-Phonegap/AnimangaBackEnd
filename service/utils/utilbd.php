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
   /*public static function registroNuevoUsuario($userName, $nombre, $sexo, $edad, $password, $email, $token){
	   return "INSERT INTO TB_USER (U_USER_NAME,U_NOMBRE,U_SEXO,U_EDAD,U_PASSWORD,U_EMAIL,U_TOKEN_FIREBASE,U_COINS,U_TOTAL_SCORE)
			   VALUES ('".$userName."', '".$nombre."', '".$sexo."', ".$edad.", '".$password."', '".$email."', '".$token."', 3000, 0);";
   }*/
   public static function registroNuevoUsuario($userName, $nombre, $sexo, $edad, $password, $email){
	   return "INSERT INTO TB_USER (U_USER_NAME,U_NOMBRE,U_SEXO,U_EDAD,U_PASSWORD,U_EMAIL,U_TOKEN_FIREBASE,U_COINS,U_TOTAL_SCORE,U_IMG_USER)
			   VALUES ('".$userName."', '".$nombre."', '".$sexo."', ".$edad.", '".$password."', '".$email."', '', 5000, 0,'');";
   }
   
  /*
   *  validar si existe un email
   *
   */
   public static function checkEmail($email){
	   return "SELECT U_EMAIL FROM TB_USER WHERE U_EMAIL = '".$email."' ;";
   }
   
   public static function checkUserName($userName){
	   return "SELECT U_USER_NAME FROM TB_USER WHERE U_USER_NAME = '".$userName."' ;";
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

   public static function updateGemsUserName($userName){
    return "UPDATE TB_USER
            SET U_COINS = ((SELECT U_COINS WHERE U_USER_NAME = '".$userName."') + 2500)
            WHERE U_USER_NAME = '".$userName."'";
  }
   
  /*
   *  Actualiza el ScoreTotal de un usuario
   *
   */
   public static function updateTotalScore($idUser){
	   return "UPDATE TB_USER
			   SET U_TOTAL_SCORE = (SELECT SUM(SC_SCORE) FROM TB_SCORE_ANIME_USER WHERE SC_ID_USER = ".$idUser.")
			   WHERE U_ID_USER = ".$idUser.";";
   }
   
 /*
  * Checa el score y nivel de un usuario y un anime especifico
  */
  public static function checkLevelAndScoreByUser($idUser, $idAnime){
	  return "SELECT * FROM TB_SCORE_ANIME_USER WHERE SC_ID_ANIME = ".$idAnime. " AND SC_ID_USER = ".$idUser.";";
  }
  
 /*
  * Actualiza Score y Nivel del jugador en un anime
  */
  public static function updateScoreAndLevel($idScore,$idUser, $idAnime, $score, $level){
	  return "UPDATE TB_SCORE_ANIME_USER 
			  SET SC_SCORE = ".$score.",
			      SC_NIVEL = ".$level.
			" WHERE SC_ID_SCORE = ".$idScore." AND SC_ID_ANIME = ".$idAnime." AND SC_ID_USER = ".$idUser." ;";
  }
  
 /*
  * Inicializa el nivel en 1 y el score en 0 la primeravez que se juega
  */
  public static function initScore($idUser, $idAnime){
	  return "INSERT INTO TB_SCORE_ANIME_USER (SC_SCORE,SC_NIVEL,SC_ID_ANIME,SC_ID_USER)
	  VALUES (0,1,".$idAnime.",".$idUser.");";
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
					 TB_PREGUNTAS.P_PUNTOS
			 FROM TB_PREGUNTAS
			 WHERE TB_PREGUNTAS.P_ID_ANIME = ".$idAnime. 
             " ORDER BY RAND() LIMIT 20";
  }
  
 /*
  * Obtiene preguntas de animes aleatorios de un nivel especifico. 
  * Limite de 20 preguntas. 
  */
  public static function getQuestionsRandomByLevel($nivel){
	  return "";
  }

  public static function getAllAnimes(){
  	return "SELECT * FROM TB_ANIME WHERE AN_ACTIVO = 1;";
  }

  public static function getAllAnimesForWallpaper(){
    return "SELECT * FROM TB_ANIME;";
  }
  
  public static function getWallpaperByAnime($idAnime){
	  return "SELECT * FROM TB_RECOMPENSAS WHERE REC_ID_ANIME = ".$idAnime." AND REC_TIPO = 'W';";
  }

  public static function getAvatarByAnime($idAnime){
    return "SELECT * FROM TB_RECOMPENSAS WHERE REC_ID_ANIME = ".$idAnime." AND REC_TIPO = 'A';";
  }

  public static function searchFriendeByUserName($userName){
  	$sUserName = $userName.'%';
  	return "SELECT U_ID_USER,U_NOMBRE,U_USER_NAME,U_IMG_USER FROM TB_USER WHERE U_USER_NAME LIKE '".$sUserName."';";
  }

  public static function getAllFriendsByUser($idUser){
    return "SELECT A1.U_ID_USER,
    A2.U_NOMBRE,
    A2.U_USER_NAME,
    A2.U_IMG_USER,
    B.UF_ID_FRIEND  
    FROM TB_USER A1 
    INNER JOIN TB_USER_FRIEND B ON A1.U_ID_USER =B.UF_ID_USER
    INNER JOIN TB_USER A2 ON B.UF_ID_FRIEND = A2.U_ID_USER
    WHERE A1.U_ID_USER =".$idUser;
  }

  public static function getAllFriendsScoreByUser($idUser){
    return "SELECT A1.U_ID_USER,
    A2.U_TOTAL_SCORE,
    A2.U_NOMBRE,
    A2.U_USER_NAME,
    A2.U_IMG_USER,
    B.UF_ID_FRIEND  
    FROM TB_USER A1 
    INNER JOIN TB_USER_FRIEND B ON A1.U_ID_USER =B.UF_ID_USER
    INNER JOIN TB_USER A2 ON B.UF_ID_FRIEND = A2.U_ID_USER
    WHERE A1.U_ID_USER =".$idUser." ORDER BY A2.U_TOTAL_SCORE DESC";
  }

  public static function addFriendById($idUser,$idFriend){
    return "INSERT INTO TB_USER_FRIEND(UF_ID_USER, UF_ID_FRIEND) VALUES (".$idUser.",".$idFriend.");";
  }

  public static function getAllAvatarsByUser($idUser){
    return "SELECT REC_ID_RECOMPENSA,REC_URL
    FROM TB_RECOMPENSAS R
    INNER JOIN TB_USER_AVATAR A ON R.REC_ID_RECOMPENSA = A.UA_ID_AVATAR
    INNER JOIN TB_USER U ON A.UA_ID_USER = U.U_ID_USER
    WHERE U.U_ID_USER = ".$idUser;
  }

  public static function updateAvatarByUser($idUser,$b64Avatar){
    return "UPDATE TB_USER
    SET U_IMG_USER = '".$b64Avatar."'
    WHERE U_ID_USER = ".$idUser;
  }
  
}
?>