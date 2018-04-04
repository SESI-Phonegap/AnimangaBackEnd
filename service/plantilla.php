<?php

include "utils/utilbd.php";
include "utils/mysql.php";

function getAllAnimes(){
	//if (isset($_POST['userName']) && isset($_POST['pass']) ) {
		if(true){
		   /*$user =  $_POST['userName'];
	         $pass = $_POST['pass'];*/
			 $user = 'chris_slash10';
			 $pass = 'Mexico-17';
			 
			 if ($user != null && $pass != null && $level != null && $idanime != null) {
				 $db = new MysqlCon();
				 $db->conectar();
				 $loginConsulta = $db->consulta(UtilBd::login($user,$pass));
				 if($db->num_rows($loginConsulta)>0){
					 
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