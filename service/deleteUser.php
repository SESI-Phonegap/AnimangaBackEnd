<?php

include "utils/utilbd.php";
include "utils/mysql.php";

deleteUser();

function deleteUser(){
    if (isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['iduser'])) {

        $email =  $_POST['email'];
		$email = urldecode($email);
	    $pass = $_POST['pass'];
        $iduser = $_POST['iduser'];
		$usuario = null;

        if ($email != null && $pass != null && $iduser != null) {
            $db = new MysqlCon();
			 $db->conectar();
			 $loginConsulta = $db->consulta(UtilBd::login($email,$pass));
             if($db->num_rows($loginConsulta)>0){
                $isDeleteUser = $db->bConsulta(UtilBd::deleteUserAccount($iduser));
                if ($isDeleteUser) {
                    $data = array('estatus' => '200', 'error' => "Se ha eliminado tu cuenta");
                    $json = json_encode($data, JSON_PRETTY_PRINT);
                    echo $json;
                }
             } else {
                $data = array('estatus' => '204','error' => "No se encontraron registros");
                $json = json_encode($data, JSON_PRETTY_PRINT);
                echo $json;
            }
        } else {
			$data = array('estatus' => '404','error' => "Bad Request2");
			$json = json_encode($data, JSON_PRETTY_PRINT);
			echo $json;
		}


    } else {
        $data = array('estatus' => '404','error' => "Bad Request");
        $json = json_encode($data, JSON_PRETTY_PRINT);
        echo $json;
    }
}
?>