<?php

class Questions{
	
	public $idQuestion;
	public $question;
	public $puntos;
	public $arrayRespuestas;
	

	public function __construct($idQuestion,$question,$puntos,$arrayRespuestas){
		$this->idQuestion = $idQuestion;
		$this->question = $question;
		$this->puntos = $puntos;
		$this->arrayRespuestas = $arrayRespuestas;
	}
}

?>