<?php 
class MysqlCon{

  public $conexion; 
  public $total_consultas;
  public $propiedad = "Variable miembro";

  public function conectar(){ 

      //Produccion
      $this->conexion = new mysqli('localhost','chrisste_chrisste','5pq4dB!7Ip[IP4','chrisste_ANIMANGA_DB','3306');//mysqli_connect('192.168.1.66','root','Abril1531Mexic@','animanga','3306');
      mysqli_set_charset($this->conexion, "utf8");
      if($this->conexion -> connect_errno){
        echo "<script>console.log('Conexion Exitosa')</script>";
        
      }  else {
        //Si falla la conexión con la base de datos se muestra el mensaje
         //echo "Falló la conexión: %s\n",  $this->conexion->connect_error;
      }
  }

  public function getPropiedad(){
    return $this->propiedad. "<br>";
  }
  
  public function consulta($consulta){ 
    $resultado = $this->conexion->query($consulta);
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