<?php

class ScoreLevel{
	public $idScore;
	public $score;
	public $level;
	public $idAnime;
	public $idUser;
	
	public function __construct($idScore, $score, $level, $idAnime, $idUser){
		$this->idScore = $idScore;
		$this->score = $score;
		$this->level = $level;
		$this->idAnime = $idAnime;
		$this->idUser = $idUser;
	}
}
?>