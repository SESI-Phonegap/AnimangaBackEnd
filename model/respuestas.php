<?php

class Respuestas{
	public $idRespuesta;
	public $respuesta;
	public $isCorrect;
	public $idPregunta;
	
	public function __construct($idRespuesta,$respuesta,$isCorrect,$idPregunta){
		$this->idRespuesta = $idRespuesta;
		$this->respuesta = $respuesta;
		$this->isCorrect = $isCorrect;
		$this->idPregunta = $idPregunta;
	}
}

?>