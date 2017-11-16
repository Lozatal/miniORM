<?php

namespace SGBD;

use SGBD\model as Model;

class Categorie extends Model{
	static $table='categorie';
	static $idcolumn='id';
	
	public function article(){
		return $this->has_many("SGBD\article", 'id_categ');
	}
}
