
application/x-httpd-php registroImageTxt.php ( PHP script, ASCII text )
<?php
include "service/utils/utilbd.php";
include "service/utils/mysql.php";

$db = new MysqlCon();
$db->conectar();

$fp = fopen("fichero.txt", "r");
$count = 0;
while(!feof($fp)) {

$linea = fgets($fp);
echo "Linea- ".$linea."<br>";
$lineaArray = explode("|",$linea);
$pregunta = $lineaArray[0];
//$nivel = $lineaArray[1];
$puntos = $lineaArray[1];
$anime = $lineaArray[2];
$respuestaOk = $lineaArray[3];
$respuesta2 = $lineaArray[4];
$respuesta3= $lineaArray[5];
$respuesta4= $lineaArray[6];

echo "".$pregunta;
echo "<br>-".$puntos;
echo "<br>-".$anime;
echo "<br>-".$respuestaOk;
echo "<br>-".$respuesta2;
echo "<br>-".$respuesta3;
echo "<br>-".$respuesta4;

$queryGetQuestion = null;
$idLastQuestion = null;


$queryInsertQuestion = $db->bConsulta(UtilBd::registraPreguntaImg($pregunta,$anime,$puntos));
if ($queryInsertQuestion) {
    $queryGetQuestion = $db->consulta(UtilBd::ultimaPreguntaAgregadaImg());
    if($db->num_rows($queryGetQuestion)>0){
        while($resultados = $db->fetch_array($queryGetQuestion)){ 
            $idLastQuestion = $resultados[0];
        }
        if ($idLastQuestion != null) {
            echo "<br>idPregunta--".$idLastQuestion;
            $queryInsertAnswer = $db->consulta(UtilBd::registraRespuestaImg($idLastQuestion,$respuestaOk,1));
            $queryInsertAnswer = $db->consulta(UtilBd::registraRespuestaImg($idLastQuestion,$respuesta2,0));
            $queryInsertAnswer = $db->consulta(UtilBd::registraRespuestaImg($idLastQuestion,$respuesta3,0));
            $queryInsertAnswer = $db->consulta(UtilBd::registraRespuestaImg($idLastQuestion,$respuesta4,0));
            
            $count += 1;
            echo "<br>Inserto ".$count;
        }
    }
} else  {
			echo "<script>alert('Error: No se pudo guardar');</script>";
		}
}
fclose($fp);
$db->closeConection();
?>