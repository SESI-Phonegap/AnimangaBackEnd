<?php
include "service/utils/utilbd.php";
include "service/utils/mysql.php";

$db = new MysqlCon();
$db->conectar();

$fp = fopen("fichero.txt", "r");

while(!feof($fp)) {

$linea = fgets($fp);
$lineaArray = explode("|",$linea);
$pregunta = $lineaArray[0];
$nivel = $lineaArray[1];
$puntos = $lineaArray[2];
$anime = $lineaArray[3];
$respuestaOk = $lineaArray[4];
$respuesta2 = $lineaArray[5];
$respuesta3= $lineaArray[6];
$respuesta4= $lineaArray[7];

$queryGetQuestion = null;
$idLastQuestion = null;
$count = 0;

$queryInsertQuestion = $db->bConsulta(UtilBd::registraPregunta($pregunta,$anime,$nivel,$puntos));
if ($queryInsertQuestion) {
    $queryGetQuestion = $db->consulta(UtilBd::ultimaPreguntaAgregada());
    if($db->num_rows($queryGetQuestion)>0){
        while($resultados = $db->fetch_array($queryGetQuestion)){ 
            $idLastQuestion = $resultados[0];
        }
        if ($idLastQuestion != null) {
            $queryInsertAnswer = $db->consulta(UtilBd::registraRespuesta($idLastQuestion,$respuestaOk,1));
            $queryInsertAnswer = $db->consulta(UtilBd::registraRespuesta($idLastQuestion,$respuesta2,0));
            $queryInsertAnswer = $db->consulta(UtilBd::registraRespuesta($idLastQuestion,$respuesta3,0));
            $queryInsertAnswer = $db->consulta(UtilBd::registraRespuesta($idLastQuestion,$respuesta4,0));
            echo "Inserto ".$count++;
        }
    }
} else  {
			echo "<script>alert('Error: No se pudo guardar');</script>";
		}
}
$db->closeConection();

fclose($fp);
?>
