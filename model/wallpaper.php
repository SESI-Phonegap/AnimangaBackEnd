<?php

class Wallpaper{
	public $idWallpaper;
	public $url;
	public $urlExample;
	public $idAnime;
	public $costo;

	
	 public function __construct($idWallpaper,$url,$urlExample,$idAnime,$costo) {
		 $this->idWallpaper = $idWallpaper;
		 $this->url = $url;
		 $this->urlExample = $urlExample;
		 $this->idAnime = $idAnime;
		 $this->costo = $costo;
	 }
}

?>