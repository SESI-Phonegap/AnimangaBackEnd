<?php

class User{
	public $idUser;
	public $userName;
	public $name;
	public $sexo;
	public $edad;
	public $password;
	public $email;
	public $token;
	public $coins;
	public $totalScore;
	public $imgUser;
	
	 public function __construct($idUser, $userName, $name, $sexo, $edad, $password, $email, $token, $coins, $totalScore, $imgUser) {
		 $this->idUser = $idUser;
		 $this->userName = $userName;
		 $this->name = $name;
		 $this->sexo = $sexo;
		 $this->edad = $edad;
		 $this->password = $password;
		 $this->email = $email;
		 $this->token = $token;
		 $this->coins = $coins;
		 $this->totalScore = $totalScore;
		 $this->imgUser = $imgUser;
	 }
}

?>