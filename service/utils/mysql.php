<?php 

class MysqlCon{

  public $conexion; 
  public $total_consultas;
  public $propiedad = "Variable miembro";

  public function conectar(){ 
  //MAMP MAC
	  //$this->conexion = mysqli_connect('127.0.01:8889','root','root');
  //WAMP Windows
      $this->conexion = mysqli_connect('localhost:3306','root','');
     
      if($this->conexion){
         if (mysqli_select_db($this->conexion,"BD_ANIMANGAQUIZ")) {
			 mysqli_set_charset($this->conexion,"utf8");
           return true;
         } else {
           //Si falla muestra el mensaje que el error está al acceder a la base de datos
           echo "No se pudo seleccionar la bd";
         }
      }  else {
        //Si falla la conexión con la base de datos se muestra el mensaje
         echo "No se pudo conectar a la bd"."<br>";
         echo "error de depuración: " . mysqli_connect_errno();
      }
  }

  public function getPropiedad(){
    return $this->propiedad. "<br>";
  }
  
  public function consulta($consulta){ 
   // $this->total_consultas++; 
    $resultado = mysqli_query($this->conexion,$consulta);
    if(!$resultado){ 
      echo 'MySQL Error: ' . mysqli_error();
      exit;
    }
    return $resultado;
  }
  
  public function bConsulta($consulta){
	  return mysqli_query($this->conexion,$consulta);
  }
  
  public function fetch_array($consulta){
   return mysqli_fetch_array($consulta);
  }
  
  public function num_rows($consulta){
   return mysqli_num_rows($consulta);
  }
  
  public function getTotalConsultas(){
   return $this->total_consultas; 
  }

  public function closeConection(){
    return mysqli_close($this->conexion);
  }


}
?>