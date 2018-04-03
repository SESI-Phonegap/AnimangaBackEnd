<?php

class Anime{
	public $idAnime;
	public $anime;
	public $imgUrl;
	
	public function __construct($idAnime,$anime,$imgUrl){
		$this->idAnime = $idAnime;
		$this->anime = $anime;
		$this->imgUrl = $imgUrl;
	}
}
?>