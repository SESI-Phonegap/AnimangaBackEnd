<?php 
class MysqlCon{

  public $conexion; 
  public $total_consultas;
  public $propiedad = "Variable miembro";

  public function conectar(){ 

      //Produccion
      //$this->conexion = new mysqli('localhost','root','','Animangaquiz','3306');
      //$this->conexion = new mysqli('http://54.177.175.213/','root','Abril-1531','Animangaquiz','3306');
      $this->conexion = new mysqli('localhost','root','Abril-1531','Animangaquiz','3306');
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