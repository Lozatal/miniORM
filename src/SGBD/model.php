<?php

namespace SGBD;

use SGBD\query as query;
use SGBD\article as article;
use SGBD\categorie as categorie;

abstract class Model{

	protected static $table;
	protected static $idColumn = 'id';

	protected $_v = [];

	public function __construct(array $t = null){
		if (!is_null($t)){
			$this->_v = $t;
		}
	}

	public function __get($attr_name){
		if (array_key_exists($attr_name, $this->_v)){
			return $this->_v[$attr_name];
		}else{
			return $this->$attr_name();
		}
	}

	public function __set($attr_name,$valeur){
		$this->_v[$attr_name]=$valeur;
	}
	
	public function delete(){
		if(isset($this->_v[static::$idColumn])){ //if clé existe
			$queryDelete=query::table(static::$table);
			$queryDelete->where(static::$idColumn,'=',$this->_v[static::$idColumn])->delete();
		}
	}

	public function insert(){
		$queryInsert=query::table(static::$table);
		$this->_v[static::$idColumn]=$queryInsert->insert($this->_v);
	}

	//Finders
	
	public static function all(){
		$query =  query::table(static::$table)->get();
		$result = [];
		
		foreach($query as $ligne){
			$object = new static($ligne);
			$result[] = $object;
		}
		return $result;
	}

	public static function find($id, array $listColmun = null){
		$query =  query::table(static::$table);
		
		if (!is_null($listColmun)){
			$query = $query->select($listColmun);
		}
		if(gettype($id)=="array"){
			if(gettype($id[0])=="array"){
				foreach($id as $tab){
					$query = $query->where($tab[0],$tab[1],$tab[2]);
				}
			}else{
				$query = $query->where($id[0],$id[1],$id[2]);
			}
			
		}else{
			$query = $query->where(static::$idColumn,'=',$id);
		}
		$query = $query->get();
		$result = [];

		foreach($query as $ligne){
			$object = new static($ligne);
			$result[] = $object;
		}

		return $result;
	}

	public static function first($id, array $listColmun = null){
		$query =  query::table(static::$table);
		
		if (!is_null($listColmun)){
			$query = $query->select($listColmun);
		}
		if(gettype($id)=="array"){
			if(gettype($id[0])=="array"){
				foreach($id as $tab){
					$query->where($tab[0],$tab[1],$tab[2]);
				}
			}else{
				$query->where($id[0],$id[1],$id[2]);
			}
			$query->get();
		}else{
			$query = $query->where(static::$idColumn,'=',$id)			
			->get();
		}
		
		$result = [];

		foreach($query as $ligne){
			$object = new static($ligne);
			$result[] = $object;
		}

		return $result[0];
	}
	
	//Associations
	
	public function belongs_to($nom, $id){
		$result=new $nom();
		$result=$result::first($this->$id);
		return $result;
	}
	
	public function has_many($nom, $id){
		$result=new $nom();
		$key=static::$idColumn;
		$result=$result::find([$id,'=',$this->$key]);
		return $result;
	}
}































