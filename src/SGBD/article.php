<?php

namespace SGBD;

use SGBD\model as Model;

class Article extends Model{
	static $table='article';
	static $idcolumn='id';
	
	public function categorie(){
		return $this->belongs_to("SGBD\categorie", 'id_categ');
	}
}
