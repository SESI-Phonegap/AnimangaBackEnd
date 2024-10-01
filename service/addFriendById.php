<?php
include "utils/utilbd.php";
include "utils/mysql.php";

addFriend();

function addFriend(){
    $requestJson = file_get_contents('php://input');
	$json = json_decode($requestJson);

    if (isset($json)) {
        $user =  $json->email;
	    $pass = $json->pass;
        $idUser = $json->iduser;
        $idFriend = $json->idFriend;

        if($user != null && $idUser != null && $idFriend != null) {
            $db = new MysqlCon();
            $db->conectar();
            $loginConsulta = $db->consulta(UtilBd::login($user,$pass));
			if($db->num_rows($loginConsulta)>0){
                $queryNewFriend = $db->bConsulta(UtilBd::addFriendById($idUser,$idFriend));
                if($queryNewFriend){
                    $data = array('estatus' => '200','error' => "Ya tienes un nuevo amigo !!");
					$json = json_encode($data, JSON_PRETTY_PRINT);
					echo $json;
                } else {
                    $data = array('estatus' => '404','error' => "Error no fue posible agregar a tus amigos !!");
                    $json = json_encode($data, JSON_PRETTY_PRINT);
                    echo $json;
                }
            } else {
                $data = array('estatus' => '202','error' => "Credenciales incorrectas");
                $json = json_encode($data, JSON_PRETTY_PRINT);
                echo $json;
            }
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
